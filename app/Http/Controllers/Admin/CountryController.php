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
use App\Http\Requests\CountryRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Country;

class CountryController extends Controller
{
    /**
     * Define the middleware for the CountryController.
     *
     * This method returns an array of Middleware instances that specify
     * the middleware to be applied to various controller actions.
     *
     * @return array An array of Middleware instances.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('country-list|country-create|country-edit|country-delete', only: ['list']),
            new Middleware('country-create', only: ['index', 'store']),
            new Middleware('country-edit', only: ['edit', 'update']),
            new Middleware('country-delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the country master data.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.country.list');
    }

    /**
     * Display the form for creating a new country.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.country.create');
    }

    /**
     * Store a newly created country in storage.
     *
     * @param  \App\Http\Requests\countryRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function store(CountryRequest $request)
    {
        try {
            DB::beginTransaction();
            $Country = new Country();
            $Country->country_name = $request->country_name;
            $Country->order = $request->order;

            $Country->created_by = Auth::id();
            $Country->save();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($Country, 'created'));

            return redirect()->route('country.index')->with('success', APIResponseMessage::CREATED);
        } catch (\Exception $e) {
            // dd($e);
            DB::rollBack();
            return redirect()->route('country.index')->with('success', APIResponseMessage::FAIL);
        }
    }

    /**
     * Display the specified country.
     *
     * This method decrypts the provided country ID, retrieves the country
     * details from the database, and returns the view for editing the country.
     *
     * @param string $id The encrypted country ID.
     * @return \Illuminate\View\View The view for editing the country.
     */
    public function show(string $id)
    {
        $countryId = decrypt($id);
        $country = country::with([])->find($countryId);

        return view('admin.country.edit',[
            'country' => $country,
        ]);
    }

    /**
     * Update the specified country in storage.
     *
     * @param  \App\Http\Requests\countryRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function update(CountryRequest $request, string $id)
    {
        try {

            DB::beginTransaction();

            $country = Country::find($id);
            $country->country_name = $request->country_name;
            $country->order = $request->order;
            $country->updated_by = Auth::id();
            $country->save();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($country, 'update'));

            return redirect()->route('country.index')->with('success', APIResponseMessage::CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('country.index')->with('error', APIResponseMessage::ERROR_EXCEPTION);
        }
    }

    /**
     * Destroy the specified country.
     *
     * @param string $id The ID of the country to be deleted.
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception If an error occurs during the deletion process.
     *
     * This method performs the following actions:
     * - Begins a database transaction.
     * - Finds the country by ID.
     * - Updates the 'deleted_by' field with the ID of the authenticated user.
     * - Deletes the country.
     * - Commits the transaction.
     * - Dispatches a LoggableEvent to log the deletion.
     * - Redirects to the country index route with a success message.
     *
     * If an exception occurs, the transaction is rolled back, an error is logged,
     * and the user is redirected to the country index route with an error message.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $country = Country::find($id);

            $country->update(['deleted_by' => Auth::id()]);
            Country::with([])->find($id)->delete();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($country, 'deleted'));

            return redirect()->route('country.index')->with('success', APIResponseMessage::DELETED);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::critical('Exception in delete branch network : ', [$e->getMessage()]);
            return redirect()->route('country.index')->with('error', APIResponseMessage::ERROR_EXCEPTION);

        }
    }

    /**
     * Activate or deactivate an country based on its current status.
     *
     * This method toggles the status of an country between 'Y' (active) and 'N' (inactive).
     * It also dispatches a LoggableEvent to log the status change.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing the country ID.
     * @return \Illuminate\Http\RedirectResponse Redirects to the country index route with a success message.
     */
    public function activation(Request $request)
    {
        $data =  Country::find($request->id);

        if ( $data->status == "Y" ) {

            $data->status = 'N';
            $data->save();
            $id = $data->id;

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($data, 'status-change'));

            return redirect()->route('country.index')->with('success', APIResponseMessage::DEACTIVALE_RECORD);
        } else {
            $data->status = "Y";
            $data->save();
            $id = $data->id;

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($data, 'statuschange'));

            return redirect()->route('country.index')->with('success', APIResponseMessage::ACTIVATE_RECORD);
        }

    }

    /**
     * Retrieve country data for DataTables via AJAX.
     *
     * This method fetches country data from the database, orders it by 'id' in descending order,
     * and returns it in a format suitable for DataTables. It includes additional columns for
     * editing, activation status, and deletion.
     *
     * @return \Illuminate\Http\JsonResponse JSON response containing the country data for DataTables.
     */
    public function getAjaxCountryData()
    {
        $model = Country::query()->with([])->orderBy('id', 'desc');

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->editColumn('country_name', function ($data) {
                return ucfirst(str_replace('_', ' ', $data['country_name']));
            })
            ->addColumn('edit', content: function ($data) {
                $edit_url = route('country.show',encrypt($data->id));
                $btn = '<a href="' . $edit_url . '"><i class="fal fa-edit"></i></a>';
                return $btn;
            })
            ->addColumn('activation', function ($data) {
                return view('admin.country.partials._status', compact('data'));
            })
            ->addColumn('delete', function ($data) {
                return view('admin.country.partials._delete', compact('data'));
            })
            ->rawColumns(['edit', 'country_name'])
            ->toJson();
    }
}
