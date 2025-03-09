<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model {
    use HasFactory;

    protected $table = 'dokter';
    protected $fillable = ['nama', 'spesialisasi', 'no_telepon', 'email'];
    
    public function jadwal() {
        return $this->hasMany(JadwalDokter::class, 'dokter_id');
    }
}
