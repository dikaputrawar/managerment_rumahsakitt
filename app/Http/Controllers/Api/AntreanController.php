<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Antrean;

class AntreanController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/antrean",
     *     operationId="getAntrean",
     *     tags={"Antrean"},
     *     summary="Menampilkan semua data antrean",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan daftar antrean"
     *     )
     * )
     */
    public function index()
    {
        $antrean = Antrean::all();
        return response()->json([
            'message' => 'Data semua antrean',
            'data' => $antrean
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/antrean/{id}",
     *     operationId="getDetailAntrean",
     *     tags={"Antrean"},
     *     summary="Menampilkan detail antrean berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail antrean ditemukan"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Antrean tidak ditemukan"
     *     )
     * )
     */
    public function show($id)
    {
        $antrean = Antrean::find($id);
        if (!$antrean) {
            return response()->json(['message' => 'Antrean tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Detail antrean',
            'data' => $antrean
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/antrean",
     *     operationId="storeAntrean",
     *     tags={"Antrean"},
     *     summary="Membuat antrean baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"pasien_id", "nomor_antrean", "status", "tanggal"},
     *             @OA\Property(property="pasien_id", type="integer"),
     *             @OA\Property(property="nomor_antrean", type="string"),
     *             @OA\Property(property="status", type="string", enum={"menunggu", "dipanggil", "selesai", "batal"}),
     *             @OA\Property(property="tanggal", type="string", format="date")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Antrean berhasil dibuat"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'nomor_antrean' => 'required|string',
            'status' => 'required|in:menunggu,dipanggil,selesai,batal',
            'tanggal' => 'required|date'
        ]);

        $antrean = Antrean::create($data);

        return response()->json([
            'message' => 'Antrean berhasil dibuat',
            'data' => $antrean
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/antrean/{id}",
     *     operationId="updateAntrean",
     *     tags={"Antrean"},
     *     summary="Memperbarui data antrean",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"pasien_id", "nomor_antrean", "status", "tanggal"},
     *             @OA\Property(property="pasien_id", type="integer"),
     *             @OA\Property(property="nomor_antrean", type="string"),
     *             @OA\Property(property="status", type="string", enum={"menunggu", "dipanggil", "selesai", "batal"}),
     *             @OA\Property(property="tanggal", type="string", format="date")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Antrean berhasil diperbarui"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Antrean tidak ditemukan"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $antrean = Antrean::find($id);
        if (!$antrean) {
            return response()->json(['message' => 'Antrean tidak ditemukan'], 404);
        }

        $data = $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'nomor_antrean' => 'required|string',
            'status' => 'required|in:menunggu,dipanggil,selesai,batal',
            'tanggal' => 'required|date'
        ]);

        $antrean->update($data);

        return response()->json([
            'message' => 'Antrean berhasil diperbarui',
            'data' => $antrean
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/antrean/{id}",
     *     operationId="deleteAntrean",
     *     tags={"Antrean"},
     *     summary="Menghapus data antrean",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Antrean berhasil dihapus"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Antrean tidak ditemukan"
     *     )
     * )
     */
    public function destroy($id)
    {
        $antrean = Antrean::find($id);
        if (!$antrean) {
            return response()->json(['message' => 'Antrean tidak ditemukan'], 404);
        }

        $antrean->delete();

        return response()->json([
            'message' => 'Antrean berhasil dihapus',
            'deleted_id' => $id
        ], 200);
    }
}
