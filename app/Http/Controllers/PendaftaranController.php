<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Pendaftaran")
 */
class PendaftaranController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/pendaftaran",
     *     tags={"Pendaftaran"},
     *     summary="Ambil semua data pendaftaran",
     *     @OA\Response(response=200, description="Sukses")
     * )
     */
    public function index()
    {
        return response()->json(Pendaftaran::all(), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/pendaftaran",
     *     tags={"Pendaftaran"},
     *     summary="Tambah pendaftaran baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"pasien_id", "poli_id", "status_bpjs"},
     *             @OA\Property(property="pasien_id", type="integer"),
     *             @OA\Property(property="poli_id", type="integer"),
     *             @OA\Property(property="status_bpjs", type="string", enum={"Ya", "Tidak"})
     *         )
     *     ),
     *     @OA\Response(response=201, description="Berhasil ditambahkan")
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'poli_id' => 'required|exists:polis,id',
            'status_bpjs' => 'required|in:Ya,Tidak',
        ]);

        $data['waktu_daftar'] = now();

        $pendaftaran = Pendaftaran::create($data);

        return response()->json($pendaftaran, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/pendaftaran/{id}",
     *     tags={"Pendaftaran"},
     *     summary="Ambil detail pendaftaran",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Data ditemukan"),
     *     @OA\Response(response=404, description="Tidak ditemukan")
     * )
     */
    public function show($id)
    {
        $data = Pendaftaran::find($id);
        if (!$data) return response()->json(['message' => 'Tidak ditemukan'], 404);
        return response()->json($data, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/pendaftaran/{id}",
     *     tags={"Pendaftaran"},
     *     summary="Update pendaftaran",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="pasien_id", type="integer"),
     *             @OA\Property(property="poli_id", type="integer"),
     *             @OA\Property(property="status_bpjs", type="string", enum={"Ya", "Tidak"})
     *         )
     *     ),
     *     @OA\Response(response=200, description="Update sukses"),
     *     @OA\Response(response=404, description="Tidak ditemukan")
     * )
     */
    public function update(Request $request, $id)
    {
        $data = Pendaftaran::find($id);
        if (!$data) return response()->json(['message' => 'Tidak ditemukan'], 404);

        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'poli_id' => 'required|exists:polis,id',
            'status_bpjs' => 'required|in:Ya,Tidak',
        ]);

        $data->update($validated);
        return response()->json($data, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/pendaftaran/{id}",
     *     tags={"Pendaftaran"},
     *     summary="Hapus pendaftaran",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Berhasil dihapus"),
     *     @OA\Response(response=404, description="Tidak ditemukan")
     * )
     */
    public function destroy($id)
    {
        $data = Pendaftaran::find($id);
        if (!$data) return response()->json(['message' => 'Tidak ditemukan'], 404);

        $data->delete();
        return response()->json(['message' => 'Berhasil dihapus'], 200);
    }
}
