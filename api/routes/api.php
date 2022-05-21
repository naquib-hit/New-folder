<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ UserController, CarController, SalesDetailsController };

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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
    // Car
});

//Cars Region
Route::get('/car', [CarController::class, 'index']);
Route::post('/car/post', [CarController::class, 'store']);
Route::put('/car/edit', [CarController::class, 'update']);
Route::delete('/car/delete/{id}', [CarController::class, 'destroy']);

// Sales Details
Route::get('/sales', [SalesDetailsController::class, 'index']);
Route::post('/sales/post', [SalesDetailsController::class, 'store']);
Route::get('/sales/summary', [SalesDetailsController::class, 'summary']);