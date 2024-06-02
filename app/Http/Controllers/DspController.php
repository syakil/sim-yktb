<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sekolah;
use App\Models\Jurusan;
use App\Repositories\FormulirPendaftaranRepository;

class DspController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $sekolah = Sekolah::all();
        $jurusan = Jurusan::all();
        return view('ppdb.dsp.index',compact('sekolah','jurusan'));
    }


    public function getData(Request $request){

        $formPendaftaran = FormulirPendaftaranRepository::getListDsp($request);
        $data = array();
        foreach ($formPendaftaran as $list) {

            $row = array();
            $row[] = $list->no_pendaftaran;
            $row[] = $list->created_at->translatedFormat('d M Y');
            $row[] = $list->nama_sekolah;
            $row[] = $list->nama_jurusan;
            $row[] = $list->nama_siswa;
            $row[] = $list->no_hp_orang_tua;
            if($list->status_data_siswa){
                $row[] = '<span class="badge bg-success">Sudah Verifikasi</span>';
            }else{
                $row[] = '<span class="badge bg-danger">Belum Verifikasi</span>';
            }
            $button = '
            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-outline-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                    <span class="sr-only"><i class="ri-settings-3-line"></i></span>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" target="_blank" href="'.route("validasi-daftar-ulang.detail",$list->no_pendaftaran).'">Verifikasi</a>
                </div>
            </div>
            ';
            $row[] = $button;
            $data[] =$row;

        }

        $output = array("data" => $data);
        return response()->json($output);

    }
}
