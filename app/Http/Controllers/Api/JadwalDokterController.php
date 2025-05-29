<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalDokter;

/**
 * @OA\Tag(
 *     name="JadwalDokter",
 *     description="Manajemen jadwal dokter"
 * )
 */
class JadwalDokterController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/jadwal-dokter",
     *     tags={"JadwalDokter"},
     *     summary="Menampilkan semua jadwal dokter",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan jadwal dokter"
     *     )
     * )
     */
    public function index()
    {
        return response()->json(JadwalDokter::all());
    }

    /**
     * @OA\Get(
     *     path="/api/jadwal-dokter/{id}",
     *     tags={"JadwalDokter"},
     *     summary="Menampilkan detail jadwal dokter berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail jadwal dokter ditemukan"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Jadwal dokter tidak ditemukan"
     *     )
     * )
     */
    public function show($id)
    {
        $data = JadwalDokter::find($id);
        if (!$data) {
            return response()->json(['message' => 'Jadwal dokter tidak ditemukan'], 404);
        }

        return response()->json($data);
    }

    /**
     * @OA\Post(
     *     path="/api/jadwal-dokter",
     *     tags={"JadwalDokter"},
     *     summary="Menyimpan jadwal dokter baru",
     *     @OA\Parameter(
     *         name="dokter_id",
     *         in="query",
     *         required=true,
     *         description="ID dokter",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="poli_id",
     *         in="query",
     *         required=true,
     *         description="ID poli",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="hari",
     *         in="query",
     *         required=true,
     *         description="Hari praktek",
     *         @OA\Schema(type="string", enum={"Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"})
     *     ),
     *     @OA\Parameter(
     *         name="jam_mulai",
     *         in="query",
     *         required=true,
     *         description="Jam mulai praktek (format: H:i:s)",
     *         @OA\Schema(type="string", format="time", example="08:00:00")
     *     ),
     *     @OA\Parameter(
     *         name="jam_selesai",
     *         in="query",
     *         required=true,
     *         description="Jam selesai praktek (format: H:i:s)",
     *         @OA\Schema(type="string", format="time", example="16:00:00")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Jadwal dokter berhasil disimpan"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'dokter_id' => 'required|exists:dokters,id',
            'poli_id' => 'required|exists:polis,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required|date_format:H:i:s',
            'jam_selesai' => 'required|date_format:H:i:s',
        ]);

        $jadwal = JadwalDokter::create($data);

        return response()->json($jadwal, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/jadwal-dokter/{id}",
     *     tags={"JadwalDokter"},
     *     summary="Memperbarui jadwal dokter",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID jadwal dokter",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="dokter_id",
     *         in="query",
     *         required=false,
     *         description="ID dokter",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="poli_id",
     *         in="query",
     *         required=false,
     *         description="ID poli",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="hari",
     *         in="query",
     *         required=false,
     *         description="Hari praktek",
     *         @OA\Schema(type="string", enum={"Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"})
     *     ),
     *     @OA\Parameter(
     *         name="jam_mulai",
     *         in="query",
     *         required=false,
     *         description="Jam mulai praktek (format: H:i:s)",
     *         @OA\Schema(type="string", format="time", example="08:00:00")
     *     ),
     *     @OA\Parameter(
     *         name="jam_selesai",
     *         in="query",
     *         required=false,
     *         description="Jam selesai praktek (format: H:i:s)",
     *         @OA\Schema(type="string", format="time", example="16:00:00")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Jadwal dokter berhasil diperbarui"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $jadwal = JadwalDokter::find($id);
        if (!$jadwal) {
            return response()->json(['message' => 'Jadwal dokter tidak ditemukan'], 404);
        }

        $data = $request->validate([
            'dokter_id' => 'sometimes|exists:dokters,id',
            'poli_id' => 'sometimes|exists:polis,id',
            'hari' => 'sometimes|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'sometimes|date_format:H:i:s',
            'jam_selesai' => 'sometimes|date_format:H:i:s',
        ]);

        $jadwal->update($data);

        return response()->json($jadwal);
    }

    /**
     * @OA\Delete(
     *     path="/api/jadwal-dokter/{id}",
     *     tags={"JadwalDokter"},
     *     summary="Menghapus jadwal dokter",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Jadwal dokter berhasil dihapus"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Jadwal dokter tidak ditemukan"
     *     )
     * )
     */
    public function destroy($id)
    {
        $jadwal = JadwalDokter::find($id);
        if (!$jadwal) {
            return response()->json(['message' => 'Jadwal dokter tidak ditemukan'], 404);
        }

        $jadwal->delete();

        return response()->json(['message' => 'Jadwal dokter berhasil dihapus']);
    }
}