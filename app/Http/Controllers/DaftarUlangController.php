<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use App\Models\FormulirPendaftaran;
use App\Models\Jurusan;
use App\Models\Sekolah;
use App\Repositories\DaftarUlangRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DaftarUlangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $daftarUlang = CalonSiswa::where('nisn', auth()->user()->id)->first();
        if($daftarUlang){
            return redirect()->route('dashboard-siswa.index');
        }
        $siswa = FormulirPendaftaran::select('formulir_pendaftaran.*', 'sekolahs.nama_sekolah', 'jurusans.nama_jurusan','jurusans.deskripsi')
        ->where('nisn', auth()->user()->id)
        ->leftJoin('sekolahs', 'formulir_pendaftaran.sekolah_id', '=', 'sekolahs.id')
        ->leftJoin('jurusans', 'formulir_pendaftaran.jurusan_id', '=', 'jurusans.id')
        ->first();
        $sekolah = Sekolah::all();
        $jurusan = Jurusan::all();
        return view('siswa.daftar_ulang.index',compact('siswa','sekolah','jurusan'));
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'pas_foto' => 'required|mimes:pdf,jpeg,png,jpg,gif|max:2048',
            'kartu_keluarga' => 'required|mimes:pdf,jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }
        $daftarUlang = DaftarUlangRepository::store($request);
        if($daftarUlang->status){
            return response()->json($daftarUlang);
        }else{
            return response()->json($daftarUlang, 422);
        }
    }
}
