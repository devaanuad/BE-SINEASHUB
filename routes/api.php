<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FilmController;
use App\Http\Controllers\API\TransactionController;

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
    Route::get('/film', [FilmController::class, 'index']);
    Route::get('/film/detail/{id}', [FilmController::class, 'showDetail']);
    Route::post('/transaction', [TransactionController::class, 'store']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

//route untuk login dengan laravel sanctum
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);