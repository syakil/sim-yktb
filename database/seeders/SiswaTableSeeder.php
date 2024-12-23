<?php

namespace Database\Seeders;

use App\Models\CalonSiswa;
use App\Models\DanaSumbanganPendidikan;
use App\Models\DataSiswa;
use App\Models\FormulirPendaftaran;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SiswaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 350; $i++) {
            $no_pendaftaran = '242500' . str_pad($i + 1, 2, '0', STR_PAD_LEFT);
            $nisn = rand(100000000, 999999999);
            $nama_siswa = Str::random(10);
            $jenis_kelamin = rand(0, 1) ? 'Laki-laki' : 'Perempuan';
            $asal_sekolah = Str::random(10);
            $alamat = Str::random(20);
            $tanggal_lahir = now()->subYears(rand(15, 18))->subDays(rand(0, 365))->format('Y-m-d');
            $no_hp_orang_tua = '08' . rand(1000000000, 9999999999);
            $no_hp_siswa = '08' . rand(1000000000, 9999999999);
            $jurusans = rand(1, 3);
            $sekolah = rand(1, 3);
            $start = Carbon::createFromDate(2025, 3, 1);
            $end = Carbon::createFromDate(2025, 8, 30);

            $randomDate = Carbon::createFromTimestamp(rand($start->timestamp, $end->timestamp))->format('Y-m-d');


            $formulirPendaftaran = new FormulirPendaftaran();
            $formulirPendaftaran->no_pendaftaran = $no_pendaftaran;
            $formulirPendaftaran->nisn = $nisn;
            $formulirPendaftaran->nama_siswa = $nama_siswa;
            $formulirPendaftaran->jenis_kelamin = $jenis_kelamin;
            $formulirPendaftaran->asal_sekolah = $asal_sekolah;
            $formulirPendaftaran->alamat = $alamat;
            $formulirPendaftaran->tanggal_lahir = $tanggal_lahir;
            $formulirPendaftaran->no_hp_orang_tua = $no_hp_orang_tua;
            $formulirPendaftaran->no_hp_siswa = $no_hp_siswa;
            $formulirPendaftaran->jurusan_id = $jurusans;
            $formulirPendaftaran->sekolah_id = $sekolah;
            $formulirPendaftaran->created_by = 1;
            $formulirPendaftaran->created_at = $randomDate;
            $formulirPendaftaran->save();




            if($i % 2 == 0){
                DB::table('calon_siswas')->insert([
                    'no_pendaftaran' => $no_pendaftaran,
                    'nisn' => $nisn,
                    'sekolah_yang_dituju' => $sekolah,
                    'jurusan' => $jurusans,
                    'nik' => Str::random(16),
                    'nama_siswa' => $nama_siswa,
                    'tempat_lahir' => Str::random(10),
                    'jenis_kelamin' => rand(0, 1) ? 'Laki-laki' : 'Perempuan',
                    'tanggal_lahir' => now()->subYears(rand(15, 18))->subDays(rand(0, 365))->format('Y-m-d'),
                    'agama' => 'Islam', // ganti sesuai kebutuhan
                    'tinggi_badan' => rand(140, 200),
                    'alamat_kampung' => Str::random(20),
                    'jumlah_saudara' => rand(1, 5),
                    'alamat_kelurahan' => Str::random(20),
                    'alamat_kota' => Str::random(20),
                    'jarak_rumah' => rand(1, 20),
                    'waktu_tempuh' => rand(5, 60),
                    'no_hp_siswa' => '08' . rand(1000000000, 9999999999),
                    'nama_ayah' => Str::random(10),
                    'pendidikan_ayah' => 'SMA',
                    'pekerjaan_ayah' => 'Karyawan Swasta',
                    'penghasilan_ayah' => rand(1000000, 5000000),
                    'no_hp_orang_tua' => '08' . rand(1000000000, 9999999999),
                    'nama_ibu' => Str::random(10),
                    'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                    'penghasilan_ibu' => rand(1000000, 5000000),
                    'pendidikan_ibu' => 'SMA',
                    'nama_wali' => Str::random(10),
                    'pekerjaan_wali' => 'Petani',
                    'pendidikan_wali' => 'SMP',
                    'penghasilan_wali' => rand(1000000, 5000000),
                    'asal_sekolah' => Str::random(10),
                    'nomor_ijazah' => Str::random(10),
                    'ijazah' => Str::random(10),
                    'tahun_lulus' => rand(2010, 2024),
                    'nomor_skhun' => Str::random(10),
                    'skhun' => Str::random(10),
                    'alamat_sekolah' => Str::random(20),
                    'jenis_kejuaraan' => Str::random(10),
                    'nama_beasiswa' => Str::random(10),
                    'peringkat_kejuaraan' => rand(1, 3),
                    'penyelengara_beasiswa' => Str::random(10),
                    'tingkat_kejuaraan' => Str::random(10),
                    'tahun_beasiswa' => rand(2010, 2024),
                    'pas_foto' => 'foto.jpg',
                    'kartu_keluarga' => 'kk.jpg',
                    'created_by' => 'Seeder',
                    'updated_by' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if($i % 3 == 0){
                $calon = CalonSiswa::where('no_pendaftaran',$no_pendaftaran)->first();
                if($calon){
                    DB::table('data_siswas')->insert([
                        'no_pendaftaran' => $no_pendaftaran,
                        'nisn' => $nisn,
                        'sekolah_yang_dituju' => $sekolah,
                        'jurusan' => $jurusans,
                        'nik' => Str::random(16),
                        'nama_siswa' => $nama_siswa,
                        'tempat_lahir' => Str::random(10),
                        'jenis_kelamin' => rand(0, 1) ? 'Laki-laki' : 'Perempuan',
                        'tanggal_lahir' => now()->subYears(rand(15, 18))->subDays(rand(0, 365))->format('Y-m-d'),
                        'agama' => 'Islam', // ganti sesuai kebutuhan
                        'tinggi_badan' => rand(140, 200),
                        'alamat_kampung' => Str::random(20),
                        'jumlah_saudara' => rand(1, 5),
                        'alamat_kelurahan' => Str::random(20),
                        'alamat_kota' => Str::random(20),
                        'jarak_rumah' => rand(1, 20),
                        'waktu_tempuh' => rand(5, 60),
                        'no_hp_siswa' => '08' . rand(1000000000, 9999999999),
                        'nama_ayah' => Str::random(10),
                        'pendidikan_ayah' => 'SMA',
                        'pekerjaan_ayah' => 'Karyawan Swasta',
                        'penghasilan_ayah' => rand(1000000, 5000000),
                        'no_hp_orang_tua' => '08' . rand(1000000000, 9999999999),
                        'nama_ibu' => Str::random(10),
                        'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                        'penghasilan_ibu' => rand(1000000, 5000000),
                        'pendidikan_ibu' => 'SMA',
                        'nama_wali' => Str::random(10),
                        'pekerjaan_wali' => 'Petani',
                        'pendidikan_wali' => 'SMP',
                        'penghasilan_wali' => rand(1000000, 5000000),
                        'asal_sekolah' => Str::random(10),
                        'nomor_ijazah' => Str::random(10),
                        'ijazah' => Str::random(10),
                        'tahun_lulus' => rand(2010, 2024),
                        'nomor_skhun' => Str::random(10),
                        'skhun' => Str::random(10),
                        'alamat_sekolah' => Str::random(20),
                        'jenis_kejuaraan' => Str::random(10),
                        'nama_beasiswa' => Str::random(10),
                        'peringkat_kejuaraan' => rand(1, 3),
                        'penyelengara_beasiswa' => Str::random(10),
                        'tingkat_kejuaraan' => Str::random(10),
                        'tahun_beasiswa' => rand(2010, 2024),
                        'pas_foto' => 'foto.jpg',
                        'kartu_keluarga' => 'kk.jpg',
                        'created_by' => 'Seeder',
                        'updated_by' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                }
            }



            if($i % 2 == 0){
                $data = DataSiswa::where('no_pendaftaran',$no_pendaftaran)->first();
                if($data){
                    $dsp = new DanaSumbanganPendidikan();
                    $dsp->no_pendaftaran = $no_pendaftaran;
                    $dsp->tgl_pembayaran = now();
                    $dsp->nominal_yang_disetor = rand(1000000, 5000000);
                    $dsp->is_lunas = rand(1,0);
                    $dsp->keterangan = Str::random(20);
                    $dsp->created_by = 'seeder';
                    $dsp->save();
                }
            }
        }
    }
}
