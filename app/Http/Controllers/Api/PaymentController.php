<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Http\Controllers\Controller;

/**
 * @OA\Tag(
 *     name="Payment",
 *     description="Manajemen data pembayaran"
 * )
 */
class PaymentController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/payment",
     *     tags={"Payment"},
     *     summary="Menampilkan semua pembayaran",
     *     @OA\Response(
     *         response=200,
     *         description="Daftar pembayaran berhasil diambil"
     *     )
     * )
     */
    public function index()
    {
        $payments = Payment::all();

        return response()->json([
            'success' => true,
            'message' => 'Daftar pembayaran berhasil diambil',
            'data' => $payments
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/payment/{id}",
     *     tags={"Payment"},
     *     summary="Menampilkan detail pembayaran",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID pembayaran",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data pembayaran berhasil diambil"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pembayaran tidak ditemukan"
     *     )
     * )
     */
    public function show($id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data pembayaran berhasil diambil',
            'data' => $payment
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/payment",
     *     tags={"Payment"},
     *     summary="Menambahkan pembayaran baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "jumlah", "metode", "status"},
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="jumlah", type="number", format="float", example=50000),
     *             @OA\Property(property="metode", type="string", example="Transfer Bank"),
     *             @OA\Property(property="status", type="string", example="Sukses")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Pembayaran berhasil ditambahkan"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'jumlah' => 'required|numeric|min:0',
            'metode' => 'required|string|max:100',
            'status' => 'required|string|in:Pending,Sukses,Gagal',
        ]);

        $payment = Payment::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil ditambahkan',
            'data' => $payment
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/payment/{id}",
     *     tags={"Payment"},
     *     summary="Memperbarui data pembayaran",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID pembayaran",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="jumlah", type="number", example=75000),
     *             @OA\Property(property="metode", type="string", example="E-Wallet"),
     *             @OA\Property(property="status", type="string", example="Sukses")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data pembayaran berhasil diperbarui"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pembayaran tidak ditemukan"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran tidak ditemukan'
            ], 404);
        }

        $data = $request->validate([
            'jumlah' => 'sometimes|required|numeric|min:0',
            'metode' => 'sometimes|required|string|max:100',
            'status' => 'sometimes|required|string|in:Pending,Sukses,Gagal',
        ]);

        $payment->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data pembayaran berhasil diperbarui',
            'data' => $payment
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/payment/{id}",
     *     tags={"Payment"},
     *     summary="Menghapus pembayaran",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID pembayaran",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pembayaran berhasil dihapus"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pembayaran tidak ditemukan"
     *     )
     * )
     */
    public function destroy($id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran tidak ditemukan'
            ], 404);
        }

        $payment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil dihapus'
        ], 200);
    }
}
