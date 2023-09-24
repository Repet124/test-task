<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {

	Route::get('/dashboard', function() {
		return view('dashboard', ['user' => auth()->user()]);
	})->name('dashboard');

	Route::get('/dashboard/{any}', function() {
		return view('dashboard', ['user' => auth()->user()]);
	})->where('any', '.*');

});

Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [UserController::class, 'auth']);

Route::get('/register', [UserController::class, 'create'])->name('register');
Route::post('/register', [UserController::class, 'store']);

Route::get('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');
