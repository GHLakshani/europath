<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Routing\Controllers\Middleware;
use App\Events\LoggableEvent;
use App\Helpers\APIResponseMessage;
use App\Helpers\StorageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\PhotographerRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Photographer;

class PhotographerController extends Controller
{
    /**
     * Define the middleware for the PhotographerController.
     *
     * This method returns an array of Middleware instances that specify
     * the middleware to be applied to various controller actions.
     *
     * @return array An array of Middleware instances.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('photographer-list|photographer-create|photographer-edit|photographer-delete', only: ['list']),
            new Middleware('photographer-create', only: ['index', 'store']),
            new Middleware('photographer-edit', only: ['edit', 'update']),
            new Middleware('photographer-delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the Photographer master data.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.photographer.list');
    }

    /**
     * Display the form for creating a new photographer.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.photographer.create');
    }

    /**
     * Store a newly created Photographer in storage.
     *
     * @param  \App\Http\Requests\PhotographerRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function store(PhotographerRequest $request)
    {

        try {
            DB::beginTransaction();
            $Photographer = new Photographer();
            $Photographer->photographer_name = $request->photographer_name;
            $Photographer->photographer_contactno = $request->photographer_contactno;
            $Photographer->photographer_email = $request->photographer_email;
            $Photographer->coat_per_each_photo = $request->coat_per_each_photo;
            $Photographer->order = $request->order;

            $Photographer->created_by = Auth::id();
            $Photographer->save();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($Photographer, 'created'));

            return redirect()->route('photographer.index')->with('success', APIResponseMessage::CREATED);
        } catch (\Exception $e) {
            // dd($e);
            DB::rollBack();
            return redirect()->route('photographer.index')->with('success', APIResponseMessage::FAIL);
        }
    }

    /**
     * Display the specified photographer.
     *
     * This method decrypts the provided Photographer ID, retrieves the Photographer
     * details from the database, and returns the view for editing the photographer.
     *
     * @param string $id The encrypted Photographer ID.
     * @return \Illuminate\View\View The view for editing the photographer.
     */
    public function show(string $id)
    {
        $PhotographerId = decrypt($id);
        $Photographer = Photographer::with([])->find($PhotographerId);

        return view('admin.photographer.edit',[
            'photographer' => $Photographer,
        ]);
    }

    /**
     * Update the specified Photographer in storage.
     *
     * @param  \App\Http\Requests\PhotographerRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function update(PhotographerRequest $request, string $id)
    {
        try {

            DB::beginTransaction();

            $Photographer = Photographer::find($id);
            $Photographer->photographer_name = $request->photographer_name;
            $Photographer->photographer_contactno = $request->photographer_contactno;
            $Photographer->photographer_email = $request->photographer_email;
            $Photographer->coat_per_each_photo = $request->coat_per_each_photo;
            $Photographer->order = $request->order;
            $Photographer->updated_by = Auth::id();
            $Photographer->save();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($Photographer, 'update'));

            return redirect()->route('photographer.index')->with('success', APIResponseMessage::CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('photographer.index')->with('error', APIResponseMessage::ERROR_EXCEPTION);
        }
    }

    /**
     * Destroy the specified photographer.
     *
     * @param string $id The ID of the Photographer to be deleted.
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception If an error occurs during the deletion process.
     *
     * This method performs the following actions:
     * - Begins a database transaction.
     * - Finds the Photographer by ID.
     * - Updates the 'deleted_by' field with the ID of the authenticated user.
     * - Deletes the photographer.
     * - Commits the transaction.
     * - Dispatches a LoggableEvent to log the deletion.
     * - Redirects to the Photographer index route with a success message.
     *
     * If an exception occurs, the transaction is rolled back, an error is logged,
     * and the user is redirected to the Photographer index route with an error message.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $Photographer = Photographer::find($id);

            $Photographer->update(['deleted_by' => Auth::id()]);
            Photographer::with([])->find($id)->delete();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($Photographer, 'deleted'));

            return redirect()->route('photographer.index')->with('success', APIResponseMessage::DELETED);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::critical('Exception in delete branch network : ', [$e->getMessage()]);
            return redirect()->route('photographer.index')->with('error', APIResponseMessage::ERROR_EXCEPTION);

        }
    }

    /**
     * Activate or deactivate an Photographer based on its current status.
     *
     * This method toggles the status of an Photographer between 'Y' (active) and 'N' (inactive).
     * It also dispatches a LoggableEvent to log the status change.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing the Photographer ID.
     * @return \Illuminate\Http\RedirectResponse Redirects to the Photographer index route with a success message.
     */
    public function activation(Request $request)
    {
        $data =  Photographer::find($request->id);

        if ( $data->status == "Y" ) {

            $data->status = 'N';
            $data->save();
            $id = $data->id;

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($data, 'status-change'));

            return redirect()->route('photographer.index')->with('success', APIResponseMessage::DEACTIVALE_RECORD);
        } else {
            $data->status = "Y";
            $data->save();
            $id = $data->id;

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($data, 'statuschange'));

            return redirect()->route('photographer.index')->with('success', APIResponseMessage::ACTIVATE_RECORD);
        }

    }

    /**
     * Retrieve Photographer data for DataTables via AJAX.
     *
     * This method fetches Photographer data from the database, orders it by 'id' in descending order,
     * and returns it in a format suitable for DataTables. It includes additional columns for
     * editing, activation status, and deletion.
     *
     * @return \Illuminate\Http\JsonResponse JSON response containing the Photographer data for DataTables.
     */
    public function getAjaxPhotographerData()
    {
        $model = Photographer::query()->with([])->orderBy('id', 'desc');

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->editColumn('photographer_name', function ($data) {
                return ucfirst(str_replace('_', ' ', $data['photographer_name']));
            })
            ->addColumn('edit', content: function ($data) {
                $edit_url = route('photographer.show',encrypt($data->id));
                $btn = '<a href="' . $edit_url . '"><i class="fal fa-edit"></i></a>';
                return $btn;
            })
            ->addColumn('activation', function ($data) {
                return view('admin.photographer.partials._status', compact('data'));
            })
            ->addColumn('delete', function ($data) {
                return view('admin.photographer.partials._delete', compact('data'));
            })
            ->rawColumns(['edit', 'photographer_name'])
            ->toJson();
    }
}
