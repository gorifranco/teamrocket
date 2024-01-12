<?php

use App\Http\Controllers\ArquitecteController;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\ComentariController;
use App\Http\Controllers\DataReformaController;
use App\Http\Controllers\EspaiController;
use App\Http\Controllers\HoraActivaController;
use App\Http\Controllers\IllaController;
use App\Http\Controllers\ImatgeController;
use App\Http\Controllers\LoginController;
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

Route::post('/login', [LoginController::class, 'login']);


//Guest routes
Route::apiResource("arquitectes", ArquitecteController::class)->only("index", "show");
Route::apiResource('audios', AudioController::class)->only(['index', 'show']);
Route::apiResource('comentaris', ComentariController::class)->only(['index', 'show']);
Route::apiResource('dates-reformes', DataReformaController::class)->only(['index', 'show']);
Route::apiResource('espais', EspaiController::class)->only(['index', 'show']);
Route::apiResource('hores-actives', HoraActivaController::class)->only(['index', 'show']);
Route::apiResource('illes', IllaController::class)->only(['index', 'show']);
Route::apiResource('imatges', ImatgeController::class)->only(['index', 'show']);
Route::apiResource('modalitats', ModalitatController::class)->only(['index', 'show']);
Route::apiResource('municipis', MunicipiController::class)->only(['index', 'show']);
Route::apiResource('punts_interes', PuntInteresController::class)->only(['index', 'show']);
Route::apiResource('serveis', ServeiController::class)->only(['index', 'show']);
Route::apiResource('tipus_espais', TipusEspaiController::class)->only(['index', 'show']);
Route::apiResource('visites', VisitaController::class)->only(['index', 'show']);
Route::apiResource('zones', ZonaController::class)->only(['index', 'show']);
Route::get("arquitectes_tots", [ArquitecteController::class, "tots"]);
Route::get("tipus_espais_tots", [TipusEspaiController::class, "tots"]);
Route::get("modalitats_tots", [ModalitatController::class, "tots"]);



Route::middleware(['apiMiddleware'])->group(function () {
    Route::apiResource("arquitectes", ArquitecteController::class)
        ->only("store", "destroy", "update")
        ->middleware("tipusUsuari:administrador,gestor");
    Route::apiResource("tipus_espais", TipusEspaiController::class)
        ->only("store", "destroy", "update")
        ->middleware("tipusUsuari:administrador,gestor");
    Route::apiResource("serveis", ServeiController::class)
        ->only("store", "destroy", "update")
        ->middleware("tipusUsuari:administrador,gestor");
    Route::apiResource("modalitats", ModalitatController::class)
        ->only("store", "destroy", "update")
        ->middleware("tipusUsuari:administrador,gestor");
    Route::get("/espais_per_gestor", [EspaiController::class, "espais_per_gestor"])
        ->middleware("tipusUsuari:gestor");
    Route::get("/espais_per_gestor/find/{cerca}", [EspaiController::class, "espais_per_gestor_find"])
        ->middleware("tipusUsuari:gestor");

    Route::apiResources([
//        'arquitectes' => ArquitecteController::class,
        'audios' => AudioController::class,
        'comentaris' => ComentariController::class,
        'dates-reformes' => DataReformaController::class,
        'espais' => EspaiController::class,
        'hores-actives' => HoraActivaController::class,
//        'illes' => IllaController::class,
        'imatges' => ImatgeController::class,
//        'modalitats' => ModalitatController::class,
//        'municipis' => MunicipiController::class,
        'punts-interes' => PuntInteresController::class,
//        'serveis' => ServeiController::class,
//        'tipus_espais' => TipusEspaiController::class,
        'visites' => VisitaController::class,
//        'zones' => ZonaController::class
    ]);
});

Route::get('/arquitectes/find/{cerca}', [ArquitecteController::class, 'find']);
Route::get('/modalitats/find/{cerca}', [ModalitatController::class, 'find']);
Route::get('/tipus_espais/find/{cerca}', [TipusEspaiController::class, 'find']);


