<?php

namespace App\Http\Controllers;

use App\Models\SistemaConservacion;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class SistemaConservacionController extends Controller
{
    /**
     *  Función para mostrar la lista de sistemas de conservación.
     */
    public function index()
    {
        try{
            $sistemasConservacion = SistemaConservacion::all();
            $result = $sistemasConservacion->map(function ($item) {
                return [
                    'id' => $item->id,
                    'NombreSistemaConservacion' => $item->NombreSistemaConservacion,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los sistemas de conservación', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de los sistemas de conservación', 500);
        }
    }

    /**
     * Función para crear un nuevo sistema de conservación.
     */
    public function store(Request $request)
    {
        try{
            $data = $request->validate([
                'NombreSistemaConservacion' => 'required|string|max:50',
            ]);

            $existeSistemaConservacion = SistemaConservacion::where($data)->exists();
            if ($existeSistemaConservacion) {
                return ApiResponse::error('El sistema de conservación ya existe', 422);
            }

            $sistemaConservacion = SistemaConservacion::create($data);
            return ApiResponse::success('Sistema de conservación creado exitosamente', 201, $sistemaConservacion);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación', 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el sistema de conservación', 500);
        }
    }

    /**
     * Función para mostrar un sistema de conservación por id.
     */
    public function show($id)
    {
        try{
            $sistemaConservacion = SistemaConservacion::findOrFail($id);
            $result = [
                'id' => $sistemaConservacion->id,
                'NombreSistemaConservacion' => $sistemaConservacion->NombreSistemaConservacion,
                'created_at' => $sistemaConservacion->created_at,
                'updated_at' => $sistemaConservacion->updated_at,
            ];
            return ApiResponse::success('Sistema de conservación obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('No existe el sistema de conservación', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el sistema de conservación', 500);
        }
    }

    /**
     * Función para actualizar un sistema de conservación por id.
     */
    public function update(Request $request, $id)
    {
        try{
            $data = $request->validate([
                'NombreSistemaConservacion' => 'required|string|max:50',
            ]);

            $existeSistemaConservacion = SistemaConservacion::where($data)->exists();
            if ($existeSistemaConservacion) {
                return ApiResponse::error('El sistema de conservación ya existe', 422);
            }

            $sistemaConservacion = SistemaConservacion::findOrFail($id);
            $sistemaConservacion->update($data);
            return ApiResponse::success('Sistema de conservación actualizado exitosamente', 200, $sistemaConservacion);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación', 422, $e->errors());
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('No existe el sistema de conservación', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el sistema de conservación', 500);
        }
    }

    /**
     * Función para eliminar un sistema de conservación por id.
     */
    public function destroy($id)
    {
        try{
            $sistemaConservacion = SistemaConservacion::findOrFail($id);
            $sistemaConservacion->delete();
            return ApiResponse::success('Sistema de conservación eliminado exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('No existe el sistema de conservación', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el sistema de conservación', 500);
        }
    }
}
