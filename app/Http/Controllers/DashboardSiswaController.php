<?php

namespace App\Http\Controllers;

use App\Models\FormulirPendaftaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardSiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $hariIni = Carbon::now()->locale('id')->isoFormat('dddd');
        $siswa = FormulirPendaftaran::where('nisn',Auth::user()->id)
        ->leftJoin('sekolahs','formulir_pendaftaran.sekolah_id','=','sekolahs.id')
        ->leftJoin('jurusans','formulir_pendaftaran.jurusan_id','=','jurusans.id')
        ->first();
        return view('siswa.dashboard.index', compact('hariIni','siswa'));
    }
}
