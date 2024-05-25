<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\CalonSiswa;
use App\Models\DataSiswa;
use App\Models\FormulirPendaftaran;
use Exception;
use Illuminate\Support\Facades\DB;
use stdClass;
//use Your Model

/**
 * Class ValidasiDaftarUlangRepository.
 */
class ValidasiDaftarUlangRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        //return YourModel::class;
    }

    public static function store($request){
        $result = new stdClass();
        $result->status = true;
        $nisn = $request->nisn;
        $check = CalonSiswa::where('nisn', $nisn)->first();
        if(!$check){
            $result->status = false;
            $result->message = 'Siswa belum mengisi daftar ulang.';
        }
        $check = FormulirPendaftaran::where('nisn', $nisn)->first();
        if(!$check){
            $result->status = false;
            $result->message = 'Siswa belum mengisi formulir pendaftaran.';
        }
        $check = DataSiswa::where('nisn', $nisn)->first();
        if($check){
            $result->status = false;
            $result->message = 'Siswa sudah melakukan daftar ulang.';
        }

        if($result->status == false){
            return $result;
        }
        try {
            DB::beginTransaction();

            $ijazah = $request->file('ijazah');
            $ijazahName = !$request->file('ijazah') ? '':$request->no_pendaftaran.'_ijazah.'.$ijazah->extension();
            $skhun = $request->file('skhun');
            $skhunName = !$request->file('skhun') ? '': $request->no_pendaftaran.'_skhun.'.$skhun->extension();
            $pasFoto = $request->file('pas_foto');
            $pasFotoName = !$request->file('pas_foto') ? '' : $request->no_pendaftaran.'_pas_foto.'.$pasFoto->extension();
            $kartuKeluarga = $request->file('kartu_keluarga');
            $kartuKeluargaName = !$request->file('kartu_keluarga') ? '' :$request->no_pendaftaran.'_kartu_keluarga.'.$kartuKeluarga->extension();

            $calonSiswa = CalonSiswa::where('nisn', $nisn)->first();
            $calonSiswa->no_pendaftaran = $request->no_pendaftaran;
            $calonSiswa->nisn = $request->nisn;
            $calonSiswa->sekolah_yang_dituju = $request->sekolah_yang_dituju;
            $calonSiswa->jurusan = $request->jurusan;
            $calonSiswa->nik = $request->nik;
            $calonSiswa->nama_siswa = $request->nama_siswa;
            $calonSiswa->tempat_lahir = $request->tempat_lahir;
            $calonSiswa->jenis_kelamin = $request->jenis_kelamin;
            $calonSiswa->tanggal_lahir = $request->tanggal_lahir;
            $calonSiswa->agama = $request->agama;
            $calonSiswa->tinggi_badan = $request->tinggi_badan;
            $calonSiswa->alamat_kampung = $request->alamat_kampung;
            $calonSiswa->jumlah_saudara = $request->jumlah_saudara;
            $calonSiswa->alamat_kelurahan = $request->alamat_kelurahan;
            $calonSiswa->alamat_kota = $request->alamat_kota;
            $calonSiswa->jarak_rumah = $request->jarak_rumah;
            $calonSiswa->waktu_tempuh = $request->waktu_tempuh;
            $calonSiswa->no_hp_siswa = $request->no_hp_siswa;
            $calonSiswa->nama_ayah = $request->nama_ayah;
            $calonSiswa->pendidikan_ayah = $request->pendidikan_ayah;
            $calonSiswa->pekerjaan_ayah = $request->pekerjaan_ayah;
            $calonSiswa->penghasilan_ayah = $request->penghasilan_ayah;
            $calonSiswa->no_hp_orang_tua = $request->no_hp_orang_tua;
            $calonSiswa->nama_ibu = $request->nama_ibu;
            $calonSiswa->pekerjaan_ibu = $request->pekerjaan_ibu;
            $calonSiswa->penghasilan_ibu = $request->penghasilan_ibu;
            $calonSiswa->pendidikan_ibu = $request->pendidikan_ibu;
            $calonSiswa->nama_wali = $request->nama_wali;
            $calonSiswa->pekerjaan_wali = $request->pekerjaan_wali;
            $calonSiswa->pendidikan_wali = $request->pendidikan_wali;
            $calonSiswa->penghasilan_wali = $request->penghasilan_wali;
            $calonSiswa->asal_sekolah = $request->nama_sekolah;
            $calonSiswa->nomor_ijazah = $request->nomor_ijazah;
            $calonSiswa->ijazah = $ijazahName;
            $calonSiswa->tahun_lulus = $request->tahun_lulus;
            $calonSiswa->nomor_skhun = $request->nomor_skhun;
            $calonSiswa->skhun = $skhunName;
            $calonSiswa->alamat_sekolah = $request->alamat_sekolah;
            $calonSiswa->jenis_kejuaraan = $request->jenis_kejuaraan;
            $calonSiswa->nama_beasiswa = $request->nama_beasiswa;
            $calonSiswa->peringkat_kejuaraan = $request->peringkat_kejuaraan;
            $calonSiswa->penyelengara_beasiswa = $request->penyelengara_beasiswa;
            $calonSiswa->tingkat_kejuaraan = $request->tingkat_kejuaraan;
            $calonSiswa->tahun_beasiswa = $request->tahun_beasiswa;
            if($request->file('pas_foto')){
                $calonSiswa->pas_foto = $pasFotoName;
            }
            if($request->file('kartu_keluarga')){
                $calonSiswa->kartu_keluarga = $kartuKeluargaName;
            }
            $calonSiswa->created_by = auth()->user()->id;
            $calonSiswa->update();

            if($request->file('ijazah')){
                $ijazah->move(public_path('daftar_ulang/'.$request->no_pendaftaran), $ijazahName);
            }
            if($request->file('skhun')){
                $skhun->move(public_path('daftar_ulang/'.$request->no_pendaftaran), $skhunName);
            }
            if($request->file('pas_foto')){
                $pasFoto->move(public_path('daftar_ulang/'.$request->no_pendaftaran), $pasFotoName);
            }
            if($request->file('kartu_keluarga')){
                $kartuKeluarga->move(public_path('daftar_ulang/'.$request->no_pendaftaran), $kartuKeluargaName);
            }

            $formulirPendaftaran = FormulirPendaftaran::where('nisn', $nisn)->first();
            $formulirPendaftaran->nama_siswa = $request->nama_siswa;
            $formulirPendaftaran->jenis_kelamin = $request->jenis_kelamin;
            $formulirPendaftaran->asal_sekolah = $request->nama_sekolah;
            $formulirPendaftaran->tanggal_lahir = $request->tanggal_lahir;
            $formulirPendaftaran->jurusan_id = $request->jurusan;
            $formulirPendaftaran->sekolah_id = $request->sekolah_yang_dituju;
            $formulirPendaftaran->no_hp_orang_tua = $request->no_hp_orang_tua;
            $formulirPendaftaran->no_hp_siswa = $request->no_hp_siswa;
            $formulirPendaftaran->status_daftar_ulang = 1;
            $formulirPendaftaran->update();

            $dataSiswa = new DataSiswa();
            $dataSiswa->no_pendaftaran = $calonSiswa->no_pendaftaran;
            $dataSiswa->nisn = $calonSiswa->nisn;
            $dataSiswa->sekolah_yang_dituju = $calonSiswa->sekolah_yang_dituju;
            $dataSiswa->jurusan = $calonSiswa->jurusan;
            $dataSiswa->nik = $calonSiswa->nik;
            $dataSiswa->nama_siswa = $calonSiswa->nama_siswa;
            $dataSiswa->tempat_lahir = $calonSiswa->tempat_lahir;
            $dataSiswa->jenis_kelamin = $calonSiswa->jenis_kelamin;
            $dataSiswa->tanggal_lahir = $calonSiswa->tanggal_lahir;
            $dataSiswa->agama = $calonSiswa->agama;
            $dataSiswa->tinggi_badan = $calonSiswa->tinggi_badan;
            $dataSiswa->alamat_kampung = $calonSiswa->alamat_kampung;
            $dataSiswa->jumlah_saudara = $calonSiswa->jumlah_saudara;
            $dataSiswa->alamat_kelurahan = $calonSiswa->alamat_kelurahan;
            $dataSiswa->alamat_kota = $calonSiswa->alamat_kota;
            $dataSiswa->jarak_rumah = $calonSiswa->jarak_rumah;
            $dataSiswa->waktu_tempuh = $calonSiswa->waktu_tempuh;
            $dataSiswa->no_hp_siswa = $calonSiswa->no_hp_siswa;
            $dataSiswa->nama_ayah = $calonSiswa->nama_ayah;
            $dataSiswa->pendidikan_ayah = $calonSiswa->pendidikan_ayah;
            $dataSiswa->pekerjaan_ayah = $calonSiswa->pekerjaan_ayah;
            $dataSiswa->penghasilan_ayah = $calonSiswa->penghasilan_ayah;
            $dataSiswa->no_hp_orang_tua = $calonSiswa->no_hp_orang_tua;
            $dataSiswa->nama_ibu = $calonSiswa->nama_ibu;
            $dataSiswa->pekerjaan_ibu = $calonSiswa->pekerjaan_ibu;
            $dataSiswa->penghasilan_ibu = $calonSiswa->penghasilan_ibu;
            $dataSiswa->pendidikan_ibu = $calonSiswa->pendidikan_ibu;
            $dataSiswa->nama_wali = $calonSiswa->nama_wali;
            $dataSiswa->pekerjaan_wali = $calonSiswa->pekerjaan_wali;
            $dataSiswa->pendidikan_wali = $calonSiswa->pendidikan_wali;
            $dataSiswa->penghasilan_wali = $calonSiswa->penghasilan_wali;
            $dataSiswa->asal_sekolah = $calonSiswa->asal_sekolah;
            $dataSiswa->nomor_ijazah = $calonSiswa->nomor_ijazah;
            $dataSiswa->ijazah = $calonSiswa->ijazah;
            $dataSiswa->tahun_lulus = $calonSiswa->tahun_lulus;
            $dataSiswa->nomor_skhun = $calonSiswa->nomor_skhun;
            $dataSiswa->skhun = $calonSiswa->skhun;
            $dataSiswa->alamat_sekolah = $calonSiswa->alamat_sekolah;
            $dataSiswa->jenis_kejuaraan = $calonSiswa->jenis_kejuaraan;
            $dataSiswa->nama_beasiswa = $calonSiswa->nama_beasiswa;
            $dataSiswa->peringkat_kejuaraan = $calonSiswa->peringkat_kejuaraan;
            $dataSiswa->penyelengara_beasiswa = $calonSiswa->penyelengara_beasiswa;
            $dataSiswa->tingkat_kejuaraan = $calonSiswa->tingkat_kejuaraan;
            $dataSiswa->tahun_beasiswa = $calonSiswa->tahun_beasiswa;
            $dataSiswa->pas_foto = $calonSiswa->pas_foto;
            $dataSiswa->kartu_keluarga = $calonSiswa->kartu_keluarga;
            $dataSiswa->created_by = auth()->user()->id;
            $dataSiswa->save();

            $result->status = true;
            $result->message = 'Data berhasil disimpan';
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            $result->status = false;
            $result->message = $ex->getMessage();
        }
        return $result;
    }
}
