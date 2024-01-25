<?php

namespace App\Http\Controllers;

use App\Models\Espai;
use App\Models\Imatge;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class EspaiController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @OA\Get(
     *     path="/api/espais",
     *     tags={"Espais"},
     *     summary="Mostrar els espais actius",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar els espais activats.",
     *              @OA\JsonContent(
     *          @OA\Property(property="data",type="object")
     *           ),
     *     ),
     * )
     */
    public function index(): JsonResponse
    {
        $espais = Espai::where("activat", 1)->get();
        return response()->json([
            'data' => $espais
        ], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @OA\Get(
     *     path="/api/espais_per_gestor",
     *     tags={"Espais"},
     *     summary="Mostrar tots els espais d'un gestor paginats",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar els espais d'un gestor paginats.",
     *              @OA\JsonContent(
     *          @OA\Property(property="data",type="object")
     *           ),
     *     ),
     * )
     */
    public function espais_per_gestor(Request $request): JsonResponse
    {
        $key = explode(' ', $request->header('Authorization'));
        $token = $key[1];
        $user = User::where('api_token', $token)->first();

        $id_gestor = $user->id;

        $data = Espai::where("fk_gestor", $id_gestor)->paginate(10);

        return response()->json([
           "data" => $data
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @OA\Get(
     *     path="/api/espais_per_gestor_tots",
     *     tags={"Espais"},
     *     summary="Mostrar tots els espais d'un gestor",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar els espais d'un gestor.",
     *              @OA\JsonContent(
     *          @OA\Property(property="data",type="object")
     *           ),
     *     ),
     * )
     */
    public function espais_per_gestor_tots(Request $request): JsonResponse
    {
        $key = explode(' ', $request->header('Authorization'));
        $token = $key[1];
        $user = User::where('api_token', $token)->first();

        $id_gestor = $user->id;

        $data = Espai::where("fk_gestor", $id_gestor)->get(["id", "nom"]);

        return response()->json([
            "data" => $data
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param string $str
     * @return JsonResponse
     * @OA\Get(
     *     path="/api/espais_per_gestor/find/{cerca}",
     *     tags={"Espais"},
     *     summary="Mostrar tots els espais d'un gestor que compleixin amb un filtre de forma paginada",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar els espais d'un gestor que compleixin amb un filtre de forma paginada.",
     *              @OA\JsonContent(
     *          @OA\Property(property="data",type="object")
     *           ),
     *     ),
     * )
     */
    public function espais_per_gestor_find(request $request, string $str): JsonResponse
    {
        $key = explode(' ', $request->header('Authorization'));
        $token = $key[1];
        $user = User::where('api_token', $token)->first();

        $id_gestor = $user->id;

        $data = Espai::where('fk_gestor', $id_gestor)
            ->where(function ($query) use ($str) {

                $query->where('nom', 'LIKE', '%' . $str . '%')
                    ->orWhere('descripcio', 'LIKE', '%' . $str . '%')
                    ->orWhere('id', 'LIKE', '%' . $str . '%');
            })
            ->paginate(10);

        return response()->json([
            "data" => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @OA\Post(
     *    path="/api/espais",
     *    tags={"Espais"},
     *    summary="Crea un espai",
     *    description="Crea un espai. Sols per administradors o gestors",
     *    security={{"bearerAuth":{}}},
     *          @OA\RequestBody(
     *         @OA\JsonContent(
     *            @OA\Property(property="nom", type="string", format="string", example="L'almudaina"),
     *            @OA\Property(property="descripcio", type="string", format="string", example="Descripció de l'almudaina"),
     *            @OA\Property(property="direccio", type="string", format="string", example="Direcció de l'almudaina"),
     *            @OA\Property(property="any_construccio", type="integer", format="integer", example="1343"),
     *            @OA\Property(property="grau_accessibilitat", type="string", enum={"alt", "mitj", "baix"}, example="mitj"),
     *            @OA\Property(property="web", type="string", format="web", example="https://www.patrimonionacional.es/visita/palacio-real-de-la-almudaina"),
     *            @OA\Property(property="email", type="string", format="mail", example="info@patrimonionacional.es"),
     *            @OA\Property(property="telefon", type="string", format="string", example="info@patrimonionacional.es"),
     *            @OA\Property(property="fk_municipi", type="integer", format="integer", example="1"),
     *            @OA\Property(property="fk_gestor", type="integer", format="integer", example="1"),
     *            @OA\Property(property="fk_tipusEspai", type="integer", format="integer", example="1"),
     *            @OA\Property(property="serveis", type="array", @OA\Items(type="integer"), example="[1,2]"),
     *            @OA\Property(property="modalitats", type="array", @OA\Items(type="integer"), example="[1,2]"),
     *            @OA\Property(property="arquitectes", type="array", @OA\Items(type="integer"), example="[1,2]"),
     *      ),
     *      ),
     *       @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *          @OA\Property(property="data",type="object")
     *           ),
     *        ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *          @OA\JsonContent(
     *          @OA\Property(property="missatge", type="string", example="Bad Request"),
     *          @OA\Property(property="errors", type="object"),
     *           )
     *        ),
     *           @OA\Response(
     *           response=401,
     *           description="Unauthorized",
     *           @OA\JsonContent(
     *           @OA\Property(property="missatge", type="string", example="Unauthorized"),
     *            )
     *         )
     * )
     */
    public function store(Request $request): JsonResponse
    {

            $regles = [
                "nom" => "required|unique:espais,nom",
                "descripcio" => 'required',
                'direccio' => 'required',
                'any_construccio' => 'required|integer',
                'grau_accessibilitat' => 'required|in:baix,mitj,alt',
                'web' => 'url',
                'email' => 'required|email',
                'fk_municipi' => 'required|integer|min:0',
                'fk_tipusEspai' => 'required|integer|min:0',
                'modalitats.*' => 'exists:modalitats,id',
                'arquitectes.*' => 'exists:arquitectes,id',
                'serveis.*' => 'exists:serveis,id',
                'imatge' => 'required|mimes:jpg,jpeg,bmp,png,jfif|max:10240',

            ];

        $validacio = Validator::make($request->all(),$regles);
        If (!$validacio->fails()) {

            $key = explode(' ', $request->header('Authorization'));
                $token = $key[1]; // key[0]->Bearer key[1]→token
            $user = User::where('api_token', $token)->first();

            $espai = new Espai();
            $espai->nom = $request->nom;
            $espai->web = $request->web;
            $espai->telefon = $request->telefon;
            $espai->direccio = $request->direccio;
            $espai->descripcio   = $request->descripcio;
            $espai->fk_tipusEspai = $request->tipusEspai;
            $espai->fk_municipi = $request->municipi;
            $espai->email = $request->email;
            $espai->grau_accessibilitat = $request->grau_accessibilitat;
            $espai->any_construccio = $request->any_construccio;
            $espai->fk_gestor = $user->id;

            $espai->save();

            if ($request->hasFile('imatge')) {
                $original_filename = $request->file('imatge')->getClientOriginalName();
                $original_filename_arr = explode('.', $original_filename);
                $file_ext = end($original_filename_arr);
                $destination_path = public_path('./upload/img/');
                $image = 'etv' . $espai->id . '_' . time() . '.' . $file_ext;
                if ($request->file('imatge')->move($destination_path, $image)) {
                    $foto = new Imatge;
                    $foto->url = \url('/public/upload/img/' . $image);
                    $foto->save();
                    $espai->fk_imatge = $foto->id;
                    $espai->save();
                }
            }

            $espai->arquitectes()->sync($request->arquitectes);
            $espai->modalitats()->sync($request->modalitats);
            $espai->serveis()->sync($request->serveis);

            return response()->json(['status' => 'success','data' => $espai],200);
        } else {
            return response()->json([ 'status' => 'error','data'=>$validacio->errors() ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return JsonResponse
     * @OA\get(
     *    path="/api/espais/{id}",
     *    tags={"Espais"},
     *    summary="Mostrar un espai",
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
    public function show(string $id): JsonResponse
    {
        $espai = Espai::with(['modalitats', 'arquitectes', 'serveis', 'municipi', 'tipusEspai', "puntsInteres"])->find($id);

        return response()->json(['data' => $espai]);
    }

    /**
     * Update the specified resource from storage.
     *
     * @param Request $request
     * @param  string  $id
     * @return JsonResponse
     * @OA\Put(
     *    path="/api/espais/{id}",
     *    tags={"Espais"},
     *    summary="Modifica un espai",
     *    description="Modifica un espai. Sols per administradors o gestors",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id Arquitecte", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *          @OA\RequestBody(
     *         @OA\JsonContent(
     *            @OA\Property(property="nom", type="string", format="string", example="L'almudaina"),
     *            @OA\Property(property="descripcio", type="string", format="string", example="Descripció de l'almudaina"),
     *            @OA\Property(property="direccio", type="string", format="string", example="Direcció de l'almudaina"),
     *            @OA\Property(property="any_construccio", type="integer", format="integer", example="1343"),
     *            @OA\Property(property="grau_accessibilitat", type="string", enum={"alt", "mitj", "baix"}, example="mitj"),
     *            @OA\Property(property="web", type="string", format="web", example="https://www.patrimonionacional.es/visita/palacio-real-de-la-almudaina"),
     *            @OA\Property(property="email", type="string", format="mail", example="info@patrimonionacional.es"),
     *            @OA\Property(property="telefon", type="string", format="string", example="info@patrimonionacional.es"),
     *            @OA\Property(property="fk_municipi", type="integer", format="integer", example="1"),
     *            @OA\Property(property="fk_gestor", type="integer", format="integer", example="1"),
     *            @OA\Property(property="fk_tipusEspai", type="integer", format="integer", example="1"),
     *            @OA\Property(property="serveis", type="array", @OA\Items(type="integer"), example="[1,2]"),
     *            @OA\Property(property="modalitats", type="array", @OA\Items(type="integer"), example="[1,2]"),
     *            @OA\Property(property="arquitectes", type="array", @OA\Items(type="integer"), example="[1,2]"),
     *      ),
     *      ),
     *       @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *          @OA\Property(property="data",type="object")
     *           ),
     *        ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *          @OA\JsonContent(
     *          @OA\Property(property="missatge", type="string", example="Bad Request"),
     *          @OA\Property(property="errors", type="object"),
     *           )
     *        ),
     *           @OA\Response(
     *           response=401,
     *           description="Unauthorized",
     *           @OA\JsonContent(
     *           @OA\Property(property="missatge", type="string", example="Unauthorized"),
     *            )
     *         )
     * )
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $regles = [
            "nom" => "required|unique:espais,nom,$id",
            "descripcio" => 'required',
            'direccio' => 'required',
            'any_construccio' => 'required|integer',
            'grau_accessibilitat' => 'required|in:baix,mitj,alt',
            'web' => 'url',
            'email' => 'required|email',
            'municipi' => 'required|integer|min:0',
            'tipusEspai' => 'required|integer|min:0',
            'modalitats.*' => 'exists:modalitats,id',
            'arquitectes.*' => 'exists:arquitectes,id',
            'serveis.*' => 'exists:serveis,id',
            'imatge' => 'mimes:jpg,jpeg,bmp,png,jfif|max:10240',
        ];

        $espai = Espai::where("id", $id)->first();

        $key = explode(' ', $request->header('Authorization'));
        $token = $key[1]; // key[0]->Bearer key[1]→token
        $user = User::where('api_token', $token)->first();

        if(!$user->esAdministrador() && $user->id !== $espai->fk_gestor){
            return response()->json([
                "error" => "Unauthorized",
            ], 401);
        }

        $validacio = Validator::make($request->all(),$regles);
        If (!$validacio->fails()) {

            $espai->nom = $request->nom;
            $espai->web = $request->web;
            $espai->telefon = $request->telefon;
            $espai->direccio = $request->direccio;
            $espai->descripcio = $request->descripcio;
            $espai->fk_tipusEspai = $request->tipusEspai;
            $espai->fk_municipi = $request->municipi;
            $espai->email = $request->email;
            $espai->grau_accessibilitat = $request->grau_accessibilitat;
            $espai->any_construccio = $request->any_construccio;
            $espai->fk_gestor = $user->id;

            $espai->save();

            if ($request->hasFile('imatge')) {

                $original_filename = $request->file('imatge')->getClientOriginalName();
                $original_filename_arr = explode('.', $original_filename);
                $file_ext = end($original_filename_arr);
                $destination_path = base_path('./upload/img/');
                $image = 'etv' . $espai->id . '_' . time() . '.' . $file_ext;
                if ($request->file('imatge')->move($destination_path, $image)) {
                    $old_img = $espai->imatge();
                    $old_image_path = public_path().$old_img->url;
                    unlink($old_image_path);
                    $old_img->delete();

                    $foto = new Imatge;
                    $foto->url = URL::to('../') . '/upload/img/' . $image;
                    $foto->save();
                    $espai->fk_imatge = $foto->id;
                    $espai->save();
                }
            }

            $espai->arquitectes()->sync($request->arquitectes);
            $espai->modalitats()->sync($request->modalitats);
            $espai->serveis()->sync($request->serveis);

            return response()->json(['data' => $espai], 200);
        }else{
            return response()->json([ 'missatge' => 'Bad Request','errors'=>$validacio->errors()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     * @OA\Delete(
     *    path="/api/espais/{id}",
     *    tags={"Espais"},
     *    summary="Esborra un espai",
     *    description="Esborra un espapi. Sols per administradors o gestors",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id Espai", required=true,
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
     *          ),
     *      @OA\Response(
     *           response=401,
     *           description="Unauthorized",
     *           @OA\JsonContent(
     *           @OA\Property(property="status", type="error", example="error"),
     *           @OA\Property(property="missatge", type="string", example="Unauthorized"),
     *            )
     *         ),
     * )
     */
    public function destroy(Request $request, string $id): JsonResponse
    {
        $key = explode(' ', $request->header('Authorization'));
        $token = $key[1]; // key[0]->Bearer key[1]→token
        $user = User::where('api_token', $token)->first();

        $espai = Espai::where("id", $id)->first();

        if ($user->esAdministrador() || $user->id === $espai->fk_gestor) {

            $old_img = $espai->imatge;
            $url_img = parse_url($old_img->url);
            $file_path = public_path('upload/img/' . basename($url_img['path']));

            if(file_exists($file_path)) {
                unlink($file_path);
                $old_img->delete();
            }

            return $this->dbActionBasic($id, Espai::class, null, "deleteOrFail", null);
        } else {
            return response()->json([
                "status" => "error",
                "missatge" => "Unauthorized"
            ],401);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     * @OA\Get(
     *     path="/api/espais/{id}/activar_desactivar",
     *     tags={"Espais"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar els espais d'un gestor que compleixin amb un filtre de forma paginada.",
     *              @OA\JsonContent(
     *          @OA\Property(property="data",type="object")
     *           ),
     *     ),
     *      @OA\Response(
     *           response=401,
     *           description="Unauthorized",
     *           @OA\JsonContent(
     *           @OA\Property(property="missatge", type="string", example="Bad Request"),
     *            )
     *         ),
     * )
     */
    public function activar_desactivar(Request $request, string $id): JsonResponse
    {
        $key = explode(' ', $request->header('Authorization'));
        $token = $key[1]; // key[0]->Bearer key[1]→token
        $user = User::where('api_token', $token)->first();

        $espai = Espai::where("id", $id)->first();

        if($user->esAdministrador() || $user->id === $espai->fk_gestor){

            $espai->activat = !$espai->activat;
            $espai->save();

            return response()->json([
                "state" => "success",
                "data" => $espai
            ],200);

        }else{
            return response()->json([
                "missatge" => "Unauthorized",
            ],401);
        }
    }
}
