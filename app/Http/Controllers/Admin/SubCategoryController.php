<?php

namespace App\Http\Controllers\Admin;

use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Events\LoggableEvent;
use Illuminate\Support\Facades\DB;
use App\Helpers\APIResponseMessage;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use App\Http\Requests\SubCategoryRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Routing\Controllers\Middleware;

class SubCategoryController extends Controller
{
    /**
     * Define the middleware for the SubCategoryController.
     *
     * This method returns an array of Middleware instances that specify
     * the middleware to be applied to various controller actions.
     *
     * @return array An array of Middleware instances.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('sub-category-list|sub-category-create|sub-category-edit|sub-category-delete', only: ['list']),
            new Middleware('sub-category-create', only: ['index', 'store']),
            new Middleware('sub-category-edit', only: ['edit', 'update']),
            new Middleware('sub-category-delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the SubCategory master data.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.sub_category.list');
    }

    /**
     * Display the form for creating a new sub-category.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $Category = Category::where('status', 'Y')->orderBy('id', 'asc')->get();

        return view('admin.sub_category.create', [
            'categories' => $Category,
        ]);
    }

    /**
     * Store a newly created SubCategory in storage.
     *
     * @param  \App\Http\Requests\SubCategoryRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function store(SubCategoryRequest $request)
    {
        try {
            DB::beginTransaction();

            $SubCategory = new SubCategory();
            $SubCategory->category_id = $request->category_id;
            $SubCategory->sub_category_name = $request->sub_category_name;
            $SubCategory->order = $request->order;
            $SubCategory->created_by = Auth::id();
            $SubCategory->save();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($SubCategory, 'created'));

            return redirect()->route('sub-category.index')->with('success', APIResponseMessage::CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('sub-category.index')->with('success', APIResponseMessage::FAIL);
        }
    }

    /**
     * Display the specified sub-category.
     *
     * This method decrypts the provided SubCategory ID, retrieves the SubCategory
     * details from the database, and returns the view for editing the sub-category.
     *
     * @param string $id The encrypted SubCategory ID.
     * @return \Illuminate\View\View The view for editing the sub-category.
     */
    public function show(string $id)
    {
        $SubCategoryId = decrypt($id);
        $SubCategory = SubCategory::with([])->find($SubCategoryId);
        $Category = Category::where('status', 'Y')->orderBy('id', 'asc')->get();

        return view('admin.sub_category.edit',[
            'subCategory' => $SubCategory,
            'categories' => $Category,
        ]);
    }

    /**
     * Update the specified SubCategory in storage.
     *
     * @param  \App\Http\Requests\SubCategoryRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function update(SubCategoryRequest $request, string $id)
    {
        try {

            DB::beginTransaction();

            $SubCategory = SubCategory::find($id);
            $SubCategory->category_id = $request->category_id;
            $SubCategory->sub_category_name = $request->sub_category_name;
            $SubCategory->order = $request->order;
            $SubCategory->updated_by = Auth::id();
            $SubCategory->save();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($SubCategory, 'update'));

            return redirect()->route('sub-category.index')->with('success', APIResponseMessage::CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('sub-category.index')->with('error', APIResponseMessage::ERROR_EXCEPTION);
        }
    }

    /**
     * Destroy the specified sub-category.
     *
     * @param string $id The ID of the SubCategory to be deleted.
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception If an error occurs during the deletion process.
     *
     * This method performs the following actions:
     * - Begins a database transaction.
     * - Finds the SubCategory by ID.
     * - Updates the 'deleted_by' field with the ID of the authenticated user.
     * - Deletes the sub-category.
     * - Commits the transaction.
     * - Dispatches a LoggableEvent to log the deletion.
     * - Redirects to the SubCategory index route with a success message.
     *
     * If an exception occurs, the transaction is rolled back, an error is logged,
     * and the user is redirected to the SubCategory index route with an error message.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $SubCategory = SubCategory::find($id);

            $SubCategory->update(['deleted_by' => Auth::id()]);
            SubCategory::with([])->find($id)->delete();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($SubCategory, 'deleted'));

            return redirect()->route('sub-category.index')->with('success', APIResponseMessage::DELETED);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::critical('Exception in delete Banner : ', [$e->getMessage()]);
            return redirect()->route('sub-category.index')->with('error', APIResponseMessage::ERROR_EXCEPTION);

        }
    }

    /**
     * Activate or deactivate an SubCategory based on its current status.
     *
     * This method toggles the status of an SubCategory between 'Y' (active) and 'N' (inactive).
     * It also dispatches a LoggableEvent to log the status change.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing the SubCategory ID.
     * @return \Illuminate\Http\RedirectResponse Redirects to the SubCategory index route with a success message.
     */
    public function activation(Request $request)
    {
        $data =  SubCategory::find($request->id);

        if ( $data->status == "Y" ) {

            $data->status = 'N';
            $data->save();
            $id = $data->id;

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($data, 'status-change'));

            return redirect()->route('sub-category.index')->with('success', APIResponseMessage::DEACTIVALE_RECORD);
        } else {
            $data->status = "Y";
            $data->save();
            $id = $data->id;

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($data, 'statuschange'));

            return redirect()->route('sub-category.index')->with('success', APIResponseMessage::ACTIVATE_RECORD);
        }

    }

    /**
     * Retrieve SubCategory data for DataTables via AJAX.
     *
     * This method fetches SubCategory data from the database, orders it by 'id' in descending order,
     * and returns it in a format suitable for DataTables. It includes additional columns for
     * editing, activation status, and deletion.
     *
     * @return \Illuminate\Http\JsonResponse JSON response containing the SubCategory data for DataTables.
     */

    public function getAjaxSubCategoryData()
        {
            $model = SubCategory::query()
                ->whereHas('category')
                ->with(['category'])
                ->orderBy('id', 'asc');

            return DataTables::eloquent($model)
                ->addIndexColumn()
                ->editColumn('sub_category_name', function ($data) {
                    return $data['sub_category_name'];
                })
                ->editColumn('category_name', function ($data) {
                    return optional($data->category)->category_name; // Prevent error if null
                })
                ->filterColumn('category_name', function ($query, $keyword) {
                    $query->whereHas('Category', function ($q) use ($keyword) {
                        $q->where('category_name', 'LIKE', "%{$keyword}%");
                    });
                })
                ->addColumn('edit', function ($data) {
                    $edit_url = route('sub-category.show', encrypt($data->id));
                    return '<a href="' . $edit_url . '"><i class="fal fa-edit"></i></a>';
                })
                ->addColumn('activation', function ($data) {
                    return view('admin.sub_category.partials._status', compact('data'));
                })
                ->addColumn('delete', function ($data) {
                    return view('admin.sub_category.partials._delete', compact('data'));
                })
                ->rawColumns(['edit'])
                ->toJson();
        }

}
