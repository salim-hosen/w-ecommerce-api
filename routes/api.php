<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\User\MeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get("/", function(){
    return "HELLO";
});

// Routes for guests only
Route::group(['middleware' => ['guest:api']], function(){

    // Guest User Routes
    Route::post('login', [LoginController::class, 'login']); // for api consumer eg. mobile
    Route::post('register', [RegisterController::class, 'register'])->name("register");

    Route::post('verification/verify/{user}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('verification/resend', [VerificationController::class, 'resend']);
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('password/reset', [ResetPasswordController::class, 'reset']);

});


Route::group(['middleware' => ['auth:api']], function(){

    Route::post('logout', [LoginController::class, 'logout']); // api user logout
    Route::get('me', [MeController::class, 'getMe']);

});
