<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function dbActionBasic(Model $objecte, string $accio): JsonResponse
    {
        try {

            $objecte::class->$accio($objecte);

            $missatge = match ($accio) {
                "find" => "espai",
                "save", "update" => 'Guardat amb èxit',
                "delete" => 'Eliminat amb èxit',
                default => 'Èxit',
            };

            return response()->json([
                'missatge' => $missatge,
                'codi' => 0,
                $objecte::class => $objecte
            ], 200);
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
        }
    }

    /**
     * Assigna tots els atributs del request a l'objecte, atributs amb el mateix nom,
     * Es poden introduïr excepcions
    **/
     protected function autoAssignar(Model $objecte, Request $request, $excepcions):void
    {
        $excep = ["id", "created_at", "updated_at"];

        if(isset($excepcions)){
            $excep = array_merge($excep, $excepcions);
        }

        $atributs = $objecte->getAttributes();

        foreach ($atributs as $atribut)
        {
            if(!in_array($atribut, $excep)) $objecte->setAttribute($atribut, $request->input($atribut));
        }
    }
}
