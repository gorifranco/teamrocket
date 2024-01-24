<?php

namespace App\Http\Controllers;

use App\Models\Illa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IllaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @OA\Get(
     *     path="/api/illes",
     *     tags={"Illes"},
     *     summary="Mostrar totes les illes",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar totes les illes.",
     *              @OA\JsonContent(
     *          @OA\Property(property="data",type="object")
     *           ),
     *     ),
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Illa::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //No canvien
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param string $id
     * @return JsonResponse
     * @OA\get(
     *    path="/api/illes/{id}",
     *    tags={"Illes"},
     *    summary="Mostrar una illa",
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
    public function show(String $id): JsonResponse
    {
        return $this->dbActionBasic($id, Illa::class, null, "findOrFail", null);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        //No canvien
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        //No Canvien
    }
}
