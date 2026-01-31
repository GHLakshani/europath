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

use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\SubDealerController;
use App\Http\Controllers\Admin\DocumentTypeController;

use App\Http\Controllers\Admin\CandidateController;


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

    Route::prefix('hanara-cms')->group(function () {

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

        // ********country***********
        Route::group([
            'prefix' => 'country',
            'as' => 'country.'
        ], function () {
            Route::get('/', [CountryController::class, 'index'])->name('index');
            Route::get('/create', [CountryController::class, 'create'])->name('create');
            Route::post('/store', [CountryController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [CountryController::class, 'show'])->name('show');
            Route::get('/get-country', [CountryController::class, 'getAjaxCountryData'])->name('get-country');
            Route::put('/update/{id}', [CountryController::class, 'update'])->name('update');
            Route::put('/change-status/{id}', [CountryController::class, 'activation'])->name('change-status');
            Route::put('/change-featured-status/{id}', [CountryController::class, 'featured'])->name('change-featured-status');
            Route::delete('/delete/{id}', [CountryController::class, 'destroy'])->name('delete');
        });

        // ********job***********
        Route::group([
            'prefix' => 'job',
            'as' => 'job.'
        ], function () {
            Route::get('/', [JobController::class, 'index'])->name('index');
            Route::get('/create', [JobController::class, 'create'])->name('create');
            Route::post('/store', [JobController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [JobController::class, 'show'])->name('show');
            Route::get('/get-job', [JobController::class, 'getAjaxJobData'])->name('get-job');
            Route::put('/update/{id}', [JobController::class, 'update'])->name('update');
            Route::put('/change-status/{id}', [JobController::class, 'activation'])->name('change-status');
            Route::delete('/delete/{id}', [JobController::class, 'destroy'])->name('delete');
        });


        // ********agent***********
        Route::group([
            'prefix' => 'agent',
            'as' => 'agent.'
        ], function () {
            Route::get('/', [AgentController::class, 'index'])->name('index');
            Route::get('/create', [AgentController::class, 'create'])->name('create');
            Route::post('/store', [AgentController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [AgentController::class, 'show'])->name('show');
            Route::get('/get-agent', [AgentController::class, 'getAjaxAgentData'])->name('get-agent');
            Route::put('/update/{id}', [AgentController::class, 'update'])->name('update');
            Route::put('/change-status/{id}', [AgentController::class, 'activation'])->name('change-status');
            Route::delete('/delete/{id}', [AgentController::class, 'destroy'])->name('delete');
        });

        // ********sub dealer***********
        Route::group([
            'prefix' => 'sub-dealer',
            'as' => 'sub-dealer.'
        ], function () {
            Route::get('/', [SubDealerController::class, 'index'])->name('index');
            Route::get('/create', [SubDealerController::class, 'create'])->name('create');
            Route::post('/store', [SubDealerController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [SubDealerController::class, 'show'])->name('show');
            Route::get('/get-sub-dealer', [SubDealerController::class, 'getAjaxSubDealerData'])->name('get-sub-dealer');
            Route::put('/update/{id}', [SubDealerController::class, 'update'])->name('update');
            Route::put('/change-status/{id}', [SubDealerController::class, 'activation'])->name('change-status');
            Route::delete('/delete/{id}', [SubDealerController::class, 'destroy'])->name('delete');
        });

        // ********document type***********
        Route::group([
            'prefix' => 'document-type',
            'as' => 'document-type.'
        ], function () {
            Route::get('/', [DocumentTypeController::class, 'index'])->name('index');
            Route::get('/create', [DocumentTypeController::class, 'create'])->name('create');
            Route::post('/store', [DocumentTypeController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [DocumentTypeController::class, 'show'])->name('show');
            Route::get('/get-document-type', [DocumentTypeController::class, 'getAjaxDocumentTypeData'])->name('get-document-type');
            Route::put('/update/{id}', [DocumentTypeController::class, 'update'])->name('update');
            Route::put('/change-status/{id}', [DocumentTypeController::class, 'activation'])->name('change-status');
            Route::delete('/delete/{id}', [DocumentTypeController::class, 'destroy'])->name('delete');
        });

        // ********candidate***********
        Route::group([
            'prefix' => 'candidate',
            'as' => 'candidate.'
        ], function () {
            Route::get('/', [CandidateController::class, 'index'])->name('index');
            Route::get('/create', [CandidateController::class, 'create'])->name('create');
            Route::post('/store', [CandidateController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [CandidateController::class, 'show'])->name('show');
            Route::get('/get-candidate', [CandidateController::class, 'getAjaxCandidateData'])->name('get-candidate');
            Route::put('/update/{id}', [CandidateController::class, 'update'])->name('update');
            Route::put('/change-status/{id}', [CandidateController::class, 'activation'])->name('change-status');
            Route::delete('/delete/{id}', [CandidateController::class, 'destroy'])->name('delete');
            Route::get('/{encryptedId}/cv', [CandidateController::class, 'exportCv'])->name('cv');

        });
    });
});
