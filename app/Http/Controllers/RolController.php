<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Rol;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RolController extends Controller
{
    /**
     * Función para obtener la lista de roles
     */
    public function index()
    {
        try {
            $roles = Rol::all();
            $result = $roles->map(function ($item) {
                return [
                    'id' => $item->id,
                    'NombreRol' => $item->NombreRol,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de roles', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de roles: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para crear un nuevo rol
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'NombreRol' => 'required|unique:roles|max:20',
            ], [
                'NombreRol.unique' => 'El nombre para el Rol ya está en uso. Por favor, elige otro nombre.',
            ]);

            // Verifica si el rol ya existe
            $existeRol = Rol::where('NombreRol', $request->input('NombreRol'))->first();
            if ($existeRol) {
                return ApiResponse::error('El Rol ya existe', 422);
            }

            // Verifica la cantidad de roles
            $totalRoles = Rol::count();
            if ($totalRoles >= 3) {
                return ApiResponse::error('No puedes crear más de 3 roles', 422);
            }
            // Crea el rol
            $rol = Rol::create($request->all());
            return ApiResponse::success('Rol creado exitosamente', 201, $rol);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        }
    }

    /**
     * Función para obtener un rol por su id
     */
    public function show(string $id)
    {
        try {
            $rol = Rol::findOrFail($id);
            $result = [
                'id' => $rol->id,
                'NombreRol' => $rol->NombreRol,
                'created_at' => $rol->created_at,
                'updated_at' => $rol->updated_at,
            ];
            return ApiResponse::success('Rol obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Rol no encontrado', 404);
        }
    }

    /**
     * Función para actualizar un rol
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'NombreRol' => 'required|string|max:20|unique:roles,NombreRol,' . $id,
            ], [
                'NombreRol.unique' => 'El nombre para el Rol ya está en uso. Por favor, elige otro nombre.',
            ]);

            $rol = Rol::findOrFail($id);
            $rol->update($request->all());

            return ApiResponse::success('Rol actualizado exitosamente', 200, $rol);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Rol no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para eliminar un rol
     */
    public function destroy($id)
    {
        try {
            $rol = Rol::findOrFail($id);
            $rol->delete();
            return ApiResponse::success('Rol eliminado exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Rol no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error: ' . $e->getMessage(), 422);
        }
    }
}
