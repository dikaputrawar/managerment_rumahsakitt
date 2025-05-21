<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antrean extends Model
{
    protected $table = 'antrean';

    protected $fillable = [
        'pasien_id', 'nomor_antrean', 'status', 'tanggal'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
}
