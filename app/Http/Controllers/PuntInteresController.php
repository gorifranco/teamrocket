<?php

namespace App\Http\Controllers;

use App\Models\PuntInteres;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PuntInteresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @OA\Get(
     *     path="/api/punts_interes",
     *     tags={"Punts d'interès"},
     *     summary="Mostrar els punts d'interès",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar tots els punts d'interès.",
     *              @OA\JsonContent(
     *          @OA\Property(property="data",type="object")
     *           ),
     *     ),
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => PuntInteres::all()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param string $id
     * @return JsonResponse
     * @OA\Get(
     *     path="/api/punts_per_espai",
     *     tags={"Punts d'interès"},
     *     summary="Mostrar els punts d'interès d'un espai",
     *     security={{"bearerAuth":{}}},
     *          @OA\RequestBody(
     *         required=true,
     *         @OA\Parameter(
     *      in="path",
     *      name="id",
     *      required="true"
     *         ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar tots els punts d'interès d'un espai.",
     *              @OA\JsonContent(
     *          @OA\Property(property="data",type="object")
     *           ),
     *     ),
     * )
     */
    public function punts_per_espai (string $id): JsonResponse
    {
        $punts = PuntInteres::where("fk_espai", $id)->get();
//            ->with(["espai" => function ($query) {
//            $query->select("id",'nom');
//        }])->get();

        return response()->json([
            "data" => $punts
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @OA\Post(
     *    path="/api/punts_interes",
     *    tags={"Punts dinterès"},
     *    summary="Crea un punt d'interès",
     *    description="Crea un nou punt dinterès. Només disponible per a administradors i gestors",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="nom", type="string", format="string", example="Put d'interès 1"),
     *           @OA\Property(property="descripcio", type="string", format="string", example="Descripció del punt d'interès 1"),
     *           @OA\Property(property="fk_espai", type="integer", format="integer", example="1"),
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
     *           description="Server error",
     *           @OA\JsonContent(
     *           @OA\Property(property="missatge", type="string"),
     *           @OA\Property(property="codi",type="integer", example="500")
     *            ),
     *         )
     *  )
     */
    public function store(Request $request): JsonResponse
    {
        $regles = [
            'nom' => 'required',
            'descripcio' => 'required',
        ];

        return $this->dbActionBasic(null, PuntInteres::class, $request, "createOrFail", $regles);

    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return JsonResponse
     * @OA\get(
     *    path="/api/punts_interes/{id}",
     *    tags={"Punts d'interès"},
     *    summary="Mostrar un punt d'interès",
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
     *           description="Internal Server Error",
     *           @OA\JsonContent(
     *           @OA\Property(property="missatge", type="string"),
     *           @OA\Property(property="codi",type="integer", example="500")
     *            ),
     *         )
     *  )
     */
    public function show(string $id): JsonResponse
    {
        return response()->json([
            'data' => PuntInteres::find($id)
        ]);
    }

    /**
     * Update the specified resource from storage.
     *
     * @param Request $request
     * @param  string  $id
     * @return JsonResponse
     * @OA\Put(
     *    path="/api/punts_interes/{id}",
     *    tags={"Punts d'interès"},
     *    summary="Modifica un punt d'interès",
     *    description="Modifica un punt d'interès. Sols per administradors o gestors",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id Arquitecte", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *          @OA\RequestBody(
     *         @OA\JsonContent(
     *            @OA\Property(property="nom", type="string", format="string", example="Punt 1"),
     *            @OA\Property(property="descripcio", type="string", format="string", example="Descripció de l'espai 1"),
     *            @OA\Property(property="fk_espai", type="integer", format="integer", example="1"),
     *      ),
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
            'nom' => 'required',
            'descripcio' => 'required',
            'fk_espai' => 'required|integer|min:0'
        ];

        $key = explode(' ', $request->header('Authorization'));
        $token = $key[1];
        $user = User::where('api_token', $token)->first();

        $id_gestor = $user->id;

        if($id_gestor !== $request->input("fk_gestor")){
            return response()->json([
                "error" => "Unauthorized"
            ]);
        }

        return $this->dbActionBasic($id, PuntInteres::class, $request, "updateOrFail", $regles);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     * @OA\Delete(
     *    path="/api/punts_interes/{id}",
     *    tags={"Punts d'interès"},
     *    summary="Esborra un punt d'interès",
     *    description="Esborra un punt d'interès. Sols per administradors o gestors",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id Arquitecte", required=true,
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
     *      @OA\Response(
     *           response=401,
     *           description="Unauthorized",
     *           @OA\JsonContent(
     *           @OA\Property(property="missatge", type="string", example="Unauthorized"),
     *            )
     *         ),
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
        $key = explode(' ', $request->header('Authorization'));
        $token = $key[1];
        $user = User::where('api_token', $token)->first();

        $id_gestor = $user->id;

        if($id_gestor !== $request->input("fk_gestor")){
            return response()->json([
                "error" => "Unauthorized"
            ],401);
        }

        return $this->dbActionBasic($id, PuntInteres::class, null, "deleteOrFail", null);
    }
}
