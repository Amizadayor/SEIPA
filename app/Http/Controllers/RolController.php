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
        return ApiResponse::success('Lista de roles', 200, $roles);
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
                'NombreRol' => 'required|unique:roles',
            ]);

            $totalRoles = Rol::count();
            if ($totalRoles >= 3) {
                return ApiResponse::error('No puedes crear más de 3 roles', 422);
            }

            $rol = Rol::create($request->all());
        return ApiResponse::success('Rol creado exitosamente', 201, $rol);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validacion: ' . $e->getMessage(), 422);
        }
    }

    /**
     * Función para obtener un rol por su id
     */
    public function show(string $id)
    {
        try {
            $rol = Rol::findOrFail($id);
        return ApiResponse::success('Rol obtenido exitosamente', 200, $rol);
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
                'NombreRol' => 'required|unique:roles,NombreRol,' . $id
            ]);

            $rol = Rol::findOrFail($id);
            $rol->update($request->all());

            return ApiResponse::success('Rol actualizado exitosamente', 200, $rol);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Rol no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('El Rol ya existe: ' . $e->getMessage(), 422);
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
