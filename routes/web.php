<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

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


Route::get('/auth/login/demo', [AuthController::class, 'loginDemo'])->name('loginDemo');
Route::get('/auth/login/google', [AuthController::class, 'loginGoogle'])->name('loginGoogle');
Route::get('/account/google', [AuthController::class, 'callbackGoogle']);
Route::post('/account/google', [AuthController::class, 'callbackGoogle']);

Route::get('/logout',  [AuthController::class, 'logout'])->name('logout');

Route::middleware(['web'])->get('/{any?}', [HomeController::class, 'home'])->where('any', '.*');