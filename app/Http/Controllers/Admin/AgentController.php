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
use App\Http\Requests\AgentRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Agent;
use App\Models\Country;

class AgentController extends Controller
{
    /**
     * Define the middleware for the AgentController.
     *
     * This method returns an array of Middleware instances that specify
     * the middleware to be applied to various controller actions.
     *
     * @return array An array of Middleware instances.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('agent-list|agent-create|agent-edit|agent-delete', only: ['list']),
            new Middleware('agent-create', only: ['index', 'store']),
            new Middleware('agent-edit', only: ['edit', 'update']),
            new Middleware('agent-delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the agent master data.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.agent.list');
    }

    /**
     * Display the form for creating a new agent.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $Country = Country::where('status', 'Y')->orderBy('id', 'asc')->get();

        return view('admin.agent.create',[
            'countries' => $Country,
        ]);
    }

    /**
     * Store a newly created agent in storage.
     *
     * @param  \App\Http\Requests\AgentRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function store(AgentRequest $request)
    {
        try {
            DB::beginTransaction();
            $agent = new Agent();
            $agent->name = $request->name;
            $agent->nic = $request->nic;
            $agent->country_id = $request->country_id;
            $agent->phone = $request->phone;
            $agent->email = $request->email;
            $agent->commission_percentage = $request->commission_percentage;

            $agent->created_by = Auth::id();
            $agent->save();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($agent, 'created'));

            return redirect()->route('agent.index')->with('success', APIResponseMessage::CREATED);
        } catch (\Exception $e) {
            // dd($e);
            DB::rollBack();
            return redirect()->route('agent.index')->with('success', APIResponseMessage::FAIL);
        }
    }

    /**
     * Display the specified agent.
     *
     * This method decrypts the provided agent ID, retrieves the agent
     * details from the database, and returns the view for editing the agent.
     *
     * @param string $id The encrypted agent ID.
     * @return \Illuminate\View\View The view for editing the agent.
     */
    public function show(string $id)
    {
        $agentId = decrypt($id);
        $agent = Agent::with([])->find($agentId);
        $Country = Country::where('status', 'Y')->orderBy('id', 'asc')->get();

        return view('admin.agent.edit',[
            'agent' => $agent,
            'countries' => $Country,
        ]);
    }

    /**
     * Update the specified agent in storage.
     *
     * @param  \App\Http\Requests\AgentRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function update(AgentRequest $request, string $id)
    {
        try {

            DB::beginTransaction();

            $agent = agent::find($id);
            $agent->name = $request->name;
            $agent->nic = $request->nic;
            $agent->country_id = $request->country_id;
            $agent->phone = $request->phone;
            $agent->email = $request->email;
            $agent->commission_percentage = $request->commission_percentage;
            $agent->updated_by = Auth::id();
            $agent->save();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($agent, 'update'));

            return redirect()->route('agent.index')->with('success', APIResponseMessage::CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('agent.index')->with('error', APIResponseMessage::ERROR_EXCEPTION);
        }
    }

    /**
     * Destroy the specified agent.
     *
     * @param string $id The ID of the agent to be deleted.
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception If an error occurs during the deletion process.
     *
     * This method performs the following actions:
     * - Begins a database transaction.
     * - Finds the agent by ID.
     * - Updates the 'deleted_by' field with the ID of the authenticated user.
     * - Deletes the agent.
     * - Commits the transaction.
     * - Dispatches a LoggableEvent to log the deletion.
     * - Redirects to the agent index route with a success message.
     *
     * If an exception occurs, the transaction is rolled back, an error is logged,
     * and the user is redirected to the agent index route with an error message.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $agent = agent::find($id);

            $agent->update(['deleted_by' => Auth::id()]);
            agent::with([])->find($id)->delete();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($agent, 'deleted'));

            return redirect()->route('agent.index')->with('success', APIResponseMessage::DELETED);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::critical('Exception in delete branch network : ', [$e->getMessage()]);
            return redirect()->route('agent.index')->with('error', APIResponseMessage::ERROR_EXCEPTION);

        }
    }

    /**
     * Activate or deactivate an agent based on its current status.
     *
     * This method toggles the status of an agent between 'Y' (active) and 'N' (inactive).
     * It also dispatches a LoggableEvent to log the status change.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing the agent ID.
     * @return \Illuminate\Http\RedirectResponse Redirects to the agent index route with a success message.
     */
    public function activation(Request $request)
    {
        $data =  agent::find($request->id);

        if ( $data->status == "Y" ) {

            $data->status = 'N';
            $data->save();
            $id = $data->id;

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($data, 'status-change'));

            return redirect()->route('agent.index')->with('success', APIResponseMessage::DEACTIVALE_RECORD);
        } else {
            $data->status = "Y";
            $data->save();
            $id = $data->id;

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($data, 'statuschange'));

            return redirect()->route('agent.index')->with('success', APIResponseMessage::ACTIVATE_RECORD);
        }

    }

    /**
     * Retrieve agent data for DataTables via AJAX.
     *
     * This method fetches agent data from the database, orders it by 'id' in descending order,
     * and returns it in a format suitable for DataTables. It includes additional columns for
     * editing, activation status, and deletion.
     *
     * @return \Illuminate\Http\JsonResponse JSON response containing the agent data for DataTables.
     */
    public function getAjaxAgentData()
    {
        $model = Agent::query()
                ->whereHas('country')
                ->with(['country'])
                ->orderBy('id', 'desc');

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->editColumn('name', function ($data) {
                return ucfirst(str_replace('_', ' ', $data['name']));
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
                $edit_url = route('agent.show',encrypt($data->id));
                $btn = '<a href="' . $edit_url . '"><i class="fal fa-edit"></i></a>';
                return $btn;
            })
            ->addColumn('activation', function ($data) {
                return view('admin.agent.partials._status', compact('data'));
            })
            ->addColumn('delete', function ($data) {
                return view('admin.agent.partials._delete', compact('data'));
            })
            ->rawColumns(['edit', 'title'])
            ->toJson();
    }

}
