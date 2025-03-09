<?php

namespace App\Http\Controllers;

use App\Models\JadwalDokter;
use Illuminate\Http\Request;

class JadwalDokterController extends Controller
{
    public function index()
    {
        return JadwalDokter::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'dokter_id' => 'required|exists:dokter,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required|date_format:H:i:s',
            'jam_selesai' => 'required|date_format:H:i:s',
        ]);

        return JadwalDokter::create($request->all());
    }

    public function show(JadwalDokter $jadwalDokter)
    {
        return $jadwalDokter;
    }

    public function update(Request $request, JadwalDokter $jadwalDokter)
    {
        $jadwalDokter->update($request->all());
        return $jadwalDokter;
    }

    public function destroy(JadwalDokter $jadwalDokter)
    {
        $jadwalDokter->delete();
        return response()->json(['message' => 'Jadwal dokter berhasil dihapus']);
    }
}
