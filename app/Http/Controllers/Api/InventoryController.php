<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;

/**
 * @OA\Tag(
 *     name="Inventory",
 *     description="Manajemen inventaris obat di rumah sakit"
 * )
 */
class InventoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/inventory",
     *     operationId="getAllInventory",
     *     tags={"Inventory"},
     *     summary="Menampilkan semua data inventaris obat",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan data inventaris"
     *     )
     * )
     */
    public function index()
    {
        $inventory = Inventory::all();
        return response()->json([
            'message' => 'Data inventaris obat',
            'data' => $inventory
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/inventory/{id}",
     *     operationId="getInventoryById",
     *     tags={"Inventory"},
     *     summary="Menampilkan data inventaris berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inventaris ditemukan"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Inventaris tidak ditemukan"
     *     )
     * )
     */
    public function show($id)
    {
        $inventory = Inventory::find($id);
        if (!$inventory) {
            return response()->json(['message' => 'Inventaris tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Detail inventaris obat',
            'data' => $inventory
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/inventory",
     *     operationId="createInventory",
     *     tags={"Inventory"},
     *     summary="Menyimpan data inventaris obat baru",
     *
     *     @OA\Parameter(
     *         name="nama_obat",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="Nama obat"
     *     ),
     *     @OA\Parameter(
     *         name="kategori",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string", enum={"Tablet", "Syrup", "Capsule", "Injection"}),
     *         description="Kategori obat"
     *     ),
     *     @OA\Parameter(
     *         name="stok",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Jumlah stok obat"
     *     ),
     *     @OA\Parameter(
     *         name="harga",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="number", format="float"),
     *         description="Harga obat"
     *     ),
     *     @OA\Parameter(
     *         name="exp_date",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string", format="date"),
     *         description="Tanggal kadaluarsa"
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama_obat","kategori","stok","harga","exp_date"},
     *             @OA\Property(property="nama_obat", type="string", example="Paracetamol"),
     *             @OA\Property(property="kategori", type="string", enum={"Tablet", "Syrup", "Capsule", "Injection"}, example="Tablet"),
     *             @OA\Property(property="stok", type="integer", example=100),
     *             @OA\Property(property="harga", type="number", format="float", example=5000),
     *             @OA\Property(property="exp_date", type="string", format="date", example="2025-12-31")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Data inventaris berhasil disimpan"
     *     )
     * )
     */

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_obat' => 'required|string',
            'kategori' => 'required|in:Tablet,Syrup,Capsule,Injection',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
            'exp_date' => 'required|date',
        ]);

        $inventory = Inventory::create($data);

        return response()->json(['message' => 'Data inventaris berhasil disimpan', 'data' => $inventory], 201);
    }

        /**
     * @OA\Put(
     *     path="/api/inventory/{id}",
     *     operationId="updateInventory",
     *     tags={"Inventory"},
     *     summary="Memperbarui data inventaris obat",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID inventaris",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="nama_obat",
     *         in="query",
     *         required=false,
     *         description="Nama obat",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="kategori",
     *         in="query",
     *         required=false,
     *         description="Kategori obat. Nilai yang tersedia: Tablet, Syrup, Capsule, Injection",
     *         @OA\Schema(type="string", enum={"Tablet", "Syrup", "Capsule", "Injection"})
     *     ),
     *     @OA\Parameter(
     *         name="stok",
     *         in="query",
     *         required=false,
     *         description="Jumlah stok obat",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="harga",
     *         in="query",
     *         required=false,
     *         description="Harga obat",
     *         @OA\Schema(type="number", format="float")
     *     ),
     *     @OA\Parameter(
     *         name="exp_date",
     *         in="query",
     *         required=false,
     *         description="Tanggal kadaluarsa (format: YYYY-MM-DD)",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(response=200, description="Data inventaris berhasil diperbarui"),
     *     @OA\Response(response=404, description="Inventaris tidak ditemukan")
     * )
     */

    public function update(Request $request, $id)
    {
        $inventory = Inventory::find($id);
        if (!$inventory) {
            return response()->json(['message' => 'Inventaris tidak ditemukan'], 404);
        }

        $data = $request->validate([
            'nama_obat' => 'sometimes|string',
            'kategori' => 'sometimes|in:Tablet,Syrup,Capsule,Injection',
            'stok' => 'sometimes|integer',
            'harga' => 'sometimes|numeric',
            'exp_date' => 'sometimes|date',
        ]);

        $inventory->update($data);

        return response()->json(['message' => 'Data inventaris berhasil diperbarui', 'data' => $inventory], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/inventory/{id}",
     *     operationId="deleteInventory",
     *     tags={"Inventory"},
     *     summary="Menghapus data inventaris obat",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Inventaris berhasil dihapus"),
     *     @OA\Response(response=404, description="Inventaris tidak ditemukan")
     * )
     */
    public function destroy($id)
    {
        $inventory = Inventory::find($id);
        if (!$inventory) {
            return response()->json(['message' => 'Inventaris tidak ditemukan'], 404);
        }

        $inventory->delete();
        return response()->json(['message' => 'Inventaris berhasil dihapus'], 204);
    }
}
