<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\NewsController;
use App\Http\Controllers\API\CommonController;

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

// Auth
Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('forgot-password', [UserController::class, 'forgotPassword']);
Route::post('reset-password', [UserController::class, 'resetPassword']);

// Common APIs
Route::post('get-countries/{id?}', [CommonController::class, 'getCountries']);
Route::post('get-states/{id}', [CommonController::class, 'getStates']);
Route::post('get-cities/{id}', [CommonController::class, 'getcities']);

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [UserController::class, 'logout']);

    Route::post('edit-profile', [UserController::class, 'editProfile']);
    Route::post('edit-profile/upload-picture', [UserController::class, 'uploadPicture']);
    Route::post('get-profile-details', [UserController::class, 'getProfileDetails']);

    Route::get('fetch-news', [NewsController::class, 'index']);
});
