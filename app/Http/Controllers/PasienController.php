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

    /**
     * @OA\Get(
     *     path="/api/pasien/{id}",
     *     operationId="getDetailPasien",
     *     tags={"Pasien"},
     *     summary="Menampilkan detail pasien berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail pasien ditemukan"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pasien tidak ditemukan"
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/pasien",
     *     operationId="storePasien",
     *     tags={"Pasien"},
     *     summary="Menyimpan data pasien baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama","tanggal_lahir","jenis_kelamin","alamat"},
     *             @OA\Property(property="nama", type="string"),
     *             @OA\Property(property="tanggal_lahir", type="string", format="date"),
     *             @OA\Property(property="jenis_kelamin", type="string"),
     *             @OA\Property(property="alamat", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Data pasien berhasil disimpan"
     *     )
     * )
     */
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

    /**
     * @OA\Put(
     *     path="/api/pasien/{id}",
     *     operationId="updatePasien",
     *     tags={"Pasien"},
     *     summary="Memperbarui data pasien",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama","tanggal_lahir","jenis_kelamin","alamat"},
     *             @OA\Property(property="nama", type="string"),
     *             @OA\Property(property="tanggal_lahir", type="string", format="date"),
     *             @OA\Property(property="jenis_kelamin", type="string"),
     *             @OA\Property(property="alamat", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data pasien berhasil diperbarui"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pasien tidak ditemukan"
     *     )
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/pasien/{id}",
     *     operationId="deletePasien",
     *     tags={"Pasien"},
     *     summary="Menghapus data pasien",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pasien berhasil dihapus"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pasien tidak ditemukan"
     *     )
     * )
     */
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