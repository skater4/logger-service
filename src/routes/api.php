<?php

use App\Http\Controllers\API\LoggerController;
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

Route::group(['middleware' => 'check-access-token', 'prefix' => 'logger'], function () {
    Route::post('/add', [LoggerController::class, 'add'])->name('logger.add');
});
