<?php

namespace App\Http\Controllers;

use App\Models\FormulirPendaftaran;
use Illuminate\Http\Request;

class DaftarUlangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $siswa = FormulirPendaftaran::select('formulir_pendaftaran.*', 'sekolahs.nama_sekolah', 'jurusans.nama_jurusan')
        ->where('nisn', auth()->user()->id)
        ->leftJoin('sekolahs', 'formulir_pendaftaran.sekolah_id', '=', 'sekolahs.id')
        ->leftJoin('jurusans', 'formulir_pendaftaran.jurusan_id', '=', 'jurusans.id')
        ->first();
        return view('siswa.daftar_ulang.index');
    }
}
