<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Permiso;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PermisoController extends Controller
{
    /**
     * Función que obtiene la lista de los permisos
     */
    public function index()
    {
        try {
            $permisos = Permiso::all();
            $result = $permisos->map(function ($item) {
                return [
                    'id' => $item->id,
                    'NombrePermiso' => $item->NombrePermiso,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los permisos', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de permisos: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para crear un nuevo permiso.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'NombrePermiso' => 'required|string|max:30|unique:permisos',
            ], [
                'NombrePermiso.unique' => 'El permiso con este nombre ya existe. Por favor, elige otro nombre.',
            ]);
            $permisos = Permiso::create($request->all());
            return ApiResponse::success('Permiso creado exitosamente', 201, $permisos);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validacion: ' . $e->getMessage(), 422,);
        }
    }

    /**
     * Función que obtiene un permiso por su id.
     */
    public function show($id)
    {
        try {
            $permisos = Permiso::findOrFail($id);
            $result = [
                'id' => $permisos->id,
                'NombrePermiso' => $permisos->NombrePermiso,
                'created_at' => $permisos->created_at,
                'updated_at' => $permisos->updated_at,
            ];
            return ApiResponse::success('Permiso obtenido exitosamente', 200, $permisos);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Permiso no encontrado', 404);
        }
    }

    /**
     * Función que actualiza un permiso por su id.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'NombrePermiso' => 'required|string|max:30|unique:permisos,NombrePermiso,' . $id,
            ], [
                'NombrePermiso.unique' => 'El permiso con este nombre ya existe. Por favor, elige otro nombre.',
            ]);

            $permisos = Permiso::findOrFail($id);
            $permisos->update($request->all());

            return ApiResponse::success('Permiso actualizado exitosamente', 200, $permisos);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Permiso no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validacion: ' . $e->getMessage(), 422);
        }
    }

    /**
     * Función que elimina un permiso por su id.
     */
    public function destroy($id)
    {
        try {
            $permisos = Permiso::findOrFail($id);
            $permisos->delete();
            return ApiResponse::success('Permiso eliminado exitosamente', 200, $permisos);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Permiso no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422);
        }
    }
}
