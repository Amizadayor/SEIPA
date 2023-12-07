<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class RegionController extends Controller
{
    /**
     * Función para obtener la lista de regiones
     */
    public function index()
    {
        try {
            $regiones = Region::all();
            $result = $regiones->map(function ($item) {
                return [
                    'id' => $item->id,
                    'NombreRegion' => $item->NombreRegion,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de regiones', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de regiones: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para crear una nueva región
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'NombreRegion' => 'required|string|max:40|unique:regiones',
            ], [
                'NombreRegion.unique' => 'La Región con este nombre ya existe. Por favor, elige otro nombre.',
            ]);

            // Verifica la cantidad de regiones
            $totalRegiones = Region::count();
            if ($totalRegiones >= 8) {
                return ApiResponse::error('No puedes crear más de 8 regiones', 422);
            }

            $region = Region::create($data);
            return ApiResponse::success('Región creada exitosamente', 201, $region);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422);
        } catch (Exception $e) {
            return ApiResponse::error('Error: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para obtener una región por su id
     */
    public function show(string $id)
    {
        try {
            $region = Region::findOrFail($id);
            return ApiResponse::success('Región obtenida exitosamente', 200, $region);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Región no encontrada', 404);
        }
    }

    /**
     * Función para actualizar una región por su id
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'NombreRegion' => 'required|string|max:40|unique:regiones',
            ], [
                'NombreRegion.unique' => 'La Región con este nombre ya existe. Por favor, elige otro nombre.',
            ]);

            $region = Region::findOrFail($id);
            $region->update($data);

            return ApiResponse::success('Región actualizada exitosamente', 200, $region);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Región no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error de validación : ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para eliminar una región por su id
     */
    public function destroy($id)
    {
        try {
            $region = Region::findOrFail($id);
            $region->delete();

            return ApiResponse::success('Región eliminada exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Región no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error: ' . $e->getMessage(), 500);
        }
    }
}
