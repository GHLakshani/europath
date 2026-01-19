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
use App\Http\Requests\TestimonialRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    /**
     * Define the middleware for the TestimonialController.
     *
     * This method returns an array of Middleware instances that specify
     * the middleware to be applied to various controller actions.
     *
     * @return array An array of Middleware instances.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('testimonials-list|testimonials-create|testimonials-edit|testimonials-delete', only: ['list']),
            new Middleware('testimonials-create', only: ['index', 'store']),
            new Middleware('testimonials-edit', only: ['edit', 'update']),
            new Middleware('testimonials-delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the Testimonial master data.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.testimonial.list');
    }

    /**
     * Display the form for creating a new Testimonial.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.testimonial.create');
    }

    /**
     * Store a newly created Testimonial in storage.
     *
     * @param  \App\Http\Requests\TestimonialRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function store(TestimonialRequest $request)
    {
        try {
            DB::beginTransaction();

            $Testimonial = new Testimonial();
            $Testimonial->name = $request->name;
            if ($request->hasFile('icon')) {
                $imageExtension = $request->icon->extension();
                $originalName = $request->icon->getClientOriginalName();
                $replace = preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower(pathinfo($originalName, PATHINFO_FILENAME))));
                $imgName = date('YmdHis'). $replace . '.' . $imageExtension;
                $uploadUrl = (new StorageHelper('testimonials', $imgName, $request->icon))->uploadImage();
                $Testimonial->icon = $imgName;
            }
            $Testimonial->message = $request->message;
            $Testimonial->created_by = Auth::id();
            $Testimonial->save();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($Testimonial, 'created'));

            return redirect()->route('testimonial.index')->with('success', APIResponseMessage::CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('testimonial.index')->with('success', APIResponseMessage::FAIL);
        }
    }

    /**
     * Display the specified Testimonial.
     *
     * This method decrypts the provided Testimonial ID, retrieves the Testimonial
     * details from the database, and returns the view for editing the Testimonial.
     *
     * @param string $id The encrypted Testimonial ID.
     * @return \Illuminate\View\View The view for editing the Testimonial.
     */
    public function show(string $id)
    {
        $TestimonialId = decrypt($id);
        $Testimonial = Testimonial::with([])->find($TestimonialId);

        return view('admin.testimonial.edit',[
            'Testimonial' => $Testimonial,
        ]);
    }

    /**
     * Update the specified Testimonial in storage.
     *
     * @param  \App\Http\Requests\TestimonialRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function update(TestimonialRequest $request, string $id)
    {
        try {

            DB::beginTransaction();

            $Testimonial = Testimonial::find($id);
            $Testimonial->name = $request->name;
            if ($request->hasFile('icon')) {
                $imageExtension = $request->icon->extension();
                $originalName = $request->icon->getClientOriginalName();
                $replace = preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', strtolower(pathinfo($originalName, PATHINFO_FILENAME))));
                $imgName = date('YmdHis'). $replace . '.' . $imageExtension;
                $uploadUrl = (new StorageHelper('testimonials', $imgName, $request->icon))->uploadImage();
                $Testimonial->icon = $imgName;
            }
            $Testimonial->message = $request->message;
            $Testimonial->updated_by = Auth::id();
            $Testimonial->save();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($Testimonial, 'update'));

            return redirect()->route('testimonial.index')->with('success', APIResponseMessage::CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('testimonial.index')->with('error', APIResponseMessage::ERROR_EXCEPTION);
        }
    }

    /**
     * Destroy the specified Testimonial.
     *
     * @param string $id The ID of the Testimonial to be deleted.
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception If an error occurs during the deletion process.
     *
     * This method performs the following actions:
     * - Begins a database transaction.
     * - Finds the Testimonial by ID.
     * - Updates the 'deleted_by' field with the ID of the authenticated user.
     * - Deletes the Testimonial.
     * - Commits the transaction.
     * - Dispatches a LoggableEvent to log the deletion.
     * - Redirects to the Testimonial index route with a success message.
     *
     * If an exception occurs, the transaction is rolled back, an error is logged,
     * and the user is redirected to the Testimonial index route with an error message.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $Testimonial = Testimonial::find($id);

            $Testimonial->update(['deleted_by' => Auth::id()]);
            Testimonial::with([])->find($id)->delete();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($Testimonial, 'deleted'));

            return redirect()->route('testimonial.index')->with('success', APIResponseMessage::DELETED);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::critical('Exception in delete Banner : ', [$e->getMessage()]);
            return redirect()->route('testimonial.index')->with('error', APIResponseMessage::ERROR_EXCEPTION);

        }
    }

    /**
     * Activate or deactivate an Testimonial based on its current status.
     *
     * This method toggles the status of an Testimonial between 'Y' (active) and 'N' (inactive).
     * It also dispatches a LoggableEvent to log the status change.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing the Testimonial ID.
     * @return \Illuminate\Http\RedirectResponse Redirects to the Testimonial index route with a success message.
     */
    public function activation(Request $request)
    {
        $data =  Testimonial::find($request->id);

        if ( $data->status == "Y" ) {

            $data->status = 'N';
            $data->save();
            $id = $data->id;

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($data, 'status-change'));

            return redirect()->route('testimonial.index')->with('success', APIResponseMessage::DEACTIVALE_RECORD);
        } else {
            $data->status = "Y";
            $data->save();
            $id = $data->id;

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($data, 'statuschange'));

            return redirect()->route('testimonial.index')->with('success', APIResponseMessage::ACTIVATE_RECORD);
        }

    }

    /**
     * Retrieve Testimonial data for DataTables via AJAX.
     *
     * This method fetches Testimonial data from the database, ratings it by 'id' in descending rating,
     * and returns it in a format suitable for DataTables. It includes additional columns for
     * editing, activation status, and deletion.
     *
     * @return \Illuminate\Http\JsonResponse JSON response containing the Testimonial data for DataTables.
     */
    public function getAjaxTestimonialData()
    {
        $model = Testimonial::query()->with([])->orderBy('id', 'desc');

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->editColumn('name', function ($data) {
                return $data['name'];
            })
            ->addColumn('edit', content: function ($data) {
                $edit_url = route('testimonial.show',encrypt($data->id));
                $btn = '<a href="' . $edit_url . '"><i class="fal fa-edit"></i></a>';
                return $btn;
            })
            ->addColumn('activation', function ($data) {
                return view('admin.testimonial.partials._status', compact('data'));
            })
            ->addColumn('delete', function ($data) {
                return view('admin.testimonial.partials._delete', compact('data'));
            })
            ->rawColumns(['edit'])
            ->toJson();
    }
}
