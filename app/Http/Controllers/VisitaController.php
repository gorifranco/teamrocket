<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Visita;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VisitaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @OA\Get(
     *     path="/api/visites",
     *     tags={"Visites"},
     *     summary="Mostrar totes les visites.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar totes les visites.",
     *              @OA\JsonContent(
     *          @OA\Property(property="data",type="object")
     *           ),
     *     ),
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Visita::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @OA\Post(
     *    path="/api/visites",
     *    tags={"Visites"},
     *    summary="Crea una visita",
     *    description="Crea una nova visita.",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="nom", type="string", format="string", example="Visita 1"),
     *           @OA\Property(property="descripcio", type="string", format="string", example="Descripcio de la primera visita"),
     *           @OA\Property(property="dataInici", type="date", format="yyyy-mm-dd", example="2024-01-17"),
     *           @OA\Property(property="dataFi", type="date", format="yyyy-mm-dd", example="2024-01-25"),
     *           @OA\Property(property="reqInscripcio", type="boolean", example="true"),
     *           @OA\Property(property="preu", type="double", format="double", example="15.50"),
     *           @OA\Property(property="places", type="integer", format="integer", example="10"),
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
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *          @OA\Property(property="error", type="string", example="Unauthorized"),
     *           ),
     *        ),
     *         @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent(
     *          @OA\Property(property="errors", type="object"),
     *          @OA\Property(property="missatge",type="string", example="Unprocessable Entity")
     *           ),
     *        )
     *  )
     */
    public function store(Request $request): JsonResponse
    {
        $regles = [
            "nom" => 'required',
            "descripcio" => "required",
            "dataInici" => 'date|required',
            'dataFi' => 'date',
            'reqInscripcio' => 'required',
            'places' => 'integer',
            'fk_espai' => 'required'
        ];

        $key = explode(' ', $request->header('Authorization'));
        $token = $key[1];
        $user = User::where('api_token', $token)->first();

        $espai = $user->espais()->where('id', $request->input("fk_espai"))->first();

        if(!$espai){
            return response()->json([
                "error" => "Unauthorized"
            ],401);
        }

        $validacio = Validator::make($request->all(), $regles);

        if (!$validacio->fails()) {
            $obj = Visita::create($request->all());

            $punts = $request->input("puntsInteres");

            foreach ($punts as $i => $puntInteresId) {
                $obj->puntsInteres()->attach([$puntInteresId => ['ordre' => $i+1]]);
            }

            return response()->json([
                'data' => $obj
            ], 200);
        }else{
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
     *    path="/api/visites/{id}",
     *    tags={"Visites"},
     *    summary="Mostrar una visita",
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
        return $this->dbActionBasic($id, Visita::class, null, "findOrFail", null);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @OA\get(
     *    path="/api/visites_per_espai/{id}",
     *    tags={"Visites"},
     *    summary="Mostrar les visites d'un espai",
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
     *  )
     */
    public function visites_per_espai(string $id): JsonResponse
    {
        $visites = Visita::where("fk_espai", $id)->with("puntsInteres")->get();

        return response()->json([
            "data" => $visites,
        ]);
    }

    /**
     * Update the specified resource from storage.
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     * @OA\Put(
     *    path="/api/visites",
     *    tags={"Visites"},
     *    summary="Edita una visita",
     *    description="Modifica una visita. Sols per administradors o gestors",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="nom", type="string", format="string", example="Visita 1"),
     *           @OA\Property(property="descripcio", type="string", format="string", example="Descripcio de la primera visita"),
     *           @OA\Property(property="dataInici", type="date", format="yyyy-mm-dd", example="2024-01-17"),
     *           @OA\Property(property="dataFi", type="date", format="yyyy-mm-dd", example="2024-01-25"),
     *           @OA\Property(property="reqInscripcio", type="boolean", example="true"),
     *           @OA\Property(property="preu", type="double", format="double", example="15.50"),
     *           @OA\Property(property="places", type="integer", format="integer", example="10"),
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
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *          @OA\Property(property="error", type="string", example="Unauthorized"),
     *           ),
     *        ),
     *         @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent(
     *          @OA\Property(property="errors", type="object"),
     *          @OA\Property(property="missatge",type="string", example="Unprocessable Entity")
     *           ),
     *        )
     *  )
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $regles = [
            "nom" => 'required',
            "descripcio" => "required",
            "dataInici" => 'date|required',
            'dataFi' => 'date',
            'reqInscripcio' => 'required',
            'places' => 'integer',
        ];

        if(!$request->input("fk_espai"))
        {
            return response()->json([
                "error" => "fk_espai required",
            ]);
        }

        $key = explode(' ', $request->header('Authorization'));
        $token = $key[1];
        $user = User::where('api_token', $token)->first();

        $visita = Visita::find($id);

        if($visita->espai->fk_gestor !== $user->id){
            return response()->json([
                "error" => "Unauthorized"
            ],401);
        }

        $validacio = Validator::make($request->all(), $regles);

        if (!$validacio->fails()) {
            $visita->nom = $request->input("nom");
            $visita->descripcio = $request->input("descripcio");
            $visita->dataInici = $request->input("dataInici");
            $visita->dataFi = $request->input("dataFi");
            $visita->reqInscripcio = $request->input("reqInscripcio");
            $visita->preu = $request->input("preu");
            $visita->places = $request->input("places");

            $punts = $request->input("puntsInteres");

            $visita->puntsInteres()->detach();

            foreach ($punts as $i => $puntInteresId) {
                $visita->puntsInteres()->syncWithoutDetaching([$puntInteresId => ['ordre' => $i+1]]);
            }

            $visita->save();

            return response()->json([
                'data' => $visita
            ], 200);
        }else{
            return response()->json([
                'errors'=> $validacio->errors()->toArray(),
                'missatge' => "Unprocessable Entity",
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return JsonResponse
     * @OA\Delete(
     *    path="/api/visites/{id}",
     *    tags={"Visites"},
     *    summary="Esborra una visita",
     *    description="Esborra una visita. Sols per administradors o gestors",
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
    public function destroy(string $id): JsonResponse
    {
        return $this->dbActionBasic($id, Visita::class, null, "deleteOrFail",null);
    }
}
