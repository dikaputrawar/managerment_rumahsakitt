<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien'; 

    protected $primaryKey = 'pasien_id'; 

    protected $fillable = [
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat'
    ];

    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class, 'pasien_id', 'pasien_id');
    }
}
