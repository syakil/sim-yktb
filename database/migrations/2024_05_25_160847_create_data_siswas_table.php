<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_siswas', function (Blueprint $table) {
              $table->integer('no_pendaftaran')->primaryKey();
                $table->integer('nisn')->unique();
                $table->integer('sekolah_yang_dituju');
                $table->integer('jurusan');
                $table->string('nik')->unique();
                $table->string('nama_siswa');
                $table->string('tempat_lahir');
                $table->string('jenis_kelamin');
                $table->date('tanggal_lahir');
                $table->string('agama');
                $table->integer('tinggi_badan');
                $table->string('alamat_kampung');
                $table->integer('jumlah_saudara');
                $table->string('alamat_kelurahan');
                $table->string('alamat_kota');
                $table->integer('jarak_rumah');
                $table->integer('waktu_tempuh');
                $table->string('no_hp_siswa');
                $table->string('nama_ayah')->nullable();
                $table->string('pendidikan_ayah')->nullable();
                $table->string('pekerjaan_ayah')->nullable();
                $table->integer('penghasilan_ayah')->nullable();
                $table->string('no_hp_orang_tua');
                $table->string('nama_ibu')->nullable();
                $table->string('pekerjaan_ibu')->nullable();
                $table->integer('penghasilan_ibu')->nullable();
                $table->string('pendidikan_ibu')->nullable();
                $table->string('nama_wali')->nullable();
                $table->string('pekerjaan_wali')->nullable();
                $table->string('pendidikan_wali')->nullable();
                $table->integer('penghasilan_wali')->nullable();
                $table->string('asal_sekolah');
                $table->string('nomor_ijazah')->nullable();
                $table->string('ijazah')->nullable();
                $table->integer('tahun_lulus');
                $table->string('nomor_skhun')->nullable();
                $table->string('skhun')->nullable();
                $table->string('alamat_sekolah');
                $table->string('jenis_kejuaraan')->nullable();
                $table->string('nama_beasiswa')->nullable();
                $table->integer('peringkat_kejuaraan')->nullable();
                $table->string('penyelengara_beasiswa')->nullable();
                $table->string('tingkat_kejuaraan')->nullable();
                $table->integer('tahun_beasiswa')->nullable();
                $table->string('pas_foto');
                $table->string('kartu_keluarga');
                $table->string('created_by');
                $table->string('updated_by')->nullable();
                $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_siswas');
    }
};
