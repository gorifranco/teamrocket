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
     *
     * @return JsonResponse
     * @OA\Get(
     *     path="/api/comentaris",
     *     tags={"Comentaris"},
     *     summary="Mostrar tots els comentaris",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar tots els comentaris."
     *     ),
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Comentari::all()
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @OA\Post(
     *    path="/api/comentaris",
     *    tags={"Comentaris"},
     *    summary="Crea un comentari",
     *    description="Crea un nou comentari. El comentari es crearà amb el codi d'usuari validat",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *          @OA\Property(property="valoracio", type="integer", format="integer", example="2"),
     *          @OA\Property(property="fk_espai", type="integer", format="integer", example="1"),
     *        ),
     *     ),
     *    @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="success"),
     *         @OA\Property(property="data",type="object")
     *          ),
     *       ),
     *    @OA\Response(
     *         response=400,
     *         description="Error",
     *         @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="error"),
     *         @OA\Property(property="data",type="string", example="Atribut msg requerit")
     *          ),
     *       )
     *  )
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
