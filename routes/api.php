<?php

use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\TagController;
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

Route::middleware('api')->as('api.')->group(function () {
    Route::get('/health_check', [HomeController::class, 'healthCheck'])->name('health_check');
    Route::get('/version', [HomeController::class, 'version'])->name('version');

    Route::get('/images/random', [ImageController::class, 'showRandom'])->name('images.random');
    Route::get('/images', [ImageController::class, 'index'])->name('images.index');
    Route::get('/images/{image}', [ImageController::class, 'show'])->name('images.show');

    Route::resource('/tags', TagController::class)->only(['index', 'show']);

    Route::get('/stats', [HomeController::class, 'stats'])->name('stats');
});

Route::fallback(function () {
    return response()->json(['message' => 'Not found.'], 404);
})->name('api.fallback.404');
