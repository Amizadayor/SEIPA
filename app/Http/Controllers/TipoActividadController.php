<?php

namespace App\Http\Controllers;

use App\Models\TipoActividad;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class TipoActividadController extends Controller
{
    /**
     * Función para obtener la lista de Tipos de Actividad.
     */
    public function index()
    {
        try {
            $tiposactividad = TipoActividad::all();
            $result = $tiposactividad->map(function ($item) {
                return [
                    'id' => $item->id,
                    'NombreActividad' => $item->NombreActividad,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de Tipos de Actividad', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de Tipos de Actividad. ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para registrar un nuevo Tipo de Actividad.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'NombreActividad' => 'required|string|max:50',
            ]);

            $existetipoactividad = TipoActividad::where($data)->exists();
            if ($existetipoactividad) {
                return ApiResponse::error('El Tipo de Actividad ya existe. ', 422);
            }

            $tiposactividad = TipoActividad::create($data);
            return ApiResponse::success('Tipo de Actividad registrado exitosamente.', 201, $tiposactividad);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación. ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para obtener un Tipo de Actividad por su id.
     */
    public function show($id)
    {
        try {
            $tiposactividad = TipoActividad::findOrFail($id);
            $result = [
                'id' => $tiposactividad->id,
                'NombreActividad' => $tiposactividad->NombreActividad,
                'created_at' => $tiposactividad->created_at,
                'updated_at' => $tiposactividad->updated_at,
            ];
            return ApiResponse::success('Tipo de Actividad obtenida exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de Actividad no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el Tipo de Actividad. ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para actualizar un Tipo de Actividad por su id.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'NombreActividad' => 'required|string|max:50',
            ]);

            $existetipoactividad = TipoActividad::where($data)->exists();
            if ($existetipoactividad) {
                return ApiResponse::error('El Tipo de Actividad ya existe. ', 422);
            }

            $tiposactividad = TipoActividad::findOrFail($id);
            $tiposactividad->update($data);
            return ApiResponse::success('Tipo de Actividad actualizado.', 200, $tiposactividad);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de Actividad no encontrado.', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el Tipo de Actividad. ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para eliminar un Tipo de Actividad por su id.
     */
    public function destroy($id)
    {
        try {
            $tiposactividad = TipoActividad::findOrFail($id);
            $tiposactividad->delete();
            return ApiResponse::success('Tipo de Actividad eliminado.', 200, $tiposactividad);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de Actividad no encontrado.', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el Tipo de Actividad. ' . $e->getMessage(), 500);
        }
    }
}
