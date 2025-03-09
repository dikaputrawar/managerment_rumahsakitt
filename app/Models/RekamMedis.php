<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis';

    protected $fillable = [
        'pasien_id',
        'riwayat_penyakit',
        'pengobatan_sebelumnya',
        'alergi',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
}
