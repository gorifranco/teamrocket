<?php

namespace App\Http\Controllers;

use App\Models\Arquitecte;
use App\Models\Espai;
use App\Models\HoraActiva;
use App\Models\Municipi;
use App\Models\TipusEspai;
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
        $espai = new Espai();

        //Assigna els atributs de l'espai
        $this->autoAssignar($espai, $request, ["destacada"]);

//        $espai->nom = $request->input("nom");
//        $espai->descripcio = $request->input("descripcio");
//        $espai->direccio = $request->input("direccio");
//        $espai->any_construccio = $request->input("any_construccio");
//        $espai->grau_accessibilitat = $request->input("grau_accessibilitat");
//        $espai->web = $request->input("web");
//        $espai->email = $request->input("email");
//        $espai->telefon = $request->input("telefon");
        //destacada default = false

        try {
            //fk_arquitecte si passen NOM
            $espai->fk_arquitecte = Arquitecte::findOrCreate($request->input("arquitecte"))->id;

            //fk_municipi
            $espai->fk_municipi = $request->input("municipi");

            //fk_tipusEspai
            $espai->fk_tipusEspai = $request->input("tipusEspai");

            $espaiJSONResponse = $this->dbActionBasic($espai, "save");

            //Si Hi ha hagut error durant el guardat de l'espai break i retorna el JSON de l'error
            if ($espaiJSONResponse->status() !== 200) return $espaiJSONResponse;

            //modalitats
            $espai->modalitats()->attach($request->input("modalitats"));

            //horesActiva
            $hores = [];
            foreach ($request->input("horesActives") as $horaActiva) {
                $ha = new HoraActiva();

                $ha->dia = $horaActiva->dia;
                $ha->desde = $horaActiva->desde;
                $ha->fins = $horaActiva->fins;

                $ha->saveOrFail();
                $hores[] = $ha;
            }

            $espai->horesActives()->attach($hores);

            //

            //serveis
            $espai->serveis()->attach($request->input("serveis"));

            //datesReforma
            $espai->reformes()->createMany($request->input("datesReforma"));

            return $espaiJSONResponse;

        } catch (QueryException $e) {
            return response()->json([
                'missatge' => $e->getMessage(),
                'codi' => $e->getCode()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'missatge' => $e->getMessage(),
                'codi' => $e->getCode()
            ], 400);
        } catch (\Throwable $e) {
            return response()->json([
                'missatge' => $e->getMessage(),
                'codi' => $e->getCode()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Espai $espai): JsonResponse
    {
        return $this->dbActionBasic($espai, "find");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Espai $espai)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Espai $espai): JsonResponse
    {
        $espai = Espai::find($espai);

        //Assigna tots els atributs del request a l'objecte, atributs amb el mateix nom, Es poden introduïr excepcions
        $this->autoAssignar($espai, $request, ["destacada"]);

//        $espai->nom = $request->input("nom");
//        $espai->descripcio = $request->input("descripcio");
//        $espai->direccio = $request->input("direccio");
//        $espai->any_construccio = $request->input("any_construccio");
//        $espai->grau_accessibilitat = $request->input("grau_accessibilitat");
//        $espai->web = $request->input("web");
//        $espai->email = $request->input("email");
//        $espai->telefon = $request->input("telefon");

        return $this->dbActionBasic($espai, "saveOrFail");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Espai $espai): JsonResponse
    {
        $espai = Espai::find($espai);

        return $this->dbActionBasic($espai, "delete");
    }
}
