<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    use HasFactory;

    protected $table = 'konsultasi';

    protected $fillable = [
        'pasien_id',
        'jadwal_id',
        'keluhan',
        'diagnosa',
        'resep_obat',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function jadwal()
    {
        return $this->belongsTo(JadwalDokter::class);
    }
}
