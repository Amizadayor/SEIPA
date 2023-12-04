<?php

namespace App\Http\Controllers;

use App\Models\PermisoPesca;
use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class PermisoPescaController extends Controller
{
    /**
     * Función para obtener todos los permisos de pesca.
     */
    public function index()
    {
        try {
            $permisopesca = PermisoPesca::all();
            $result = $permisopesca->map(function ($item) {
                return [
                    'id' => $item->id,
                    'NombrePermiso' => $item->NombrePermiso,
                    'TPEspecieid' => $item->Especie->NombreEspecie
                ];
            });
            return ApiResponse::success('Lista de Permisos de pesca', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de permisos de pesca: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para crear un permiso de pesca.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'NombrePermiso' => 'required|string|max:50',
                'TPEspecieid' => 'required|integer'
            ]);

            $existepermisopesca = PermisoPesca::where('NombrePermiso', $request->NombrePermiso)
                ->where('TPEspecieid', $request->TPEspecieid)
                ->first();
            if ($existepermisopesca) {
                return ApiResponse::error('Ya existe un permiso de pesca con el mismo nombre y especie', 409);
            }

            $permisopesca = PermisoPesca::create($request->all());
            return ApiResponse::success('Permiso de pesca creado', 201, $permisopesca);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el permiso de pesca: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para mostrar un permiso de pesca por su id.
     */
    public function show($id)
    {
        try {
            $permisopesca = PermisoPesca::findOrfail($id);
            $result = [
                'id' => $permisopesca->id,
                'NombrePermiso' => $permisopesca->NombrePermiso,
                'TPEspecieid' => $permisopesca->Especie->NombreEspecie
            ];
            return ApiResponse::success('Permiso de pesca obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Permiso de pesca no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el permiso de pesca: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para actualizar un permiso de pesca por su id.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'NombrePermiso' => 'required|string|max:50',
                'TPEspecieid' => 'required|integer'
            ]);

            $existepermisopesca = PermisoPesca::where('NombrePermiso', $request->NombrePermiso)
                ->where('TPEspecieid', $request->TPEspecieid)
                ->first();
            if ($existepermisopesca) {
                return ApiResponse::error('Ya existe un permiso de pesca con el mismo nombre y especie', 409);
            }

            $permisopesca = PermisoPesca::findOrfail($id);
            $permisopesca->update($request->all());
            return ApiResponse::success('Permiso de pesca actualizado', 200, $permisopesca);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Permiso de pesca no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el permiso de pesca: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para eliminar un permiso de pesca por su id.
     */
    public function destroy($id)
    {
        try {
            $permisopesca = PermisoPesca::findOrfail($id);
            $permisopesca->delete();
            return ApiResponse::success('Permiso de pesca eliminado', 200, $permisopesca);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Permiso de pesca no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el permiso de pesca: ' . $e->getMessage(), 500);
        }
    }
}
