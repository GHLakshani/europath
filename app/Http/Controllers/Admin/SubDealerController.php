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
use App\Http\Requests\SubDealerRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Models\SubDealer;
use App\Models\Country;

class SubDealerController extends Controller
{
    /**
     * Define the middleware for the SubDealerController.
     *
     * This method returns an array of Middleware instances that specify
     * the middleware to be applied to various controller actions.
     *
     * @return array An array of Middleware instances.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('sub-dealer-list|sub-dealer-create|sub-dealer-edit|sub-dealer-delete', only: ['list']),
            new Middleware('sub-dealer-create', only: ['index', 'store']),
            new Middleware('sub-dealer-edit', only: ['edit', 'update']),
            new Middleware('sub-dealer-delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the sub_dealer master data.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.sub_dealer.list');
    }

    /**
     * Display the form for creating a new sub_dealer.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        return view('admin.sub_dealer.create');
    }

    /**
     * Store a newly created sub_dealer in storage.
     *
     * @param  \App\Http\Requests\SubDealerRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function store(SubDealerRequest $request)
    {
        try {
            DB::beginTransaction();
            $sub_dealer = new SubDealer();
            $sub_dealer->name = $request->name;
            $sub_dealer->nic = $request->nic;
            $sub_dealer->phone = $request->phone;
            $sub_dealer->commission_percentage = $request->commission_percentage;

            $sub_dealer->created_by = Auth::id();
            $sub_dealer->save();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($sub_dealer, 'created'));

            return redirect()->route('sub-dealer.index')->with('success', APIResponseMessage::CREATED);
        } catch (\Exception $e) {
            // dd($e);
            DB::rollBack();
            return redirect()->route('sub-dealer.index')->with('success', APIResponseMessage::FAIL);
        }
    }

    /**
     * Display the specified sub_dealer.
     *
     * This method decrypts the provided sub_dealer ID, retrieves the sub_dealer
     * details from the database, and returns the view for editing the sub_dealer.
     *
     * @param string $id The encrypted sub_dealer ID.
     * @return \Illuminate\View\View The view for editing the sub_dealer.
     */
    public function show(string $id)
    {
        $sub_dealerId = decrypt($id);
        $sub_dealer = SubDealer::with([])->find($sub_dealerId);

        return view('admin.sub_dealer.edit',[
            'sub_dealer' => $sub_dealer,
        ]);
    }

    /**
     * Update the specified sub_dealer in storage.
     *
     * @param  \App\Http\Requests\SubDealerRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function update(SubDealerRequest $request, string $id)
    {
        try {

            DB::beginTransaction();

            $sub_dealer = SubDealer::find($id);
            $sub_dealer->name = $request->name;
            $sub_dealer->nic = $request->nic;
            $sub_dealer->phone = $request->phone;
            $sub_dealer->commission_percentage = $request->commission_percentage;
            $sub_dealer->updated_by = Auth::id();
            $sub_dealer->save();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($sub_dealer, 'update'));

            return redirect()->route('sub-dealer.index')->with('success', APIResponseMessage::CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('sub-dealer.index')->with('error', APIResponseMessage::ERROR_EXCEPTION);
        }
    }

    /**
     * Destroy the specified sub_dealer.
     *
     * @param string $id The ID of the sub_dealer to be deleted.
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception If an error occurs during the deletion process.
     *
     * This method performs the following actions:
     * - Begins a database transaction.
     * - Finds the sub_dealer by ID.
     * - Updates the 'deleted_by' field with the ID of the authenticated user.
     * - Deletes the sub_dealer.
     * - Commits the transaction.
     * - Dispatches a LoggableEvent to log the deletion.
     * - Redirects to the sub_dealer index route with a success message.
     *
     * If an exception occurs, the transaction is rolled back, an error is logged,
     * and the user is redirected to the sub_dealer index route with an error message.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $sub_dealer = SubDealer::find($id);

            $sub_dealer->update(['deleted_by' => Auth::id()]);
            SubDealer::with([])->find($id)->delete();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($sub_dealer, 'deleted'));

            return redirect()->route('sub-dealer.index')->with('success', APIResponseMessage::DELETED);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::critical('Exception in delete branch network : ', [$e->getMessage()]);
            return redirect()->route('sub-dealer.index')->with('error', APIResponseMessage::ERROR_EXCEPTION);

        }
    }

    /**
     * Activate or deactivate an sub_dealer based on its current status.
     *
     * This method toggles the status of an sub_dealer between 'Y' (active) and 'N' (inactive).
     * It also dispatches a LoggableEvent to log the status change.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing the sub_dealer ID.
     * @return \Illuminate\Http\RedirectResponse Redirects to the sub_dealer index route with a success message.
     */
    public function activation(Request $request)
    {
        $data =  SubDealer::find($request->id);

        if ( $data->status == "Y" ) {

            $data->status = 'N';
            $data->save();
            $id = $data->id;

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($data, 'status-change'));

            return redirect()->route('sub-dealer.index')->with('success', APIResponseMessage::DEACTIVALE_RECORD);
        } else {
            $data->status = "Y";
            $data->save();
            $id = $data->id;

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($data, 'statuschange'));

            return redirect()->route('sub-dealer.index')->with('success', APIResponseMessage::ACTIVATE_RECORD);
        }

    }

    /**
     * Retrieve sub_dealer data for DataTables via AJAX.
     *
     * This method fetches sub_dealer data from the database, orders it by 'id' in descending order,
     * and returns it in a format suitable for DataTables. It includes additional columns for
     * editing, activation status, and deletion.
     *
     * @return \Illuminate\Http\JsonResponse JSON response containing the sub_dealer data for DataTables.
     */
    public function getAjaxSubDealerData()
    {
        $model = SubDealer::query()->orderBy('id', 'desc');

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->editColumn('title', function ($data) {
                return ucfirst(str_replace('_', ' ', $data['title']));
            })
            ->addColumn('edit', content: function ($data) {
                $edit_url = route('sub-dealer.show',encrypt($data->id));
                $btn = '<a href="' . $edit_url . '"><i class="fal fa-edit"></i></a>';
                return $btn;
            })
            ->addColumn('activation', function ($data) {
                return view('admin.sub_dealer.partials._status', compact('data'));
            })
            ->addColumn('delete', function ($data) {
                return view('admin.sub_dealer.partials._delete', compact('data'));
            })
            ->rawColumns(['edit', 'title'])
            ->toJson();
    }

}
