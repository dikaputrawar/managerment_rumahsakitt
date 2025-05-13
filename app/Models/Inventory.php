<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory';

    protected $fillable = [
        'nama_obat',
        'kategori',
        'stok',
        'harga',
        'exp_date',
    ];

    protected $dates = ['exp_date', 'created_at', 'updated_at'];
}
