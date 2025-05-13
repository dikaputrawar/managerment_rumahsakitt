<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Payments",
 *     description="Manajemen data pembayaran"
 * )
 */
class PaymentController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/payments",
     *     operationId="getPayments",
     *     tags={"Payments"},
     *     summary="Menampilkan daftar semua pembayaran",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan daftar pembayaran"
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $payments = Payment::all();
        return response()->json([
            'success' => true,
            'message' => 'Daftar semua pembayaran',
            'data' => $payments
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/payments/{id}",
     *     operationId="getPaymentDetail",
     *     tags={"Payments"},
     *     summary="Menampilkan detail pembayaran berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail pembayaran ditemukan"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pembayaran tidak ditemukan"
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail pembayaran',
            'data' => $payment
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/payments",
     *     operationId="storePayment",
     *     tags={"Payments"},
     *     summary="Menyimpan data pembayaran baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"konsultasi_id", "amount", "payment_date", "method", "status"},
     *             @OA\Property(property="konsultasi_id", type="integer"),
     *             @OA\Property(property="amount", type="number", format="float"),
     *             @OA\Property(property="payment_date", type="string", format="date"),
     *             @OA\Property(property="method", type="string", enum={"Cash", "Credit Card", "Transfer"}),
     *             @OA\Property(property="status", type="string", enum={"Pending", "Paid", "Cancelled"})
     *         )
     *     ),
     *     @OA\Response(response=201, description="Pembayaran berhasil disimpan")
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'konsultasi_id' => 'required|exists:konsultasi,konsultasi_id',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'method' => 'required|in:Cash,Credit Card,Transfer',
            'status' => 'required|in:Pending,Paid,Cancelled',
        ]);

        $payment = Payment::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil disimpan',
            'data' => $payment
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/payments/{id}",
     *     operationId="updatePayment",
     *     tags={"Payments"},
     *     summary="Memperbarui data pembayaran",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Pembayaran berhasil diperbarui")
     * )
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran tidak ditemukan'
            ], 404);
        }

        $data = $request->validate([
            'konsultasi_id' => 'sometimes|exists:konsultasi,konsultasi_id',
            'amount' => 'sometimes|numeric',
            'payment_date' => 'sometimes|date',
            'method' => 'sometimes|in:Cash,Credit Card,Transfer',
            'status' => 'sometimes|in:Pending,Paid,Cancelled',
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
     *     path="/api/payments/{id}",
     *     operationId="deletePayment",
     *     tags={"Payments"},
     *     summary="Menghapus data pembayaran",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Pembayaran berhasil dihapus")
     * )
     */
    public function destroy(int $id): JsonResponse
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
            'message' => 'Pembayaran berhasil dihapus',
            'deleted_id' => $id
        ], 200);
    }
}
