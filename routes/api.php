<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('user')->group(function () {
    Route::post('register', [UserController::class, 'store']);
    Route::post('login', [UserController::class, 'login']);
});
Route::prefix('/')->middleware('auth:api')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
});
Route::prefix('/')->middleware('auth:api')->group(function () {
    Route::get('orders', [OrderController::class, 'index']);
    Route::post('order/add', [OrderController::class, 'store']);
    Route::put('order/{id}/add', [OrderController::class, 'update']);
    Route::delete('order/{id}', [OrderController::class, 'delete']);
    Route::post('orders/{id}/pay', [OrderController::class, 'pay']);
});
