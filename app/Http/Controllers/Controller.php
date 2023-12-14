<?php

namespace App\Http\Controllers;

use App\Models\Comentari;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function dbActionBasic(Model $objecte, Request $request, string $accio, array $regles): JsonResponse
    {
        try{
            switch ($accio){
                case "updateOrFail":
                {
                    $validacio = Validator::make($request->all(), $regles);
                    if (!$validacio->fails()) {
                        $obj = $objecte::class::findOrFail($objecte);
                        $obj::updateOrFail($request->all());
                        return response()->json([
                            'data' => $obj
                        ],200);
                    }
                }
                break;
                case "createOrFail":{
                    $validacio = Validator::make($request->all(), $regles);
                    if (!$validacio->fails()) {
                        $obj = $objecte::class::findOrFail($objecte);
                        $obj::createOrFail($request->all());
                        return response()->json([
                            'data' => $obj
                        ],200);
                    }
                }
                    break;
                case "deleteOrFail":{
                    $obj = $objecte::class::findOrFail($objecte);
                    $obj::deleteOrFail();
                    return response()->json([
                        'data' => $obj
                    ],200);
                }
                break;
                default: {
                    return response()->json([
                        'missatge' => "action fail"
                    ],400);
                }
            }
            return response()->json([
                'acttion' => $accio,
                'data' => $objecte
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'missatge' => $e->getMessage(),
                'codi' => $e->getCode()
            ], 400);
        }
    }

    /**
     * Assigna tots els atributs del request a l'objecte, atributs amb el mateix nom,
     * Es poden introduïr excepcions
     **/
    protected function autoAssignar(Model $objecte, Request $request, $excepcions): void
    {
        $excep = ["id", "created_at", "updated_at"];

        if (isset($excepcions)) {
            $excep = array_merge($excep, $excepcions);
        }

        $atributs = $objecte->getAttributes();

        foreach ($atributs as $atribut) {
            if (!in_array($atribut, $excep)) $objecte->setAttribute($atribut, $request->input($atribut));
        }
    }
}
