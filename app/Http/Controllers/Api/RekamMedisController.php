<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekamMedis;

/**
 * @OA\Tag(
 *     name="Rekam Medis",
 *     description="Manajemen data rekam medis pasien"
 * )
 */
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
        return response()->json($rekamMedis);
    }

    /**
     * @OA\Get(
     *     path="/api/rekam-medis/{id}",
     *     tags={"Rekam Medis"},
     *     summary="Menampilkan detail rekam medis",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID rekam medis",
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
        return response()->json($rekamMedis);
    }

    /**
     * @OA\Post(
     *     path="/api/rekam-medis",
     *     tags={"Rekam Medis"},
     *     summary="Membuat data rekam medis baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"pasien_id", "tanggal_kunjungan", "diagnosis", "tindakan", "obat"},
     *             @OA\Property(property="pasien_id", type="integer"),
     *             @OA\Property(property="tanggal_kunjungan", type="string", format="date"),
     *             @OA\Property(property="diagnosis", type="string"),
     *             @OA\Property(property="tindakan", type="string"),
     *             @OA\Property(property="obat", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Rekam medis berhasil dibuat"
     *     )
     * )
     */
    public function store(Request $request) 
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,pasien_id',
            'tanggal_kunjungan' => 'required|date',
            'diagnosis' => 'required|string',
            'tindakan' => 'required|string',
            'obat' => 'required|string',
        ]);

        $rekamMedis = RekamMedis::create($request->all());
        return response()->json($rekamMedis, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/rekam-medis/{id}",
     *     tags={"Rekam Medis"},
     *     summary="Memperbarui data rekam medis",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID rekam medis",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="pasien_id", type="integer"),
     *             @OA\Property(property="tanggal_kunjungan", type="string", format="date"),
     *             @OA\Property(property="diagnosis", type="string"),
     *             @OA\Property(property="tindakan", type="string"),
     *             @OA\Property(property="obat", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data rekam medis berhasil diperbarui"
     *     )
     * )
     */
    public function update(Request $request, $id) 
    {
        $rekamMedis = RekamMedis::find($id);
        if (!$rekamMedis) {
            return response()->json(['message' => 'Rekam medis tidak ditemukan'], 404);
        }

        $request->validate([
            'pasien_id' => 'sometimes|required|exists:pasien,pasien_id',
            'tanggal_kunjungan' => 'sometimes|required|date',
            'diagnosis' => 'sometimes|required|string',
            'tindakan' => 'sometimes|required|string',
            'obat' => 'sometimes|required|string',
        ]);

        $rekamMedis->update($request->all());
        return response()->json($rekamMedis);
    }

    /**
     * @OA\Delete(
     *     path="/api/rekam-medis/{id}",
     *     tags={"Rekam Medis"},
     *     summary="Menghapus data rekam medis",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID rekam medis",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Rekam medis berhasil dihapus"
     *     )
     * )
     */
    public function destroy($id) 
    {
        $rekamMedis = RekamMedis::find($id);
        if (!$rekamMedis) {
            return response()->json(['message' => 'Rekam medis tidak ditemukan'], 404);
        }

        $rekamMedis->delete();
        return response()->json(['message' => 'Rekam medis berhasil dihapus']);
    }
}