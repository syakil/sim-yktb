<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulirPendaftaran extends Model
{
    use HasFactory;
    protected $table = 'formulir_pendaftaran';
    protected $primaryKey = 'no_pendaftaran';
    protected $fillable = [
        'nisn',
        'nama_siswa',
        'jenis_kelamin',
        'asal_sekolah',
        'alamat',
        'tanggal_lahir',
        'no_hp_orang_tua',
        'no_hp_siswa',
        'jurusan_id',
        'sekolah_id',
        'status_daftar_ulang',
        'no_pendaftaran'
    ];
}
