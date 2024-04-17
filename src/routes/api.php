<?php

use App\Http\Controllers\API\V1\LoggerController;
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

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => '/logger'], function () {
        Route::post('/add', [LoggerController::class, 'add'])->name('v1.logger.add');
        Route::get('/get', [LoggerController::class, 'get'])->name('v1.logger.get');
    });
});
