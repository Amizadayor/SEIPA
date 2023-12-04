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
