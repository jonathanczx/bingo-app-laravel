<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\CardTileController;

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

Route::group([], function () {
    Route::post('cards', [CardController::class, 'store']);
    Route::get('cards/leaderboard', [CardController::class, 'leaderboard']);
    Route::get('cards/{card}', [CardController::class, 'show']);
    Route::post('cards/{card}/pull-number', [CardController::class, 'pullNumber']);
    Route::put('cards/{card}/{cardTile}/mark-number', [CardTileController::class, 'markNumber']);
    Route::put('cards/{card}/score', [CardController::class, 'score']);
});

