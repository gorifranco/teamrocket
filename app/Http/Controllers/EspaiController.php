<?php

namespace App\Http\Controllers;

use App\Models\Arquitecte;
use App\Models\Espai;
use App\Models\HoraActiva;
use App\Models\Municipi;
use App\Models\TipusEspai;
use App\Models\User;
use App\Models\Zona;
use Illuminate\Database\QueryException;
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
        return response()->json([
            'data' => Espai::all()
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
//        try {
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
            ];

        $validacio = Validator::make($request->except(["modalitats", "arquitectes"]),$regles);
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

            $espai->arquitectes()->insert($request->arquitectes);
            $espai->modalitats()->insert($request->modalitats);

            $espai->save();

            return response()->json(['status' => 'success','data' => $espai],200);
        } else {
            return response()->json([ 'status' => 'error','data'=>$validacio->errors() ], 400);
        }
//            return $this->dbActionBasic(null, Espai::class, $request, "createOrFail", $regles);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        return $this->dbActionBasic($id, Espai::class, null, "findOrFail", null);
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
            "nom" => "required|unique:espais.nom",
            "descripció" => 'required',
            'direccio' => 'required',
            'any_construccio' => 'required|date',
            'grau_accessibilitat' => 'required|in:baix,mitj,alt',
            'web' => 'url',
            'email' => 'email',
            'fk_arquitecte' => 'integer|min:0',
            'fk_municipi' => 'required|integer|min:0',
            'fk_tipusEspai' => 'required|integer|min:0'
        ];

        $espai = Espai::where("id", $id)->first();
        $usuari = $request->user();

        if(!$usuari->esAdministrador() || $usuari->id !== $espai->gestor()->id()){
            return response()->json([
                "error" => "Unauthorized"
            ], 401);
        }

        return $this->dbActionBasic($id, Espai::class, $request, "updateOrFail", $regles);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        return $this->dbActionBasic($id, Espai::class, null, "deleteOrFail", null);
    }

}
