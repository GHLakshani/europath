<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\DynamicMenu;
use App\Events\LoggableEvent;
use Illuminate\Support\Facades\Event;
use Illuminate\Routing\Controllers\Middleware;
use Yajra\DataTables\Facades\DataTables;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function middleware(): array
    {
        return [
            new Middleware('role-list|role-create|role-edit|role-delete', only: ['list']),
            new Middleware('role-create', only: ['index', 'store']),
            new Middleware('role-edit', only: ['edit', 'update']),
            new Middleware('role-delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*
       $roles = Role::ord
        ,'DESC')->paginate(5);
        return view('roles.index',compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
        */


        if ($request->ajax()) {
            $data = Role::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('edit', 'admin.roles.actionsBlock')
                ->rawColumns(['edit'])
                ->make(true);
        }

        return view('admin.roles.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$permission = Permission::get();
        //return view('roles.create', compact('permission'));

        $permission = Permission::get();
        $dynamicMenu =  DynamicMenu::where('show_menu', 1)->orderBy('fOrder', 'ASC')->get();

        // dd($dynamicMenu);

        return view('admin.roles.index', compact('permission', 'dynamicMenu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
            // 'user_manual' => 'mimes:pdf|max:5120'
        ]);

        // $role = Role::create(['name' => $request->input('name')]);

        // if (!$request->file('user_manual') == "") {

        //     $user_manual = $request->file('user_manual')->getClientOriginalName();

        //     $path = $request->file('user_manual')->store('public/usermanual');
        // } else {
        //     $path = null;
        // }

        // dd($path);

        $role = new Role();
        $role->name = $request->name;
        $role->guard_name = 'web';
        // $role->user_manual = $path;
        $role->save();

        $role->syncPermissions($request->input('permission'));

        // \LogActivity::addToLog('New role record inserted. ID '.$role->id.'.');

        // Dispatch Activity Event to log this creation
        Event::dispatch(new LoggableEvent($role, 'New role record inserted'));

        return redirect()->route('roles-list')->with('success', 'Role created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /*
    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('roles.edit', compact('role', 'permission', 'rolePermissions'));
    }
    */

    public function edit($id)
    {
        //$id = decrypt($id);
        $role = Role::find($id);
        $permission = Permission::get();
        $dynamicMenu =  DynamicMenu::where('show_menu', 1)->orderBy('fOrder', 'ASC')->get();

        //         print_r($dynamicMenu);
        // die();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        //  var_dump($rolePermissions); exit();
        return view('admin.roles.edit', compact('role', 'permission', 'rolePermissions', 'dynamicMenu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd($request->all());
        $id = $request->id;

        $request->validate([
            'name' => 'required',
            'permission' => 'required',
            // 'user_manual' => 'mimes:pdf|max:5120'
        ]);


        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->guard_name = 'web';
        // if ($request->hasFile('user_manual')) {

        //     $user_manual = $request->file('user_manual')->getClientOriginalName();

        //     $path = $request->file('user_manual')->store('public/usermanual');

        //     $role->user_manual = $path;
        // }
        $role->save();

        // \LogActivity::addToLog('Role record ID '.$role->id.' updated.');

        // Dispatch Activity Event to log this creation
        Event::dispatch(new LoggableEvent($role, 'Role record ID'));

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id', $id)->delete();
        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully');
    }
}
