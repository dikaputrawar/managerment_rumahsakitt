<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Konsultasi;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Tag(
 *     name="Konsultasi",
 *     description="Manajemen data konsultasi pasien"
 * )
 */
class KonsultasiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/konsultasi",
     *     tags={"Konsultasi"},
     *     summary="Menampilkan semua data konsultasi",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil semua data konsultasi"
     *     )
     * )
     */
    public function index()
    {
        try {
            $konsultasi = Konsultasi::with(['pasien', 'dokter', 'jadwal'])->get();

            return response()->json([
                'success' => true,
                'message' => 'Data semua konsultasi berhasil diambil',
                'data' => $konsultasi
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error saat mengambil data konsultasi: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data konsultasi'
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/konsultasi/{id}",
     *     tags={"Konsultasi"},
     *     summary="Menampilkan detail konsultasi",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID konsultasi",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Berhasil mengambil detail konsultasi"),
     *     @OA\Response(response=404, description="Konsultasi tidak ditemukan")
     * )
     */
    public function show($id)
    {
        try {
            $konsultasi = Konsultasi::with(['pasien', 'dokter', 'jadwal'])->find($id);
            
            if (!$konsultasi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Konsultasi tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Detail konsultasi berhasil diambil',
                'data' => $konsultasi
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error saat mengambil detail konsultasi: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail konsultasi'
            ], 500);
        }
    }

        /**
     * @OA\Post(
     *     path="/api/konsultasi",
     *     tags={"Konsultasi"},
     *     summary="Menyimpan data konsultasi baru",
     *     @OA\Parameter(
     *         name="pasien_id",
     *         in="query",
     *         required=true,
     *         description="ID pasien",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="dokter_id",
     *         in="query",
     *         required=true,
     *         description="ID dokter",
     *         @OA\Schema(type="integer", example=2)
     *     ),
     *     @OA\Parameter(
     *         name="jadwal_id",
     *         in="query",
     *         required=true,
     *         description="ID jadwal dokter",
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\Parameter(
     *         name="tanggal_konsultasi",
     *         in="query",
     *         required=true,
     *         description="Tanggal konsultasi",
     *         @OA\Schema(type="string", format="date", example="2025-04-30")
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         required=true,
     *         description="Status konsultasi",
     *         @OA\Schema(type="string", enum={"Dijadwalkan", "Selesai", "Dibatalkan"}, example="Dijadwalkan")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"pasien_id", "dokter_id", "jadwal_id", "tanggal_konsultasi", "status"},
     *             @OA\Property(property="pasien_id", type="integer", example=1),
     *             @OA\Property(property="dokter_id", type="integer", example=2),
     *             @OA\Property(property="jadwal_id", type="integer", example=3),
     *             @OA\Property(property="tanggal_konsultasi", type="string", format="date", example="2025-04-30"),
     *             @OA\Property(property="status", type="string", enum={"Dijadwalkan", "Selesai", "Dibatalkan"}, example="Dijadwalkan")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Konsultasi berhasil disimpan"),
     *     @OA\Response(response=500, description="Gagal menyimpan konsultasi")
     * )
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'pasien_id' => 'required|exists:pasiens,id',
                'dokter_id' => 'required|exists:dokters,id',
                'jadwal_id' => 'required|exists:jadwal_dokters,id',
                'tanggal_konsultasi' => 'required|date',
                'status' => 'required|in:Dijadwalkan,Selesai,Dibatalkan',
            ]);

            $konsultasi = Konsultasi::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Konsultasi berhasil disimpan',
                'data' => $konsultasi
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan konsultasi: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan konsultasi'
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/konsultasi/{id}",
     *     tags={"Konsultasi"},
     *     summary="Memperbarui data konsultasi",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID konsultasi yang akan diperbarui",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="pasien_id",
     *         in="query",
     *         required=false,
     *         description="ID pasien",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="dokter_id",
     *         in="query",
     *         required=false,
     *         description="ID dokter",
     *         @OA\Schema(type="integer", example=2)
     *     ),
     *     @OA\Parameter(
     *         name="jadwal_id",
     *         in="query",
     *         required=false,
     *         description="ID jadwal dokter",
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\Parameter(
     *         name="tanggal_konsultasi",
     *         in="query",
     *         required=false,
     *         description="Tanggal konsultasi",
     *         @OA\Schema(type="string", format="date", example="2025-04-30")
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         required=false,
     *         description="Status konsultasi",
     *         @OA\Schema(type="string", enum={"Dijadwalkan", "Selesai", "Dibatalkan"}, example="Selesai")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Konsultasi berhasil diperbarui"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Konsultasi tidak ditemukan"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $konsultasi = Konsultasi::find($id);
            
            if (!$konsultasi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Konsultasi tidak ditemukan'
                ], 404);
            }

            $data = $request->validate([
                'pasien_id' => 'sometimes|required|exists:pasiens,id',
                'dokter_id' => 'sometimes|required|exists:dokters,id',
                'jadwal_id' => 'sometimes|required|exists:jadwal_dokters,id',
                'tanggal_konsultasi' => 'sometimes|required|date',
                'status' => 'sometimes|required|in:Dijadwalkan,Selesai,Dibatalkan',
            ]);

            $konsultasi->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Data konsultasi berhasil diperbarui',
                'data' => $konsultasi
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error saat memperbarui konsultasi: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui konsultasi'
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/konsultasi/{id}",
     *     tags={"Konsultasi"},
     *     summary="Menghapus data konsultasi",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID konsultasi",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Konsultasi berhasil dihapus"),
     *     @OA\Response(response=404, description="Konsultasi tidak ditemukan")
     * )
     */
    public function destroy($id)
    {
        try {
            $konsultasi = Konsultasi::find($id);
            
            if (!$konsultasi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Konsultasi tidak ditemukan'
                ], 404);
            }

            $konsultasi->delete();

            return response()->json([
                'success' => true,
                'message' => 'Konsultasi berhasil dihapus',
                'deleted_id' => $id
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error saat menghapus konsultasi: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus konsultasi'
            ], 500);
        }
    }
}