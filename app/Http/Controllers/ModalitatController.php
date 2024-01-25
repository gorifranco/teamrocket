<?php

namespace App\Http\Controllers;

use App\Models\Modalitat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ModalitatController extends Controller
{
    /**
     * Display a paginated listing of the resource.
     *
     * @return JsonResponse
     * @OA\Get(
     *     path="/api/modalitats",
     *     tags={"Modalitats"},
     *     summary="Mostrar les modalitats paginades",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar totes les modalitats de forma paginada.",
     *              @OA\JsonContent(
     *          @OA\Property(property="data",type="object")
     *           ),
     *     ),
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Modalitat::paginate(10)
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @OA\Get(
     *     path="/api/modalitats_tots",
     *     tags={"Modalitats"},
     *     summary="Mostrar les modalitats",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar totes les modalitats.",
     *              @OA\JsonContent(
     *          @OA\Property(property="data",type="object")
     *           ),
     *     ),
     * )
     */
    public function tots(): JsonResponse
    {
        return response()->json([
            'data' => Modalitat::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @OA\Post(
     *    path="/api/modalitats",
     *    tags={"Modalitats"},
     *    summary="Crea una modalitats",
     *    description="Crea una nova modalitat.",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="nom", type="string", format="string", example="pintura"),
     *         ),
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
            'nom' => 'required|unique:modalitats,nom'
        ];
        return $this->dbActionBasic(null, Modalitat::class, $request, "createOrFail", $regles);
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return JsonResponse
     * @OA\get(
     *    path="/api/modalitats/{id}",
     *    tags={"Modalitats"},
     *    summary="Mostrar una modalitat",
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
        return $this->dbActionBasic($id, Modalitat::class, null, "findOrFail", null);
    }

    /**
     * Update the specified resource from storage.
     *
     * @param Request $request
     * @param  string  $id
     * @return JsonResponse
     * @OA\Put(
     *    path="/api/modalitats/{id}",
     *    tags={"Modalitats"},
     *    summary="Modifica una modalitat",
     *    description="Modifica una modalitat. Sols per administradors o gestors",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id Arquitecte", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *          @OA\RequestBody(
     *         @OA\JsonContent(
     *            @OA\Property(property="nom", type="string", format="string", example="fotografia"),
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
            'nom' => "required|unique:modalitats,nom,$id"
        ];
        return $this->dbActionBasic($id, Modalitat::class, $request, "updateOrFail", $regles);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return JsonResponse
     * @OA\Delete(
     *    path="/api/modalitats/{id}",
     *    tags={"Modalitats"},
     *    summary="Esborra una modalitat",
     *    description="Esborra una modalitat. Sols per administradors o gestors",
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
        return $this->dbActionBasic($id, Modalitat::class, null, "deleteOrFail",null);

    }

    /**
     *
     * @param string $str
     * @return JsonResponse
     * @OA\get(
     *    path="/api/modalitats/find/{cerca}",
     *    tags={"Modalitats"},
     *    summary="Mostrar les modalitats que contenguin el filtre de manera paginada",
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
        $data = Modalitat::where('nom', 'LIKE', '%' . $str . '%')
            ->orWhere('id', 'LIKE','%'. $str. '%')
            ->paginate(10);

        return response()->json([
            'data' => $data
        ]);
    }
}
