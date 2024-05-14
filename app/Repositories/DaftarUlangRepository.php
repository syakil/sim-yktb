<?php

namespace App\Repositories;

use App\Models\CalonSiswa;
use App\Models\FormulirPendaftaran;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use stdClass;

//use Your Model

/**
 * Class DaftarUlangRepository.
 */
class DaftarUlangRepository extends BaseRepository
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
        $check = CalonSiswa::where('nisn', auth()->user()->id)->first();
        if($check){
            return response()->json([
                'status' => false,
                'message' => 'Siswa sudah terdaftar sebagai calon siswa.'
            ]);
        }
        $check = FormulirPendaftaran::where('nisn', auth()->user()->id)->first();
        if(!$check){
            return response()->json([
                'status' => false,
                'message' => 'Siswa belum mengisi formulir pendaftaran.'
            ]);
        }
        try {
            DB::beginTransaction();

            $ijazah = $request->file('ijazah');
            $ijazahName = $request->no_pendaftaran.'_ijazah.'.$ijazah->extension();
            $skhun = $request->file('skhun');
            $skhunName = $request->no_pendaftaran.'_skhun.'.$skhun->extension();
            $pasFoto = $request->file('pas_foto');
            $pasFotoName = $request->no_pendaftaran.'_pas_foto.'.$pasFoto->extension();
            $kartuKeluarga = $request->file('kartu_keluarga');
            $kartuKeluargaName = $request->no_pendaftaran.'_kartu_keluarga.'.$kartuKeluarga->extension();

            $calonSiswa = new CalonSiswa();
            $calonSiswa->no_pendaftaran = $request->no_pendaftaran;
            $calonSiswa->nisn = auth()->user()->id;
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
            $calonSiswa->pas_foto = $pasFotoName;
            $calonSiswa->kartu_keluarga = $kartuKeluargaName;
            $calonSiswa->created_by = auth()->user()->id;
            $calonSiswa->save();

            $ijazah->move(public_path('daftar_ulang/'.$request->no_pendaftaran), $ijazahName);
            $skhun->move(public_path('daftar_ulang/'.$request->no_pendaftaran), $skhunName);
            $pasFoto->move(public_path('daftar_ulang/'.$request->no_pendaftaran), $pasFotoName);
            $kartuKeluarga->move(public_path('daftar_ulang/'.$request->no_pendaftaran), $kartuKeluargaName);

            $formulirPendaftaran = FormulirPendaftaran::where('nisn', auth()->user()->id)->first();
            $formulirPendaftaran->status_daftar_ulang = 1;
            $formulirPendaftaran->update();

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
