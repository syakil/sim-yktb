<?php

namespace App\Http\Controllers;

use App\Models\FormulirPendaftaran;
use App\Models\Jurusan;
use App\Models\Sekolah;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sekolah = Sekolah::all();
        $jurusan = Jurusan::all();
        $total_pendaftar = DB::table('formulir_pendaftaran')->count('no_pendaftaran');
        $total_sudah_verifikasi = DB::table('data_siswas')->count('no_pendaftaran');
        $total_dsp =  number_format(DB::table('dana_sumbangan_pendidikan')->sum('nominal_yang_disetor'));
        return view('home',compact('sekolah','jurusan','total_pendaftar','total_sudah_verifikasi','total_dsp'));
    }

    public function getChartData(Request $request)
    {
        $results = DB::table('formulir_pendaftaran')
        ->leftJoin('sekolahs', 'formulir_pendaftaran.sekolah_id', '=', 'sekolahs.id')
        ->select('sekolahs.nama_sekolah', DB::raw('COUNT(formulir_pendaftaran.sekolah_id) AS sekolah'))
        ->groupBy('formulir_pendaftaran.sekolah_id')
        ->orderBy('sekolahs.nama_sekolah')
        ->get();

        $labels = [];
        $series = [];
        foreach ($results as $result) {
            $labels[] = $result->nama_sekolah;
            $series[] = $result->sekolah;
        }

        $data = [
            'sekolah' => [
                'labels' => $labels,
                'series' => $series
            ]
        ];

        return $data['sekolah'];

        return response()->json($data);
    }

    public function getChartBedasarkanJurusan(Request $request)
    {
        $results = DB::table('formulir_pendaftaran')
        ->select('jurusans.nama_jurusan', DB::raw('COUNT(formulir_pendaftaran.jurusan_id) AS jurusan'))
        ->leftJoin('jurusans', 'formulir_pendaftaran.jurusan_id', '=', 'jurusans.id');

        // Menambahkan kondisi filter dinamis berdasarkan permintaan
        if ($request->sekolah != 'All') {
            $results->where('formulir_pendaftaran.sekolah_id', $request->sekolah);
        }

        // Menambahkan group by dan order by, serta mendapatkan hasilnya
        $results = $results
            ->groupBy('formulir_pendaftaran.jurusan_id')
            ->orderBy('jurusans.nama_jurusan')
            ->get();

        $labels = [];
        $series = [];
        foreach ($results as $result) {
            $labels[] = $result->nama_jurusan;
            $series[] = $result->jurusan;
        }

        $data = [
            'jurusan' => [
                'labels' => $labels,
                'series' => $series
            ]
        ];

        return $data['jurusan'];

        return response()->json($data);
    }

    public function getTrenPendaftaranHarian(Request $request)
    {
        $result = FormulirPendaftaran::select('created_at', DB::raw('COUNT(no_pendaftaran) as count'));

        if($request->sekolah != 'all') {
            $result->where('sekolah_id', $request->sekolah);
        }

        if($request->jurusan != 'all') {
            $result->where('jurusan_id', $request->jurusan);
        }

        $result = $result->groupBy('created_at')
                    ->get();

        $dates = [];
        $series = [];

        foreach($result as $item) {
            $dates[] = Carbon::parse($item->created_at)->format('d M Y');
            $series[] = $item->count;
        }
        $data = [
            'labels' => $dates,
            'series' => $series
        ];


        return response()->json($data);
    }
}
