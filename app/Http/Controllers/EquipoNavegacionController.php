<?php

namespace App\Http\Controllers;

use App\Models\EquipoNavegacion;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

class EquipoNavegacionController extends Controller
{
    /**
     * Función para mostrar la lista de equipos de navegación
     */
    public function index()
    {
        try{
            $equiposNavegacion = EquipoNavegacion::all();
            $result = $equiposNavegacion->map(function($item){
                return [
                    'id' => $item->id,
                    'NombreEquipoNavegacion' => $item->NombreEquipoNavegacion,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista equipos de navegación.', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de equipos de navegación: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para crear un nuevo equipo de navegación
     */
    public function store(Request $request)
    {
        try{
            $data = $request->validate([
                'NombreEquipoNavegacion' => 'required|string|max:50',
            ]);

            $existeEquipoNavegacion = EquipoNavegacion::where($data)->exists();
            if($existeEquipoNavegacion){
                return ApiResponse::error('El equipo de navegación ya existe', 422);
            }

            $equipoNavegacion = EquipoNavegacion::create($data);
            return ApiResponse::success('Equipo de navegación creado exitosamente', 201, $equipoNavegacion);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        }
    }

    /**
     * Función para mostrar un equipo de navegación por id.
     */
    public function show($id)
    {
        try{
            $equipoNavegacion = EquipoNavegacion::findOrFail($id);
            $result = [
                'id' => $equipoNavegacion->id,
                'NombreEquipoNavegacion' => $equipoNavegacion->NombreEquipoNavegacion,
                'created_at' => $equipoNavegacion->created_at,
                'updated_at' => $equipoNavegacion->updated_at,
            ];

            return ApiResponse::success('Equipo de navegación obtenido exitosamente.', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Error al obtener el equipo de navegación: ' , 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el equipo de navegación: ' , 500);
        }
    }

    /**
     * Función para actualizar un equipo de navegación por id.
     */
    public function update(Request $request, $id)
    {
        try{
            $data = $request->validate([
                'NombreEquipoNavegacion' => 'required|string|max:50',
            ]);

            $existeEquipoNavegacion = EquipoNavegacion::where($data)->exists();
            if($existeEquipoNavegacion){
                return ApiResponse::error('El equipo de navegación ya existe', 422);
            }

            $equipoNavegacion = EquipoNavegacion::findOrFail($id);
            $equipoNavegacion->update($data);
            return ApiResponse::success('Equipo de navegación actualizado exitosamente.', 200, $equipoNavegacion);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Error al obtener el equipo de navegación: ' , 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el equipo de navegación: ' , 500);
        }
    }

    /**
     * Función para eliminar un equipo de navegación por id.
     */
    public function destroy($id)
    {
        try{
            $equipoNavegacion = EquipoNavegacion::findOrFail($id);
            $equipoNavegacion->delete();
            return ApiResponse::success('Equipo de navegación eliminado exitosamente.', 200, $equipoNavegacion);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Error al obtener el equipo de navegación: ' , 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el equipo de navegación: ' , 500);
        }
    }
}
