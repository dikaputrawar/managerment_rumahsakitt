<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Pasien;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(
 *     title="Pendaftaran API",
 *     version="1.0.0",
 *     description="API for managing patient registrations",
 *     @OA\Contact(
 *         email="admin@example.com"
 *     )
 * )
 */
class PendaftaranController extends Controller
{
    /**
     * Display a listing of the registrations.
     * 
     * @OA\Get(
     *     path="/api/pendaftarans",
     *     tags={"Pendaftaran"},
     *     summary="Get list of all registrations",
     *     description="Returns list of registrations with pagination",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *            type="object",
     *            @OA\Property(
     *                property="data",
     *                type="array",
     *                @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="pasien_id", type="integer"),
     *                     @OA\Property(property="poli_id", type="integer"),
     *                     @OA\Property(property="status_bpjs", type="string", enum={"Ya", "Tidak"}),
     *                     @OA\Property(property="waktu_daftar", type="string", format="date-time"),
     *                     @OA\Property(
     *                         property="pasien",
     *                         type="object",
     *                         @OA\Property(property="id", type="integer"),
     *                         @OA\Property(property="name", type="string")
     *                     ),
     *                     @OA\Property(
     *                         property="poli",
     *                         type="object",
     *                         @OA\Property(property="id", type="integer"),
     *                         @OA\Property(property="name", type="string")
     *                     )
     *                )
     *            ),
     *            @OA\Property(property="links", type="object"),
     *            @OA\Property(property="meta", type="object")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $pendaftarans = Pendaftaran::with(['pasien', 'poli'])
            ->latest('waktu_daftar')
            ->paginate(10);
            
        if (request()->expectsJson()) {
            return response()->json($pendaftarans);
        }
            
        return view('pendaftarans.index', compact('pendaftarans'));
    }

    /**
     * Show the form for creating a new registration.
     */
    public function create(): View
    {
        $pasiens = Pasien::all();
        $polis = Poli::all();
        
        return view('pendaftarans.create', compact('pasiens', 'polis'));
    }

    /**
     * Store a newly created registration in storage.
     * 
     * @OA\Post(
     *     path="/api/pendaftarans",
     *     tags={"Pendaftaran"},
     *     summary="Create a new registration",
     *     description="Creates a new registration and returns the created data",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"pasien_id", "poli_id", "status_bpjs", "waktu_daftar"},
     *             @OA\Property(property="pasien_id", type="integer", example="1"),
     *             @OA\Property(property="poli_id", type="integer", example="1"),
     *             @OA\Property(property="status_bpjs", type="string", enum={"Ya", "Tidak"}, example="Ya"),
     *             @OA\Property(property="waktu_daftar", type="string", format="date-time", example="2025-05-21 09:00:00")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Registration created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="pasien_id", type="integer"),
     *             @OA\Property(property="poli_id", type="integer"),
     *             @OA\Property(property="status_bpjs", type="string", enum={"Ya", "Tidak"}),
     *             @OA\Property(property="waktu_daftar", type="string", format="date-time"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="pasien_id",
     *                     type="array",
     *                     @OA\Items(type="string", example="The selected pasien id is invalid.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'poli_id' => 'required|exists:polis,id',
            'status_bpjs' => 'required|in:Ya,Tidak',
            'waktu_daftar' => 'required|date',
        ]);

        $pendaftaran = Pendaftaran::create($validated);

        if ($request->expectsJson()) {
            return response()->json($pendaftaran, 201);
        }

        return redirect()->route('pendaftarans.index')
            ->with('success', 'Pendaftaran berhasil ditambahkan!');
    }

    /**
     * Display the specified registration.
     * 
     * @OA\Get(
     *     path="/api/pendaftarans/{id}",
     *     tags={"Pendaftaran"},
     *     summary="Get registration by ID",
     *     description="Returns a single registration with details",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the registration",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="pasien_id", type="integer"),
     *             @OA\Property(property="poli_id", type="integer"),
     *             @OA\Property(property="status_bpjs", type="string", enum={"Ya", "Tidak"}),
     *             @OA\Property(property="waktu_daftar", type="string", format="date-time"),
     *             @OA\Property(
     *                 property="pasien",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string")
     *             ),
     *             @OA\Property(
     *                 property="poli",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Registration not found"
     *     )
     * )
     */
    public function show(Pendaftaran $pendaftaran, Request $request)
    {
        $pendaftaran->load(['pasien', 'poli']);
        
        if ($request->expectsJson()) {
            return response()->json($pendaftaran);
        }
        
        return view('pendaftarans.show', compact('pendaftaran'));
    }

    /**
     * Show the form for editing the specified registration.
     */
    public function edit(Pendaftaran $pendaftaran): View
    {
        $pasiens = Pasien::all();
        $polis = Poli::all();
        
        return view('pendaftarans.edit', compact('pendaftaran', 'pasiens', 'polis'));
    }

    /**
     * Update the specified registration in storage.
     * 
     * @OA\Put(
     *     path="/api/pendaftarans/{id}",
     *     tags={"Pendaftaran"},
     *     summary="Update an existing registration",
     *     description="Updates a registration and returns the updated data",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the registration to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"pasien_id", "poli_id", "status_bpjs", "waktu_daftar"},
     *             @OA\Property(property="pasien_id", type="integer", example="1"),
     *             @OA\Property(property="poli_id", type="integer", example="1"),
     *             @OA\Property(property="status_bpjs", type="string", enum={"Ya", "Tidak"}, example="Ya"),
     *             @OA\Property(property="waktu_daftar", type="string", format="date-time", example="2025-05-21 09:00:00")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Registration updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="pasien_id", type="integer"),
     *             @OA\Property(property="poli_id", type="integer"),
     *             @OA\Property(property="status_bpjs", type="string", enum={"Ya", "Tidak"}),
     *             @OA\Property(property="waktu_daftar", type="string", format="date-time"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Registration not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'poli_id' => 'required|exists:polis,id',
            'status_bpjs' => 'required|in:Ya,Tidak',
            'waktu_daftar' => 'required|date',
        ]);

        $pendaftaran->update($validated);

        if ($request->expectsJson()) {
            return response()->json($pendaftaran);
        }

        return redirect()->route('pendaftarans.index')
            ->with('success', 'Pendaftaran berhasil diperbarui!');
    }

    /**
     * Remove the specified registration from storage.
     * 
     * @OA\Delete(
     *     path="/api/pendaftarans/{id}",
     *     tags={"Pendaftaran"},
     *     summary="Delete a registration",
     *     description="Deletes a registration and returns no content",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the registration to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Registration deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Registration not found"
     *     )
     * )
     */
    public function destroy(Pendaftaran $pendaftaran, Request $request)
    {
        $pendaftaran->delete();

        if ($request->expectsJson()) {
            return response()->json(null, 204);
        }

        return redirect()->route('pendaftarans.index')
            ->with('success', 'Pendaftaran berhasil dihapus!');
    }
}