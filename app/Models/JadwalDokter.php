<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalDokter extends Model
{
    use HasFactory;

    protected $table = 'jadwal_dokter'; 

    protected $primaryKey = 'jadwal_id'; 

    protected $fillable = [
        'dokter_id',
        'hari',
        'jam_mulai',
        'jam_selesai'
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }
}
