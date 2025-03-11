<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;

class LaporanController extends Controller
{
    public function index()
    {
        return response()->json(Laporan::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'periode' => 'required|string',
            'jumlah_pasien' => 'required|integer',
            'pendapatan' => 'required|numeric'
        ]);

        $laporan = Laporan::create($request->all());
        return response()->json($laporan, 201);
    }

    public function show($id)
    {
        return response()->json(Laporan::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->update($request->all());
        return response()->json($laporan);
    }

    public function destroy($id)
    {
        Laporan::destroy($id);
        return response()->json(null, 204);
    }
}
