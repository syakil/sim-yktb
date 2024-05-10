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
        Schema::create('formulir_pendaftaran', function (Blueprint $table) {
            $table->integer('no_pendaftaran')->primary();
            $table->string('nisn');
            $table->string('nama_siswa');
            $table->string('jenis_kelamin');
            $table->string('asal_sekolah');
            $table->string('alamat');
            $table->date('tanggal_lahir');
            $table->string('no_hp_orang_tua');
            $table->string('no_hp_siswa');
            $table->integer('jurusan_id');
            $table->integer('sekolah_id');
            $table->boolean('status_daftar_ulang')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulir_pendaftarans');
    }
};
