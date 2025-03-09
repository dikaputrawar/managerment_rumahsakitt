<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use Illuminate\Http\Request;

class RekamMedisController extends Controller
{
    public function index()
    {
        return RekamMedis::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'riwayat_penyakit' => 'required|string',
            'pengobatan' => 'required|string',
        ]);

        return RekamMedis::create($request->all());
    }

    public function show(RekamMedis $rekamMedis)
    {
        return $rekamMedis;
    }

    public function update(Request $request, RekamMedis $rekamMedis)
    {
        $rekamMedis->update($request->all());
        return $rekamMedis;
    }

    public function destroy(RekamMedis $rekamMedis)
    {
        $rekamMedis->delete();
        return response()->json(['message' => 'Rekam Medis berhasil dihapus']);
    }
}
