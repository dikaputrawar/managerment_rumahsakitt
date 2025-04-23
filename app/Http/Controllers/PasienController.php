<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Dokumentasi API Rumah Sakit",
 *     description="API ini digunakan untuk mengelola data pasien, dokter, konsultasi, dan lainnya."
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Server API Lokal"
 * )
 */

class PasienController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/pasien",
     *     operationId="getPasien",
     *     tags={"Pasien"},
     *     summary="Menampilkan daftar semua pasien",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan daftar pasien"
     *     )
     * )
     */
    

    public function index()
    {
        $pasien = Pasien::all();
        return response()->json([
            'message' => 'Data semua pasien',
            'data' => $pasien
        ], 200);
    }

    public function show($id)
    {
        $pasien = Pasien::find($id);
        if (!$pasien) {
            return response()->json([
                'message' => 'Pasien tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Detail pasien',
            'data' => $pasien
        ], 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string',
            'alamat' => 'required|string',
        ]);

        $pasien = Pasien::create($data);

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $pasien
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $pasien = Pasien::find($id);
        if (!$pasien) {
            return response()->json([
                'message' => 'Pasien tidak ditemukan'
            ], 404);
        }

        $data = $request->validate([
            'nama' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string',
            'alamat' => 'required|string',
        ]);

        $pasien->update($data);

        return response()->json([
            'message' => 'Data pasien berhasil diperbarui',
            'data' => $pasien
        ], 200);
    }

    public function destroy($id)
    {
        $pasien = Pasien::find($id);
        if (!$pasien) {
            return response()->json([
                'message' => 'Pasien tidak ditemukan'
            ], 404);
        }

        $pasien->delete();

        return response()->json([
            'message' => 'Pasien berhasil dihapus',
            'deleted_id' => $id
        ], 200);
    }
    
}