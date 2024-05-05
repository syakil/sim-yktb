<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulirPendaftaran extends Model
{
    use HasFactory;
    protected $table = 'formulir_pendaftaran';
    protected $primaryKey = 'no_pendaftaran';
}
