<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;

/**
 * @OA\Tag(
 *     name="Laporan",
 *     description="API untuk laporan klinik"
 * )
 */
class LaporanController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/laporan",
     *     tags={"Laporan"},
     *     summary="Menampilkan semua data laporan",
     *     @OA\Response(
     *         response=200,
     *         description="Data laporan berhasil diambil"
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Laporan::all());
    }

    /**
     * @OA\Post(
     *     path="/api/laporan",
     *     tags={"Laporan"},
     *     summary="Menyimpan data laporan baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"periode", "jumlah_pasien", "pendapatan"},
     *             @OA\Property(property="periode", type="string", example="Januari 2025"),
     *             @OA\Property(property="jumlah_pasien", type="integer", example=100),
     *             @OA\Property(property="pendapatan", type="number", format="float", example=15000000)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Data laporan berhasil disimpan"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'periode' => 'required|string',
            'jumlah_pasien' => 'required|integer',
            'pendapatan' => 'required|numeric'
        ]);

        $laporan = Laporan::create($request->all());
        return response()->json($laporan, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/laporan/{id}",
     *     tags={"Laporan"},
     *     summary="Menampilkan detail laporan berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID laporan",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail laporan ditemukan"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Laporan tidak ditemukan"
     *     )
     * )
     */
    public function show($id)
    {
        return response()->json(Laporan::findOrFail($id));
    }

    /**
     * @OA\Put(
     *     path="/api/laporan/{id}",
     *     tags={"Laporan"},
     *     summary="Memperbarui data laporan",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID laporan",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="periode", type="string", example="Februari 2025"),
     *             @OA\Property(property="jumlah_pasien", type="integer", example=120),
     *             @OA\Property(property="pendapatan", type="number", format="float", example=17000000)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data laporan berhasil diperbarui"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->update($request->all());
        return response()->json($laporan);
    }

    /**
     * @OA\Delete(
     *     path="/api/laporan/{id}",
     *     tags={"Laporan"},
     *     summary="Menghapus data laporan",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID laporan",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Laporan berhasil dihapus"
     *     )
     * )
     */
    public function destroy($id)
    {
        Laporan::destroy($id);
        return response()->json(null, 204);
    }
}