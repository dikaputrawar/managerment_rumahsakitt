<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari konvensi
    protected $table = 'konsultasi';

    // Tentukan field yang dapat diisi (fillable)
    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'jadwal_id',
        'tanggal_konsultasi',
        'status',
    ];

    /**
     * Relasi dengan model Pasien
     */
    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    /**
     * Relasi dengan model Dokter
     */
    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    /**
     * Relasi dengan model Jadwal
     */
    public function jadwal()
    {
        return $this->belongsTo(jadwaldokter::class);
    }
}