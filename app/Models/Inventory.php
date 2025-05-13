<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory';

    protected $primaryKey = 'inventory_id';

    protected $fillable = [
        'nama_obat',
        'kategori',
        'stok',
        'harga',
        'exp_date',
    ];

    protected $casts = [
        'exp_date' => 'date',
        'harga' => 'decimal:2',
    ];
}
