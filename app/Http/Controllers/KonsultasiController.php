<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use Illuminate\Http\Request;

class KonsultasiController extends Controller
{
    public function index()
    {
        return Konsultasi::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'jadwal_id' => 'required|exists:jadwal_dokter,id',
            'keluhan' => 'required|string',
        ]);

        return Konsultasi::create($request->all());
    }

    public function show(Konsultasi $konsultasi)
    {
        return $konsultasi;
    }

    public function update(Request $request, Konsultasi $konsultasi)
    {
        $konsultasi->update($request->all());
        return $konsultasi;
    }

    public function destroy(Konsultasi $konsultasi)
    {
        $konsultasi->delete();
        return response()->json(['message' => 'Konsultasi berhasil dihapus']);
    }
}
