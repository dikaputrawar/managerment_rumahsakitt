<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengambilanObat;

/**
 * @OA\Tag(
 *     name="PengambilanObat",
 *     description="Manajemen data pengambilan obat"
 * )
 */
class PengambilanObatController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/pengambilan-obat",
     *     tags={"PengambilanObat"},
     *     summary="Menampilkan semua data pengambilan obat",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan data pengambilan obat"
     *     )
     * )
     */
    public function index()
    {
        return response()->json(PengambilanObat::all());
    }

    /**
     * @OA\Get(
     *     path="/api/pengambilan-obat/{id}",
     *     tags={"PengambilanObat"},
     *     summary="Menampilkan detail pengambilan obat berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail pengambilan obat ditemukan"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pengambilan obat tidak ditemukan"
     *     )
     * )
     */
    public function show($id)
    {
        $data = PengambilanObat::find($id);
        if (!$data) {
            return response()->json(['message' => 'Pengambilan obat tidak ditemukan'], 404);
        }

        return response()->json($data);
    }

    /**
     * @OA\Post(
     *     path="/api/pengambilan-obat",
     *     tags={"PengambilanObat"},
     *     summary="Menyimpan data pengambilan obat baru",
     *     @OA\Parameter(
     *         name="resep_id",
     *         in="query",
     *         required=true,
     *         description="ID resep",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="tanggal_pengambilan",
     *         in="query",
     *         required=true,
     *         description="Tanggal pengambilan (format: Y-m-d H:i:s)",
     *         @OA\Schema(type="string", format="date-time", example="2025-05-21T10:00:00")
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         required=true,
     *         description="Status pengambilan",
     *         @OA\Schema(type="string", enum={"Menunggu", "Diambil", "Batal"})
     *     ),
     *     @OA\Parameter(
     *         name="petugas_apotek_id",
     *         in="query",
     *         required=true,
     *         description="ID petugas apotek",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Data pengambilan obat berhasil disimpan"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'resep_id' => 'required|exists:reseps,id',
            'tanggal_pengambilan' => 'required|date_format:Y-m-d\TH:i:s',
            'status' => 'required|in:Menunggu,Diambil,Batal',
            'petugas_apotek_id' => 'required|exists:petugas_apoteks,id',
        ]);

        $pengambilan = PengambilanObat::create($data);

        return response()->json($pengambilan, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/pengambilan-obat/{id}",
     *     tags={"PengambilanObat"},
     *     summary="Memperbarui data pengambilan obat",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID pengambilan obat",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="resep_id",
     *         in="query",
     *         required=false,
     *         description="ID resep",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="tanggal_pengambilan",
     *         in="query",
     *         required=false,
     *         description="Tanggal pengambilan (format: Y-m-d H:i:s)",
     *         @OA\Schema(type="string", format="date-time", example="2025-05-21T10:00:00")
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         required=false,
     *         description="Status pengambilan",
     *         @OA\Schema(type="string", enum={"Menunggu", "Diambil", "Batal"})
     *     ),
     *     @OA\Parameter(
     *         name="petugas_apotek_id",
     *         in="query",
     *         required=false,
     *         description="ID petugas apotek",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data pengambilan obat berhasil diperbarui"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $pengambilan = PengambilanObat::find($id);
        if (!$pengambilan) {
            return response()->json(['message' => 'Pengambilan obat tidak ditemukan'], 404);
        }

        $data = $request->validate([
            'resep_id' => 'sometimes|exists:reseps,id',
            'tanggal_pengambilan' => 'sometimes|date_format:Y-m-d\TH:i:s',
            'status' => 'sometimes|in:Menunggu,Diambil,Batal',
            'petugas_apotek_id' => 'sometimes|exists:petugas_apoteks,id',
        ]);

        $pengambilan->update($data);

        return response()->json($pengambilan);
    }

    /**
     * @OA\Delete(
     *     path="/api/pengambilan-obat/{id}",
     *     tags={"PengambilanObat"},
     *     summary="Menghapus data pengambilan obat",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pengambilan obat berhasil dihapus"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pengambilan obat tidak ditemukan"
     *     )
     * )
     */
    public function destroy($id)
    {
        $pengambilan = PengambilanObat::find($id);
        if (!$pengambilan) {
            return response()->json(['message' => 'Pengambilan obat tidak ditemukan'], 404);
        }

        $pengambilan->delete();

        return response()->json(['message' => 'Pengambilan obat berhasil dihapus']);
    }
}