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

    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Audio::all()
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        return $this->dbActionBasic($id, Audio::class, null, "fildOrFail", null);
    }


    /**
     * Update the specified resource in storage.
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

            return response()->json(['status' => 'success', 'message' => 'Audio eliminado correctamente'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }


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
                return response()->json(['status' => 'error','data'=>'fitxer no trobat'],400);
            }
        } else {
            return response()->json(['status' => 'error', 'data' => $validacio->errors()], 422);
        }
    }
}
