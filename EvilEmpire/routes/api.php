<?php

use App\Http\Controllers\Api\FootballController;
use App\Http\Controllers\BetDataExportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\EventController;

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

Route::post('football/teamCompare', [BetDataExportController::class, 'dataCompare'])->name('api.football.teamCompare');

// Packet Users API - DONT TOUCH
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users', [UserController::class, 'index']);
Route::post('users', [UserController::class, 'store']);
Route::get('posts', [PostController::class, 'index']);
Route::post('posts', [PostController::class, 'store']);


// Calendar API - DONT TOUCH
Route::get('events', [EventController::class, 'index'])->name('api.events.index');
Route::get('events/by-month', [EventController::class, 'getEventsByMonth'])->name('api.events.byMonth');
