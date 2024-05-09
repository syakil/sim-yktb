<?php

namespace App\Http\Controllers\PPDB;

use App\Http\Controllers\Controller;
use App\Models\FormulirPendaftaran;
use App\Models\Jurusan;
use App\Models\Sekolah;
use App\Repositories\FormulirPendaftaranRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;



class FormulirPendaftaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $sekolah = Sekolah::all();
        $jurusan = Jurusan::all();
        return view('ppdb.formulir_pendaftaran.index',compact('sekolah','jurusan'));
    }

    public function getData(Request $request){

        $formPendaftaran = FormulirPendaftaranRepository::getListPendaftar($request);
        $data = array();
        foreach ($formPendaftaran as $list) {

            $row = array();
            $row[] = $list->no_pendaftaran;
            $row[] = $list->created_at->translatedFormat('d M Y');
            $row[] = $list->nama_sekolah;
            $row[] = $list->nama_jurusan;
            $row[] = $list->nama_siswa;
            $row[] = $list->no_hp_orang_tua;
            $button = '
            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-outline-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                    <span class="sr-only"><i class="ri-settings-3-line"></i></span>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Edit</a>
                    <a class="dropdown-item" target="_blank" href="'.route("formulir-pendaftaran.download").'">Cetak Blangko</a>
                    <a class="dropdown-item" href="#">Delete</a>
                </div>
            </div>
            ';
            $row[] = $button;
            $data[] =$row;

        }

        $output = array("data" => $data);
        return response()->json($output);

    }

    public function store(Request $request)
    {
        $noPendaftaran  = FormulirPendaftaranRepository::store($request);
        if($noPendaftaran == null){
            return response()->json(['error' => 'Gagal menyimpan data'],500);
        }elseif($noPendaftaran->status == 'error'){
            return response()->json(['error' => $noPendaftaran->message],500);
        }else{
            return response()->json(['no_pendaftaran' => $noPendaftaran->no_pendaftaran]);
        }
    }


    public function downloadData() {
        $data = [
            "title" => 'data'
        ];
        $pdf = Pdf::loadView('ppdb.formulir_pendaftaran.blangko',$data);
        return $pdf->stream('invoice.pdf');
    }
}
