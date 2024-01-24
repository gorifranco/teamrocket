<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;


class AudioController extends Controller
{

    /**
     * @return JsonResponse
     * @OA\Get(
     *     path="/api/arquitectes_tots",
     *     tags={"Arquitectes"},
     *     summary="Mostrar els arquitectes",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar tots els arquitectes.",
     *              @OA\JsonContent(
     *          @OA\Property(property="data",type="object")
     *           ),
     *     ),
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Audio::all()
        ]);
    }


    /**
     * @param string $id
     * @return JsonResponse
     * @OA\get(
     *    path="/api/audios/{id}",
     *    tags={"Audios"},
     *    summary="Mostrar un audio",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\Parameter(
     *     in="path",
     *     name="id",
     *     required="true"
     *        ),
     *     ),
     *    @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *         @OA\Property(property="data",type="object")
     *          ),
     *       ),
     *    @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *         @OA\Property(property="missatge", type="string", example="Bad Request"),
     *          ),
     *       ),
     *         @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent(
     *          @OA\Property(property="errors", type="object"),
     *          @OA\Property(property="missatge",type="string", example="Unprocessable Entity")
     *           ),
     *        ),
     *              @OA\Response(
     *           response=500,
     *           description="Unprocessable Entity",
     *           @OA\JsonContent(
     *           @OA\Property(property="missatge", type="string"),
     *           @OA\Property(property="codi",type="integer", example="500")
     *            ),
     *         )
     *  )
     */
    public function show(string $id): JsonResponse
    {
        return $this->dbActionBasic($id, Audio::class, null, "fildOrFail", null);
    }


    /**
     * @param Request $request
     * @param  string  $id
     * @return JsonResponse
     * @OA\Put(
     *    path="/api/audios/{id}",
     *    tags={"Audios"},
     *    summary="Modifica un audio",
     *    description="Modifica un audio. Sols per administradors o el gestor del punt d'interes",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id Àudio", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *          @OA\RequestBody(
     *         @OA\JsonContent(
     *            @OA\Property(property="ordre", type="integer", format="integer", example="1"),
     *            @OA\Property(property="transcripcio", type="string", format="string", example="Transcripció d'un àudio"),
     *               ),
     *      ),
     *       @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *          @OA\Property(property="data",type="object")
     *           ),
     *        ),
     * @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *          @OA\JsonContent(
     *          @OA\Property(property="missatge", type="string", example="Bad Request"),
     *           )
     *        ),
     * @OA\Response(
     *           response=422,
     *           description="Unprocessable Entity",
     *           @OA\JsonContent(
     *           @OA\Property(property="errors", type="object"),
     *           @OA\Property(property="missatge",type="string", example="Unprocessable Entity")
     *            )
     *         ),
     * @OA\Response(
     *            response=500,
     *            description="Internal Server Error",
     *            @OA\JsonContent(
     *            @OA\Property(property="missatge", type="string"),
     *            @OA\Property(property="codi",type="integer", example="500")
     *             ),
     *          )
     * )
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $validacio = Validator::make($request->all(),[
            'ordre' =>'integer|min:0',
            'transcripcio' => 'string'
        ]);

        if (!$validacio->fails()) {

            $audio = Audio::find($id);
            $audio->transcripcio=$request->input("transcripcio");
            $audio->ordre = $request->input("ordre");
            $audio->save();

            return response()->json(['data' => $audio],200);

        } else {
            return response()->json(['status' => 'error', 'data' => $validacio->errors()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return JsonResponse
     * @OA\Delete(
     *    path="/api/audios/{id}",
     *    tags={"Àudios"},
     *    summary="Esborra un àudio",
     *    description="Esborra un àudio. Sols per administradors o gestors autors de l'audio",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id Àudio", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *       @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *          @OA\Property(property="status",type="string"),
     *          @OA\Property(property="missatge",type="string"),
     *           ),
     *        ),
     * @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *          @OA\JsonContent(
     *          @OA\Property(property="missatge", type="string", example="Bad Request"),
     *           )
     *        ),
     * @OA\Response(
     *           response=422,
     *           description="Unprocessable Entity",
     *           @OA\JsonContent(
     *           @OA\Property(property="errors", type="object"),
     *           @OA\Property(property="missatge",type="string", example="Unprocessable Entity")
     *            )
     *         ),
     * @OA\Response(
     *            response=500,
     *            description="Internal Server Error",
     *            @OA\JsonContent(
     *            @OA\Property(property="missatge", type="string"),
     *            @OA\Property(property="codi",type="integer", example="500")
     *             ),
     *          )
     * )
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $audio = Audio::findOrFail($id);

            // Eliminar el archivo del servidor
            $filePath = public_path('upload/aud/') . basename($audio->url);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }

            // Eliminar el registro de la base de datos
            $audio->delete();

            return response()->json(['status' => 'success', 'missatge' => 'Audio eliminat amb èxit'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @OA\Post(
     *    path="/api/audios",
     *    tags={"Àudios"},
     *    summary="Crea un àudio",
     *    description="Crea un nou audio a la base de dades i el puja al servidor.",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="ordre", type="integer", format="integer", example="1"),
     *           @OA\Property(property="transcripcio", type="string", format="string", example="Transcripció d'un àudio"),
     *           @OA\Property(property="fk_puntInteres", type="integer", format="integer", example="1"),
     *        ),
     *     ),
     *    @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *         @OA\Property(property="status",type="string")
     *         @OA\Property(property="data",type="object")
     *          ),
     *       ),
     *    @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *         @OA\Property(property="status", type="string", example="error"),
     *         @OA\Property(property="data", type="string", example="Bad Request"),
     *          ),
     *       ),
     *         @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent(
     *          @OA\Property(property="data", type="object"),
     *          @OA\Property(property="status",type="string", example="error")
     *           ),
     *        ),
     *              @OA\Response(
     *           response=500,
     *           description="Unprocessable Entity",
     *           @OA\JsonContent(
     *           @OA\Property(property="data", type="string"),
     *           @OA\Property(property="status",type="string")
     *            ),
     *         )
     *  )
     */
    public function uploadAudio(Request $request): JsonResponse
    {

        $missatges = [
            'required' => 'Atribut audio no rebut',
            'mimes' => 'Es requereix mp3,m4a,flac,mp4,wav,wma',
            'max' => 'Excedit el tamany màxim'
        ];

        $validacio = Validator::make($request->all(), [
            'audio' => 'required|mimes:jpg,jpeg,bmp,png|max:10240',
            'ordre' =>'integer|min:0',
            'transcripcio' => 'string'
        ], $missatges);

        if (!$validacio->fails()) {

            if ($request->hasFile('audio')) {
                $original_filename = $request->file('audio')->getClientOriginalName();
                $original_filename_arr = explode('.', $original_filename);
                $file_ext = end($original_filename_arr);
                $destination_path = base_path('./upload/aud/');
                $audio = 'etv'.$request->input("fk_puntInteres").'_'. time() . '.' . $file_ext;
                if ($request->file('foto')->move($destination_path, $audio)) {
                    $audio=new Audio;
                    $audio->url = URL::to('../').'/upload/aud/' . $audio;
                    $audio->fk_puntInteres=$request->input("fk_puntInteres");
                    $audio->transcripcio=$request->input("transcripcio");
                    $audio->ordre = $request->input("ordre");

                    $audio->save();

                    return response()->json(['status' => 'success','data' => $audio],200);
                } else {
                    return response()->json(['status' => 'error','data'=>'error guardant'],500);
                }
            } else {
                return response()->json(['status' => 'error','data'=>'Bad Request'],400);
            }
        } else {
            return response()->json(['status' => 'error', 'data' => $validacio->errors()], 422);
        }
    }
}
