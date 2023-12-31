<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
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
Route::middleware('auth:sanctum')->group(function () {

	Route::get('/events', [EventController::class, 'index'])->name('events-list');
	Route::get('/events/{id}', [EventController::class, 'show'])->name('events-show');
	Route::post('/events', [EventController::class, 'store'])->name('event-store');
	Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('event-destroy');

	Route::get('/events/{event}/involve', [EventController::class, 'involve'])->name('event-involve');
	Route::get('/events/{event}/leave', [EventController::class, 'leave'])->name('event-leave');

	Route::get('/users', [UserController::class, 'index'])->name('user-show');
	Route::get('/users/{user}', [UserController::class, 'show'])->name('user-show');
});
