<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReportController;
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
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/admin', [DashboardController::class,'Dashboard']);
        Route::get('/summary', [DashboardController::class,'Summary']);
    });
    Route::controller(UserController::class)->group(function () {
        Route::post('/resetPassword', 'resetPassword');
        Route::post('/update-profile', 'UpdateProfile');
        Route::get('/user-data', 'ProfileData');
        Route::get('/reset-password', 'ResetPasswordPage');
        Route::get('/user-profile', 'UserProfilePage');
    });
    Route::controller(CustomerController::class)->group(function () {
        Route::get('/customers', 'CustomerPage');
        Route::get('/customer-list', 'CustomerList');
        Route::post('/create-customer', 'CustomerCreate');
        Route::post('/update-customer', 'CustomerUpdate');
        Route::post('/customer-by-id', 'CustomerByID');
        Route::post('/delete-customer', 'CustomerDelete');
    });
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/categories', 'CategoryPage');
        Route::get('/category-list', 'CategoryList');
        Route::post('/create-category', 'CategoryCreate');
        Route::post('/update-category', 'CategoryUpdate');
        Route::post('/category-by-id', 'CategoryByID');
        Route::post('/delete-category', 'CategoryDelete');
    });
    Route::controller(ProductController::class)->group(function () {
        Route::get('/products', 'ProductPage');
        Route::get('/product-list', 'ProductList');
        Route::post('/create-product', 'ProductCreate');
        Route::post('/update-product', 'ProductUpdate');
        Route::post('/product-by-id', 'ProductByID');
        Route::post('/delete-product', 'ProductDelete');
    });
    Route::controller(InvoiceController::class)->group(function () {
        Route::get('/sales', 'SalePage');
        Route::get('/invoices', 'InvoicePage');
        Route::get('/invoice-list', 'InvoiceList');
        Route::post('/invoice-create', 'InvoiceCreate');
        Route::post('/invoice-details', 'InvoiceDetails');
        Route::post('/invoice-delete', 'InvoiceDelete');
    });
    
    Route::controller(InvoiceController::class)->group(function () {
        Route::get('/reportPage',[ReportController::class,'ReportPage']);
        Route::get("/sales-report/{FormDate}/{ToDate}",[ReportController::class,'SalesReport']);
    });
});
