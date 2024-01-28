<?php

use App\Http\Controllers\AjaxErrorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\MatchExportController;

// Welcome Blade Start up - DONT TOUCH
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Authorized Routes - DONT TOUCH
Auth::routes();

// Dashboard Route - DONT TOUCH
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

// Dashboard Authorized route - DONT TOUCH
Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

// Authorization -> user need to be loged in to access this routes
Route::group(['middleware' => 'auth'], function () {
	// Calendar - DONT TOUCH
	Route::get('/events/recent', [EventController::class, 'recentEventsJson'])->name('events.recent');
    Route::resource('events', EventController::class);

	// Map - DONT TOUCH
	// Route::get('map', function () {
	// 	return view('pages.map');
	// })->name('map');
	
	// Posts
	Route::resource('/post', PostController::class);

	// Match
	Route::resource('/matchExportController', MatchExportController::class);
	Route::resource('/ajaxerror', AjaxErrorController::class);
	Route::post('/matchExportController/storeBasketballPlayer', [MatchExportController::class, 'storeBasketballPlayer'])->name('matchExportController.storeBasketballPlayer');
	Route::post('/matchExportController/storeBasketballTeam', [MatchExportController::class, 'storeBasketballTeam'])->name('matchExportController.storeBasketballTeam');
	Route::post('/matchExportController/storeFootballTeam', [MatchExportController::class, 'storeFootballTeam'])->name('matchExportController.storeFootballTeam');
	Route::post('/matchExportController/storeError', [MatchExportController::class, 'storeError'])->name('matchExportController.storeError');
	Route::post('/matchExportController/ajaxErrorDescription', [MatchExportController::class, 'ajaxErrorDescription'])->name('matchExportController.ajaxErrorDescription');
	
});

// Frameword user manager configuration routes - DONT TOUCH
Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

