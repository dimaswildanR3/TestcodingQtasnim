<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('barangs', [BarangController::class, 'index']);
Route::get('barangs/{id}', [BarangController::class, 'show']);
Route::post('barangs/store', [BarangController::class, 'store']);
Route::post('/api/barangs/search', [BarangController::class, 'searchAndSort']);
Route::post('barangs/edit/{id}', [BarangController::class, 'update']);
Route::delete('barangs/{id}', [BarangController::class, 'destroy']);


Route::get('transaksis', [TransaksiController::class, 'index']);
Route::get('transaksis/{id}', [TransaksiController::class, 'show']);
Route::post('transaksis/store', [TransaksiController::class, 'store']);
Route::post('transaksis/edit/{id}', [TransaksiController::class, 'update']);
Route::delete('transaksis/{id}', [TransaksiController::class, 'destroy']);
Route::post('transaksisb/search', [TransaksiController::class, 'search']);
