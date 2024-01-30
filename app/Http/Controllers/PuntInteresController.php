<?php

namespace App\Http\Controllers;

use App\Models\Imatge;
use App\Models\PuntInteres;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    public function punts_per_espai(string $id): JsonResponse
    {
        $punts = PuntInteres::where("fk_espai", $id)->get();
//            ->with(["espai" => function ($query) {
//            $query->select("id",'nom');
//        }])->get();

        return response()->json([
            "data" => $punts
        ], 200);
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
            'imatge' => 'required|mimes:jpg,jpeg,bmp,png,webp|max:10240',

        ];

        $validacio = Validator::make($request->all(), $regles);
        if (!$validacio->fails()) {

            $key = explode(' ', $request->header('Authorization'));
            $token = $key[1]; // key[0]->Bearer key[1]→token
            $user = User::where('api_token', $token)->first();

            $punt = new PuntInteres();
            $punt->nom = $request->nom;
            $punt->descripcio = $request->descripcio;
            $punt->fk_espai = $request->fk_espai;
            $punt->save();


            if ($request->hasFile('imatge')) {
                $original_filename = $request->file('imatge')->getClientOriginalName();
                $original_filename_arr = explode('.', $original_filename);
                $file_ext = end($original_filename_arr);
                $destination_path = public_path('./upload/img/');
                $image = 'etv' . $punt->id . '_' . time() . '.' . $file_ext;
                if ($request->file('imatge')->move($destination_path, $image)) {
                    $foto = new Imatge;
                    $foto->url = \url('/upload/img/' . $image);
                    $foto->save();
                    $punt->fk_imatge = $foto->id;
                    $punt->save();
                }
            }

            $punt->save();
            return response()->json([
                "data" => $punt
            ]);
        } else {
            return response()->json(['status' => 'error', 'data' => $validacio->errors()], 400);
        }
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
     * @param string $id
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
            'fk_espai' => 'required|integer|min:0',
            'imatge' => 'mimes:jpg,jpeg,bmp,png,webp|max:10240',

        ];

        $key = explode(' ', $request->header('Authorization'));
        $token = $key[1];
        $user = User::where('api_token', $token)->first();

        $id_gestor = $user->id;

        $punt = PuntInteres::find($id);

        if ($id_gestor !== $punt->espai()->fk_gestor) {
            return response()->json([
                "error" => "Unauthorized"
            ]);
        }
        $validacio = Validator::make($request->all(), $regles);
        if (!$validacio->fails()) {

            $punt->nom = $request->nom;
            $punt->descripcio = $request->descripcio;
            $punt->fk_espai = $request->fk_espai;
            $punt->save();

            if ($request->hasFile('imatge')) {

                $old_img = $punt->imatge;
                $url_img = parse_url($old_img->url);
                $file_path = public_path('upload/img/' . basename($url_img['path']));

                if (file_exists($file_path)) {
                    unlink($file_path);
                    $old_img->delete();
                }

                $original_filename = $request->file('imatge')->getClientOriginalName();
                $original_filename_arr = explode('.', $original_filename);
                $file_ext = end($original_filename_arr);
                $destination_path = public_path('./upload/img/');
                $image = 'etv' . $punt->id . '_' . time() . '.' . $file_ext;
                if ($request->file('imatge')->move($destination_path, $image)) {
                    $foto = new Imatge;
                    $foto->url = \url('upload/img/' . $image);
                    $foto->save();
                    $punt->fk_imatge = $foto->id;
                    $punt->save();
                }
            }
            return response()->json(['data' => $punt], 200);
        }
        return response()->json(['status' => 'error', 'data' => $validacio->errors()], 400);

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
        $punt = PuntInteres::find($id);

        if ($id_gestor !== $punt->espai()->gestor_id) {
            return response()->json([
                "error" => "Unauthorized"
            ], 401);
        }

        $old_img = $punt->imatge;
        $url_img = parse_url($old_img->url);
        $file_path = public_path('upload/img/' . basename($url_img['path']));

        if (file_exists($file_path)) {
            unlink($file_path);
            $old_img->delete();
        }

        return $this->dbActionBasic($id, PuntInteres::class, null, "deleteOrFail", null);
    }
}
