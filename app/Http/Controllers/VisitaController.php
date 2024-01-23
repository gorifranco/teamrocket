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
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'visites' => Visita::all()
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
            ],401);
        }

        $key = explode(' ', $request->header('Authorization'));
        $token = $key[1];
        $user = User::where('api_token', $token)->first();

        $espai = $user->espais()->where('id', $request->input("fk_espai"))->first();

        if(!$espai){
            return response()->json([
                "error" => "Unauthorized"
            ]);
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
                'missatge' => "action fail",
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        return $this->dbActionBasic($id, Visita::class, null, "findOrFail", null);
    }

    public function visites_per_espai(string $id): JsonResponse
    {
        $visites = Visita::where("fk_espai", $id)->with("puntsInteres")->get();

        return response()->json([
            "data" => $visites,
        ]);
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
                'missatge' => "action fail",
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        return $this->dbActionBasic($id, Visita::class, null, "deleteOrFail",null);
    }
}
