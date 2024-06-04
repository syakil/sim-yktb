<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use App\Models\DanaSumbanganPendidikan;
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
            $status = '';
            $button = '';
            if($list->status_data_siswa == null){
                $status = '<span class="badge bg-danger">Belum Bayar</span>';
                $button = '
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                        <span class="sr-only"><i class="ri-settings-3-line"></i></span>
                    </button>
                    <div class="dropdown-menu">
                        <button class="dropdown-item" onclick="modalBayar('.$list->no_pendaftaran.')" >Bayar</button>
                    </div>
                </div>
                ';
            }else{
                $status = '<span class="badge bg-success">Sudah Bayar</span>';
                $button = '
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                        <span class="sr-only"><i class="ri-settings-3-line"></i></span>
                    </button>
                    <div class="dropdown-menu">
                        <button class="dropdown-item">Cetak Bukti Bayar</button>
                    </div>
                </div>
                ';
            }
            $row[] = $status;
            $row[] = $button;
            $data[] =$row;

        }

        $output = array("data" => $data);
        return response()->json($output);

    }

    public function getDetail($noPendaftaran){
        $formPendaftaran = CalonSiswa::where('no_pendaftaran',$noPendaftaran)
        ->leftJoin('sekolahs','calon_siswas.sekolah_yang_dituju','=','sekolahs.id')
        ->leftJoin('jurusans','calon_siswas.jurusan','=','jurusans.id')
        ->first();
        return response()->json($formPendaftaran);
    }

    public function store(Request $request){
        $formPendaftaran = CalonSiswa::where('no_pendaftaran',$request->no_pendaftaran)->first();
        if(!$formPendaftaran){
            return response()->json(['status' => 'error','message' => 'Data tidak ditemukan']);
        }
        $dsp = new DanaSumbanganPendidikan();
        $dsp->no_pendaftaran = $request->no_pendaftaran;
        $dsp->tgl_pembayaran = now();
        $dsp->nominal_yang_disetor = $request->nominal;
        $dsp->is_lunas = $request->is_lunas;
        $dsp->keterangan = $request->keterangan;
        $dsp->created_by = auth()->user()->id;
        $dsp->save();

        return response()->json(['status' => 'success','message' => 'Berhasil Menyimpan Data']);
    }
}
