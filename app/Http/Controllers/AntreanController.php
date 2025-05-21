<?php

namespace App\Http\Controllers;

use App\Models\Antrean;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Antrean",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="pasien_id", type="integer"),
 *     @OA\Property(property="nomor_antrean", type="string"),
 *     @OA\Property(property="status", type="string", enum={"menunggu", "dipanggil", "selesai", "batal"}),
 *     @OA\Property(property="tanggal", type="string", format="date"),
 * )
 */
class AntreanController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/antrean",
     *     summary="Get all antrean",
     *     @OA\Response(response=200, description="List antrean")
     * )
     */
    public function index()
    {
        return response()->json(Antrean::all());
    }

    /**
     * @OA\Post(
     *     path="/api/antrean",
     *     summary="Create antrean",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Antrean")
     *     ),
     *     @OA\Response(response=201, description="Antrean created")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'nomor_antrean' => 'required|string',
            'status' => 'required|in:menunggu,dipanggil,selesai,batal',
            'tanggal' => 'required|date'
        ]);

        $antrean = Antrean::create($validated);
        return response()->json($antrean, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/antrean/{id}",
     *     summary="Get antrean by ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Antrean found")
     * )
     */
    public function show($id)
    {
        $antrean = Antrean::findOrFail($id);
        return response()->json($antrean);
    }

    /**
     * @OA\Put(
     *     path="/api/antrean/{id}",
     *     summary="Update antrean",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Antrean")
     *     ),
     *     @OA\Response(response=200, description="Antrean updated")
     * )
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'nomor_antrean' => 'required|string',
            'status' => 'required|in:menunggu,dipanggil,selesai,batal',
            'tanggal' => 'required|date'
        ]);

        $antrean = Antrean::findOrFail($id);
        $antrean->update($validated);
        return response()->json($antrean);
    }

    /**
     * @OA\Delete(
     *     path="/api/antrean/{id}",
     *     summary="Delete antrean",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Antrean deleted")
     * )
     */
    public function destroy($id)
    {
        $antrean = Antrean::findOrFail($id);
        $antrean->delete();
        return response()->json(null, 204);
    }
}
