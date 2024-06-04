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
        Schema::create('dana_sumbangan_pendidikan', function (Blueprint $table) {
            $table->integer('no_pendaftaran');
            $table->date('tgl_pembayaran');
            $table->string('nominal_yang_disetor');
            $table->string('is_lunas');
            $table->string('keterangan');
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
        Schema::dropIfExists('dana_sumbangan_pendidikans');
    }
};
