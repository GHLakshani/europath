<?php

namespace App\Http\Controllers\Admin;

use App\Models\UploadImage;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Photographer;
use Illuminate\Http\Request;
use App\Events\LoggableEvent;
use Illuminate\Support\Facades\DB;
use App\Helpers\APIResponseMessage;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use App\Http\Requests\UploadImageRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Routing\Controllers\Middleware;
use Intervention\Image\Laravel\Facades\Image;

class UploadImageController extends Controller
{
    /**
     * Define the middleware for the UploadImageController.
     *
     * This method returns an array of Middleware instances that specify
     * the middleware to be applied to various controller actions.
     *
     * @return array An array of Middleware instances.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('upload-image-list|upload-image-create|upload-image-edit|upload-image-delete', only: ['list']),
            new Middleware('upload-image-create', only: ['index', 'store']),
            new Middleware('upload-image-edit', only: ['edit', 'update']),
            new Middleware('upload-image-delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the UploadImage master data.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.upload_image.list');
    }

    /**
     * Display the form for creating a new upload-image.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $Categories = Category::where('status', 'Y')->orderBy('id', 'asc')->get();
        $subcategories = SubCategory::where('status', 'Y')->orderBy('id', 'asc')->get();
        $photographers = Photographer::where('status', 'Y')->orderBy('id', 'asc')->get();

        return view('admin.upload_image.create', [
            'categories' => $Categories,
            'subcategories' => $subcategories,
            'photographers' => $photographers
        ]);
    }

    /**
     * Store a newly created UploadImage in storage.
     *
     * @param  \App\Http\Requests\UploadImageRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */

    public function store(UploadImageRequest $request)
    {
        try {
            DB::beginTransaction();

            // Fetch related category & subcategory
            $category    = Category::findOrFail($request->category_id);
            $subcategory = $request->subcategory_id
                            ? SubCategory::find($request->subcategory_id)
                            : null;
            

            // Prepare image manager (GD driver)
            $manager = new \Intervention\Image\ImageManager(
                new \Intervention\Image\Drivers\Gd\Driver()
            );

            // Read uploaded image
            $imageFile     = $request->file('image');
            $imageInstance = $manager->read($imageFile);

            // Read watermark
            $watermark = $manager->read(public_path('images/watermarks/watermark.png'));

            // Resize watermark to 20% of image width
            $watermark->scale(width: intval($imageInstance->width() * 0.2));

            for ($y = 0; $y < $imageInstance->height(); $y += $watermark->height() + 50) {
                for ($x = 0; $x < $imageInstance->width(); $x += $watermark->width() + 50) {
                    $imageInstance->place($watermark, 'top-left', $x, $y);
                }
            }

            // Place watermark at bottom-right with 10px offset
            $imageInstance->place($watermark, 'bottom-right', 10, 10);

            // Prepare directory & filename
            if ($subcategory) {
                $imageDirectory = 'images/' . $category->category_name . '/' . $subcategory->sub_category_name;
            } else {
                $imageDirectory = 'images/' . $category->category_name;
            }
            
            $compressedImageName = 'compressed_' . $imageFile->hashName();
            $imagePath           = storage_path('app/public/' . $imageDirectory . '/' . $compressedImageName);

            // Ensure directory exists
            if (!file_exists(dirname($imagePath))) {
                mkdir(dirname($imagePath), 0755, true);
            }

            // Save compressed image
            $imageInstance->save($imagePath, quality: 75);

            // Get dimensions & size
            $width  = $imageInstance->width();
            $height = $imageInstance->height();
            $size   = filesize($imagePath) / 1024; // KB

            // Save record
            $UploadImage = UploadImage::create([
                'title' => $request->title,
                'filename'        => $imageFile->getClientOriginalName(),
                'path'            => $imageDirectory . '/' . $compressedImageName,
                'compressed_path' => $imageDirectory . '/' . $compressedImageName,
                'category_id'     => $request->category_id,
                'subcategory_id'  => $subcategory ? $subcategory->id : null,
                'user_id'         => Auth::id(),
                'photographer_id' => $request->photographer_id,
                'width'           => $width,
                'height'          => $height,
                'mime_type'       => $imageFile->getClientMimeType(),
                'size'            => $size,
                'processed'       => true,
                'price'  => $request->price,
                'created_by'      => Auth::id(),
            ]);

            DB::commit();

            Event::dispatch(new LoggableEvent($UploadImage, 'created'));

            return redirect()->route('upload-image.index')
                ->with('success', APIResponseMessage::CREATED);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Upload Image Store Error: " . $e->getMessage());
            return redirect()->route('upload-image.index')
                ->with('error', $e->getMessage());
        }
    }




    /**
     * Display the specified upload-image.
     *
     * This method decrypts the provided UploadImage ID, retrieves the UploadImage
     * details from the database, and returns the view for editing the upload-image.
     *
     * @param string $id The encrypted UploadImage ID.
     * @return \Illuminate\View\View The view for editing the upload-image.
     */
    public function show(string $id)
    {
        $UploadImageId = decrypt($id);
        $UploadImage = UploadImage::with([])->find($UploadImageId);
        $Categories = Category::where('status', 'Y')->orderBy('id', 'asc')->get();
        $subcategories = SubCategory::where('status', 'Y')->orderBy('id', 'asc')->get();
        $photographers = Photographer::where('status', 'Y')->orderBy('id', 'asc')->get();

        return view('admin.upload_image.edit',[
            'image' => $UploadImage,
            'categories' => $Categories,
            'subcategories' => $subcategories,
            'photographers' => $photographers
        ]);
    }

    /**
     * Update the specified UploadImage in storage.
     *
     * @param  \App\Http\Requests\UploadImageRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */

    public function update(UploadImageRequest $request, string $id)
    {
        try {
            DB::beginTransaction();

            $UploadImage = UploadImage::findOrFail($id);

            $category    = Category::findOrFail($request->category_id);
            $subcategory = $request->subcategory_id
                            ? SubCategory::find($request->subcategory_id)
                            : null;

            // Prepare Intervention Image Manager (GD driver)
            $manager = new \Intervention\Image\ImageManager(
                new \Intervention\Image\Drivers\Gd\Driver()
            );

            if ($request->hasFile('image')) {
                $imageFile = $request->file('image');
                if ($subcategory) {
                    $imageDirectory = 'images/' . $category->category_name . '/' . $subcategory->sub_category_name;
                } else {
                    $imageDirectory = 'images/' . $category->category_name;
                }

                // Read uploaded image
                $imageInstance = $manager->read($imageFile);

                // Load watermark
                $watermark = $manager->read(public_path('images/watermarks/watermark.png'));

                // Resize watermark to 20% of image width
                $watermark->scale(width: intval($imageInstance->width() * 0.2));

                for ($y = 0; $y < $imageInstance->height(); $y += $watermark->height() + 50) {
                    for ($x = 0; $x < $imageInstance->width(); $x += $watermark->width() + 50) {
                        $imageInstance->place($watermark, 'top-left', $x, $y);
                    }
                }

                // Place watermark bottom-right with 10px offset
                $imageInstance->place($watermark, 'bottom-right', 10, 10);

                // Prepare compressed path
                $compressedImageName = 'compressed_' . $imageFile->hashName();
                $imagePath = storage_path('app/public/' . $imageDirectory . '/' . $compressedImageName);

                // Ensure directory exists
                if (!file_exists(dirname($imagePath))) {
                    mkdir(dirname($imagePath), 0755, true);
                }

                // Save compressed + watermarked image
                $imageInstance->save($imagePath, quality: 75);

                $width  = $imageInstance->width();
                $height = $imageInstance->height();
                $size   = filesize($imagePath) / 1024; // KB

                // Delete old image if exists
                if ($UploadImage->compressed_path && file_exists(storage_path('app/public/' . $UploadImage->compressed_path))) {
                    unlink(storage_path('app/public/' . $UploadImage->compressed_path));
                }

                // Update new image details
                $UploadImage->filename        = $imageFile->getClientOriginalName();
                $UploadImage->path            = $imageDirectory . '/' . $compressedImageName;
                $UploadImage->compressed_path = $imageDirectory . '/' . $compressedImageName;
                $UploadImage->width           = $width;
                $UploadImage->height          = $height;
                $UploadImage->mime_type       = $imageFile->getClientMimeType();
                $UploadImage->size            = $size;
            }

            // Always update metadata
            $UploadImage->category_id    = $request->category_id;
            $UploadImage->subcategory_id = $request->subcategory_id;
            $UploadImage->photographer_id = $request->photographer_id;
            $UploadImage->title = $request->title;
            $UploadImage->price = $request->price;
            $UploadImage->updated_by     = Auth::id();

            $UploadImage->save();

            DB::commit();

            Event::dispatch(new LoggableEvent($UploadImage, 'updated'));

            return redirect()->route('upload-image.index')
                ->with('success', APIResponseMessage::UPDATED);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Upload Image Update Error: " . $e->getMessage());
            return redirect()->route('upload-image.index')
                ->with('error', APIResponseMessage::ERROR_EXCEPTION);
        }
    }




    /**
     * Destroy the specified upload-image.
     *
     * @param string $id The ID of the UploadImage to be deleted.
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception If an error occurs during the deletion process.
     *
     * This method performs the following actions:
     * - Begins a database transaction.
     * - Finds the UploadImage by ID.
     * - Updates the 'deleted_by' field with the ID of the authenticated user.
     * - Deletes the upload-image.
     * - Commits the transaction.
     * - Dispatches a LoggableEvent to log the deletion.
     * - Redirects to the UploadImage index route with a success message.
     *
     * If an exception occurs, the transaction is rolled back, an error is logged,
     * and the user is redirected to the UploadImage index route with an error message.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $UploadImage = UploadImage::find($id);

            $UploadImage->update(['deleted_by' => Auth::id()]);
            UploadImage::with([])->find($id)->delete();

            DB::commit();

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($UploadImage, 'deleted'));

            return redirect()->route('upload-image.index')->with('success', APIResponseMessage::DELETED);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::critical('Exception in delete Banner : ', [$e->getMessage()]);
            return redirect()->route('upload-image.index')->with('error', APIResponseMessage::ERROR_EXCEPTION);

        }
    }

    /**
     * Activate or deactivate an UploadImage based on its current status.
     *
     * This method toggles the status of an UploadImage between 'Y' (active) and 'N' (inactive).
     * It also dispatches a LoggableEvent to log the status change.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing the UploadImage ID.
     * @return \Illuminate\Http\RedirectResponse Redirects to the UploadImage index route with a success message.
     */
    public function activation(Request $request)
    {
        $data =  UploadImage::find($request->id);

        if ( $data->status == "Y" ) {

            $data->status = 'N';
            $data->save();
            $id = $data->id;

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($data, 'status-change'));

            return redirect()->route('upload-image.index')->with('success', APIResponseMessage::DEACTIVALE_RECORD);
        } else {
            $data->status = "Y";
            $data->save();
            $id = $data->id;

            // Dispatch Activity Event to log this creation
            Event::dispatch(new LoggableEvent($data, 'statuschange'));

            return redirect()->route('upload-image.index')->with('success', APIResponseMessage::ACTIVATE_RECORD);
        }

    }

    /**
     * Retrieve UploadImage data for DataTables via AJAX.
     *
     * This method fetches UploadImage data from the database, orders it by 'id' in descending order,
     * and returns it in a format suitable for DataTables. It includes additional columns for
     * editing, activation status, and deletion.
     *
     * @return \Illuminate\Http\JsonResponse JSON response containing the UploadImage data for DataTables.
     */

    public function getAjaxUploadImageData()
    {
        $model = UploadImage::with(['category','subcategory','photographer'])->orderBy('id', 'asc');

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->addColumn('image', function($data){
                return '<img src="'. asset('storage/app/public/' . $data->path) .'" alt="'.$data->filename.'" width="60">';
            })
            ->addColumn('category_name', function($data){
                return optional($data->category)->category_name;
            })
            ->addColumn('subcategory_name', function($data){
                return optional($data->subcategory)->sub_category_name;
            })
            ->addColumn('photographer_name', function($data){
                return optional($data->photographer)->photographer_name;
            })
            ->addColumn('edit', function ($data) {
                $edit_url = route('upload-image.show', encrypt($data->id));
                return '<a href="' . $edit_url . '"><i class="fal fa-edit"></i></a>';
            })
            ->addColumn('activation', function ($data) {
                return view('admin.upload_image.partials._status', compact('data'));
            })
            ->addColumn('delete', function ($data) {
                return view('admin.upload_image.partials._delete', compact('data'));
            })
            ->rawColumns(['image','edit','activation','delete'])
            ->toJson();
    }

    public function getByCategory($categoryId)
    {
        $subcategories = SubCategory::where('category_id', $categoryId)->get();
        return response()->json($subcategories);
    }


}
