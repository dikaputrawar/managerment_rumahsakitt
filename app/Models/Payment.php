<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';
    protected $primaryKey = 'payment_id';

    protected $fillable = [
        'konsultasi_id',
        'amount',
        'payment_date',
        'method',
        'status',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    /**
     * Relasi ke Konsultasi
     */
    public function konsultasi()
    {
        return $this->belongsTo(Konsultasi::class, 'konsultasi_id', 'konsultasi_id');
    }
}
