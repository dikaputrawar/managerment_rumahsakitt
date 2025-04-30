<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="User",
 *     description="Manajemen data pengguna sistem"
 * )
 */
class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user",
     *     tags={"User"},
     *     summary="Menampilkan semua user",
     *     @OA\Response(response=200, description="Daftar semua user")
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Daftar pengguna',
            'data' => User::all()
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/user/{id}",
     *     tags={"User"},
     *     summary="Menampilkan detail user",
     *     @OA\Parameter(
     *         name="id", in="path", required=true, @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Detail user"),
     *     @OA\Response(response=404, description="User tidak ditemukan")
     * )
     */
    public function show($id): JsonResponse
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail pengguna',
            'data' => $user
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/user",
     *     tags={"User"},
     *     summary="Membuat user baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="Admin"),
     *             @OA\Property(property="email", type="string", format="email", example="admin@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(response=201, description="User berhasil dibuat"),
     *     @OA\Response(response=400, description="Validasi gagal")
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil ditambahkan',
            'data' => $user
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/user/{id}",
     *     tags={"User"},
     *     summary="Memperbarui data user",
     *     @OA\Parameter(
     *         name="id", in="path", required=true, @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="User berhasil diperbarui"),
     *     @OA\Response(response=404, description="User tidak ditemukan")
     * )
     */
    public function update(Request $request, $id): JsonResponse
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:100',
            'email' => 'sometimes|required|email|unique:users,email,' . $id,
            'password' => 'sometimes|required|min:6',
        ]);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil diperbarui',
            'data' => $user
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/user/{id}",
     *     tags={"User"},
     *     summary="Menghapus user",
     *     @OA\Parameter(
     *         name="id", in="path", required=true, @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="User berhasil dihapus"),
     *     @OA\Response(response=404, description="User tidak ditemukan")
     * )
     */
    public function destroy($id): JsonResponse
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil dihapus'
        ]);
    }
}