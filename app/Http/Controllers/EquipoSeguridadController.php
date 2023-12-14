<?php

namespace App\Http\Controllers;

use App\Models\EquipoSeguridad;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

class EquipoSeguridadController extends Controller
{
    /**
     * Función para mostrar la lista de equipos de seguridad
     */
    public function index()
    {
        try {
            $equiposSeguridad = EquipoSeguridad::all();
            $result = $equiposSeguridad->map(function ($item) {
                return [
                    'id' => $item->id,
                    'NombreEquipoSeguridad' => $item->NombreEquipoSeguridad,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista Equipos de seguridad.', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de equipos de seguridad: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para crear un nuevo equipo de seguridad
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'NombreEquipoSeguridad' => 'required|string|max:50',
            ]);

            $existeEquipoSeguridad = EquipoSeguridad::where($data)->exists();
            if ($existeEquipoSeguridad) {
                return ApiResponse::error('El equipo de seguridad ya existe', 422);
            }

            $equipoSeguridad = EquipoSeguridad::create($data);
            return ApiResponse::success('Equipo de seguridad creado exitosamente', 201, $equipoSeguridad);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        }
    }

    /**
     * Función para mostrar un equipo de seguridad por id.
     */
    public function show($id)
    {
        try {
            $equipoSeguridad = EquipoSeguridad::findOrFail($id);
            $result = [
                'id' => $equipoSeguridad->id,
                'NombreEquipoSeguridad' => $equipoSeguridad->NombreEquipoSeguridad,
                'created_at' => $equipoSeguridad->created_at,
                'updated_at' => $equipoSeguridad->updated_at,
            ];
            return ApiResponse::success('Equipo de seguridad obtenido exitosamente.', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de seguridad no encontrado. ', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el equipo de seguridad: ', 500);
        }
    }

    /**
     * Función para actualizar un equipo de seguridad por id.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'NombreEquipoSeguridad' => 'required|string|max:50',
            ]);

            $existeEquipoSeguridad = EquipoSeguridad::where($data)->exists();
            if ($existeEquipoSeguridad) {
                return ApiResponse::error('El equipo de seguridad ya existe', 422);
            }

            $equipoSeguridad = EquipoSeguridad::findOrFail($id);
            $equipoSeguridad->update($data);
            return ApiResponse::success('Equipo de seguridad actualizado exitosamente.', 200, $equipoSeguridad);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de seguridad no encontrado. ', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el equipo de seguridad: ', 500);
        }
    }

    /**
     * Función para eliminar un equipo de seguridad por id.
     */
    public function destroy($id)
    {
        try {
            $equipoSeguridad = EquipoSeguridad::findOrFail($id);
            $equipoSeguridad->delete();
            return ApiResponse::success('Equipo de seguridad eliminado exitosamente.', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de seguridad no encontrado. ', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el equipo de seguridad: ', 500);
        }
    }
}
