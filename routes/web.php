<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect("/api-view", "public/swagger-ui");

Route::get('/', function () { return view('auth/login'); });

Auth::routes();


Route::group(['middleware' => 'auth'], function () {
Route::get('/home', [HomeController::class, 'index'])->name('home');
	Route::get('user',[UserController::class,'index'])->name('user');
    Route::get('user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::post('user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

    Route::resource('language', LanguageController::class);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

    Route::get('quiz',[QuizController::class,'index'])->name('quiz');
    Route::get('quiz/create', [QuizController::class, 'create'])->name('quiz.create');
    Route::post('quiz/store', [QuizController::class, 'store'])->name('quiz.store');
    Route::get('quiz/{id}/edit', [QuizController::class, 'edit'])->name('quiz.edit');
    Route::post('quiz/update/{id}', [QuizController::class, 'update'])->name('quiz.update');
    Route::delete('quiz/{quiz}', [QuizController::class, 'destroy'])->name('quiz.destroy');
});

