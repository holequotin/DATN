<?php

use App\Http\Controllers\Api\CinemaController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\MovieController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('cinema', CinemaController::class);
Route::get('cinema/{cinema}/{movie}', [CinemaController::class, 'showScheduleOfMovieInCinema']);
Route::resource('schedule', ScheduleController::class);
Route::resource('order', OrderController::class);
Route::resource('movie', MovieController::class);
