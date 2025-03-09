<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index()
    {
        return Pasien::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:15',
        ]);

        return Pasien::create($request->all());
    }

    public function show(Pasien $pasien)
    {
        return $pasien;
    }

    public function update(Request $request, Pasien $pasien)
    {
        $pasien->update($request->all());
        return $pasien;
    }

    public function destroy(Pasien $pasien)
    {
        $pasien->delete();
        return response()->json(['message' => 'Pasien berhasil dihapus']);
    }
}
