<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return Laporan::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        return Laporan::create($request->all());
    }

    public function show(Laporan $laporan)
    {
        return $laporan;
    }

    public function update(Request $request, Laporan $laporan)
    {
        $laporan->update($request->all());
        return $laporan;
    }

    public function destroy(Laporan $laporan)
    {
        $laporan->delete();
        return response()->json(['message' => 'Laporan berhasil dihapus']);
    }
}
