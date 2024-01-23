<?php

namespace App\Http\Controllers;

use App\Models\Comentari;
use App\Models\User;
use Exception;
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
            'fk_espai' => ["required", "integer", "min:0"]
        ];

        return $this->dbActionBasic(null, Comentari::class, $request, "createOrFail", $regles);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $c = Comentari::find($id);
        if($c !== null && $c->validat !== false){
            return $this->dbActionBasic($id, Comentari::class, null, "findOrFail", null);
        }else{
            return response()->json([
               "error" => "no autoritzat"
            ]);
        }
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
            'fk_espai' => "required|integer|min:0"
        ];

        return $this->dbActionBasic($id, Comentari::class, $request, "updateOrFail", $regles);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id): JsonResponse
    {
        $c = Comentari::find($id);
        $key = explode(' ', $request->header('Authorization'));
        $token = $key[1]; // key[0]->Bearer key[1]→token
        $user = User::where('api_token', $token)->first();

        if($c === null || !$user->esAdministrador || ($user->esUsuari() && $c->fk_usuari !== $user->id) ||
        $user->esGestor && ($c->espai()->fk_gestor !== $user->id && $c->fk_usuari !== $user->id)){
            return response()->json([
               "error" => "Unauthorized"
            ]);
        }

        return $this->dbActionBasic($id, Comentari::class, null, "deleteOrFail", null);
    }

    public function validar_invalidar(Request $request, string $id): JsonResponse
    {
        $key = explode(' ', $request->header('Authorization'));
        $token = $key[1]; // key[0]->Bearer key[1]→token
        $user = User::where('api_token', $token)->first();

        try {
            $comentari = Comentari::findOrFail($id);
            $espai = $comentari->espai();
            if(!$user->esAdministrador() || ($espai->fk_gestor !== $user->id)){
                return response()->json([
                   "error" => "Unauthorized"
                ]);
            }

            $comentari->validat = !$comentari->validat;
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
