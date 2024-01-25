<?php

namespace App\Http\Controllers;

use App\Models\Modalitat;
use App\Models\TipusEspai;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TipusEspaiController extends Controller
{


    public function index(): JsonResponse
    {
        return response()->json([
            'data' => TipusEspai::paginate(10)
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @OA\Get(
     *     path="/api/tipus_espais_tots",
     *     tags={"Tipus d'espais"},
     *     summary="Mostrar els tipus d'espais",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar tots els tipus d'espais.",
     *              @OA\JsonContent(
     *          @OA\Property(property="data",type="object")
     *           ),
     *     ),
     * )
     */
    public function tots(): JsonResponse
    {
        return response()->json([
           'data' => TipusEspai::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @OA\Post(
     *    path="/api/tipus_espais",
     *    tags={"Tipus d'espai"},
     *    summary="Crea un tipus d'espai",
     *    description="Crea un nou tipus d'espai.",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="nom", type="string", format="string", example="Museu"),
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
            'nom' => 'required|unique:tipusespais,nom'
        ];

        return $this->dbActionBasic(null, TipusEspai::class, $request, "createOrFail", $regles);
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return JsonResponse
     * @OA\get(
     *    path="/api/tipus_espais/{id}",
     *    tags={"Tipus d'espai"},
     *    summary="Mostrar un tipus d'espai",
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
            return $this->dbActionBasic($id, TipusEspai::class, null, "findOrFail", null);
    }


    /**
     * Update the specified resource from storage.
     *
     * @param Request $request
     * @param  string  $id
     * @return JsonResponse
     * @OA\Put(
     *    path="/api/tipus_espais/{id}",
     *    tags={"Tipus d'espai"},
     *    summary="Modifica un tipus d'espai",
     *    description="Modifica un tipus d'espai. Sols per administradors o gestors",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id Arquitecte", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *          @OA\RequestBody(
     *         @OA\JsonContent(
     *            @OA\Property(property="nom", type="string", format="string", example="Lluís Domènech i Montaner"),
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
            'nom' => "required|unique:tipusespais,nom$id"
        ];

        return $this->dbActionBasic($id, TipusEspai::class, $request, "updateOrFail", $regles);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return JsonResponse
     * @OA\Delete(
     *    path="/api/tipus_espais/{id}",
     *    tags={"Tipus d'espais"},
     *    summary="Esborra un tipus d'espai",
     *    description="Esborra un tipus d'espai. Sols per administradors o gestors",
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
        return $this->dbActionBasic($id, TipusEspai::class, null, "deleteOrFail", null);
    }

    /**
     *
     * @param string $str
     * @return JsonResponse
     * @OA\get(
     *    path="/api/tipus_espais/find/{cerca}",
     *    tags={"Tipus d'espais"},
     *    summary="Mostrar els tipus d'espai que contenguin el filtre de manera paginada",
     *    security={{"bearerAuth":{}}},
     *        @OA\Parameter(
     *     in="path",
     *     name="cerca",
     *     required=false
     *        ),
     *    @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *         @OA\Property(property="data",type="object")
     *          ),
     *       ),
     *  )
     */
    public function find(string $str): JsonResponse
    {
        $data = TipusEspai::where('nom', 'LIKE', '%' . $str . '%')
            ->orWhere('id', 'LIKE','%'. $str. '%')
            ->paginate(10);

        return response()->json([
            'data' => $data
        ]);
    }

}
