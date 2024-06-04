<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use App\Models\DanaSumbanganPendidikan;
use App\Models\FormulirPendaftaran;
use Illuminate\Http\Request;
use App\Models\Sekolah;
use App\Models\Jurusan;
use App\Repositories\FormulirPendaftaranRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Riskihajar\Terbilang\Facades\Terbilang;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

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
                        <a target="_blank" href="'.route("dsp.cetakBukti",$list->no_pendaftaran).'" class="dropdown-item">Cetak Bukti Bayar</a>
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

    public function cetakBukti($noPendaftaran) {
        $siswa = FormulirPendaftaran::select('formulir_pendaftaran.*','sekolahs.nama_sekolah','jurusans.nama_jurusan','dana_sumbangan_pendidikan.nominal_yang_disetor')
        ->where('formulir_pendaftaran.no_pendaftaran',$noPendaftaran)
        ->leftJoin('sekolahs','sekolahs.id','formulir_pendaftaran.sekolah_id')
        ->leftJoin('jurusans','jurusans.id','formulir_pendaftaran.jurusan_id')
        ->leftJoin('dana_sumbangan_pendidikan','dana_sumbangan_pendidikan.no_pendaftaran','formulir_pendaftaran.no_pendaftaran')
        ->first();
        Carbon::setLocale('id');
        $password =  Carbon::parse($siswa->tanggal_lahir)->format('dmY');


        $tanggalDaftar = Carbon::parse($siswa->created_at)->translatedFormat('d M Y');
        $tanggalLahir = Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d M Y');
        $tanggalDaftarUlang = Carbon::parse($siswa->created_at);
        $date = $tanggalDaftarUlang->copy()->addDay();

        $daysToAdd = 7;

        while ($daysToAdd > 0) {
            if (!$date->isWeekend()) {
                $daysToAdd--;
            }
            $date->addDay(); // Move to the next day
        }
        $tahunIni = date('Y');
        $tahunDepan = $tahunIni + 1;
        $url = config('app.url').'/login-siswa';

        $tanggalDaftarUlang = $date->translatedFormat('d M Y');
        $qrcode = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($url));
        $terbilang = ucwords(Terbilang::make($siswa->nominal_yang_disetor) . ' Rupiah');
        $nominal = 'RP '.number_format($siswa->nominal_yang_disetor,0,',','.');
        $data= [
            'siswa' => $siswa,
            'tanggal' => $tanggalDaftar,
            'password' => $password,
            'tanggal_lahir' => $tanggalLahir,
            'tanggal_daftar_ulang' => $tanggalDaftarUlang,
            'tahunAjaran' => $tahunIni.'/'.$tahunDepan,
            'nominal' => $nominal,
            'terbilang' => $terbilang,
        ];
        $pdf =Pdf::loadView('ppdb.dsp.bukti-bayar',['data'=>$data]);
        return $pdf->stream('blangko.pdf');
    }

}
