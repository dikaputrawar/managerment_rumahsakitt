<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekamMedis;

class RekamMedisController extends Controller
{
    public function index()
    {
        $rekamMedis = RekamMedis::with('pasien')->get();
        return response()->json($rekamMedis);
    }

    public function show($id)
    {
        $rekamMedis = RekamMedis::with('pasien')->find($id);
        if (!$rekamMedis) {
            return response()->json(['message' => 'Rekam medis tidak ditemukan'], 404);
        }
        return response()->json($rekamMedis);
    }

    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,pasien_id',
            'tanggal_kunjungan' => 'required|date',
            'diagnosis' => 'required|string',
            'tindakan' => 'required|string',
            'obat' => 'required|string',
        ]);

        $rekamMedis = RekamMedis::create($request->all());

        return response()->json($rekamMedis, 201);
    }

    public function update(Request $request, $id)
    {
        $rekamMedis = RekamMedis::find($id);
        if (!$rekamMedis) {
            return response()->json(['message' => 'Rekam medis tidak ditemukan'], 404);
        }

        $request->validate([
            'pasien_id' => 'sometimes|required|exists:pasien,pasien_id',
            'tanggal_kunjungan' => 'sometimes|required|date',
            'diagnosis' => 'sometimes|required|string',
            'tindakan' => 'sometimes|required|string',
            'obat' => 'sometimes|required|string',
        ]);

        $rekamMedis->update($request->all());

        return response()->json($rekamMedis);
    }

    public function destroy($id)
    {
        $rekamMedis = RekamMedis::find($id);
        if (!$rekamMedis) {
            return response()->json(['message' => 'Rekam medis tidak ditemukan'], 404);
        }

        $rekamMedis->delete();

        return response()->json(['message' => 'Rekam medis berhasil dihapus']);
    }
}
