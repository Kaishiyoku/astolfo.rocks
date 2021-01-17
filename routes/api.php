<?php

use App\Http\Controllers\Api\v1\HomeController;
use App\Http\Controllers\Api\v1\ImageController;
use App\Http\Controllers\Api\v1\TagController;
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

Route::prefix('v1')->middleware('api')->group(function () {
    Route::get('/health_check', [HomeController::class, 'healthCheck']);
    Route::get('/version', [HomeController::class, 'version']);

    Route::get('/images/random/{rating?}', [ImageController::class, 'showRandom']);
    Route::resource('/images', ImageController::class)->only(['index', 'show']);
    Route::get('/images/rating/{rating?}', [ImageController::class, 'index']);
    Route::get('/images/{image}/data', [ImageController::class, 'getImageData']);

    Route::resource('/tags', TagController::class)->only(['index', 'show']);

    Route::get('/stats', [HomeController::class, 'stats']);
});

Route::fallback(function () {
    return response()->json(['message' => 'Not Found.'], 404);
})->name('api.fallback.404');
