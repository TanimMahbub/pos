<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('/signup', [UserController::class, 'userRegistration']);
Route::post('/login', [UserController::class, 'userLogin']);
Route::post('/reset-password', [UserController::class, 'sendOTP']);
Route::post('/verifyOTP', [UserController::class, 'verifyOTP']);
Route::post('/resetPassword', [UserController::class, 'resetPassword'])->middleware(TokenVerificationMiddleware::class);