<?php

use App\Http\Controllers\AktorController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\API\AuthController;
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

Route::get('/', function () {
    return view('layouts.dashboardAdmin');
});

Route::resource('/admin/genre', GenreController::class);
Route::resource('/admin/film', FilmController::class);
Route::resource('/admin/aktor', AktorController::class);

//maaf bang asep buat route google auth di sini soalnya butuh session buat redirect ke url google sedangkan di api.php gak diset session nya sama laravel
Route::get('auth/redirect', [AuthController::class, "redirectToProvider"]);
Route::get('auth/callback', [AuthController::class, "handleProviderCallback"]);


require __DIR__.'/auth.php';
