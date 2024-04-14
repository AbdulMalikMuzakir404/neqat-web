<?php

use App\Http\Controllers\API\LoginApiController;
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

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [LoginApiController::class, 'login']);
    Route::get('/profile', [LoginApiController::class, 'profile'])->middleware('auth:sanctum');
    Route::post('/logout', [LoginApiController::class, 'logout'])->middleware('auth:sanctum');
});
