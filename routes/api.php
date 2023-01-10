<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BarangController;
use App\Http\Controllers\API\TransaksiController;
use App\Http\Controllers\API\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::apiResource('user', UserController::class);
    Route::apiResource('barang', BarangController::class);
    
    //transaksi
    Route::get('transaksi', [TransaksiController::class, 'index']);
    Route::get('transaksi/{id}', [TransaksiController::class, 'getUser']);
    Route::post('bayar', [TransaksiController::class, 'bayar']);
});

Route::get('/fotobarang/{folder}/{data}', [BarangController::class, 'foto']);


// Route::post('tambahbarang', [BarangController::class, 'create']);
// Route::patch('editbarang/{id}', [BarangController::class, 'edit']);

// Route::post('bayar', [TransaksiController::class, 'bayar']);