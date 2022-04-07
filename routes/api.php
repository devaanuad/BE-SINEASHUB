<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\TransactionController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/film', [FilmController::class, 'semua']);//dapetin semua data film
    Route::get('/film/{id}', [FilmController::class, 'satu']);//dapetin satu film
    Route::get('/film/detail/{id}', [FilmController::class, 'filmDetail']);//dapetin detail film
    Route::post('/transaction', [TransactionController::class, 'store']);//lakukan transaksi
});

//route untuk login dengan laravel sanctum
Route::post('/login', [UserController::class, 'authenticate']);