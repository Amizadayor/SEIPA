<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermisoController;


//Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    //return $request->user();
//});

//Ruta: http://siipo.test/api/nombre_ruta

Route::apiResource('roles', RolController::class);
Route::apiResource('users', UserController::class);
Route::apiResource('permisos', PermisoController::class);
