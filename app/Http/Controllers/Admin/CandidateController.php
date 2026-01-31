<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;
use App\Events\LoggableEvent;
use App\Helpers\APIResponseMessage;
use App\Helpers\StorageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CandidateRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Candidate;
use App\Models\Country;
use App\Models\CandidateJob;
use App\Models\Agent;
use App\Models\SubDealer;
use App\Models\DocumentType;
use App\Models\CandidateDocument;
use App\Models\CandidateEducation;
use App\Models\CandidateExperience;
use App\Models\CandidateLanguage;

use App\Enums\CandidateStatus;

use Barryvdh\DomPDF\Facade\Pdf;

class CandidateController extends Controller
{
    /**
     * Define the middleware for the CandidateController.
     *
     * This method returns an array of Middleware instances that specify
     * the middleware to be applied to various controller actions.
     *
     * @return array An array of Middleware instances.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('candidate-list|candidate-create|candidate-edit|candidate-delete', only: ['list']),
            new Middleware('candidate-create', only: ['index', 'store']),
            new Middleware('candidate-edit', only: ['edit', 'update']),
            new Middleware('candidate-delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the candidate master data.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.candidate.list');
    }

    /**
     * Display the form for creating a new candidate.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        return view('admin.candidate.create', [
            'countries'      => Country::where('status', 'Y')->orderBy('id', 'asc')->get(),
            'jobs'           => CandidateJob::where('status', 'Y')->orderBy('id', 'asc')->get(),
            'agents'         => Agent::orderBy('id', 'asc')->get(),
            'subDealers'     => SubDealer::orderBy('id', 'asc')->get(),
            'documentTypes'  => DocumentType::orderBy('id', 'asc')->get(),
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
    public function store(CandidateRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {

                /* Upload photo */
                $photoPath = null;
                if ($request->hasFile('photo')) {
                    $photoPath = $request->file('photo')
                        ->store('candidates/photos', 'public');
                }

                /* Create Candidate */
                $candidate = Candidate::create([
                    'registration_no'     => $request->registration_no,
                    'reference_no'        => $request->reference_no,
                    'full_name'           => $request->full_name,
                    'nic'                 => $request->nic,
                    'passport_no'         => $request->passport_no,
                    'passport_expiry'     => $request->passport_expiry,
                    'dob'                 => $request->dob,
                    'age'                 => $request->age,

                    'contact_number_1'    => $request->contact_number_1,
                    'contact_number_2'    => $request->contact_number_2,
                    'address'             => $request->address,
                    'place_of_birth'      => $request->place_of_birth,
                    'civil_status'        => $request->civil_status,
                    'no_of_children'      => $request->no_of_children,
                    'nationality'         => $request->nationality,
                    'religion'            => $request->religion,
                    'father_name'         => $request->father_name,
                    'mother_name'         => $request->mother_name,
                    'height_cm'           => $request->height_cm,
                    'weight_kg'           => $request->weight_kg,

                    'country_id'          => $request->country_id,
                    'job_id'              => $request->job_id,
                    'agent_id'            => $request->agent_id,
                    'sub_dealer_id'       => $request->sub_dealer_id,

                    'photo'               => $photoPath,
                    'status'              => CandidateStatus::REGISTERED,
                    'created_by'          => Auth::id(),
                ]);

                /* Educations */

                foreach ($request->educations ?? [] as $edu) {
                    if (!empty($edu['institute_name'])) {
                        $candidateEducation = CandidateEducation::create([
                            'candidate_id' => $candidate->id,
                            'institute_name'    => $edu['institute_name'],
                            'course'       => $edu['course'],
                            'duration'     => $edu['duration'],
                        ]);
                    }
                }

                /* Experiences */
                foreach ($request->experiences ?? [] as $exp) {
                    if (!empty($exp['employer_name'])) {
                        CandidateExperience::create([
                            'candidate_id' => $candidate->id,
                            'employer_name'     => $exp['employer_name'],
                            'position'     => $exp['position'],
                            'duration'     => $exp['duration'],
                        ]);
                    }
                }

                /* Languages */
                foreach ($request->languages ?? [] as $lang) {
                    if (!empty($lang['language'])) {
                        CandidateLanguage::create([
                            'candidate_id'  => $candidate->id,
                            'language'      => $lang['language'],
                            'understanding' => $lang['understanding'],
                            'speaking'      => $lang['speaking'],
                            'writing'       => $lang['writing'],
                        ]);
                    }
                }

                // Dispatch Activity Event to log this creation
                Event::dispatch(new LoggableEvent($candidate, 'created'));
            });


            return redirect()->route('candidate.index')->with('success', APIResponseMessage::CREATED);
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect()->route('candidate.index')->with('success', APIResponseMessage::FAIL);
        }
    }

    /**
     * Display the specified candidate.
     *
     * This method decrypts the provided candidate ID, retrieves the candidate
     * details from the database, and returns the view for editing the candidate.
     *
     * @param string $id The encrypted candidate ID.
     * @return \Illuminate\View\View The view for editing the candidate.
     */
    public function show(string $id)
    {
        $candidateId = decrypt($id);
        $candidate = Candidate::with([])->find($candidateId);

        return view('admin.candidate.edit',[
            'candidate' => $candidate,
            'countries'      => Country::where('status', 'Y')->orderBy('id', 'asc')->get(),
            'jobs'           => CandidateJob::where('status', 'Y')->orderBy('id', 'asc')->get(),
            'agents'         => Agent::orderBy('id', 'asc')->get(),
            'subDealers'     => SubDealer::orderBy('id', 'asc')->get(),
            'documentTypes'  => DocumentType::orderBy('id', 'asc')->get(),
        ]);
    }

    /**
     * Update the specified agent in storage.
     *
     * @param  \App\Http\Requests\Candidate  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function update(CandidateRequest $request, $id)
    {
        $candidate = Candidate::findOrFail($id);
        try {
            DB::transaction(function () use ($request, $candidate) {

                /* ================= Photo ================= */
                if ($request->hasFile('photo')) {
                    $candidate->photo = $request->file('photo')
                        ->store('candidates/photos', 'public');
                    $candidate->save();
                }

                /* ================= Candidate ================= */
                $candidate->update(
                    $request->except(['photo', 'educations', 'experiences', 'languages'])
                );

                /* ================= EDUCATIONS ================= */

                $existingEducationIds = $candidate->educations()->pluck('id')->toArray();
                $submittedEducationIds = [];

                foreach ($request->educations ?? [] as $edu) {

                    if (!empty($edu['id'])) {
                        $candidate->educations()
                            ->where('id', $edu['id'])
                            ->update([
                                'institute_name' => $edu['institute_name'],
                                'course'         => $edu['course'] ?? null,
                                'duration'       => $edu['duration'] ?? null,
                            ]);

                        $submittedEducationIds[] = $edu['id'];
                    } else {

                        $new = $candidate->educations()->create([
                            'institute_name' => $edu['institute_name'],
                            'course' => $edu['course'] ?? null,
                            'duration' => $edu['duration'] ?? null,
                        ]);
                        $submittedEducationIds[] = $new->id;
                    }
                }

                $candidate->educations()
                    ->whereIn('id', array_diff($existingEducationIds, $submittedEducationIds))
                    ->delete();


                /* ================= EXPERIENCES ================= */

                $existingExperienceIds = $candidate->experiences()->pluck('id')->toArray();
                $submittedExperienceIds = [];

                foreach ($request->experiences ?? [] as $exp) {
                    if (!empty($exp['id'])) {
                        $candidate->experiences()
                            ->where('id', $exp['id'])
                            ->update([
                                'employer_name' => $exp['employer_name'],
                                'position'      => $exp['position'] ?? null,
                                'duration'      => $exp['duration'] ?? null,
                            ]);

                        $submittedExperienceIds[] = $exp['id'];
                    } else {
                        $new = $candidate->experiences()->create([
                            'employer_name' => $exp['employer_name'],
                            'position'      => $exp['position'] ?? null,
                            'duration'      => $exp['duration'] ?? null,
                        ]);

                        $submittedExperienceIds[] = $new->id;
                    }
                }

                $candidate->experiences()
                    ->whereIn('id', array_diff($existingExperienceIds, $submittedExperienceIds))
                    ->delete();

                /* ================= LANGUAGES ================= */

                $existingLanguageIds = $candidate->languages()->pluck('id')->toArray();
                $submittedLanguageIds = [];

                foreach ($request->languages ?? [] as $lang) {
                    if (!empty($lang['id'])) {
                        $candidate->languages()
                            ->where('id', $lang['id'])
                            ->update([
                                'language'      => $lang['language'],
                                'understanding' => $lang['understanding'] ?? null,
                                'speaking'      => $lang['speaking'] ?? null,
                                'writing'       => $lang['writing'] ?? null,
                            ]);

                        $submittedLanguageIds[] = $lang['id'];
                    } else {
                        $new = $candidate->languages()->create([
                            'language'      => $lang['language'],
                            'understanding' => $lang['understanding'] ?? null,
                            'speaking'      => $lang['speaking'] ?? null,
                            'writing'       => $lang['writing'] ?? null,
                        ]);

                        $submittedLanguageIds[] = $new->id;
                    }
                }

                $candidate->languages()
                    ->whereIn('id', array_diff($existingLanguageIds, $submittedLanguageIds))
                    ->delete();

                Event::dispatch(new LoggableEvent($candidate, 'update'));
            });


            return redirect()
                ->route('candidate.index')
                ->with('success', APIResponseMessage::UPDATED);

        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect()
                ->route('candidate.index')
                ->with('error', APIResponseMessage::FAIL);
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
            $candidate = Candidate::find($id);

            $candidate->update(['deleted_by' => Auth::id()]);
            Candidate::with([])->find($id)->delete();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($candidate, 'deleted'));

            return redirect()->route('candidate.index')->with('success', APIResponseMessage::DELETED);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::critical('Exception in delete branch network : ', [$e->getMessage()]);
            return redirect()->route('candidate.index')->with('error', APIResponseMessage::ERROR_EXCEPTION);

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
        $data =  Candidate::find($request->id);

        if ( $data->status == "Y" ) {

            $data->status = 'N';
            $data->save();
            $id = $data->id;

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($data, 'status-change'));

            return redirect()->route('candidate.index')->with('success', APIResponseMessage::DEACTIVALE_RECORD);
        } else {
            $data->status = "Y";
            $data->save();
            $id = $data->id;

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($data, 'statuschange'));

            return redirect()->route('candidate.index')->with('success', APIResponseMessage::ACTIVATE_RECORD);
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
    public function getAjaxCandidateData()
    {
        $model = Candidate::with(['country', 'job', 'agent'])
            ->orderBy('id', 'desc');

        return DataTables::eloquent($model)
            ->addIndexColumn()

            /* Candidate Name */
            ->editColumn('full_name', function ($data) {
                return e($data->full_name);
            })

            /* Country Name (relation) */
            ->addColumn('country_name', function ($data) {
                return optional($data->country)->country_name ?? '-';
            })

            ->filterColumn('country_name', function ($query, $keyword) {
                $query->whereHas('country', function ($q) use ($keyword) {
                    $q->where('country_name', 'LIKE', "%{$keyword}%");
                });
            })
            ->addColumn('edit', content: function ($data) {
                $edit_url = route('candidate.show',encrypt($data->id));
                $btn = '<a href="' . $edit_url . '"><i class="fal fa-edit"></i></a>';
                return $btn;
            })
            ->addColumn('export_cv', content: function ($data) {
                $edit_url = route('candidate.cv',encrypt($data->id));
                $btn = '<a href="' . $edit_url . '"><i class="fal fa-download"></i></a>';
                return $btn;
            })
            ->addColumn('activation', function ($data) {
                return view('admin.candidate.partials._status', compact('data'));
            })

            ->rawColumns(['edit','export_cv'])
            ->toJson();
    }


    private function updateCandidateDocumentStatus(Candidate $candidate)
    {
        $mandatoryDocIds = DocumentType::where('is_mandatory', true)->pluck('id');

        $submittedCount = CandidateDocument::where('candidate_id', $candidate->id)
            ->whereIn('document_type_id', $mandatoryDocIds)
            ->where('is_submitted', true)
            ->count();

        if ($submittedCount === $mandatoryDocIds->count()) {
            $candidate->update([
                'status' => CandidateStatus::DOCUMENT_COMPLETED
            ]);
        } else {
            $candidate->update([
                'status' => CandidateStatus::DOCUMENT_PENDING
            ]);
        }
    }

    public function exportCv($encryptedId)
    {
        $id = decrypt($encryptedId);
        $candidate = Candidate::findOrFail($id);

        $pdf = Pdf::loadView('admin.candidate.cv', compact('candidate'));
        $filename = 'CV_' . $candidate->full_name . '.pdf';
        return $pdf->download($filename);
    }


}
