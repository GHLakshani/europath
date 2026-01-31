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
use App\Http\Requests\JobRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Models\CandidateJob;
use App\Models\Country;

class JobController extends Controller
{
    /**
     * Define the middleware for the JobController.
     *
     * This method returns an array of Middleware instances that specify
     * the middleware to be applied to various controller actions.
     *
     * @return array An array of Middleware instances.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('job-list|job-create|job-edit|job-delete', only: ['list']),
            new Middleware('job-create', only: ['index', 'store']),
            new Middleware('job-edit', only: ['edit', 'update']),
            new Middleware('job-delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the Job master data.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.job.list');
    }

    /**
     * Display the form for creating a new job.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $Country = Country::where('status', 'Y')->orderBy('id', 'asc')->get();

        return view('admin.job.create',[
            'countries' => $Country,
        ]);
    }

    /**
     * Store a newly created Job in storage.
     *
     * @param  \App\Http\Requests\JobRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function store(JobRequest $request)
    {
        try {
            DB::beginTransaction();
            $job = new CandidateJob();
            $job->title = $request->title;
            $job->country_id = $request->country_id;
            $job->order = $request->order;

            $job->created_by = Auth::id();
            $job->save();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($job, 'created'));

            return redirect()->route('job.index')->with('success', APIResponseMessage::CREATED);
        } catch (\Exception $e) {
            // dd($e);
            DB::rollBack();
            return redirect()->route('job.index')->with('success', APIResponseMessage::FAIL);
        }
    }

    /**
     * Display the specified job.
     *
     * This method decrypts the provided Job ID, retrieves the Job
     * details from the database, and returns the view for editing the job.
     *
     * @param string $id The encrypted Job ID.
     * @return \Illuminate\View\View The view for editing the job.
     */
    public function show(string $id)
    {
        $JobId = decrypt($id);
        $Job = CandidateJob::with([])->find($JobId);
        $Country = Country::where('status', 'Y')->orderBy('id', 'asc')->get();

        return view('admin.job.edit',[
            'job' => $Job,
            'countries' => $Country,
        ]);
    }

    /**
     * Update the specified Job in storage.
     *
     * @param  \App\Http\Requests\JobRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function update(JobRequest $request, string $id)
    {
        try {

            DB::beginTransaction();

            $job = CandidateJob::find($id);
            $job->title = $request->title;
            $job->country_id = $request->country_id;
            $job->order = $request->order;
            $job->updated_by = Auth::id();
            $job->save();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($job, 'update'));

            return redirect()->route('job.index')->with('success', APIResponseMessage::CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('job.index')->with('error', APIResponseMessage::ERROR_EXCEPTION);
        }
    }

    /**
     * Destroy the specified job.
     *
     * @param string $id The ID of the Job to be deleted.
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception If an error occurs during the deletion process.
     *
     * This method performs the following actions:
     * - Begins a database transaction.
     * - Finds the Job by ID.
     * - Updates the 'deleted_by' field with the ID of the authenticated user.
     * - Deletes the job.
     * - Commits the transaction.
     * - Dispatches a LoggableEvent to log the deletion.
     * - Redirects to the Job index route with a success message.
     *
     * If an exception occurs, the transaction is rolled back, an error is logged,
     * and the user is redirected to the Job index route with an error message.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $Job = CandidateJob::find($id);

            $Job->update(['deleted_by' => Auth::id()]);
            CandidateJob::with([])->find($id)->delete();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($Job, 'deleted'));

            return redirect()->route('job.index')->with('success', APIResponseMessage::DELETED);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::critical('Exception in delete branch network : ', [$e->getMessage()]);
            return redirect()->route('job.index')->with('error', APIResponseMessage::ERROR_EXCEPTION);

        }
    }

    /**
     * Activate or deactivate an Job based on its current status.
     *
     * This method toggles the status of an Job between 'Y' (active) and 'N' (inactive).
     * It also dispatches a LoggableEvent to log the status change.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing the Job ID.
     * @return \Illuminate\Http\RedirectResponse Redirects to the Job index route with a success message.
     */
    public function activation(Request $request)
    {
        $data =  CandidateJob::find($request->id);

        if ( $data->status == "Y" ) {

            $data->status = 'N';
            $data->save();
            $id = $data->id;

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($data, 'status-change'));

            return redirect()->route('job.index')->with('success', APIResponseMessage::DEACTIVALE_RECORD);
        } else {
            $data->status = "Y";
            $data->save();
            $id = $data->id;

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($data, 'statuschange'));

            return redirect()->route('job.index')->with('success', APIResponseMessage::ACTIVATE_RECORD);
        }

    }

    /**
     * Retrieve Job data for DataTables via AJAX.
     *
     * This method fetches Job data from the database, orders it by 'id' in descending order,
     * and returns it in a format suitable for DataTables. It includes additional columns for
     * editing, activation status, and deletion.
     *
     * @return \Illuminate\Http\JsonResponse JSON response containing the Job data for DataTables.
     */
    public function getAjaxJobData()
    {
        $model = CandidateJob::query()
                ->whereHas('country')
                ->with(['country'])
                ->orderBy('id', 'desc');

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->editColumn('title', function ($data) {
                return ucfirst(str_replace('_', ' ', $data['title']));
            })
            ->editColumn('country_name', function ($data) {
                return optional($data->country)->country_name; // Prevent error if null
            })
            ->filterColumn('country_name', function ($query, $keyword) {
                $query->whereHas('Country', function ($q) use ($keyword) {
                    $q->where('country_name', 'LIKE', "%{$keyword}%");
                });
            })
            ->addColumn('edit', content: function ($data) {
                $edit_url = route('job.show',encrypt($data->id));
                $btn = '<a href="' . $edit_url . '"><i class="fal fa-edit"></i></a>';
                return $btn;
            })
            ->addColumn('activation', function ($data) {
                return view('admin.job.partials._status', compact('data'));
            })
            ->addColumn('delete', function ($data) {
                return view('admin.job.partials._delete', compact('data'));
            })
            ->rawColumns(['edit', 'title'])
            ->toJson();
    }

}
