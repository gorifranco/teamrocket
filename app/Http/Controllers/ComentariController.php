<?php

namespace App\Http\Controllers;

use App\Models\Comentari;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ComentariController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Comentari::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $regles = [
            'valoracio' => ["required", "integer", "min:0", "max:5"],
            'fk_usuari' => ["required", "integer", "min:0"],
            'fk_espai' => ["required", "integer", "min:0"]
        ];

        return $this->dbActionBasic(null, Comentari::class, $request, "createOrFail", $regles);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        return $this->dbActionBasic($id, Comentari::class, null, "findOrFail", null);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $regles = [
            'valoracio' => "required|integer|min:0|max:5",
            'fk_usuari' => "required|integer|min:0",
            'fk_espai' => "required|integer|min:0"
        ];

        return $this->dbActionBasic($id, Comentari::class, $request, "updateOrFail", $regles);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        return $this->dbActionBasic($id, Comentari::class, null, "deleteOrFail", null);
    }

    public function validar(string $id): JsonResponse
    {
        try {
            $comentari = Comentari::findOrFail($id);
            $comentari->validat = true;
            $comentari->save();
            return response()->json([
                'data' => $comentari
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
