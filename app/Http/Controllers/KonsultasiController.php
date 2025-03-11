<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konsultasi;

class KonsultasiController extends Controller
{
    public function index()
    {
        $konsultasi = Konsultasi::with(['pasien', 'dokter', 'jadwal'])->get();
        return response()->json($konsultasi);
    }

    public function show($id)
    {
        $konsultasi = Konsultasi::with(['pasien', 'dokter', 'jadwal'])->find($id);
        if (!$konsultasi) {
            return response()->json(['message' => 'Konsultasi tidak ditemukan'], 404);
        }
        return response()->json($konsultasi);
    }

    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,pasien_id',
            'dokter_id' => 'required|exists:dokter,dokter_id',
            'jadwal_id' => 'required|exists:jadwal_dokter,jadwal_id',
            'tanggal_konsultasi' => 'required|date',
            'status' => 'required|in:Dijadwalkan,Selesai,Dibatalkan',
        ]);

        $konsultasi = Konsultasi::create($request->all());

        return response()->json($konsultasi, 201);
    }

    public function update(Request $request, $id)
    {
        $konsultasi = Konsultasi::find($id);
        if (!$konsultasi) {
            return response()->json(['message' => 'Konsultasi tidak ditemukan'], 404);
        }

        $request->validate([
            'pasien_id' => 'sometimes|required|exists:pasien,pasien_id',
            'dokter_id' => 'sometimes|required|exists:dokter,dokter_id',
            'jadwal_id' => 'sometimes|required|exists:jadwal_dokter,jadwal_id',
            'tanggal_konsultasi' => 'sometimes|required|date',
            'status' => 'sometimes|required|in:Dijadwalkan,Selesai,Dibatalkan',
        ]);

        $konsultasi->update($request->all());

        return response()->json($konsultasi);
    }

    public function destroy($id)
    {
        $konsultasi = Konsultasi::find($id);
        if (!$konsultasi) {
            return response()->json(['message' => 'Konsultasi tidak ditemukan'], 404);
        }

        $konsultasi->delete();

        return response()->json(['message' => 'Konsultasi berhasil dihapus']);
    }
}
