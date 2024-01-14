<?php

namespace App\Http\Controllers;

use App\Models\TipoActivo;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class TipoActivoController extends Controller
{
    /**
     * Función para obtener la lista de Tipos de Activos.

     */
    public function index()
    {
        try{
            $tiposactivo = TipoActivo::all();
            $result = $tiposactivo->map(function($item){
                return [
                    'id' => $item->id,
                    'NombreActivo' => $item->NombreActivo,
                    'Clave' => $item->Clave,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de tipos de activos', 200, $result);
        } catch(Exception $e){
            return ApiResponse::error('Error al obtener la lista de tipos de activos. ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para registrar un nuevo Tipo de Activos.
     */
    public function store(Request $request)
    {
        try{
            $data = $request->validate([
                'NombreActivo' => 'required|string|max:100',
                'Clave' => 'required|string|max:6',
            ]);

            $existetipoactivo = TipoActivo::where($data)->exists();
            if($existetipoactivo){
                return ApiResponse::error('El tipo de activo ya existe. ', 422);
            }

            $tiposactivo = TipoActivo::create($data);
            return ApiResponse::success('tipo de activo registrado exitosamente.', 201, $tiposactivo);
        } catch(ValidationException $e){
            return ApiResponse::error('Error de validación. ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para obtener un tipo de activo por su id.
     */
    public function show($id)
    {
        try{
            $tiposactivo = TipoActivo::findOrFail($id);
            $result = [
                'id' => $tiposactivo->id,
                'NombreActivo' => $tiposactivo->NombreActivo,
                'Clave' => $tiposactivo->Clave,
                'created_at' => $tiposactivo->created_at,
                'updated_at' => $tiposactivo->updated_at,
            ];
            return ApiResponse::success('Tipo de activo obtenido exitosamente.', 200, $result);
        } catch(ModelNotFoundException $e){
            return ApiResponse::error('Tipo de activo no encontrado. ' . $e->getMessage(), 404);
        } catch(Exception $e){
            return ApiResponse::error('Error al obtener el tipo de activo. ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para actualizar un tipo de activo por su id.
     */
    public function update(Request $request, $id)
    {
        try{
            $data = $request->validate([
                'NombreActivo' => 'required|string|max:100',
                'Clave' => 'required|string|max:6',
            ]);

            $existetipoactivo = TipoActivo::where($data)->exists();
            if($existetipoactivo){
                return ApiResponse::error('El tipo de activo ya existe. ', 422);
            }

            $tiposactivo = TipoActivo::findOrFail($id);
            $tiposactivo->update($data);
            return ApiResponse::success('Tipo de activo actualizado exitosamente.', 200, $tiposactivo);
        } catch(ValidationException $e){
            return ApiResponse::error('Error de validación. ' . $e->getMessage(), 500);
        } catch(ModelNotFoundException $e){
            return ApiResponse::error('Tipo de activo no encontrado. ' . $e->getMessage(), 404);
        } catch(Exception $e){
            return ApiResponse::error('Error al actualizar el tipo de activo. ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para eliminar un tipo de activo por su id.
     */
    public function destroy($id)
    {
        try{
            $tiposactivo = TipoActivo::findOrFail($id);
            $tiposactivo->delete();
            return ApiResponse::success('Tipo de activo eliminado exitosamente.', 200, $tiposactivo);
        } catch(ModelNotFoundException $e){
            return ApiResponse::error('Tipo de activo no encontrado. ' . $e->getMessage(), 404);
        } catch(Exception $e){
            return ApiResponse::error('Error al eliminar el tipo de activo. ' . $e->getMessage(), 500);
        }
    }
}
