<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftaran;

/**
 * @OA\Tag(
 *     name="Pendaftaran",
 *     description="Manajemen data pendaftaran pasien"
 * )
 */
class PendaftaranController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/pendaftaran",
     *     operationId="getPendaftaran",
     *     tags={"Pendaftaran"},
     *     summary="Menampilkan semua data pendaftaran",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan data pendaftaran"
     *     )
     * )
     */
    public function index()
    {
        $data = Pendaftaran::all();
        return response()->json([
            'message' => 'Data semua pendaftaran',
            'data' => $data
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/pendaftaran/{id}",
     *     operationId="getDetailPendaftaran",
     *     tags={"Pendaftaran"},
     *     summary="Menampilkan detail pendaftaran berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail pendaftaran ditemukan"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pendaftaran tidak ditemukan"
     *     )
     * )
     */
    public function show($id)
    {
        $data = Pendaftaran::find($id);
        if (!$data) {
            return response()->json([
                'message' => 'Pendaftaran tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Detail pendaftaran',
            'data' => $data
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/pendaftaran",
     *     operationId="storePendaftaran",
     *     tags={"Pendaftaran"},
     *     summary="Menyimpan data pendaftaran baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"pasien_id","poli_id","status_bpjs","waktu_daftar"},
     *             @OA\Property(property="pasien_id", type="integer"),
     *             @OA\Property(property="poli_id", type="integer"),
     *             @OA\Property(property="status_bpjs", type="string", enum={"Ya","Tidak"}),
     *             @OA\Property(property="waktu_daftar", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Data pendaftaran berhasil disimpan"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'poli_id' => 'required|exists:polis,id',
            'status_bpjs' => 'required|in:Ya,Tidak',
            'waktu_daftar' => 'required|date_format:Y-m-d\TH:i:sP', // ISO 8601
        ]);

        $pendaftaran = Pendaftaran::create($data);

        return response()->json([
            'message' => 'Data pendaftaran berhasil disimpan',
            'data' => $pendaftaran
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/pendaftaran/{id}",
     *     operationId="updatePendaftaran",
     *     tags={"Pendaftaran"},
     *     summary="Memperbarui data pendaftaran",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"pasien_id","poli_id","status_bpjs","waktu_daftar"},
     *             @OA\Property(property="pasien_id", type="integer"),
     *             @OA\Property(property="poli_id", type="integer"),
     *             @OA\Property(property="status_bpjs", type="string", enum={"Ya","Tidak"}),
     *             @OA\Property(property="waktu_daftar", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data pendaftaran berhasil diperbarui"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pendaftaran tidak ditemukan"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::find($id);
        if (!$pendaftaran) {
            return response()->json([
                'message' => 'Pendaftaran tidak ditemukan'
            ], 404);
        }

        $data = $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'poli_id' => 'required|exists:polis,id',
            'status_bpjs' => 'required|in:Ya,Tidak',
            'waktu_daftar' => 'required|date_format:Y-m-d\TH:i:sP',
        ]);

        $pendaftaran->update($data);

        return response()->json([
            'message' => 'Data pendaftaran berhasil diperbarui',
            'data' => $pendaftaran
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/pendaftaran/{id}",
     *     operationId="deletePendaftaran",
     *     tags={"Pendaftaran"},
     *     summary="Menghapus data pendaftaran",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pendaftaran berhasil dihapus"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pendaftaran tidak ditemukan"
     *     )
     * )
     */
    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::find($id);
        if (!$pendaftaran) {
            return response()->json([
                'message' => 'Pendaftaran tidak ditemukan'
            ], 404);
        }

        $pendaftaran->delete();

        return response()->json([
            'message' => 'Pendaftaran berhasil dihapus',
            'deleted_id' => $id
        ], 200);
    }
}
