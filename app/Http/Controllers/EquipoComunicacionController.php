<?php

namespace App\Http\Controllers;

use App\Models\EquipoComunicacion;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;


class EquipoComunicacionController extends Controller
{
    /**
     * Función para mostrar la lista de equipos de comunicación
     */
    public function index()
    {
        try{
            $equiposComunicacion = EquipoComunicacion::all();
            $result = $equiposComunicacion->map(function($item){
                return [
                    'id' => $item->id,
                    'NombreEquipoComunicacion' => $item->NombreEquipoComunicacion,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los equipos de comunicación.', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de equipos de comunicación: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para crear un nuevo equipo de comunicación
     */
    public function store(Request $request)
    {
        try{
            $data = $request->validate([
                'NombreEquipoComunicacion' => 'required|string|max:50',
            ]);

            $existeEquipoComunicacion = EquipoComunicacion::where($data)->exists();
            if($existeEquipoComunicacion){
                return ApiResponse::error('El equipo de comunicación ya existe', 422);
            }

            $EquipoComunicacion = EquipoComunicacion::create($data);
            return ApiResponse::success('Equipo de comunicación creado exitosamente', 201, $EquipoComunicacion);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        }
    }

    /**
     * Función para mostrar un equipo de comunicación por id.
     */
    public function show($id)
    {
        try{
            $EquipoComunicacion = EquipoComunicacion::findOrFail($id);
            $result = [
                'id' => $EquipoComunicacion->id,
                'NombreEquipoComunicacion' => $EquipoComunicacion->NombreEquipoComunicacion,
                'created_at' => $EquipoComunicacion->created_at,
                'updated_at' => $EquipoComunicacion->updated_at,
            ];

            return ApiResponse::success('Equipo de comunicación obtenido exitosamente.', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Error al obtener el equipo de comunicación: ' . $e->getMessage(), 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el equipo de comunicación: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para actualizar un equipo de comunicación por id.
     */
    public function update(Request $request, $id)
    {
        try{
            $data = $request->validate([
                'NombreEquipoComunicacion' => 'required|string|max:50',
            ]);

            $existeEquipoComunicacion = EquipoComunicacion::where($data)->exists();
            if($existeEquipoComunicacion){
                return ApiResponse::error('El equipo de comunicación ya existe', 422);
            }

            $EquipoComunicacion = EquipoComunicacion::findOrFail($id);
            $EquipoComunicacion->update($data);
            return ApiResponse::success('Equipo de comunicación actualizado exitosamente.', 200, $EquipoComunicacion);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Error al actualizar el equipo de comunicación: ' . $e->getMessage(), 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el equipo de comunicación: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para eliminar un equipo de comunicación por id.
     */
    public function destroy($id)
    {
        try{
            $EquipoComunicacion = EquipoComunicacion::findOrFail($id);
            $EquipoComunicacion->delete();
            return ApiResponse::success('Equipo de comunicación eliminado exitosamente.', 200, $EquipoComunicacion);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Error al eliminar el equipo de comunicación: ' . $e->getMessage(), 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el equipo de comunicación: ' . $e->getMessage(), 500);
        }
    }
}
