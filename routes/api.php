<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\AsignacionPermisoController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\DistritoController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\LocalidadController;
use App\Http\Controllers\OficinaController;
use App\Http\Controllers\UnidadEconomicaPAFisicoController;
use App\Http\Controllers\ArtePescaController;
use App\Http\Controllers\EspecieController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PermisoPescaController;
use App\Http\Controllers\UnidadEconomicaPAMoralController;
use App\Http\Controllers\SocioDetallePAMoralController;
use App\Http\Controllers\TipoActividadController;
use App\Http\Controllers\TipoCubiertaController;
use App\Http\Controllers\MaterialCascoController;
use App\Http\Controllers\UnidadEconomicaEmbMaController;
use App\Http\Controllers\EquipoDeteccionController;
use App\Http\Controllers\SistemaConservacionController;

//Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    //return $request->user();
//});

//Ruta: http://seipa.test/api/nombre_ruta

Route::apiResource('roles', RolController::class);
Route::apiResource('users', UserController::class);
Route::apiResource('permisos', PermisoController::class);
Route::apiResource('asignacion_permisos', AsignacionPermisoController::class);
Route::apiResource('regiones', RegionController::class);
Route::apiResource('distritos', DistritoController::class);
Route::apiResource('municipios', MunicipioController::class);
Route::apiResource('localidades', LocalidadController::class);
Route::apiResource('oficinas', OficinaController::class);
Route::apiResource('unidades_economicas_pa_fisico', UnidadEconomicaPAFisicoController::class);
Route::apiResource('artes_pesca', ArtePescaController::class);
Route::apiResource('especies', EspecieController::class);
Route::apiResource('productos', ProductoController::class);
Route::apiResource('permisos_pesca', PermisoPescaController::class);
Route::apiResource('unidades_economicas_pa_moral', UnidadEconomicaPAMoralController::class);
Route::apiResource('socios_detalles_pa_moral', SocioDetallePAMoralController::class);
Route::apiResource('tipos_actividad', TipoActividadController::class);
Route::apiResource('tipos_cubierta', TipoCubiertaController::class);
Route::apiResource('materiales_casco', MaterialCascoController::class);
Route::apiResource('unidades_economicas_emb_ma', UnidadEconomicaEmbMaController::class);
Route::apiResource('equipos_deteccion', EquipoDeteccionController::class);
Route::apiResource('sistemas_conservacion', SistemaConservacionController::class);
