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
     * 
     *     @OA\Parameter(
     *         name="nama",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="Nama pasien"
     *     ),
     *     @OA\Parameter(
     *         name="tanggal_lahir",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string", format="date"),
     *         description="Tanggal lahir pasien"
     *     ),
     *     @OA\Parameter(
     *         name="jenis_kelamin",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string", enum={"Laki-laki", "Perempuan"}),
     *         description="Jenis kelamin pasien"
     *     ),
     *     @OA\Parameter(
     *         name="alamat",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="Alamat pasien"
     *     ),
     * 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"pasien_id", "nomor_antrean", "status", "tanggal"},
     *             @OA\Property(property="pasien_id", type="integer", example=1),
     *             @OA\Property(property="nomor_antrean", type="string", example="A001"),
     *             @OA\Property(property="status", type="string", enum={"menunggu", "dipanggil", "selesai", "batal"}, example="menunggu"),
     *             @OA\Property(property="tanggal", type="string", format="date", example="2025-05-26")
     *         )
     *     ),
     * 
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
     * 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID antrean yang akan diperbarui"
     *     ),
     *     @OA\Parameter(
     *         name="nama",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="Nama pasien"
     *     ),
     *     @OA\Parameter(
     *         name="tanggal_lahir",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string", format="date"),
     *         description="Tanggal lahir pasien"
     *     ),
     *     @OA\Parameter(
     *         name="jenis_kelamin",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string", enum={"Laki-laki", "Perempuan"}),
     *         description="Jenis kelamin pasien"
     *     ),
     *     @OA\Parameter(
     *         name="alamat",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="Alamat pasien"
     *     ),
     * 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"pasien_id", "nomor_antrean", "status", "tanggal"},
     *             @OA\Property(property="pasien_id", type="integer", example=1),
     *             @OA\Property(property="nomor_antrean", type="string", example="A002"),
     *             @OA\Property(property="status", type="string", enum={"menunggu", "dipanggil", "selesai", "batal"}, example="dipanggil"),
     *             @OA\Property(property="tanggal", type="string", format="date", example="2025-05-27")
     *         )
     *     ),
     * 
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
