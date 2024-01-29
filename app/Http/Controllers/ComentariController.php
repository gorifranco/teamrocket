<?php

namespace App\Http\Controllers;

use App\Models\Comentari;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
     *         response=422,
     *         description="Error",
     *         @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="error"),
     *         @OA\Property(property="missatge",type="string", example="Unprocessable Entity")
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

        $validacio = Validator::make($request->all(), $regles);
        if (!$validacio->fails()) {

            $key = explode(' ', $request->header('Authorization'));
            $token = $key[1]; // key[0]->Bearer key[1]→token
            $user = User::where('api_token', $token)->first();

            $obj = Comentari::create($request->all());

            $obj->fk_usuari = $user->id;
            $obj->save();

            return response()->json([
                'data' => $obj
            ], 200);
        } else{

            return response()->json([
                'errors'=> $validacio->errors()->toArray(),
                'missatge' => "Unprocessable Entity",
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return JsonResponse
     * @OA\get(
     *    path="/api/comentaris/{id}",
     *    tags={"Comentaris"},
     *    summary="Mostrar un comentari",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\Parameter(
     *     in="path",
     *     name="id",
     *     required="true"
     *        ),
     *     ),
     *    @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *         @OA\Property(property="data",type="object")
     *          ),
     *       ),
     *    @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *         @OA\Property(property="missatge", type="string", example="Bad Request"),
     *          ),
     *       ),
     *         @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent(
     *          @OA\Property(property="errors", type="object"),
     *          @OA\Property(property="missatge",type="string", example="Unprocessable Entity")
     *           ),
     *        ),
     *              @OA\Response(
     *           response=500,
     *           description="Unprocessable Entity",
     *           @OA\JsonContent(
     *           @OA\Property(property="missatge", type="string"),
     *           @OA\Property(property="codi",type="integer", example="500")
     *            ),
     *         )
     *  )
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
     * Update the specified resource from storage.
     *
     * @param Request $request
     * @param  string  $id
     * @return JsonResponse
     * @OA\Put(
     *    path="/api/comentaris/{id}",
     *    tags={"Comentaris"},
     *    summary="Modifica un comentari",
     *    description="Modifica un comentari",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id Comentari", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *          @OA\RequestBody(
     *         @OA\JsonContent(
     *            @OA\Property(property="valoracio", type="integer", minimum=1, maximum=5 , example="4"),
     *            @OA\Property(property="comentari", type="string", example="Aquest espai és preciós."),
     *  ),
     *      ),
     *       @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *          @OA\Property(property="data",type="object")
     *           ),
     *        ),
     * @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *          @OA\JsonContent(
     *          @OA\Property(property="missatge", type="string", example="Bad Request"),
     *           )
     *        ),
     * @OA\Response(
     *           response=422,
     *           description="Unprocessable Entity",
     *           @OA\JsonContent(
     *           @OA\Property(property="errors", type="object"),
     *           @OA\Property(property="missatge",type="string", example="Unprocessable Entity")
     *            )
     *         ),
     * @OA\Response(
     *            response=500,
     *            description="Internal Server Error",
     *            @OA\JsonContent(
     *            @OA\Property(property="missatge", type="string"),
     *            @OA\Property(property="codi",type="integer", example="500")
     *             ),
     *          )
     * )
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $regles = [
            'valoracio' => "required|integer|min:0|max:5",
            'fk_espai' => "required|integer|min:0",
            'comentari' => "required|string|max:255",
        ];

        return $this->dbActionBasic($id, Comentari::class, $request, "updateOrFail", $regles);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     * @OA\Delete(
     *    path="/api/comentaris/{id}",
     *    tags={"Comentaris"},
     *    summary="Esborra un comentari",
     *    description="Esborra un comentari.",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id Comentari", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *       @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *          @OA\Property(property="data",type="object")
     *           ),
     *        ),
     * @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *          @OA\JsonContent(
     *          @OA\Property(property="missatge", type="string", example="Bad Request"),
     *           )
     *        ),
     * @OA\Response(
     *           response=422,
     *           description="Unprocessable Entity",
     *           @OA\JsonContent(
     *           @OA\Property(property="errors", type="object"),
     *           @OA\Property(property="missatge",type="string", example="Unprocessable Entity")
     *            )
     *         ),
     * @OA\Response(
     *            response=500,
     *            description="Internal Server Error",
     *            @OA\JsonContent(
     *            @OA\Property(property="missatge", type="string"),
     *            @OA\Property(property="codi",type="integer", example="500")
     *             ),
     *          )
     * )
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


    /**
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     * @OA\get(
     *    path="/api/comentaris/validar_invalidar/{id}",
     *    tags={"Comentaris"},
     *    summary="Canvia l'estat del comentari",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\Parameter(
     *     in="path",
     *     name="id",
     *     required="true"
     *        ),
     *     ),
     *    @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *         @OA\Property(property="data",type="object")
     *          ),
     *       ),
     *    @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *         @OA\Property(property="error", type="object"),
     *          ),
     *       ),
     *         @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *          @OA\Property(property="error", type="string"),
     *           ),
     *        )
     *  )
     */
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
                ],401);
            }

            $comentari->validat = !$comentari->validat;
            $comentari->save();
            return response()->json([
                'data' => $comentari
            ],200);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
