<?php

namespace App\Http\Controllers;

use App\Models\EquipoDeteccion;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

class EquipoDeteccionController extends Controller
{
    /**
     * Función para mostrar la lista de equipos de detección
     */
    public function index()
    {
        try {
            $equiposDeteccion = EquipoDeteccion::all();
            $result = $equiposDeteccion->map(function ($item) {
                return [
                    'id' => $item->id,
                    'NombreEquipo' => $item->NombreEquipo,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los equipos de detección.', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de equipos de detección: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para crear un nuevo equipo de detección
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'NombreEquipo' => 'required|string|max:50|alpha',
            ]);

            $existeEquipoDeteccion = EquipoDeteccion::where($data)->exists();
            if ($existeEquipoDeteccion) {
                return ApiResponse::error('El equipo de detección ya existe', 422);
            }

            $EquipoDeteccion = EquipoDeteccion::create($data);
            return ApiResponse::success('Equipo de detección creado exitosamente', 201, $EquipoDeteccion);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        }
    }

    /**
     * Función para mostrar un equipo de detección por id.
     */
    public function show($id)
    {
        try{
            $EquipoDeteccion = EquipoDeteccion::findOrFail($id);
            $result = [
                'id' => $EquipoDeteccion->id,
                'NombreEquipo' => $EquipoDeteccion->NombreEquipo,
                'created_at' => $EquipoDeteccion->created_at,
                'updated_at' => $EquipoDeteccion->updated_at,
            ];

            return ApiResponse::success('Equipo de detección encontrado', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de detección no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el equipo de detección: ' , 500);
        }
    }

    /**
     * Función para actualizar un equipo de detección por id.
     */
    public function update(Request $request, $id)
    {
        try{
            $data = $request->validate([
                'NombreEquipo' => 'required|string|max:50|alpha',
            ]);

            $existeEquipoDeteccion = EquipoDeteccion::where($data)->exists();
            if ($existeEquipoDeteccion) {
                return ApiResponse::error('El equipo de detección ya existe', 422);
            }

            $EquipoDeteccion = EquipoDeteccion::findOrFail($id);
            $EquipoDeteccion->update($data);
            return ApiResponse::success('Equipo de detección actualizado exitosamente', 200, $EquipoDeteccion);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de detección no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el equipo de detección: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para eliminar un equipo de detección por id.
     */
    public function destroy($id)
    {
        try{
            $EquipoDeteccion = EquipoDeteccion::findOrFail($id);
            $EquipoDeteccion->delete();
            return ApiResponse::success('Equipo de detección eliminado exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de detección no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el equipo de detección: ' , 500);
        }
    }
}
