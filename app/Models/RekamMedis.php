<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis'; 

    protected $primaryKey = 'rekam_id';

    protected $fillable = [
        'pasien_id',
        'tanggal_kunjungan',
        'diagnosis',
        'tindakan',
        'obat'
    ];


    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }
}
