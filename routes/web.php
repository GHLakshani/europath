<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ImageListController;
use App\Http\Controllers\ContactUsController;

use App\Http\Controllers\SiteAuthController;
use App\Http\Controllers\PurchaseController;

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth.login');
});


require __DIR__ . '/auth.php';
