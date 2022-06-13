<?php
//header('Access-Control-Allow-Origin: *');
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FilmController;
use App\Http\Controllers\API\MidtransController;
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

    Route::get('/film', [FilmController::class, 'index']); // list film
    Route::get('/film/detail/{id}', [FilmController::class, 'showDetail']); // detail film
    Route::post('/transaction', [TransactionController::class, 'store']); // beli film
    Route::get('/getUserTransaction', [TransactionController::class, 'get_user_transaction']);
    Route::post('/logout', [AuthController::class, 'Logout']); // keluar
    Route::post('/user/update', [AuthController::class, 'update']); // update user
    Route::post('/transaction/midtrans', [TransactionController::class,'midtrans']);
    Route::get('/film/trending', [UtilityController::class,'trending']);  // list folm trending
    Route::get('/film/terfavorit', [UtilityController::class,'terfavorit']);  // list film favorid
    Route::post('/film/like_dislike', [UtilityController::class,'like_dislike']);
    Route::get('/film/get_liked_film', [UtilityController::class,'get_liked_film']);
    Route::post('/sendOtp', [OtpController::class, 'sendOtp']);
    Route::get('/film/find_film_by_genre/{genre}', [FilmController::class, 'cari_genre']); // list film berdasarkan genre
    Route::get('/film/terkait', [UtilityController::class,'terkait']); // list film terkait
    Route::get('/get_genre', [UtilityController::class,'get_genre']);
    Route::get('/film/find_film_by_judul/{judul}', [FilmController::class,'cari']); // list film berdasarkan judul


    // midtrans transaction
    Route::post('/transaction/midtrans', [TransactionController::class, 'transactionMidtrans']);

    Route::post('/midtrans/callback', [MidtransController::class, 'MidtransNotification']);
    Route::get('/midtrans/finis', [MidtransController::class, 'finis']);
    Route::get('/midtrans/unfinis', [MidtransController::class, 'unfinis']);
    Route::get('/midtrans/error', [MidtransController::class, 'error']);
});

Route::post('/login', [AuthController::class, 'Login']);
Route::post('/register', [AuthController::class, 'Register']);
