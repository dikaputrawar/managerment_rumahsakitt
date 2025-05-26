<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Dokter;
use App\Http\Controllers\Controller;

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
     *     @OA\Parameter(
     *         name="nama",
     *         in="query",
     *         required=true,
     *         description="Nama dokter",
     *         @OA\Schema(type="string", maxLength=100)
     *     ),
     *     @OA\Parameter(
     *         name="spesialisasi",
     *         in="query",
     *         required=true,
     *         description="Spesialisasi dokter",
     *         @OA\Schema(type="string", maxLength=100)
     *     ),
     *     @OA\Parameter(
     *         name="no_telepon",
     *         in="query",
     *         required=true,
     *         description="Nomor telepon dokter, harus unik",
     *         @OA\Schema(type="string", maxLength=20)
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         required=true,
     *         description="Email dokter, harus unik",
     *         @OA\Schema(type="string", format="email", maxLength=100)
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Dokter berhasil ditambahkan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Dokter berhasil ditambahkan"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nama", type="string", example="Dr. Budi"),
     *                 @OA\Property(property="spesialisasi", type="string", example="Kardiologi"),
     *                 @OA\Property(property="no_telepon", type="string", example="08123456789"),
     *                 @OA\Property(property="email", type="string", example="budi@example.com")
     *             )
     *         )
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
     *     summary="Memperbarui data dokter melalui query parameter",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID dokter yang akan diperbarui",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="nama",
     *         in="query",
     *         required=false,
     *         description="Nama dokter",
     *         @OA\Schema(type="string", example="Dr. Budi")
     *     ),
     *     @OA\Parameter(
     *         name="spesialisasi",
     *         in="query",
     *         required=false,
     *         description="Spesialisasi dokter",
     *         @OA\Schema(type="string", example="Kardiologi")
     *     ),
     *     @OA\Parameter(
     *         name="no_telepon",
     *         in="query",
     *         required=false,
     *         description="Nomor telepon dokter",
     *         @OA\Schema(type="string", example="08123456789")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         required=false,
     *         description="Email dokter",
     *         @OA\Schema(type="string", format="email", example="budi@example.com")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Data dokter berhasil diperbarui",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Data dokter berhasil diperbarui"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nama", type="string", example="Dr. Budi"),
     *                 @OA\Property(property="spesialisasi", type="string", example="Kardiologi"),
     *                 @OA\Property(property="no_telepon", type="string", example="08123456789"),
     *                 @OA\Property(property="email", type="string", example="budi@example.com")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Dokter tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Dokter tidak ditemukan")
     *         )
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