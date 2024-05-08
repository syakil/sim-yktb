<?php

namespace App\Repositories;

use App\Models\FormulirPendaftaran;
use Illuminate\Support\Facades\DB;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use stdClass;

//use Your Model

/**
 * Class FormulirPendaftaranRepository.
 */
class FormulirPendaftaranRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        //return YourModel::class;
    }

    public static function getListPendaftar($request){

        $list = FormulirPendaftaran::select('formulir_pendaftaran.*','sekolahs.nama_sekolah','jurusans.nama_jurusan')
        ->leftJoin('sekolahs','formulir_pendaftaran.sekolah_id','=','sekolahs.id')
        ->leftJoin('jurusans','formulir_pendaftaran.jurusan_id','=','jurusans.id')
        ->orderBy('no_pendaftaran','asc');

        if($request->filled('no_pendaftaran')){
            $list->where('no_pendaftaran','like','%'.$request->no_pendaftaran.'%');
        }

        if($request->filled('sekolah_yang_dituju')){
            $list->where('sekolah_id','like','%'.$request->sekolah_yang_dituju.'%');
        }

        if($request->filled('jurusan')){
            $list->where('jurusans.id','like','%'.$request->jurusan.'%');
        }

        if($request->filled('nama_siswa')){
            $list->where('nama_siswa','like','%'.$request->nama_siswa.'%');
        }

        if($request->filled('no_hp')){
            $list->where('no_hp_orang_tua','like','%'.$request->no_hp.'%');
        }

        if($request->filled('tanggal_pendaftaran')){
            $list->where('formulir_pendaftaran.created_at','like', $request->tanggal_pendaftaran.'%');
        }

        return $list->get();

    }

    public static function store($request)
    {
        try {
            DB::beginTransaction();
            $result = new stdClass();

            $result->status = 'success';
            $result->noPendaftaran = '';

            // Mendapatkan tahun sekarang dan menambahkannya 1 tahun
            $nextYear = date('Y') + 1;
            $thisYear = date('Y');
            // Mengambil 2 angka dari belakang tahun berikutnya
            $lastTwoDigitsThisYear = substr($thisYear, -2);
            $lastTwoDigits = substr($nextYear, -2);

            // Mendapatkan nomor formulir pendaftaran terakhir
            $lastFormulir = FormulirPendaftaran::orderBy('no_pendaftaran','desc')->first();

            if ($lastFormulir) {
                // Jika ada nomor formulir sebelumnya, ambil nomor terakhirnya
                $lastNumber = (int) substr($lastFormulir->no_pendaftaran, -4);
                // Increment nomor terakhir dan format dengan 4 digit leading zero
                $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            } else {
                // Jika tidak ada nomor formulir sebelumnya, gunakan nomor 1
                $nextNumber = '0001';
            }

            // Gabungkan tahun, 2 angka belakang tahun, dan nomor formulir ke format yang diinginkan
            $noPendaftaran = $lastTwoDigitsThisYear . $lastTwoDigits . $nextNumber;

            // return response()->json(['no_pendaftaran' => $noPendaftaran]);

            // Sekarang Anda memiliki nomor formulir yang sesuai, Anda dapat menyimpan data formulir ke database
            // Misalnya:
            FormulirPendaftaran::create([
                'no_pendaftaran' => $noPendaftaran,
                'nisn' => $request->create_nisn,
                'nama_siswa' => $request->create_nama_siswa,
                'jenis_kelamin' => $request->create_jenis_kelamin,
                'asal_sekolah' => $request->create_asal_sekolah,
                'alamat' => $request->create_alamat,
                'tanggal_lahir' => $request->create_tgl_lahir,
                'no_hp_orang_tua' => $request->create_no_hp_orang_tua,
                'jurusan_id' => $request->jurusan,
                'sekolah_id' => $request->sekolah,
            ]);

            // Jika Anda perlu merespons dengan nomor formulir yang dibuat, Anda dapat mengembalikannya sebagai respons
            $result->no_pendaftaran =  $noPendaftaran;
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            $result->status = 'error';
            $result->message = $ex->getMessage();
        }
        return $result;
    }
}
