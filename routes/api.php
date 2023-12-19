<?php

use App\Http\Controllers\ArquitecteController;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComentariController;
use App\Http\Controllers\DataReformaController;
use App\Http\Controllers\EspaiController;
use App\Http\Controllers\HoraActivaController;
use App\Http\Controllers\IllaController;
use App\Http\Controllers\ImatgeController;
use App\Http\Controllers\ModalitatController;
use App\Http\Controllers\MunicipiController;
use App\Http\Controllers\PuntInteresController;
use App\Http\Controllers\ServeiController;
use App\Http\Controllers\TipusEspaiController;
use App\Http\Controllers\VisitaController;
use App\Http\Controllers\ZonaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);

Route::apiResource('arquitectes', ArquitecteController::class)->only(['index', 'show']);
Route::apiResource('comentaris', ComentariController::class)->only(['index', 'show']);
Route::apiResource('espais', EspaiController::class)->only(['index', 'show']);
Route::apiResource('hores-actives', HoraActivaController::class)->only(['index', 'show']);
Route::apiResource('illes', IllaController::class);
Route::apiResource('imatges', ImatgeController::class)->only(['index', 'show']);
Route::apiResource('modalitats', ModalitatController::class)->only(['index', 'show']);
Route::apiResource('municipis', MunicipiController::class);
Route::apiResource('punts-interes', PuntInteresController::class)->only(['index', 'show']);
Route::apiResource('serveis', ServeiController::class)->only(['index', 'show']);
Route::apiResource('tipus-espais', TipusEspaiController::class)->only(['index', 'show']);
Route::apiResource('visites', VisitaController::class)->only(['index', 'show']);
Route::apiResource('zones', ZonaController::class);

Route::middleware('auth:sanctum')->group(function () {

    //rutes per usuari:
    Route::middleware('usuari')->group(function () {
        Route::apiResource('comentaris', ComentariController::class)->only(['store', 'update', 'destroy']);
    });

    //rutes per gestor
    Route::middleware('gestor')->group(function () {
        Route::apiResources([
            'arquitectes' => ArquitecteController::class,
            'audios' => AudioController::class,
            'comentaris' => ComentariController::class,
            'dates-reformes' => DataReformaController::class,
            'espais' => EspaiController::class,
            'hores-actives' => HoraActivaController::class,
            'illes' => IllaController::class,
            'imatges' => ImatgeController::class,
            'modalitats' => ModalitatController::class,
            'municipis' => MunicipiController::class,
            'punts-interes' => PuntInteresController::class,
            'tipus-espais' => TipusEspaiController::class,
            'visites' => VisitaController::class,
            'zones' => ZonaController::class
        ]);
        Route::apiResource('serveis', ServeiController::class)->except(['create', 'update', 'destroy']);
        Route::apiResource('modalitats', ModalitatController::class)->only(['index', 'show']);
        Route::apiResource('tipus-espais', TipusEspaiController::class)->only(['index', 'show']);

    });

    //Rutes administrador
    Route::middleware('administrador')->group(function () {
        Route::apiResources([
            'arquitectes' => ArquitecteController::class,
            'audios' => AudioController::class,
            'comentaris' => ComentariController::class,
            'dates-reformes' => DataReformaController::class,
            'espais' => EspaiController::class,
            'hores-actives' => HoraActivaController::class,
            'illes' => IllaController::class,
            'imatges' => ImatgeController::class,
            'modalitats' => ModalitatController::class,
            'municipis' => MunicipiController::class,
            'punts-interes' => PuntInteresController::class,
            'serveis' => ServeiController::class,
            'tipus-espais' => TipusEspaiController::class,
            'visites' => VisitaController::class,
            'zones' => ZonaController::class
        ]);
    });
});




