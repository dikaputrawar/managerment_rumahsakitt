<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan'; 

    protected $primaryKey = 'laporan_id'; 

    protected $fillable = [
        'periode',
        'jumlah_pasien',
        'pendapatan'
    ];
}
