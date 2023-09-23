<?php

use App\Http\Controllers\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/events', [EventController::class, 'index'])->name('events-list');
Route::post('/events', [EventController::class, 'store'])->name('event-store');
Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('event-destroy');

Route::get('/events/{event}/involve', [EventController::class, 'involve'])->name('event-involve');
Route::get('/events/{event}/leave', [EventController::class, 'leave'])->name('event-leave');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
