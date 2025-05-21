<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pendaftaran extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pendaftarans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pasien_id',
        'poli_id',
        'status_bpjs',
        'waktu_daftar',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'waktu_daftar' => 'datetime',
    ];

    /**
     * Get the pasien that owns the pendaftaran.
     */
    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    /**
     * Get the poli that owns the pendaftaran.
     */
    public function poli(): BelongsTo
    {
        return $this->belongsTo(Poli::class);
    }
}