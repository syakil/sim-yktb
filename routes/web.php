<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login-siswa',[\App\Http\Controllers\Auth\LoginSiswaController::class,'index'])->name('login-siswa.index');
Route::post('/login-siswa',[\App\Http\Controllers\Auth\LoginSiswaController::class,'login'])->name('login-siswa.login');
Route::post('/logout-siswa',[\App\Http\Controllers\Auth\LoginSiswaController::class,'logout'])->name('login-siswa.logout');

Auth::routes();

Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/formulir-pendaftaran',[\App\Http\Controllers\PPDB\FormulirPendaftaranController::class,'index'])->name('formulir-pendaftaran.index');
    Route::get('/formulir-pendaftaran/generate',[\App\Http\Controllers\PPDB\FormulirPendaftaranController::class,'generate'])->name('formulir-pendaftaran.generate');
    Route::get('/formulir-pendaftaran/getData',[\App\Http\Controllers\PPDB\FormulirPendaftaranController::class,'getData'])->name('formulir-pendaftaran.data');
    Route::get('/formulir-pendaftaran/download/{noPendaftaran}',[\App\Http\Controllers\PPDB\FormulirPendaftaranController::class,'downloadData'])->name('formulir-pendaftaran.download');
    Route::post('/formulir-pendaftaran/store',[\App\Http\Controllers\PPDB\FormulirPendaftaranController::class,'store'])->name('formulir-pendaftaran.store');
});

Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/dashboard-siswa',[\App\Http\Controllers\DashboardSiswaController::class,'index'])->name('dashboard-siswa.index');
    Route::get('/daftar-ulang',[\App\Http\Controllers\DaftarUlangController::class,'index'])->name('daftar-ulang.index');
    Route::post('/daftar-ulang/store',[\App\Http\Controllers\DaftarUlangController::class,'store'])->name('daftar-ulang.store');
});

Route::get('/jurusan',[\App\Http\Controllers\PPDB\JurusanController::class,'getJurusan'])->name('jurusan.getJurusan');
