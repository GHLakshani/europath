<?php

namespace App\Http\Controllers\Admin;


use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Events\LoggableEvent;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Helpers\APIResponseMessage;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware('user-list|user-create|user-edit|user-delete', only: ['list']),
            new Middleware('user-create', only: ['index', 'store']),
            new Middleware('user-edit', only: ['edit', 'update']),
            new Middleware('user-delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        return view('admin.users.list');
    }

    public function create(Request $request)
    {

        $roles = Role::pluck('name', 'name')->all();

        if (Auth::user()->id != 1) {
            unset($roles['Admin']);
        }

        return view('admin.users.index', compact('roles'));
    }


    public function getUserList(Request $request)
    {
        $data = User::where('is_delete','0')->orderBy('id', 'DESC');
        
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('edit', function ($row) {
                $edit_url = route('users-edit',encrypt($row->id));
                if ($row->id != 1 || Auth::user()->id == 1) {
                    $btn = '<a href="' . $edit_url . '"><i class="fal fa-edit"></i></a>';
                } else {
                    $btn = '<a href="' . $edit_url . '"></a>'; // Empty anchor tag
                }
                return $btn;
            })
            ->addColumn('role', function ($row) {
                $v = "";
                if(!empty($row->getRoleNames())){
                    foreach($row->getRoleNames() as $v){
                        $v;
                    }
                }
                    return $v;
                })
            ->addColumn('activation', function($row){
                if ( $row->status == "Y" )
                    $status ='fal fa-check';
                else 
                    $status ='fal fa-backspace';
            
                if ($row->id == 1) {
                    $btn = '<a href="changestatus-user/'.$row->id.'"></a>';
                } else {
                    $btn = '<a href="changestatus-user/'.$row->id.'"><i class="'.$status.'"></i></a>';
                }
                

                return $btn;
            })
            ->addColumn('blockuser', function ($row) {
                return view('admin.users.partials.actionsBlock', compact('row'));
            })
            ->rawColumns(['edit','role','activation','blockuser'])
            ->make(true);
    
    }

     public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm_password',
            'roles' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $input = $request->all();
            $input['password'] = Hash::make($input['password']);

            $user = User::create($input);
            $user->assignRole($request->input('roles'));

            DB::commit();

            Event::dispatch(new LoggableEvent($user, 'created'));

            return redirect()->route('users-list')->with('success', APIResponseMessage::CREATED);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::critical('Exception in createBay : ', [$e->getMessage()]);
            return redirect()->back()->withInput()->with('error', APIResponseMessage::ERROR_EXCEPTION);
        }
    }

    public function show($id)
    {
        $userId = decrypt($id);
        $user = User::find($userId);
        $roles = Role::pluck('name', 'name')->all();

        if (Auth::user()->id != 1) {
            unset($roles['Admin']);
        }

        return view('admin.users.edit', compact('user','roles'));
    }


    public function update(Request $request)
    {
        $id = $request->id;
        
        // Validate the presence and type of ID
        if (empty($id) || !is_numeric($id)) {
            return redirect()->back()->withErrors(['id' => 'Invalid user ID provided.']);
        }
    
        // Validate the request data
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required',
        ]);
    
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password']);
        }
    
        $user = User::findOrFail($id);
        $user->update($input);
    
        // Remove old roles and assign new ones
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));
    
        // Log activity
        Event::dispatch(new LoggableEvent($user, 'update'));
    
        return redirect()->route('users-list')->with('success', APIResponseMessage::UPDATED);
    }
    

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $user = User::find($id);
            $user->is_delete = 1;
            $user->update();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($user, 'deleted'));

            return redirect()->route('users.index')->with('success', APIResponseMessage::DELETED);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::critical('Exception in deleteBay : ', [$e->getMessage()]);
            return redirect()->route('users.index')->with('error', APIResponseMessage::ERROR_EXCEPTION);

        }
    }

    public function activation(Request $request)
    {
        $request->validate([
            // 'status' => 'required'
        ]);

        $data =  User::find($request->id);
       

        if ( $data->status == "Y" ) {

            $data->status = 'N';
            $data->save();
            $id = $data->id;

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($data, 'statuschange'));

            return redirect()->route('users-list')
            ->with('success', 'Record deactivate successfully.');

        } else {

            $data->status = "Y";
            $data->save();
            $id = $data->id;

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($data, 'statuschange'));

            return redirect()->route('users-list')
            ->with('success', 'Record activate successfully.');
        }

    }
}
