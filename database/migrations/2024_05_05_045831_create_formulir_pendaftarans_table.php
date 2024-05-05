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
            $table->string('nama_anak');
            $table->string('no_hp');
            $table->string('jurusan');
            $table->string('sekolah_yang_dituju');
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
