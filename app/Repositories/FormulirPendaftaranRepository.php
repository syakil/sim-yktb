<?php

namespace App\Repositories;

use App\Models\FormulirPendaftaran;
use App\Models\User;
use Carbon\Carbon;
use App\Models\CalonSiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

    public static function getListPendaftarVerifikasi($request){

        $list = CalonSiswa::select('calon_siswas.*','data_siswas.nisn as status_data_siswa','sekolahs.nama_sekolah','jurusans.nama_jurusan')
        ->leftJoin('data_siswas','data_siswas.nisn','=','calon_siswas.nisn')
        ->leftJoin('sekolahs','calon_siswas.sekolah_yang_dituju','=','sekolahs.id')
        ->leftJoin('jurusans','calon_siswas.jurusan','=','jurusans.id')
        ->orderBy('no_pendaftaran','asc');

        if($request->filled('no_pendaftaran')){
            $list->where('calon_siswas.no_pendaftaran','like','%'.$request->no_pendaftaran.'%');
        }

        if($request->filled('sekolah_yang_dituju')){
            $list->where('calon_siswas.sekolah_yang_dituju','like','%'.$request->sekolah_yang_dituju.'%');
        }

        if($request->filled('jurusan')){
            $list->where('jurusans.id','like','%'.$request->jurusan.'%');
        }

        if($request->filled('nama_siswa')){
            $list->where('calon_siswas.nama_siswa','like','%'.$request->nama_siswa.'%');
        }

        if($request->filled('no_hp')){
            $list->where('calon_siswas.no_hp_orang_tua','like','%'.$request->no_hp.'%');
        }

        if($request->filled('tanggal_pendaftaran')){
            $list->where('calon_siswas.formulir_pendaftaran.created_at','like', $request->tanggal_pendaftaran.'%');
        }

        return $list->get();

    }


    public static function getListDsp($request){

        $list = CalonSiswa::select('calon_siswas.*','sekolahs.nama_sekolah','jurusans.nama_jurusan','dana_sumbangan_pendidikan.no_pendaftaran as status_data_siswa')
        ->leftJoin('dana_sumbangan_pendidikan','dana_sumbangan_pendidikan.no_pendaftaran','=','calon_siswas.no_pendaftaran')
        ->leftJoin('sekolahs','calon_siswas.sekolah_yang_dituju','=','sekolahs.id')
        ->leftJoin('jurusans','calon_siswas.jurusan','=','jurusans.id')
        ->orderBy('no_pendaftaran','asc');

        if($request->filled('no_pendaftaran')){
            $list->where('calon_siswas.no_pendaftaran','like','%'.$request->no_pendaftaran.'%');
        }

        if($request->filled('sekolah_yang_dituju')){
            $list->where('calon_siswas.sekolah_yang_dituju','like','%'.$request->sekolah_yang_dituju.'%');
        }

        if($request->filled('jurusan')){
            $list->where('jurusans.id','like','%'.$request->jurusan.'%');
        }

        if($request->filled('nama_siswa')){
            $list->where('calon_siswas.nama_siswa','like','%'.$request->nama_siswa.'%');
        }

        if($request->filled('no_hp')){
            $list->where('calon_siswas.no_hp_orang_tua','like','%'.$request->no_hp.'%');
        }

        if($request->filled('tanggal_pendaftaran')){
            $list->where('calon_siswas.formulir_pendaftaran.created_at','like', $request->tanggal_pendaftaran.'%');
        }

        return $list->get();

    }

    public static function store($request)
    {
        try {

            $result = new stdClass();
            $check_nisn = FormulirPendaftaran::where('nisn',$request->create_nisn)->first();
            if($check_nisn){
                $result->status = 'error';
                $result->message = 'NISN Sudah Terdaftar Atas Nama '.$check_nisn->nama_siswa;
                return $result;
            }
            DB::beginTransaction();

            $result->status = 'success';
            $result->noPendaftaran = '';

            $nextYear = date('Y') + 1;
            $thisYear = date('Y');
            $lastTwoDigitsThisYear = substr($thisYear, -2);
            $lastTwoDigits = substr($nextYear, -2);

            $lastFormulir = FormulirPendaftaran::orderBy('no_pendaftaran','desc')->first();

            if ($lastFormulir) {
                $lastNumber = (int) substr($lastFormulir->no_pendaftaran, -4);
                $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $nextNumber = '0001';
            }

            $noPendaftaran = $lastTwoDigitsThisYear . $lastTwoDigits . $nextNumber;

            $formulirPendaftaran = new FormulirPendaftaran();
            $formulirPendaftaran->no_pendaftaran = $noPendaftaran;
            $formulirPendaftaran->nisn = $request->create_nisn;
            $formulirPendaftaran->nama_siswa = $request->create_nama_siswa;
            $formulirPendaftaran->jenis_kelamin = $request->create_jenis_kelamin;
            $formulirPendaftaran->asal_sekolah = $request->create_asal_sekolah;
            $formulirPendaftaran->alamat = $request->create_alamat;
            $formulirPendaftaran->tanggal_lahir = $request->create_tgl_lahir;
            $formulirPendaftaran->no_hp_orang_tua = $request->create_no_hp_orang_tua;
            $formulirPendaftaran->no_hp_siswa = $request->create_no_hp_siswa;
            $formulirPendaftaran->jurusan_id = $request->jurusan;
            $formulirPendaftaran->sekolah_id = $request->sekolah;
            $formulirPendaftaran->created_by = auth()->user()->id;
            $formulirPendaftaran->save();

            $password = Carbon::parse($request->create_tgl_lahir)->format('dmY');
            $password = Hash::make($password);

            $newUser = new User();
            $newUser->id = $request->create_nisn;
            $newUser->name = $request->create_nama_siswa;
            $newUser->email = substr(str_replace(' ', '',$request->create_nama_siswa),0,8).'@yktb.sch.id';
            $newUser->password = $password;
            $newUser->role = 'siswa';
            $newUser->save();

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
