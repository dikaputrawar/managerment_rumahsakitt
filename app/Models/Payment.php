<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Payment",
 *     title="Payment",
 *     description="Data pembayaran",
 *     type="object",
 *     required={"payment_id", "konsultasi_id", "amount", "payment_date", "method", "status"},
 *     @OA\Property(property="payment_id", type="integer", example=1),
 *     @OA\Property(property="konsultasi_id", type="integer", example=3),
 *     @OA\Property(property="amount", type="number", format="float", example=150000),
 *     @OA\Property(property="payment_date", type="string", format="date", example="2024-05-15"),
 *     @OA\Property(property="method", type="string", example="Cash"),
 *     @OA\Property(property="status", type="string", example="Paid"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-05-15T10:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-05-15T10:30:00Z")
 * )
 */
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
