<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PossibleDuplicateController;
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

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => ['auth', 'administrate']], function () {
    Route::put('/possible_duplicates/{possibleDuplicate}/ignore', [PossibleDuplicateController::class, 'ignore'])->name('possible_duplicates.ignore');
    Route::put('/possible_duplicates/{possibleDuplicate}/{image}', [PossibleDuplicateController::class, 'keepImage'])->name('possible_duplicates.keep_image');
    Route::resource('possible_duplicates', PossibleDuplicateController::class)->only(['index', 'show', 'destroy']);

    Route::get('/images/rating/{rating?}', [ImageController::class, 'index'])->name('images.index_by_rating');
    Route::resource('images', ImageController::class);
});

require __DIR__.'/auth.php';
