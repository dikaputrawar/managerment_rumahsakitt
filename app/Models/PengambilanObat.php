<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengambilanObat extends Model
{
    use HasFactory;

    protected $table = 'obat_pengambilan';

    protected $fillable = [
        'pasien_id',
        'inventory_id',
        'jumlah',
        'tanggal_ambil',
        'status',
    ];

    // Relasi ke Pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    // Relasi ke Inventory
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
