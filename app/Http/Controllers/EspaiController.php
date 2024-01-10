<?php

namespace App\Http\Controllers;

use App\Models\Arquitecte;
use App\Models\Espai;
use App\Models\HoraActiva;
use App\Models\Municipi;
use App\Models\TipusEspai;
use App\Models\Zona;
use Dotenv\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EspaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'espais' => Espai::all()
        ], 200);
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

            return $this->dbActionBasic(null, Espai::class, $request, "createOrFail", $regles);
//
//            //modalitats
//            $espai->modalitats()->attach($request->input("modalitats"));
//
//            //horesActiva
//            $hores = [];
//            foreach ($request->input("horesActives") as $horaActiva) {
//                $ha = new HoraActiva();
//
//                $ha->dia = $horaActiva->dia;
//                $ha->desde = $horaActiva->desde;
//                $ha->fins = $horaActiva->fins;
//
//                $ha->saveOrFail();
//                $hores[] = $ha;
//            }
//
//            $espai->horesActives()->attach($hores);
//
//            //
//
//            //serveis
//            $espai->serveis()->attach($request->input("serveis"));
//
//            //datesReforma
//            $espai->reformes()->createMany($request->input("datesReforma"));
//
//            return $espaiJSONResponse;
//
//        } catch (QueryException $e) {
//            return response()->json([
//                'missatge' => $e->getMessage(),
//                'codi' => $e->getCode()
//            ], 400);
//        } catch (\Exception $e) {
//            return response()->json([
//                'missatge' => $e->getMessage(),
//                'codi' => $e->getCode()
//            ], 400);
//        } catch (\Throwable $e) {
//            return response()->json([
//                'missatge' => $e->getMessage(),
//                'codi' => $e->getCode()
//            ], 400);
//        }
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
