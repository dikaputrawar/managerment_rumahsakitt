<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RekamMedis;

class RekamMedisController extends Controller
{
    /**
 * @OA\Get(
 *     path="/api/rekam-medis",
 *     tags={"Rekam Medis"},
 *     summary="Menampilkan semua rekam medis",
 *     @OA\Response(
 *         response=200,
 *         description="Berhasil menampilkan semua rekam medis"
 *     )
 * )
 */
    public function index()
    {
        $rekamMedis = RekamMedis::with('pasien')->get();
        return response()->json([
            'message' => 'Data semua rekam medis',
            'data' => $rekamMedis
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/rekam-medis/{id}",
     *     tags={"Rekam Medis"},
     *     summary="Menampilkan detail rekam medis berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail rekam medis ditemukan"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Rekam medis tidak ditemukan"
     *     )
     * )
     */
    public function show($id)
    {
        $rekamMedis = RekamMedis::with('pasien')->find($id);
        if (!$rekamMedis) {
            return response()->json(['message' => 'Rekam medis tidak ditemukan'], 404);
        }
        return response()->json([
            'message' => 'Detail rekam medis',
            'data' => $rekamMedis
        ], 200);
    }

    /**
 * @OA\Post(
 *     path="/api/rekam-medis",
 *     summary="Membuat data rekam medis baru (via parameter)",
 *     tags={"Rekam Medis"},
 *     @OA\Parameter(
 *         name="pasien_id",
 *         in="query",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID pasien",
 *         example=1
 *     ),
 *     @OA\Parameter(
 *         name="tanggal_kunjungan",
 *         in="query",
 *         required=true,
 *         @OA\Schema(type="string", format="date"),
 *         example="2025-05-21"
 *     ),
 *     @OA\Parameter(
 *         name="diagnosis",
 *         in="query",
 *         required=true,
 *         @OA\Schema(type="string"),
 *         example="Demam"
 *     ),
 *     @OA\Parameter(
 *         name="tindakan",
 *         in="query",
 *         required=false,
 *         @OA\Schema(type="string"),
 *         example="Pemberian obat"
 *     ),
 *     @OA\Parameter(
 *         name="obat",
 *         in="query",
 *         required=false,
 *         @OA\Schema(type="string"),
 *         example="Paracetamol"
 *     ),
 *     @OA\Parameter(
 *         name="catatan",
 *         in="query",
 *         required=false,
 *         @OA\Schema(type="string"),
 *         example="Kontrol 3 hari"
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Rekam medis berhasil dibuat"
 *     )
 * )
 */

    public function store(Request $request)
    {
        $data = $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'tanggal_kunjungan' => 'required|date',
            'diagnosis' => 'required|string',
            'tindakan' => 'required|string',
            'obat' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $rekamMedis = RekamMedis::create($data);

        return response()->json([
            'message' => 'Rekam medis berhasil disimpan',
            'data' => $rekamMedis
        ], 201);
    }

    /**
 * @OA\Put(
 *     path="/api/rekam-medis/{id}",
 *     tags={"Rekam Medis"},
 *     summary="Memperbarui data rekam medis",
 *     @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true, 
 *       @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *       name="pasien_id", 
 *       in="query", 
 *       required=false, 
 *       @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *       name="tanggal_kunjungan", 
 *       in="query", 
 *       required=false, 
 *       @OA\Schema(type="string", format="date")
 *     ),
 *     @OA\Parameter(
 *       name="diagnosis", 
 *       in="query", 
 *       required=false, 
 *       @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *       name="tindakan", 
 *       in="query", 
 *       required=false, 
 *       @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *       name="obat", 
 *       in="query", 
 *       required=false, 
 *       @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *       name="catatan", 
 *       in="query", 
 *       required=false, 
 *       @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *       response=200, 
 *       description="Data rekam medis berhasil diperbarui")
 *     ,
 *     @OA\Response(
 *       response=404, 
 *       description="Rekam medis tidak ditemukan")
 * )
 */

    public function update(Request $request, $id)
    {
        $rekamMedis = RekamMedis::find($id);
        if (!$rekamMedis) {
            return response()->json(['message' => 'Rekam medis tidak ditemukan'], 404);
        }

        $data = $request->validate([
            'pasien_id' => 'sometimes|required|exists:pasien,id',
            'tanggal_kunjungan' => 'sometimes|required|date',
            'diagnosis' => 'sometimes|required|string',
            'tindakan' => 'sometimes|required|string',
            'obat' => 'sometimes|required|string',
            'catatan' => 'nullable|string',
        ]);

        $rekamMedis->update($data);

        return response()->json([
            'message' => 'Rekam medis berhasil diperbarui',
            'data' => $rekamMedis
        ], 200);
    }

    /**
 * @OA\Delete(
 *     path="/api/rekam-medis/{id}",
 *     tags={"Rekam Medis"},
 *     summary="Menghapus data rekam medis",
 *     @OA\Parameter(
 *       name="id", 
 *       in="path", 
 *       required=true, 
 *       @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *       response=200, 
 *       description="Rekam medis berhasil dihapus")
 *     ,
 *     @OA\Response(
 *       response=404, 
 *       description="Rekam medis tidak ditemukan")
 * )
 */

    public function destroy($id)
    {
        $rekamMedis = RekamMedis::find($id);
        if (!$rekamMedis) {
            return response()->json(['message' => 'Rekam medis tidak ditemukan'], 404);
        }

        $rekamMedis->delete();

        return response()->json([
            'message' => 'Rekam medis berhasil dihapus',
            'deleted_id' => $id
        ], 200);
    }
}
