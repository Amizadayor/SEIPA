<?php

namespace App\Http\Controllers;

use App\Models\Especie;
use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

class EspecieController extends Controller
{
    /**
     * Función para mostrar la lista de especies
     */
    public function index()
    {
        try {
            $especies = Especie::all();
            $result = $especies->map(function ($item) {
                return [
                    'id' => $item->id,
                    'NombreEspecie' => $item->NombreEspecie,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de las especies', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de especies: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para crear una nueva especie
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'NombreEspecie' => 'required|string|max:50',
            ]);

            $existeEspecie = Especie::where('NombreEspecie', $request->NombreEspecie)
                ->first();
            if ($existeEspecie) {
                return ApiResponse::error('La especie ya existe', 422);
            }

            $especie = Especie::create($request->all());
            return ApiResponse::success('Especie creada exitosamente', 201, $especie);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        }
    }

    /**
     * Función para mostrar una especie por su id
     */
    public function show($id)
    {
        try {
            $especie = Especie::findOrFail($id);
            $result = [
                'id' => $especie->id,
                'NombreEspecie' => $especie->NombreEspecie,
                'created_at' => $especie->created_at,
                'updated_at' => $especie->updated_at,
            ];
            return ApiResponse::success('Especie obtenida exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Especie no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la especie: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para actualizar una especie por su id
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'NombreEspecie' => 'required|string|max:50',
            ]);

            $existeEspecie = Especie::where('NombreEspecie', $request->NombreEspecie)
                ->first();
            if ($existeEspecie) {
                return ApiResponse::error('La especie ya existe', 422);
            }

            $especie = Especie::findOrFail($id);
            $especie->update($request->all());
            return ApiResponse::success('Especie actualizada exitosamente', 200, $especie);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Especie no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar la especie: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para eliminar una especie por su id
     */
    public function destroy($id)
    {
        try {
            $especie = Especie::findOrFail($id);
            $especie->delete();
            return ApiResponse::success('Especie eliminada exitosamente', 200, $especie);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Especie no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar la especie: ' . $e->getMessage(), 500);
        }
    }
}
