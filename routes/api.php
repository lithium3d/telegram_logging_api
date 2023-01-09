<?php

use App\Http\Controllers\DomainController;
use App\Http\Controllers\TelegramController;
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

Route::post('telegram', [TelegramController::class, 'postToTelegram']);
Route::post('add-report-domain', [DomainController::class, 'addReportDomain'])->middleware('auth:api');

Route::post('add-ping-domain', [DomainController::class, 'addPingDomain'])->middleware('auth:api');
