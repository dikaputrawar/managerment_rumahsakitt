<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;

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
     *     summary="Menampilkan semua data pembayaran",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan data pembayaran"
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Payment::all());
    }

    /**
     * @OA\Get(
     *     path="/api/payment/{id}",
     *     tags={"Payment"},
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
    public function show($id)
    {
        $data = Payment::find($id);
        if (!$data) {
            return response()->json(['message' => 'Pembayaran tidak ditemukan'], 404);
        }

        return response()->json($data);
    }

    /**
     * @OA\Post(
     *     path="/api/payment",
     *     tags={"Payment"},
     *     summary="Menyimpan data pembayaran baru",
     *     @OA\Parameter(
     *         name="pendaftaran_id",
     *         in="query",
     *         required=true,
     *         description="ID pendaftaran",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="jumlah",
     *         in="query",
     *         required=true,
     *         description="Jumlah pembayaran",
     *         @OA\Schema(type="number", format="float")
     *     ),
     *     @OA\Parameter(
     *         name="metode",
     *         in="query",
     *         required=true,
     *         description="Metode pembayaran",
     *         @OA\Schema(type="string", enum={"Tunai", "Kartu Kredit", "Transfer"})
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         required=true,
     *         description="Status pembayaran",
     *         @OA\Schema(type="string", enum={"Pending", "Lunas", "Gagal"})
     *     ),
     *     @OA\Parameter(
     *         name="tanggal",
     *         in="query",
     *         required=true,
     *         description="Tanggal pembayaran (format: Y-m-d H:i:s)",
     *         @OA\Schema(type="string", format="date-time", example="2025-05-21T10:00:00")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Data pembayaran berhasil disimpan"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'pendaftaran_id' => 'required|exists:pendaftarans,id',
            'jumlah' => 'required|numeric',
            'metode' => 'required|in:Tunai,Kartu Kredit,Transfer',
            'status' => 'required|in:Pending,Lunas,Gagal',
            'tanggal' => 'required|date_format:Y-m-d\TH:i:s',
        ]);

        $payment = Payment::create($data);

        return response()->json($payment, 201);
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
     *     @OA\Parameter(
     *         name="pendaftaran_id",
     *         in="query",
     *         required=false,
     *         description="ID pendaftaran",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="jumlah",
     *         in="query",
     *         required=false,
     *         description="Jumlah pembayaran",
     *         @OA\Schema(type="number", format="float")
     *     ),
     *     @OA\Parameter(
     *         name="metode",
     *         in="query",
     *         required=false,
     *         description="Metode pembayaran",
     *         @OA\Schema(type="string", enum={"Tunai", "Kartu Kredit", "Transfer"})
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         required=false,
     *         description="Status pembayaran",
     *         @OA\Schema(type="string", enum={"Pending", "Lunas", "Gagal"})
     *     ),
     *     @OA\Parameter(
     *         name="tanggal",
     *         in="query",
     *         required=false,
     *         description="Tanggal pembayaran (format: Y-m-d H:i:s)",
     *         @OA\Schema(type="string", format="date-time", example="2025-05-21T10:00:00")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data pembayaran berhasil diperbarui"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $payment = Payment::find($id);
        if (!$payment) {
            return response()->json(['message' => 'Pembayaran tidak ditemukan'], 404);
        }

        $data = $request->validate([
            'pendaftaran_id' => 'sometimes|exists:pendaftarans,id',
            'jumlah' => 'sometimes|numeric',
            'metode' => 'sometimes|in:Tunai,Kartu Kredit,Transfer',
            'status' => 'sometimes|in:Pending,Lunas,Gagal',
            'tanggal' => 'sometimes|date_format:Y-m-d\TH:i:s',
        ]);

        $payment->update($data);

        return response()->json($payment);
    }

    /**
     * @OA\Delete(
     *     path="/api/payment/{id}",
     *     tags={"Payment"},
     *     summary="Menghapus data pembayaran",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
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
            return response()->json(['message' => 'Pembayaran tidak ditemukan'], 404);
        }

        $payment->delete();

        return response()->json(['message' => 'Pembayaran berhasil dihapus']);
    }
}