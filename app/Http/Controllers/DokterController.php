<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokter;

class DokterController extends Controller
{
    public function index()
    {
        $dokter = Dokter::with('jadwal', 'konsultasi')->get();
        return response()->json($dokter);
    }

    public function show($id)
    {
        $dokter = Dokter::with('jadwal', 'konsultasi')->find($id);
        if (!$dokter) {
            return response()->json(['message' => 'Dokter tidak ditemukan'], 404);
        }
        return response()->json($dokter);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'spesialisasi' => 'required|string|max:100',
            'no_telepon' => 'required|string|max:20|unique:dokter,no_telepon',
            'email' => 'required|email|max:100|unique:dokter,email',
        ]);

        $dokter = Dokter::create($request->all());

        return response()->json($dokter, 201);
    }

    public function update(Request $request, $id)
    {
        $dokter = Dokter::find($id);
        if (!$dokter) {
            return response()->json(['message' => 'Dokter tidak ditemukan'], 404);
        }

        $request->validate([
            'nama' => 'sometimes|required|string|max:100',
            'spesialisasi' => 'sometimes|required|string|max:100',
            'no_telepon' => 'sometimes|required|string|max:20|unique:dokter,no_telepon,' . $id . ',dokter_id',
            'email' => 'sometimes|required|email|max:100|unique:dokter,email,' . $id . ',dokter_id',
        ]);

        $dokter->update($request->all());

        return response()->json($dokter);
    }

    public function destroy($id)
    {
        $dokter = Dokter::find($id);
        if (!$dokter) {
            return response()->json(['message' => 'Dokter tidak ditemukan'], 404);
        }

        $dokter->delete();

        return response()->json(['message' => 'Dokter berhasil dihapus']);
    }
}
