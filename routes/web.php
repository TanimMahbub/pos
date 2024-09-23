<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/',[HomeController::class,'HomePage']);

Route::controller(UserController::class)->group(function () {
    Route::post('/signup', 'userRegistration');
    Route::post('/login', 'userLogin');
    Route::post('/reset-password', 'sendOTP');
    Route::post('/verifyOTP', 'verifyOTP');

    Route::get('/signup', 'SignUpPage');
    Route::get('/login', 'LoginPage');
    Route::get('/logout', 'UserLogout');
    Route::get('/forgot-password', 'SendOtpPage');
    Route::get('/verify-OTP', 'VerifyOTPPage');
});

Route::middleware([TokenVerificationMiddleware::class])->group(function () {
    Route::get('/admin', [DashboardController::class,'Dashboard']);
    Route::controller(UserController::class)->group(function () {
        Route::post('/resetPassword', 'resetPassword');
        Route::post('/update-profile', 'UpdateProfile');
        Route::get('/user-data', 'ProfileData');
        Route::get('/reset-password', 'ResetPasswordPage');
        Route::get('/user-profile', 'UserProfilePage');
    });
    Route::controller(CustomerController::class)->group(function () {
        Route::get('/customers', 'CustomerPage');
        Route::get('/customer-list', 'CategoryList');
        Route::post('/create-customer', 'CategoryCreate');
    });
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/categories', 'CategoryPage');
        Route::get('/category-list', 'CategoryList');
        Route::post('/create-category', 'CategoryCreate');
        Route::post('/update-category', 'CategoryUpdate');
        Route::post('/category-by-id', 'CategoryByID');
        Route::post('/delete-category', 'CategoryDelete');
    });
});
