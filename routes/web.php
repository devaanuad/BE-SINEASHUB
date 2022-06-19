<?php

use App\Http\Controllers\AktorController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\CreatorController;
use App\Http\Controllers\TransactionController;
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


Route::middleware('auth', 'admin')
    ->group(function(){
        Route::view('/', 'pages.dashboard');
        Route::resource('/genre', GenreController::class);
        Route::resource('/film', FilmController::class);
        Route::resource('/aktor', AktorController::class);
        Route::resource('/creator', CreatorController::class);
        Route::resource('/transaction', TransactionController::class);
    });




//maaf bang asep buat route google auth di sini soalnya butuh session buat redirect ke url google sedangkan di api.php gak diset session nya sama laravel
Route::get('auth/redirect', [AuthController::class, "redirectToProvider"]);
Route::get('auth/callback', [AuthController::class, "handleProviderCallback"]);
//Route::post('/logout', [AuthController::class, 'Logout'])->middleware('auth:sanctum');

require __DIR__.'/auth.php';
