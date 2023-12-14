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

        $validacio = Validator::make($request->all(), $regles);
        try {
            if (!$validacio->fails()) {
                $comentari = Comentari::createorfail($request->all());
                return response()->json([
                    'data' => $comentari
                ]);
            } else {
                return response()->json([
                    'error' => $validacio->errors()
                ], 400);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comentari $comentari): JsonResponse
    {
        try {
            $com = Comentari::findOrFail($comentari);
            return response()->json([
                'comentari' => $com
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comentari $comentari)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comentari $comentari): JsonResponse
    {
        $regles = [
            'valoracio' => ["required", "integer", "min:0", "max:5"],
            'fk_usuari' => ["required", "integer", "min:0"],
            'fk_espai' => ["required", "integer", "min:0"]
        ];

        return $this->dbActionBasic($comentari, $request, "updateorfail", $regles);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comentari $comentari): JsonResponse
    {
        try {
            $comentari = Comentari::findOrFail($comentari);
            return response()->json([
                'data' => $comentari
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function validar(Comentari $comentari): JsonResponse
    {
        try {
            $comentari = Comentari::findOrFail($comentari);
            $comentari->validat = true;
            $comentari::updateOrFail();
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
