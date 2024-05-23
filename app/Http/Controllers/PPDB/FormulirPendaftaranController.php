<?php

namespace App\Http\Controllers\PPDB;

use App\Http\Controllers\Controller;
use App\Models\FormulirPendaftaran;
use App\Models\Jurusan;
use App\Models\Sekolah;
use App\Models\User;
use App\Repositories\FormulirPendaftaranRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use function Laravel\Prompts\password;

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
                    <a class="dropdown-item" target="_blank" href="'.route("formulir-pendaftaran.download",$list->no_pendaftaran).'">Cetak Blangko</a>
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
            return response()->json(['message' => 'Gagal menyimpan data'],500);
        }elseif($noPendaftaran->status == 'error'){
            return response()->json(['message' => $noPendaftaran->message],500);
        }else{
            return response()->json(['no_pendaftaran' => $noPendaftaran->no_pendaftaran]);
        }
    }


    public function downloadData($noPendaftaran) {
        $siswa = FormulirPendaftaran::select('formulir_pendaftaran.*','sekolahs.nama_sekolah','jurusans.nama_jurusan')->where('no_pendaftaran',$noPendaftaran)
        ->leftJoin('sekolahs','sekolahs.id','formulir_pendaftaran.sekolah_id')
        ->leftJoin('jurusans','jurusans.id','formulir_pendaftaran.jurusan_id')
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
        $url = config('app.url').'/daftar-ulang/login/'.$noPendaftaran;

        $tanggalDaftarUlang = $date->translatedFormat('d M Y');
        $qrcode = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($url));
        $data= [
            'siswa' => $siswa,
            'tanggal' => $tanggalDaftar,
            'password' => $password,
            'tanggal_lahir' => $tanggalLahir,
            'tanggal_daftar_ulang' => $tanggalDaftarUlang,
            'tahunAjaran' => $tahunIni.'/'.$tahunDepan,
            'qrcode' => $qrcode
        ];
        $pdf =Pdf::loadView('ppdb.formulir_pendaftaran.blangko',['data'=>$data]);
        return $pdf->stream('blangko.pdf');
    }

    public function generate()
    {
        $currentUrl = URL::current();
        $url = config('app.url');
        dd($url);
        // dd($currentUrl);
        $qrcode = QrCode::size(300)->format('png')->generate('google.com');

        // Simpan QR code ke storage
        $filename = 'qrcode.png';
        Storage::put('public/qrcodes/'.$filename, $qrcode);

        return asset('storage/qrcodes/'.$filename);
        // return response()->json(['url' => asset('storage/qrcodes/'.$filename)]);
    }
}
