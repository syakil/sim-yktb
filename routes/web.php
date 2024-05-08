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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/formulir-pendaftaran',[\App\Http\Controllers\PPDB\FormulirPendaftaranController::class,'index'])->name('formulir-pendaftaran.index');
Route::get('/formulir-pendaftaran/getData',[\App\Http\Controllers\PPDB\FormulirPendaftaranController::class,'getData'])->name('formulir-pendaftaran.data');
Route::get('/formulir-pendaftaran/download',[\App\Http\Controllers\PPDB\FormulirPendaftaranController::class,'downloadData'])->name('formulir-pendaftaran.download');
Route::post('/formulir-pendaftaran/store',[\App\Http\Controllers\PPDB\FormulirPendaftaranController::class,'store'])->name('formulir-pendaftaran.store');
