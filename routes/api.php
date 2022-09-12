<?php

use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\UserController;
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
Route::namespace('Api')->group(function () {
    Route::get('swagger', 'SwaggerController@listItem');

    Route::post('emailVerify', [UserController::class, 'signupOtp']);
    Route::post('loginEmailVerify', [UserController::class, 'loginOtp']);
    Route::post('signup', [UserController::class, 'signup']);
    Route::post('login', [UserController::class, 'login']);
    Route::get('languages',[LanguageController::class,'index']);
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('edit',[UserController::class,'edit']);
        Route::get('getUser',[UserController::class,'getUser']);
        Route::get('isColingual',[UserController::class,'isColingual']);
        Route::get('isVideo',[UserController::class,'isVideo']);
        Route::get('isAudio',[UserController::class,'isAudio']);
        Route::get('isChat',[UserController::class,'isChat']);
    });
});
