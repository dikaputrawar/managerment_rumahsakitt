<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function index()
    {
        $dokter = Dokter::all();
        return response()->json($dokter);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'spesialisasi' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15',
            'email' => 'required|email|unique:dokter,email',
        ]);

        $dokter = Dokter::create($request->all());
        return response()->json(['message' => 'Dokter berhasil ditambahkan', 'data' => $dokter], 201);
    }

    public function show(Dokter $dokter)
    {
        return response()->json($dokter);
    }

    public function update(Request $request, Dokter $dokter)
    {
        $request->validate([
            'nama' => 'sometimes|string|max:255',
            'spesialisasi' => 'sometimes|string|max:255',
            'no_telepon' => 'sometimes|string|max:15',
            'email' => 'sometimes|email|unique:dokter,email,'.$dokter->id,
        ]);

        $dokter->update($request->all());
        return response()->json(['message' => 'Dokter berhasil diperbarui', 'data' => $dokter]);
    }

    public function destroy(Dokter $dokter)
    {
        $dokter->delete();
        return response()->json(['message' => 'Dokter berhasil dihapus']);
    }
}
