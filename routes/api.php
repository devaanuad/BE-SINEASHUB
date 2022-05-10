<?php
//header('Access-Control-Allow-Origin: *');
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FilmController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\UtilityController;
use App\Http\Controllers\API\OtpController;

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
    Route::post('/logout', [AuthController::class, 'Logout']);
    Route::post('/user/update', [AuthController::class, 'update']);
    Route::post('/transaction/midtrans', [TransactionController::class,'midtrans']);
    Route::get('/rekomendasi', [UtilityController::class,'rekomendasi']);
    Route::get('/trending', [UtilityController::class,'trending']);
    Route::get('/terfavorit', [UtilityController::class,'terfavorit']);
    Route::post('/like_dislike', [UtilityController::class,'like_dislike']);
    Route::get('/get_liked_film', [UtilityController::class,'get_liked_film']);
    Route::post('/sendOtp', [OtpController::class, 'sendOtp']);
    Route::get('/cari/{judul}', [FilmController::class, 'cari']);
});

//route untuk login dengan laravel sanctum
Route::post('/login', [AuthController::class, 'Login']);
Route::post('/register', [AuthController::class, 'Register']);
