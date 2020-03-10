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

Route::prefix('v1')->middleware('api')->group(function () {
    Route::get('/health_check', 'Api\v1\HomeController@healthCheck');
    Route::get('/version', 'Api\v1\HomeCOntroller@version');

    Route::get('/images/random/{rating?}', 'Api\v1\ImageController@showRandom');
    Route::resource('/images', 'Api\v1\ImageController')->only(['index', 'show']);
    Route::get('/images/rating/{rating?}', 'Api\v1\ImageController@index');

    Route::resource('/tags', 'Api\v1\TagController')->only(['index', 'show']);

    Route::get('/stats', 'Api\v1\HomeController@stats');
});

Route::fallback(function () {
    return response()->json(['message' => 'Not Found.'], 404);
})->name('api.fallback.404');
