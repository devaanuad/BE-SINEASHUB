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
    Route::get('/getUserTransaction', [TransactionController::class, 'get_user_transaction']);
    Route::post('/logout', [AuthController::class, 'Logout']);
    Route::post('/user/update', [AuthController::class, 'update']);
    Route::post('/transaction/midtrans', [TransactionController::class,'midtrans']);
    Route::get('/film/trending', [UtilityController::class,'trending']);
    Route::get('/film/terfavorit', [UtilityController::class,'terfavorit']);
    Route::post('/film/like_dislike', [UtilityController::class,'like_dislike']);
    Route::get('/film/get_liked_film', [UtilityController::class,'get_liked_film']);
    Route::post('/sendOtp', [OtpController::class, 'sendOtp']);
    Route::get('/film/cari/{judul}', [FilmController::class, 'cari']);
    Route::get('/film/terkait', [UtilityController::class,'terkait']);
});

Route::post('/login', [AuthController::class, 'Login']);
Route::post('/register', [AuthController::class, 'Register']);