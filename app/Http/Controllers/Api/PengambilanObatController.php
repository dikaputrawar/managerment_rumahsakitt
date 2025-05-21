<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\PengambilanObat;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Pengambilan Obat",
 *     description="Manajemen data pengambilan obat oleh pasien"
 * )
 */
class PengambilanObatController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/pengambilan-obat",
     *     operationId="getAllPengambilanObat",
     *     tags={"Pengambilan Obat"},
     *     summary="Menampilkan semua data pengambilan obat",
     *     @OA\Response(response=200, description="Berhasil mendapatkan data")
     * )
     */
    public function index(): JsonResponse
    {
        $data = PengambilanObat::all();
        return response()->json([
            'success' => true,
            'message' => 'Daftar pengambilan obat',
            'data' => $data
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/pengambilan-obat/{id}",
     *     operationId="getPengambilanObatById",
     *     tags={"Pengambilan Obat"},
     *     summary="Menampilkan detail pengambilan obat",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Data ditemukan"),
     *     @OA\Response(response=404, description="Data tidak ditemukan")
     * )
     */
    public function show(int $id): JsonResponse
    {
        $data = PengambilanObat::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data pengambilan obat tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail pengambilan obat',
            'data' => $data
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/pengambilan-obat",
     *     operationId="createPengambilanObat",
     *     tags={"Pengambilan Obat"},
     *     summary="Menyimpan data pengambilan obat",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"pasien_id", "inventory_id", "jumlah", "tanggal_ambil", "status"},
     *             @OA\Property(property="pasien_id", type="integer"),
     *             @OA\Property(property="inventory_id", type="integer"),
     *             @OA\Property(property="jumlah", type="integer"),
     *             @OA\Property(property="tanggal_ambil", type="string", format="date"),
     *             @OA\Property(property="status", type="string", enum={"Diambil", "Belum"})
     *         )
     *     ),
     *     @OA\Response(response=201, description="Data berhasil disimpan")
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'inventory_id' => 'required|exists:inventory,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_ambil' => 'required|date',
            'status' => 'required|in:Diambil,Belum',
        ]);

        $obat = PengambilanObat::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Pengambilan obat berhasil disimpan',
            'data' => $obat
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/pengambilan-obat/{id}",
     *     operationId="updatePengambilanObat",
     *     tags={"Pengambilan Obat"},
     *     summary="Memperbarui data pengambilan obat",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="pasien_id", type="integer"),
     *             @OA\Property(property="inventory_id", type="integer"),
     *             @OA\Property(property="jumlah", type="integer"),
     *             @OA\Property(property="tanggal_ambil", type="string", format="date"),
     *             @OA\Property(property="status", type="string", enum={"Diambil", "Belum"})
     *         )
     *     ),
     *     @OA\Response(response=200, description="Data berhasil diperbarui"),
     *     @OA\Response(response=404, description="Data tidak ditemukan")
     * )
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $obat = PengambilanObat::find($id);

        if (!$obat) {
            return response()->json([
                'success' => false,
                'message' => 'Data pengambilan obat tidak ditemukan'
            ], 404);
        }

        $data = $request->validate([
            'pasien_id' => 'sometimes|exists:pasien,id',
            'inventory_id' => 'sometimes|exists:inventory,id',
            'jumlah' => 'sometimes|integer|min:1',
            'tanggal_ambil' => 'sometimes|date',
            'status' => 'sometimes|in:Diambil,Belum',
        ]);

        $obat->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data pengambilan obat berhasil diperbarui',
            'data' => $obat
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/pengambilan-obat/{id}",
     *     operationId="deletePengambilanObat",
     *     tags={"Pengambilan Obat"},
     *     summary="Menghapus data pengambilan obat",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Data berhasil dihapus"),
     *     @OA\Response(response=404, description="Data tidak ditemukan")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $obat = PengambilanObat::find($id);

        if (!$obat) {
            return response()->json([
                'success' => false,
                'message' => 'Data pengambilan obat tidak ditemukan'
            ], 404);
        }

        $obat->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data pengambilan obat berhasil dihapus',
            'deleted_id' => $id
        ], 200);
    }
}