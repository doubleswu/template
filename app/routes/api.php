<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['ApiSignMiddleware','CasbinMiddleware']) -> group(function () {
    Route::get('/test', [\App\Http\Controllers\TestController::class , 'handler']);
});

// 后台
Route::middleware([]) -> group(function () {
    Route::get('/user/login', [\App\Http\Controllers\User\LoginController::class , 'handler']);
    Route::get('/user/token', [\App\Http\Controllers\User\TokenController::class , 'handler']);
});

