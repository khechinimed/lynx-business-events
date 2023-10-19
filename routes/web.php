<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\EventController;


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

Route::resource('events', EventController::class);

//Route::get('/events', [EventController::class, 'index']);

Route::get('/events-range/date-range', [EventController::class, 'getEventsByDateRange']);

//Route::post('/events/create_event', [EventController::class, 'store']);

//Route::put('/events/{id}', 'EventController@update');
//
//Route::delete('/events/{id}', [EventController::class, 'destroy']);
//
//Route::get('/', function () {
//    return Inertia::render('Views/OurEvents', [
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});
//
//
//Route::middleware([
//    'auth:sanctum',
//    config('jetstream.auth_session'),
//    'verified',
//])->group(function () {
//
//});

Route::get('/', [EventController::class, 'index'])->name('OurEvents');
Route::get('/our-calendar', [EventController::class, 'calendar'])->name('OurCalendar');
Route::get('/event-management', [EventController::class, 'management'])->name('EventManagement');

