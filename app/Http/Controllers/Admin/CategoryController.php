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
use App\Http\Requests\CategoryRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Define the middleware for the CategoryController.
     *
     * This method returns an array of Middleware instances that specify
     * the middleware to be applied to various controller actions.
     *
     * @return array An array of Middleware instances.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('category-list|category-create|category-edit|category-delete', only: ['list']),
            new Middleware('category-create', only: ['index', 'store']),
            new Middleware('category-edit', only: ['edit', 'update']),
            new Middleware('category-delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the Category master data.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.category.list');
    }

    /**
     * Display the form for creating a new category.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function store(CategoryRequest $request)
    {

        try {
            DB::beginTransaction();
            $Category = new Category();
            $Category->category_name = $request->category_name;
            $Category->order = $request->order;

            $Category->created_by = Auth::id();
            $Category->save();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($Category, 'created'));

            return redirect()->route('category.index')->with('success', APIResponseMessage::CREATED);
        } catch (\Exception $e) {
            // dd($e);
            DB::rollBack();
            return redirect()->route('category.index')->with('success', APIResponseMessage::FAIL);
        }
    }

    /**
     * Display the specified category.
     *
     * This method decrypts the provided Category ID, retrieves the Category
     * details from the database, and returns the view for editing the category.
     *
     * @param string $id The encrypted Category ID.
     * @return \Illuminate\View\View The view for editing the category.
     */
    public function show(string $id)
    {
        $CategoryId = decrypt($id);
        $Category = Category::with([])->find($CategoryId);

        return view('admin.category.edit',[
            'category' => $Category,
        ]);
    }

    /**
     * Update the specified Category in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function update(CategoryRequest $request, string $id)
    {
        try {

            DB::beginTransaction();

            $Category = Category::find($id);
            $Category->category_name = $request->category_name;
            $Category->order = $request->order;
            $Category->updated_by = Auth::id();
            $Category->save();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($Category, 'update'));

            return redirect()->route('category.index')->with('success', APIResponseMessage::CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('category.index')->with('error', APIResponseMessage::ERROR_EXCEPTION);
        }
    }

    /**
     * Destroy the specified category.
     *
     * @param string $id The ID of the Category to be deleted.
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception If an error occurs during the deletion process.
     *
     * This method performs the following actions:
     * - Begins a database transaction.
     * - Finds the Category by ID.
     * - Updates the 'deleted_by' field with the ID of the authenticated user.
     * - Deletes the category.
     * - Commits the transaction.
     * - Dispatches a LoggableEvent to log the deletion.
     * - Redirects to the Category index route with a success message.
     *
     * If an exception occurs, the transaction is rolled back, an error is logged,
     * and the user is redirected to the Category index route with an error message.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $Category = Category::find($id);

            $Category->update(['deleted_by' => Auth::id()]);
            Category::with([])->find($id)->delete();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($Category, 'deleted'));

            return redirect()->route('category.index')->with('success', APIResponseMessage::DELETED);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::critical('Exception in delete branch network : ', [$e->getMessage()]);
            return redirect()->route('category.index')->with('error', APIResponseMessage::ERROR_EXCEPTION);

        }
    }

    /**
     * Activate or deactivate an Category based on its current status.
     *
     * This method toggles the status of an Category between 'Y' (active) and 'N' (inactive).
     * It also dispatches a LoggableEvent to log the status change.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing the Category ID.
     * @return \Illuminate\Http\RedirectResponse Redirects to the Category index route with a success message.
     */
    public function activation(Request $request)
    {
        $data =  Category::find($request->id);

        if ( $data->status == "Y" ) {

            $data->status = 'N';
            $data->save();
            $id = $data->id;

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($data, 'status-change'));

            return redirect()->route('category.index')->with('success', APIResponseMessage::DEACTIVALE_RECORD);
        } else {
            $data->status = "Y";
            $data->save();
            $id = $data->id;

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($data, 'statuschange'));

            return redirect()->route('category.index')->with('success', APIResponseMessage::ACTIVATE_RECORD);
        }

    }

    /**
     * Retrieve Category data for DataTables via AJAX.
     *
     * This method fetches Category data from the database, orders it by 'id' in descending order,
     * and returns it in a format suitable for DataTables. It includes additional columns for
     * editing, activation status, and deletion.
     *
     * @return \Illuminate\Http\JsonResponse JSON response containing the Category data for DataTables.
     */
    public function getAjaxCategoryData()
    {
        $model = Category::query()->with([])->orderBy('id', 'desc');

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->editColumn('category_name', function ($data) {
                return ucfirst(str_replace('_', ' ', $data['category_name']));
            })
            ->addColumn('edit', content: function ($data) {
                $edit_url = route('category.show',encrypt($data->id));
                $btn = '<a href="' . $edit_url . '"><i class="fal fa-edit"></i></a>';
                return $btn;
            })
            ->addColumn('featured', function ($data) {
                return view('admin.category.partials._featured', compact('data'));
            })
            ->addColumn('activation', function ($data) {
                return view('admin.category.partials._status', compact('data'));
            })
            ->addColumn('delete', function ($data) {
                return view('admin.category.partials._delete', compact('data'));
            })
            ->rawColumns(['edit', 'category_name'])
            ->toJson();
    }


    public function featured(Request $request)
    {
        $data =  Category::find($request->id);

        if ( $data->is_featured == "Y" ) {

            $data->is_featured = 'N';
            $data->save();
            $id = $data->id;

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($data, 'isfeatured-change'));

            return redirect()->route('category.index')->with('success', APIResponseMessage::DEACTIVALE_RECORD);
        } else {
            $data->is_featured = "Y";
            $data->save();
            $id = $data->id;

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($data, 'isfeaturedchange'));

            return redirect()->route('category.index')->with('success', APIResponseMessage::ACTIVATE_RECORD);
        }

    }
}
