<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    // Definisikan nama tabel jika berbeda dari konvensi
    protected $table = 'dokter';

    // Tentukan field yang dapat diisi (fillable)
    protected $fillable = [
        'nama',
        'spesialisasi',
        'no_telepon',
        'email',
    ];

    /**
     * Relasi dengan model Konsultasi
     */
    public function konsultasi()
    {
        return $this->hasMany(Konsultasi::class);
    }

    /**
     * Relasi dengan model Jadwal
     */
    public function jadwal()
    {
        return $this->hasMany(jadwaldokter::class);
    }
}