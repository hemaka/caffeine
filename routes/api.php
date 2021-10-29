<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\DrinksController;

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

Route::middleware('auth:sanctum')->namespace('api')->group(function () {

    // Route::apiResource('drinks', DrinkController::class)->only([
    //     'index', 'store', 'update', 'destroy'
    // ]);

    Route::get('/drinks', [DrinksController::class, 'index']);
    Route::post('/drinks', [DrinksController::class, 'store']);
    Route::put('/drinks/{id}', [DrinksController::class, 'update']);
    Route::delete('/drinks/{id}', [DrinksController::class, 'destroy']);
    Route::post('/drinks/{id}/restore', [DrinksController::class, 'restore']);

});