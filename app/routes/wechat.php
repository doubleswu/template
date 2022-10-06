<?php

use Illuminate\Support\Facades\Route;

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

// 微信相关
Route::middleware([]) -> group(function () {
    Route::get('/user/token', [\App\Http\Controllers\Wechat\TokenController::class , 'handler']);
});

Route::middleware([]) -> group(function () {
    Route::post('/pay/prepay', [\App\Http\Controllers\Wechat\PrePayController::class , 'handler']);
});

