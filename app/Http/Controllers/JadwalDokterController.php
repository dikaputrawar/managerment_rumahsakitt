<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalDokter;

/**
 * @OA\Tag(
 *     name="Jadwal Dokter",
 *     description="Manajemen data jadwal dokter"
 * )
 */
class JadwalDokterController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/jadwal-dokter",
     *     tags={"Jadwal Dokter"},
     *     summary="Menampilkan semua jadwal dokter",
     *     @OA\Response(
     *         response=200,
     *         description="Daftar jadwal dokter berhasil diambil"
     *     )
     * )
     */
    public function index()
    {
        $jadwal = JadwalDokter::with('dokter')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar jadwal dokter berhasil diambil',
            'data' => $jadwal
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/jadwal-dokter/{id}",
     *     tags={"Jadwal Dokter"},
     *     summary="Menampilkan detail jadwal dokter",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID jadwal dokter",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data jadwal dokter berhasil diambil"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Jadwal tidak ditemukan"
     *     )
     * )
     */
    public function show($id)
    {
        $jadwal = JadwalDokter::with('dokter')->find($id);

        if (!$jadwal) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data jadwal dokter berhasil diambil',
            'data' => $jadwal
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/jadwal-dokter",
     *     tags={"Jadwal Dokter"},
     *     summary="Membuat jadwal dokter baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"dokter_id", "hari", "jam_mulai", "jam_selesai"},
     *             @OA\Property(property="dokter_id", type="integer"),
     *             @OA\Property(property="hari", type="string"),
     *             @OA\Property(property="jam_mulai", type="string", format="time"),
     *             @OA\Property(property="jam_selesai", type="string", format="time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Jadwal dokter berhasil ditambahkan"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'dokter_id' => 'required',
            'hari' => 'required|string',
            'jam_mulai' => 'required|string',
            'jam_selesai' => 'required|string',
        ]);

        $jadwal = JadwalDokter::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Jadwal dokter berhasil ditambahkan',
            'data' => $jadwal
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/jadwal-dokter/{id}",
     *     tags={"Jadwal Dokter"},
     *     summary="Memperbarui jadwal dokter",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID jadwal dokter",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="dokter_id", type="integer"),
     *             @OA\Property(property="hari", type="string"),
     *             @OA\Property(property="jam_mulai", type="string", format="time"),
     *             @OA\Property(property="jam_selesai", type="string", format="time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Jadwal dokter berhasil diperbarui"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Jadwal tidak ditemukan"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $jadwal = JadwalDokter::find($id);

        if (!$jadwal) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ditemukan',
                'data' => null
            ], 404);
        }

        $validated = $request->validate([
            'dokter_id' => 'sometimes|required|exists:dokters,dokter_id',
            'hari' => 'sometimes|required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'sometimes|required|date_format:H:i',
            'jam_selesai' => 'sometimes|required|date_format:H:i|after:jam_mulai',
        ]);

        try {
            $jadwal->update($validated);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui jadwal',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Jadwal dokter berhasil diperbarui',
            'data' => $jadwal
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/jadwal-dokter/{id}",
     *     tags={"Jadwal Dokter"},
     *     summary="Menghapus jadwal dokter",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID jadwal dokter",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Jadwal dokter berhasil dihapus"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Jadwal tidak ditemukan"
     *     )
     * )
     */
    public function destroy($id)
    {
        $jadwal = JadwalDokter::find($id);

        if (!$jadwal) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ditemukan',
                'data' => null
            ], 404);
        }

        $jadwal->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jadwal dokter berhasil dihapus'
        ], 200);
    }
}