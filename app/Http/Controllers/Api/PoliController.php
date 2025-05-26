<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Poli;

/**
 * @OA\Tag(
 *     name="Poli",
 *     description="Manajemen data poli"
 * )
 */
class PoliController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/poli",
     *     tags={"Poli"},
     *     summary="Menampilkan semua data poli",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data poli"
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Poli::all());
    }

        /**
     * @OA\Post(
     *     path="/api/poli",
     *     tags={"Poli"},
     *     summary="Membuat poli baru",
     *     description="Menambahkan data poli baru melalui parameter query",
     *
     *     @OA\Parameter(
     *         name="nama_poli",
     *         in="query",
     *         required=true,
     *         description="Nama poli",
     *         @OA\Schema(type="string", example="Poli Gigi")
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Poli berhasil dibuat",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="nama_poli", type="string", example="Poli Gigi"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Data tidak valid")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_poli' => 'required|string|max:100',
        ]);

        $poli = Poli::create($validated);
        return response()->json($poli, 201);
    }


    /**
     * @OA\Get(
     *     path="/api/poli/{id}",
     *     tags={"Poli"},
     *     summary="Menampilkan detail poli",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Data poli ditemukan"),
     *     @OA\Response(response=404, description="Poli tidak ditemukan")
     * )
     */
    public function show($id)
    {
        $poli = Poli::find($id);

        if (!$poli) {
            return response()->json(['message' => 'Poli tidak ditemukan'], 404);
        }

        return response()->json($poli);
    }

        /**
     * @OA\Put(
     *     path="/api/poli/{id}",
     *     tags={"Poli"},
     *     summary="Memperbarui data poli",
     *     description="Memperbarui nama poli berdasarkan ID",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID poli yang ingin diperbarui",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="nama_poli",
     *         in="query",
     *         required=true,
     *         description="Nama poli baru",
     *         @OA\Schema(type="string", example="Poli Anak")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Data poli berhasil diperbarui",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="nama_poli", type="string", example="Poli Anak"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Poli tidak ditemukan"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $poli = Poli::find($id);

        if (!$poli) {
            return response()->json(['message' => 'Poli tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'nama_poli' => 'required|string|max:100',
        ]);

        $poli->update($validated);
        return response()->json($poli);
    }

    /**
     * @OA\Delete(
     *     path="/api/poli/{id}",
     *     tags={"Poli"},
     *     summary="Menghapus data poli",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Poli berhasil dihapus"),
     *     @OA\Response(response=404, description="Poli tidak ditemukan")
     * )
     */
    public function destroy($id)
    {
        $poli = Poli::find($id);

        if (!$poli) {
            return response()->json(['message' => 'Poli tidak ditemukan'], 404);
        }

        $poli->delete();
        return response()->json(['message' => 'Poli berhasil dihapus']);
    }
}
