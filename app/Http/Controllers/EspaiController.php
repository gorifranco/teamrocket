<?php

namespace App\Http\Controllers;

use App\Models\Espai;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EspaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $espais = Espai::where("activat", 1)->get();
        return response()->json([
            'data' => $espais
        ], 200);
    }

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
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
                'municipi' => 'required|integer|min:0',
                'tipusEspai' => 'required|integer|min:0',
                'modalitats.*' => 'exists:modalitats,id',
                'arquitectes.*' => 'exists:arquitectes,id',
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

            $espai->arquitectes()->sync($request->arquitectes);
            $espai->modalitats()->sync($request->modalitats);

            return response()->json(['status' => 'success','data' => $espai],200);
        } else {
            return response()->json([ 'status' => 'error','data'=>$validacio->errors() ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $espai = Espai::with(['modalitats', 'arquitectes', 'municipi', 'tipusEspai', "puntsInteres"])->find($id);

        return response()->json(['data' => $espai]);
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
        ];

        $espai = Espai::where("id", $id)->first();

        $key = explode(' ', $request->header('Authorization'));
        $token = $key[1]; // key[0]->Bearer key[1]→token
        $user = User::where('api_token', $token)->first();

        if(!$user->esAdministrador() && $user->id !== $espai->fk_gestor){
            return response()->json([
                "user" => $user,
                "espai" => $espai,
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

            $espai->arquitectes()->sync($request->arquitectes);
            $espai->modalitats()->sync($request->modalitats);

            return response()->json(['status' => 'success', 'data' => $espai], 200);
        }else{
            return response()->json([ 'status' => 'error','data'=>$validacio->errors() ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id): JsonResponse
    {
        $key = explode(' ', $request->header('Authorization'));
        $token = $key[1]; // key[0]->Bearer key[1]→token
        $user = User::where('api_token', $token)->first();

        $espai = Espai::where("id", $id)->first();

        if ($user->esAdministrador() || $user->id === $espai->fk_gestor) {
            return $this->dbActionBasic($id, Espai::class, null, "deleteOrFail", null);
        } else {
            return response()->json([
                "status" => "error",
                "missatge" => "No autoritzat"
            ],401);
        }
    }

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
                "state" => "error",
            ],400);
        }
    }
}
