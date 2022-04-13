<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Dosen\DosenController;
use App\Http\Controllers\Api\Dosen\NilaiController;
use App\Http\Controllers\Api\Mahasiswa\MahasiswaController;

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

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('/mahasiswa/register', [AuthController::class, 'register']);
    Route::post('/dosen/register', [AuthController::class, 'register']);
    Route::post('/mahasiswa/login', [AuthController::class, 'login']);
    Route::post('/dosen/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/profile', [AuthController::class, 'profile']);
});

Route::group(['middleware' => ['jwtAuth', 'roleAuth'], 'prefix' => 'dosen'], function () {
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('import', [DosenController::class, 'importMahasiswa']);
    Route::put('import', [DosenController::class, 'importMahasiswa']);
    Route::get('nilai', [DosenController::class, 'nilai']);
    Route::put('nilai', [DosenController::class, 'nilaiStore']);
    Route::post('nilai', [DosenController::class, 'nilaiStore']);
    Route::delete('nilai/delete/{nilai}', [DosenController::class, 'delete']);
});

Route::group(['middleware' => ['jwtAuth'], 'prefix' => 'mahasiswa'], function () {
    Route::get('/', [MahasiswaController::class, 'indexNilai']);
    Route::get('/list', [MahasiswaController::class, 'index']);
    Route::get('profile', [AuthController::class, 'profile']);
    Route::get('rata-rata', [NilaiController::class, 'average']);
    Route::get('rata-rata/jurusan', [NilaiController::class, 'averageJurusan']);
});
