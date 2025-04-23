<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokter;

/**
 * @OA\Tag(
 *     name="Dokter",
 *     description="Manajemen data dokter"
 * )
 */
class DokterController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/dokter",
     *     tags={"Dokter"},
     *     summary="Menampilkan semua dokter",
     *     @OA\Response(
     *         response=200,
     *         description="Daftar dokter berhasil diambil"
     *     )
     * )
     */
    public function index()
    {
        $dokter = Dokter::with('jadwal', 'konsultasi')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar dokter berhasil diambil',
            'data' => $dokter
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/dokter/{id}",
     *     tags={"Dokter"},
     *     summary="Menampilkan detail dokter",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID dokter",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data dokter berhasil diambil"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Dokter tidak ditemukan"
     *     )
     * )
     */
    public function show($id)
    {
        $dokter = Dokter::with('jadwal', 'konsultasi')->find($id);

        if (!$dokter) {
            return response()->json([
                'success' => false,
                'message' => 'Dokter tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data dokter berhasil diambil',
            'data' => $dokter
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/dokter",
     *     tags={"Dokter"},
     *     summary="Menambahkan dokter baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama", "spesialisasi", "no_telepon", "email"},
     *             @OA\Property(property="nama", type="string"),
     *             @OA\Property(property="spesialisasi", type="string"),
     *             @OA\Property(property="no_telepon", type="string"),
     *             @OA\Property(property="email", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Dokter berhasil ditambahkan"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'spesialisasi' => 'required|string|max:100',
            'no_telepon' => 'required|string|max:20|unique:dokter,no_telepon',
            'email' => 'required|email|max:100|unique:dokter,email',
        ]);

        $dokter = Dokter::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Dokter berhasil ditambahkan',
            'data' => $dokter
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/dokter/{id}",
     *     tags={"Dokter"},
     *     summary="Memperbarui data dokter",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID dokter",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nama", type="string"),
     *             @OA\Property(property="spesialisasi", type="string"),
     *             @OA\Property(property="no_telepon", type="string"),
     *             @OA\Property(property="email", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data dokter berhasil diperbarui"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Dokter tidak ditemukan"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $dokter = Dokter::find($id);
        if (!$dokter) {
            return response()->json(['message' => 'Dokter tidak ditemukan'], 404);
        }

        $data = $request->validate([
            'nama' => 'sometimes|required|string',
            'spesialisasi' => 'sometimes|required|string',
            'no_telepon' => 'sometimes|required|string',
            'email' => 'sometimes|required|email',
        ]);

        $dokter->update($data);

        return response()->json([
            'message' => 'Data dokter berhasil diperbarui',
            'data' => $dokter
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/dokter/{id}",
     *     tags={"Dokter"},
     *     summary="Menghapus dokter",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID dokter",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dokter berhasil dihapus"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Dokter tidak ditemukan"
     *     )
     * )
     */
    public function destroy($id)
    {
        $dokter = Dokter::find($id);

        if (!$dokter) {
            return response()->json([
                'success' => false,
                'message' => 'Dokter tidak ditemukan',
                'data' => null
            ], 404);
        }

        $dokter->delete();

        return response()->json([
            'success' => true,
            'message' => 'Dokter berhasil dihapus'
        ], 200);
    }
}