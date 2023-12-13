<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function dbActionBasic(Model $objecte, string $accio): JsonResponse
    {
        try {

            $objecte->$accio();

            $missatge = match ($accio) {
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

    protected function autoAssignar(Model $objecte, Response $response)
    {
        $atributs = $objecte->getAttributes();
        foreach ($atributs as $atribut)
        {
        $objecte->setAttribute($atribut, $response->input($atribut));
        }

    }
}
