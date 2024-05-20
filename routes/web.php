<?php

use App\Http\Controllers\CinemaController;
use App\Http\Controllers\ElasticsearchController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ScheduleController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/movie-coming', [MovieController::class, 'showMovieComing'])->name('movie-coming');

Route::get('/movie-detail/{movie}', [MovieController::class, 'show']);

Route::get('/cinema', [CinemaController::class, 'index'])->name('cinema');

Route::middleware(['auth'])->group(function () {
    Route::get('/assign-movie', [ScheduleController::class, 'create'])
        ->middleware('can:create,App\Models\Schedule')
        ->name('schedule.create');

    Route::get('/booking-ticket/{schedule}', [OrderController::class, 'chooseSeat'])
        ->middleware('can:create,App\Models\Order')
        ->name('order.create');

    Route::post('/payment/{schedule}', [OrderController::class, 'payment'])
        ->middleware('can:create,App\Models\Order')
        ->name('payment');

    Route::get('/schedule/{schedule}/edit', [ScheduleController::class, 'edit'])
        ->middleware('can:update,App\Models\Schedule')
        ->name('schedule.edit');

    Route::post('/schedule/', [ScheduleController::class, 'store'])->name('schedule.store');

    Route::get('/movie/create', [MovieController::class, 'create'])
        ->middleware('can:create,App\Models\Movie')
        ->name('movie.create');

    Route::get('/my-order/{user}', [OrderController::class, 'index'])
        ->middleware('can:viewAny,App\Models\Order')
        ->name('order.index');

    Route::get('/my-order/order-detail/{order}', [OrderController::class, 'show'])
        ->middleware('can:view,App\Models\Order')
        ->name('order.show');

    Route::get('/movie/{movie}/edit', [MovieController::class, 'edit'])
        ->middleware('can:update,App\Models\Movie')
        ->name('movie.edit');

    Route::get('/cinema/order', [OrderController::class, 'cinemaIndex'])
        ->middleware('can:view-cinema-order')
        ->name('order.cinema');
});

Route::get('/search', [ElasticsearchController::class, 'search'])->name('search');
