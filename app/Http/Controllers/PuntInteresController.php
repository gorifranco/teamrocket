<?php

namespace App\Http\Controllers;

use App\Models\PuntInteres;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PuntInteresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => PuntInteres::all()
        ]);
    }

    public function punts_per_espai (string $id): JsonResponse
    {
        $punts = PuntInteres::where("fk_espai", $id)
            ->with(["espai" => function ($query) {
            $query->select("id",'nom');
        }])->get();

        return response()->json([
            "data" => $punts
        ],200);
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
            'nom' => 'required',
            'descripcio' => 'required',
        ];

        return $this->dbActionBasic(null, PuntInteres::class, $request, "createOrFail", $regles);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        return response()->json([
            'data' => PuntInteres::find($id)
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
            'nom' => 'required',
            'descripcio' => 'required',
            'fk_espai' => 'required|integer|min:0'
        ];

        $key = explode(' ', $request->header('Authorization'));
        $token = $key[1];
        $user = User::where('api_token', $token)->first();

        $id_gestor = $user->id;

        if($id_gestor !== $request->input("fk_gestor")){
            return response()->json([
                "error" => "Unauthorized"
            ]);
        }

        return $this->dbActionBasic($id, PuntInteres::class, $request, "updateOrFail", $regles);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id): JsonResponse
    {
        $key = explode(' ', $request->header('Authorization'));
        $token = $key[1];
        $user = User::where('api_token', $token)->first();

        $id_gestor = $user->id;

        if($id_gestor !== $request->input("fk_gestor")){
            return response()->json([
                "error" => "Unauthorized"
            ]);
        }

        return $this->dbActionBasic($id, PuntInteres::class, null, "deleteOrFail", null);
    }
}
