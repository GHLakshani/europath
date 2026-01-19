<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\RegisteredUserController;

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;


Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});


Route::group(['middleware' => ['auth']], function () {

    Route::prefix('mg-cms')->group(function () {

        Route::get('dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::resource('roles', RoleController::class);
        Route::get('roles-list', [RoleController::class, 'index'])->name('roles-list');
        Route::post('new-role', [RoleController::class, 'store'])->name('new-role');
        Route::get('create-roles', [RoleController::class, 'create'])->name('create-roles');
        Route::get('roles-edit/{id}', [RoleController::class, 'edit'])->name('roles-edit');
        Route::put('update-role', [RoleController::class, 'update'])->name('update-role');

        Route::resource('users', UserController::class);
        Route::get('users-list', [UserController::class, 'index'])->name('users-list');
        Route::get('create-users', [UserController::class, 'create'])->name('create-users');
        Route::post('new-user', [UserController::class, 'store'])->name('new-user');
        Route::get('get-users-list', [UserController::class, 'getUserList'])->name('get-users-list');
        Route::get('users-edit/{id}', [UserController::class, 'show'])->name('users-edit');
        Route::put('save-user', [UserController::class, 'update'])->name('save-user');
        Route::get('changestatus-user/{id}', [UserController::class, 'activation'])->name('changestatus-user');
        Route::delete('delete-user/{id}', [UserController::class, 'destroy'])->name('delete-user');

        Route::post('profile', [ProfileController::class, 'update'])->name('profile.store');

        Route::group([
            'prefix' => 'main-slider',
            'as' => 'main-slider.'
        ], function () {
            Route::get('/', [MainSliderController::class, 'index'])->name('index');
            Route::get('/create', [MainSliderController::class, 'create'])->name('create');
            Route::post('/store', [MainSliderController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [MainSliderController::class, 'edit'])->name('show');
            Route::get('/get-main-slider', [MainSliderController::class, 'getAjaxMainSliderData'])->name('get-main-slider');
            Route::put('/update/{id}', [MainSliderController::class, 'update'])->name('update');
            Route::put('/change-status/{id}', [MainSliderController::class, 'activation'])->name('change-status');
            Route::delete('/delete/{id}', [MainSliderController::class, 'destroy'])->name('delete');
        });

        Route::group([
            'prefix' => 'photographer',
            'as' => 'photographer.'
        ], function () {
            Route::get('/', [PhotographerController::class, 'index'])->name('index');
            Route::get('/create', [PhotographerController::class, 'create'])->name('create');
            Route::post('/store', [PhotographerController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [PhotographerController::class, 'edit'])->name('show');
            Route::get('/get-photographer', [PhotographerController::class, 'getAjaxPhotographerData'])->name('get-photographer');
            Route::put('/update/{id}', [PhotographerController::class, 'update'])->name('update');
            Route::put('/change-status/{id}', [PhotographerController::class, 'activation'])->name('change-status');
            Route::delete('/delete/{id}', [PhotographerController::class, 'destroy'])->name('delete');
        });


        // ********Category***********
        Route::group([
            'prefix' => 'category',
            'as' => 'category.'
        ], function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('/create', [CategoryController::class, 'create'])->name('create');
            Route::post('/store', [CategoryController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [CategoryController::class, 'show'])->name('show');
            Route::get('/get-category', [CategoryController::class, 'getAjaxCategoryData'])->name('get-category');
            Route::put('/update/{id}', [CategoryController::class, 'update'])->name('update');
            Route::put('/change-status/{id}', [CategoryController::class, 'activation'])->name('change-status');
            Route::put('/change-featured-status/{id}', [CategoryController::class, 'featured'])->name('change-featured-status');
            Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('delete');
        });

        // ********sub Category***********
        Route::group([
            'prefix' => 'sub-category',
            'as' => 'sub-category.'
        ], function () {
            Route::get('/', [SubCategoryController::class, 'index'])->name('index');
            Route::get('/create', [SubCategoryController::class, 'create'])->name('create');
            Route::post('/store', [SubCategoryController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [SubCategoryController::class, 'show'])->name('show');
            Route::get('/get-sub-category', [SubCategoryController::class, 'getAjaxSubCategoryData'])->name('get-sub-category');
            Route::put('/update/{id}', [SubCategoryController::class, 'update'])->name('update');
            Route::put('/change-status/{id}', [SubCategoryController::class, 'activation'])->name('change-status');
            Route::delete('/delete/{id}', [SubCategoryController::class, 'destroy'])->name('delete');
        });

        // ******** uplad images***********
        Route::group([
            'prefix' => 'upload-image',
            'as' => 'upload-image.'
        ], function () {
            Route::get('/', [UploadImageController::class, 'index'])->name('index');
            Route::get('/create', [UploadImageController::class, 'create'])->name('create');
            Route::post('/store', [UploadImageController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [UploadImageController::class, 'show'])->name('show');
            Route::get('/get-upload-image', [UploadImageController::class, 'getAjaxUploadImageData'])->name('get-upload-image');
            Route::put('/update/{id}', [UploadImageController::class, 'update'])->name('update');
            Route::put('/change-status/{id}', [UploadImageController::class, 'activation'])->name('change-status');
            Route::delete('/delete/{id}', [UploadImageController::class, 'destroy'])->name('delete');
            Route::get('/subcategories/{category}', [UploadImageController::class, 'getByCategory'])->name('upload-image.subcategories');

        });

        // ********Meta Tags***********
        Route::group([
            'prefix' => 'meta-tag',
            'as' => 'meta-tag.'
        ], function () {
            Route::get('/', [MetaTagController::class, 'index'])->name('index');
            Route::get('/create', [MetaTagController::class, 'create'])->name('create');
            Route::post('/store', [MetaTagController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [MetaTagController::class, 'show'])->name('show');
            Route::get('/get-meta-tag', [MetaTagController::class, 'getAjaxMetaTagData'])->name('get-meta-tag');
            Route::put('/update/{id}', [MetaTagController::class, 'update'])->name('update');
            Route::put('/change-status/{id}', [MetaTagController::class, 'activation'])->name('change-status');
            Route::delete('/delete/{id}', [MetaTagController::class, 'destroy'])->name('delete');
        });

        // ******** contact us *****
        Route::prefix('contact_us')->group(function () {
            Route::group([
                'prefix' => 'contact-us',
                'as' => 'contact-us.'
            ], function () {
                Route::get('/', [ContactUsController::class, 'index'])->name('index');
                Route::post('/update/{id}', [ContactUsController::class, 'update'])->name('update');
            });

            Route::group([
                'prefix' => 'contact-us-inquiry',
                'as' => 'contact-us-inquiry.'
            ], function () {
                Route::get('/', [ContactUsInquiryController::class, 'index'])->name('index');
                Route::get('/edit/{id}', [ContactUsInquiryController::class, 'show'])->name('show');
                Route::get('/get-contact-us-inquiry', [ContactUsInquiryController::class, 'getAjaxContactInquiryData'])->name('get-contact-us-inquiry');
            });
        });

        // ******** testimonial *****
        Route::group([
            'prefix' => 'testimonial',
            'as' => 'testimonial.'
        ], function () {
            Route::get('/', [TestimonialController::class, 'index'])->name('index');
            Route::get('/create', [TestimonialController::class, 'create'])->name('create');
            Route::post('/store', [TestimonialController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [TestimonialController::class, 'show'])->name('show');
            Route::get('/get-testimonial', [TestimonialController::class, 'getAjaxTestimonialData'])->name('get-testimonial');
            Route::put('/update/{id}', [TestimonialController::class, 'update'])->name('update');
            Route::put('/change-status/{id}', [TestimonialController::class, 'activation'])->name('change-status');
            Route::delete('/delete/{id}', [TestimonialController::class, 'destroy'])->name('delete');
        });

    });
});

