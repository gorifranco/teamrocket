<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function dbActionBasic(string|null $id, string $classe, Request|null $request, string $accio, array|null $regles): JsonResponse
    {
        try {
            switch ($accio) {
                case "updateOrFail":
                    {
                        $validacio = Validator::make($request->except(["updated_at", "created_at", "id"]), $regles);
                        if (!$validacio->fails()) {
                            $obj = resolve($classe)::findOrFail($id);
                            $obj::updateOrFail($request->all());
                            return response()->json([
                                'data' => $obj
                            ], 200);
                        }
                    }
                    break;
                case "createOrFail":
                    {
                        $validacio = Validator::make($request->all(), $regles);
                        if (!$validacio->fails()) {
                            $obj = resolve($classe)::create($request->all());
                            return response()->json([
                                'data' => $obj
                            ], 200);
                        }
                    }
                    break;
                case "deleteOrFail":
                    {
                        $obj = resolve($classe)::findOrFail($id);
                        $obj->deleteOrFail();
                        return response()->json([
                            'data' => $obj
                        ], 200);
                    }
                    break;
                case "findOrFail":
                {
                    $obj = resolve($classe)::findOrFail($id);
                    return response()->json([
                        'data' => $obj
                    ], 200);
                }
                default:
                {
                    return response()->json([
                        'missatge' => "action fail"
                    ], 400);
                }
            }
            return response()->json([
                'errors'=> $validacio->errors()->toArray(),
                'missatge' => "action fail",
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                'missatge' => $e->getMessage(),
                'codi' => $e->getCode()
            ], 400);
        }
    }
}
