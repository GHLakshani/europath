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
use App\Http\Requests\DocumentTypeRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Models\DocumentType;

class DocumentTypeController extends Controller
{
    /**
     * Define the middleware for the DocumentTypeController.
     *
     * This method returns an array of Middleware instances that specify
     * the middleware to be applied to various controller actions.
     *
     * @return array An array of Middleware instances.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('document-type-list|document-type-create|document-type-edit|document-type-delete', only: ['list']),
            new Middleware('document-type-create', only: ['index', 'store']),
            new Middleware('document-type-edit', only: ['edit', 'update']),
            new Middleware('document-type-delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the document-type master data.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.document_type.list');
    }

    /**
     * Display the form for creating a new document_type.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        return view('admin.document_type.create');
    }

    /**
     * Store a newly created document-type in storage.
     *
     * @param  \App\Http\Requests\DocumentTypeRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function store(DocumentTypeRequest $request)
    {
        try {
            DB::beginTransaction();
            $documentType = new DocumentType();
            $documentType->name = $request->name;
            $documentType->is_mandatory = $request->boolean('is_mandatory');

            $documentType->created_by = Auth::id();
            $documentType->save();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($documentType, 'created'));

            return redirect()->route('document-type.index')->with('success', APIResponseMessage::CREATED);
        } catch (\Exception $e) {
            // dd($e);
            DB::rollBack();
            return redirect()->route('document-type.index')->with('success', APIResponseMessage::FAIL);
        }
    }

    /**
     * Display the specified document_type.
     *
     * This method decrypts the provided document-type ID, retrieves the document-type
     * details from the database, and returns the view for editing the document_type.
     *
     * @param string $id The encrypted document-type ID.
     * @return \Illuminate\View\View The view for editing the document_type.
     */
    public function show(string $id)
    {
        $documentTypeId = decrypt($id);
        $documentType = DocumentType::with([])->find($documentTypeId);

        return view('admin.document_type.edit',[
            'documentType' => $documentType
        ]);
    }

    /**
     * Update the specified document-type in storage.
     *
     * @param  \App\Http\Requests\DocumentTypeRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function update(DocumentTypeRequest $request, string $id)
    {
        try {

            DB::beginTransaction();

            $documentType = DocumentType::find($id);
            $documentType->name = $request->name;
            $documentType->is_mandatory = $request->is_mandatory;
            $documentType->updated_by = Auth::id();
            $documentType->save();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($documentType, 'update'));

            return redirect()->route('document-type.index')->with('success', APIResponseMessage::CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('document-type.index')->with('error', APIResponseMessage::ERROR_EXCEPTION);
        }
    }

    /**
     * Destroy the specified document_type.
     *
     * @param string $id The ID of the document-type to be deleted.
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception If an error occurs during the deletion process.
     *
     * This method performs the following actions:
     * - Begins a database transaction.
     * - Finds the document-type by ID.
     * - Updates the 'deleted_by' field with the ID of the authenticated user.
     * - Deletes the document_type.
     * - Commits the transaction.
     * - Dispatches a LoggableEvent to log the deletion.
     * - Redirects to the document-type index route with a success message.
     *
     * If an exception occurs, the transaction is rolled back, an error is logged,
     * and the user is redirected to the document-type index route with an error message.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $documentType = DocumentType::find($id);

            $documentType->update(['deleted_by' => Auth::id()]);
            DocumentType::with([])->find($id)->delete();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($documentType, 'deleted'));

            return redirect()->route('document-type.index')->with('success', APIResponseMessage::DELETED);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::critical('Exception in delete branch network : ', [$e->getMessage()]);
            return redirect()->route('document-type.index')->with('error', APIResponseMessage::ERROR_EXCEPTION);

        }
    }

    /**
     * Activate or deactivate an document-type based on its current status.
     *
     * This method toggles the status of an document-type between 'Y' (active) and 'N' (inactive).
     * It also dispatches a LoggableEvent to log the status change.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing the document-type ID.
     * @return \Illuminate\Http\RedirectResponse Redirects to the document-type index route with a success message.
     */
    public function activation(Request $request)
    {
        $data =  DocumentType::find($request->id);

        if ( $data->status == "Y" ) {

            $data->status = 'N';
            $data->save();
            $id = $data->id;

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($data, 'status-change'));

            return redirect()->route('document-type.index')->with('success', APIResponseMessage::DEACTIVALE_RECORD);
        } else {
            $data->status = "Y";
            $data->save();
            $id = $data->id;

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($data, 'statuschange'));

            return redirect()->route('document-type.index')->with('success', APIResponseMessage::ACTIVATE_RECORD);
        }

    }

    /**
     * Retrieve document-type data for DataTables via AJAX.
     *
     * This method fetches document-type data from the database, orders it by 'id' in descending order,
     * and returns it in a format suitable for DataTables. It includes additional columns for
     * editing, activation status, and deletion.
     *
     * @return \Illuminate\Http\JsonResponse JSON response containing the document-type data for DataTables.
     */
    public function getAjaxDocumentTypeData()
    {
        $model = DocumentType::query()->orderBy('id', 'desc');

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->editColumn('name', function ($data) {
                return ucfirst(str_replace('_', ' ', $data['name']));
            })
            ->addColumn('edit', content: function ($data) {
                $edit_url = route('document-type.show',encrypt($data->id));
                $btn = '<a href="' . $edit_url . '"><i class="fal fa-edit"></i></a>';
                return $btn;
            })
            ->addColumn('activation', function ($data) {
                return view('admin.document_type.partials._status', compact('data'));
            })
            ->addColumn('delete', function ($data) {
                return view('admin.document_type.partials._delete', compact('data'));
            })
            ->rawColumns(['edit', 'name'])
            ->toJson();
    }

}
