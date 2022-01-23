<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\User\MeController;
use App\Models\Product;
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

    Route::resource("products", ProductController::class)->except(["index", "show"]);
    Route::resource("orders", OrderController::class);

});


// Public Routes

Route::get("products", [ProductController::class, 'index'])->name("products.index");
Route::get("products/{slug}", [ProductController::class, 'show'])->name("products.show");
