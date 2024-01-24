<?php

namespace App\Http\Controllers;

use App\Models\Arquitecte;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ArquitecteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @OA\Get(
     *     path="/api/arquitectes",
     *     tags={"Arquitectes"},
     *     summary="Mostrar els arquitectes paginats",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar tots els arquitectes de forma paginada.",
     *              @OA\JsonContent(
     *          @OA\Property(property="data",type="object")
     *           ),
     *     ),
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Arquitecte::paginate(10)
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @OA\Get(
     *     path="/api/arquitectes_tots",
     *     tags={"Arquitectes"},
     *     summary="Mostrar els arquitectes",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar tots els arquitectes.",
     *              @OA\JsonContent(
     *          @OA\Property(property="data",type="object")
     *           ),
     *     ),
     * )
     */
    public function tots(): JsonResponse
    {
        return response()->json([
            'data' => Arquitecte::all()
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @OA\Post(
     *    path="/api/arquitectes",
     *    tags={"Arquitectes"},
     *    summary="Crea un arquitecte",
     *    description="Crea un nou arquitecte.",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="nom", type="string", format="string", example="Lluís Domènech i Montaner"),
     *           @OA\Property(property="data_naix", type="date", format="yyyy-mm-dd", example="1850-12-21"),
     *           @OA\Property(property="descripcio", type="string", format="string", example="Lluís Domènech i Montaner va ser un destacat arquitecte espanyol del modernisme català, nascut el 1850 i mort el 1923.
     *                                                                                               És conegut per obres emblemàtiques com l'Hospital de Sant Pau i el Palau de la Música Catalana a
     *                                                                                                   Barcelona, que reflecteixen la seva contribució significativa al desenvolupament arquitectònic de la ciutat durant el segle XIX i principis del XX."),
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
     *           description="Internal Server error",
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
            'nom' => "required|unique:arquitectes,nom|max:500",
            'data_naix' => 'date'
        ];

        return $this->dbActionBasic(null, Arquitecte::class, $request, "createOrFail", $regles);

    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return JsonResponse
     * @OA\get(
     *    path="/api/arquitectes/{id}",
     *    tags={"Arquitectes"},
     *    summary="Mostrar un arquitecte",
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
        return $this->dbActionBasic($id, Arquitecte::class, null, "findOrFail", null);
    }


    /**
     *
     * @param string $str
     * @return JsonResponse
     * @OA\get(
     *    path="/api/arquitectes/find/{cerca}",
     *    tags={"Arquitectes"},
     *    summary="Mostrar els arquitectes que contenguin el filtre de manera paginada",
     *    security={{"bearerAuth":{}}},
     *        @OA\Parameter(
     *     in="path",
     *     name="cerca",
     *     required="false"
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
        $data = Arquitecte::where('nom', 'LIKE', '%' . $str . '%')
            ->orWhere('descripcio', 'LIKE', '%' . $str . '%')
            ->orWhere('id', 'LIKE','%'. $str. '%')
            ->orWhere('data_naix', 'LIKE','%'. $str. '%')
            ->paginate(10);

        return response()->json([
            'data' => $data
            ]);
    }

    /**
     * Update the specified resource from storage.
     *
     * @param Request $request
     * @param  string  $id
     * @return JsonResponse
     * @OA\Put(
     *    path="/api/arquitectes/{id}",
     *    tags={"Arquitectes"},
     *    summary="Modifica un arquitecte",
     *    description="Modifica un arquitecte. Sols per administradors o gestors",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id Arquitecte", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *          @OA\RequestBody(
     *         @OA\JsonContent(
     *            @OA\Property(property="nom", type="string", format="string", example="Lluís Domènech i Montaner"),
     *            @OA\Property(property="data_naix", type="date", format="yyyy-mm-dd", example="1850-12-21"),
     *            @OA\Property(property="descripcio", type="string", format="string", example="Lluís Domènech i Montaner va ser un destacat arquitecte espanyol del modernisme català, nascut el 1850 i mort el 1923.
     *                                                                                                És conegut per obres emblemàtiques com l'Hospital de Sant Pau i el Palau de la Música Catalana a
     *                                                                                                    Barcelona, que reflecteixen la seva contribució significativa al desenvolupament arquitectònic de la ciutat durant el segle XIX i principis del XX."),
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
    public function update(Request $request, String $id): JsonResponse
    {
            $regles = [
                'nom' => "required|unique:arquitectes,nom,$id|max:500",
                'data_naix' => 'date'
            ];

            return $this->dbActionBasic($id, Arquitecte::class, $request, "updateOrFail", $regles);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return JsonResponse
     * @OA\Delete(
     *    path="/api/arquitectes/{id}",
     *    tags={"Arquitectes"},
     *    summary="Esborra un arquitecte",
     *    description="Esborra un arquitecte. Sols per administradors o gestors",
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
        return $this->dbActionBasic($id, Arquitecte::class, null, "deleteOrFail", null);
    }
}
