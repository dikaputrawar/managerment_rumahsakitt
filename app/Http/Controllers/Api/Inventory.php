<?php

namespace App\Http\Controllers;

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
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama_obat","kategori","stok","harga","exp_date"},
     *             @OA\Property(property="nama_obat", type="string"),
     *             @OA\Property(property="kategori", type="string", enum={"Tablet", "Syrup", "Capsule", "Injection"}),
     *             @OA\Property(property="stok", type="integer"),
     *             @OA\Property(property="harga", type="number", format="float"),
     *             @OA\Property(property="exp_date", type="string", format="date")
     *         )
     *     ),
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

        return response()->json([
            'message' => 'Data inventaris berhasil disimpan',
            'data' => $inventory
        ], 201);
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
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama_obat","kategori","stok","harga","exp_date"},
     *             @OA\Property(property="nama_obat", type="string"),
     *             @OA\Property(property="kategori", type="string", enum={"Tablet", "Syrup", "Capsule", "Injection"}),
     *             @OA\Property(property="stok", type="integer"),
     *             @OA\Property(property="harga", type="number", format="float"),
     *             @OA\Property(property="exp_date", type="string", format="date")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data inventaris berhasil diperbarui"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Inventaris tidak ditemukan"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $inventory = Inventory::find($id);
        if (!$inventory) {
            return response()->json(['message' => 'Inventaris tidak ditemukan'], 404);
        }

        $data = $request->validate([
            'nama_obat' => 'required|string',
            'kategori' => 'required|in:Tablet,Syrup,Capsule,Injection',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
            'exp_date' => 'required|date',
        ]);

        $inventory->update($data);

        return response()->json([
            'message' => 'Data inventaris berhasil diperbarui',
            'data' => $inventory
        ], 200);
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
     *     @OA\Response(
     *         response=200,
     *         description="Inventaris berhasil dihapus"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Inventaris tidak ditemukan"
     *     )
     * )
     */
    public function destroy($id)
    {
        $inventory = Inventory::find($id);
        if (!$inventory) {
            return response()->json(['message' => 'Inventaris tidak ditemukan'], 404);
        }

        $inventory->delete();

        return response()->json([
            'message' => 'Inventaris berhasil dihapus',
            'deleted_id' => $id
        ], 200);
    }
}
