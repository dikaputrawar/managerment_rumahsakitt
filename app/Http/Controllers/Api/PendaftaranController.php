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
        return response()->json(Pendaftaran::all());
    }

    /**
     * @OA\Get(
     *     path="/api/pendaftaran/{id}",
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
            return response()->json(['message' => 'Pendaftaran tidak ditemukan'], 404);
        }

        return response()->json($data);
    }

    /**
     * @OA\Post(
     *     path="/api/pendaftaran",
     *     tags={"Pendaftaran"},
     *     summary="Menyimpan data pendaftaran baru",
     *     @OA\Parameter(
     *         name="pasien_id",
     *         in="query",
     *         required=true,
     *         description="ID pasien",
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
     *         name="status_bpjs",
     *         in="query",
     *         required=true,
     *         description="Status BPJS",
     *         @OA\Schema(type="string", enum={"Ya", "Tidak"})
     *     ),
     *     @OA\Parameter(
     *         name="waktu_daftar",
     *         in="query",
     *         required=true,
     *         description="Waktu daftar (format: Y-m-d H:i:s)",
     *         @OA\Schema(type="string", format="date-time", example="2025-05-21T10:00:00")
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
            'waktu_daftar' => 'required|date_format:Y-m-d\TH:i:s',
        ]);

        $pendaftaran = Pendaftaran::create($data);

        return response()->json($pendaftaran, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/pendaftaran/{id}",
     *     tags={"Pendaftaran"},
     *     summary="Memperbarui data pendaftaran",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID pendaftaran",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="pasien_id",
     *         in="query",
     *         required=false,
     *         description="ID pasien",
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
     *         name="status_bpjs",
     *         in="query",
     *         required=false,
     *         description="Status BPJS",
     *         @OA\Schema(type="string", enum={"Ya", "Tidak"})
     *     ),
     *     @OA\Parameter(
     *         name="waktu_daftar",
     *         in="query",
     *         required=false,
     *         description="Waktu daftar (format: Y-m-d H:i:s)",
     *         @OA\Schema(type="string", format="date-time", example="2025-05-21T10:00:00")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data pendaftaran berhasil diperbarui"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::find($id);
        if (!$pendaftaran) {
            return response()->json(['message' => 'Pendaftaran tidak ditemukan'], 404);
        }

        $data = $request->validate([
            'pasien_id' => 'sometimes|exists:pasiens,id',
            'poli_id' => 'sometimes|exists:polis,id',
            'status_bpjs' => 'sometimes|in:Ya,Tidak',
            'waktu_daftar' => 'sometimes|date_format:Y-m-d\TH:i:s',
        ]);

        $pendaftaran->update($data);

        return response()->json($pendaftaran);
    }

    /**
     * @OA\Delete(
     *     path="/api/pendaftaran/{id}",
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
            return response()->json(['message' => 'Pendaftaran tidak ditemukan'], 404);
        }

        $pendaftaran->delete();

        return response()->json(['message' => 'Pendaftaran berhasil dihapus']);
    }
}
