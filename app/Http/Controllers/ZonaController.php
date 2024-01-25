<?php

namespace App\Http\Controllers;

use App\Models\Zona;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ZonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @OA\Get(
     *     path="/api/zones",
     *     tags={"Zones"},
     *     summary="Mostrar totes les zones",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar totes les zones.",
     *              @OA\JsonContent(
     *          @OA\Property(property="data",type="object")
     *           ),
     *     ),
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Zona::all()
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //No es crearan més zones
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param string $id
     * @return JsonResponse
     * @OA\get(
     *    path="/api/zones/{id}",
     *    tags={"Zones"},
     *    summary="Mostrar una zona",
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
        return $this->dbActionBasic($id, ZonaController::class, null, "findOrFail", null);
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
    public function update(Request $request, string $id)
    {
        //No canviaran
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //No es borraran
    }
}
