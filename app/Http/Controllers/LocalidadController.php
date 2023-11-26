<?php

namespace App\Http\Controllers;

use App\Models\Localidad;
use App\Models\Municipio;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

class LocalidadController extends Controller
{
    /**
     * Función que obtener todos las localidades.
     */
    public function index()
    {
        try {
            $localidades = Localidad::all();
            $result = $localidades->map(function ($item) {
                return [
                    'id' => $item->id,
                    'NombreLocalidad' => $item->NombreLocalidad,
                    'Munid' => $item->municipio->NombreMunicipio,
                    'Disid' => $item->municipio->distrito->NombreDistrito,
                    'Regid' => $item->municipio->distrito->region->NombreRegion,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de las localidades', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de localidades: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para crear una nueva Localidad
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'NombreLocalidad' => 'required|string|max:30',
                'Munid' => 'required|exists:municipios,id'
            ]);

            $existeLocalidad = Localidad::where('NombreLocalidad', $request->NombreLocalidad)
                ->where('Munid', $request->Munid)
                ->first();
            if ($existeLocalidad) {
                return ApiResponse::error('La localidad ya existe en este municipio', 422);
            }

            $localidad = Localidad::create($request->all());
            return ApiResponse::success('Localidad creada exitosamente', 201, $localidad);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear la localidad: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para obtener una localidad por id
     */
    public function show($id)
    {
        try {
            $localidad = Localidad::findOrFail($id);
            $result = [
                'id' => $localidad->id,
                'NombreLocalidad' => $localidad->NombreLocalidad,
                'Munid' => $localidad->municipio->NombreMunicipio,
                'Disid' => $localidad->municipio->distrito->NombreDistrito,
                'Regid' => $localidad->municipio->distrito->region->NombreRegion,
                'created_at' => $localidad->created_at,
                'updated_at' => $localidad->updated_at,
            ];
            return ApiResponse::success('Localidad obtenida exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Localidad no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la localidad: ' . $e->getMessage(), 500);
        }
    }

    /**
     *  Función para actualizar una localidad por id
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'NombreLocalidad' => 'required|string|max:30',
                'Munid' => 'required|exists:municipios,id'
            ]);

            $existeLocalidad = Localidad::where('NombreLocalidad', $request->NombreLocalidad)
                ->where('Munid', $request->Munid)
                ->first();
            if ($existeLocalidad) {
                return ApiResponse::error('La localidad ya existe en este municipio', 422);
            }

            $localidad = Localidad::findOrFail($id);
            $localidad->update($request->all());
            return ApiResponse::success('Localidad actualizada exitosamente', 200, $localidad);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Localidad no encontrada', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar la localidad: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para eliminar una localidad por id
     */
    public function destroy($id)
    {
        try {
            $localidad = Localidad::findOrFail($id);
            $localidad->delete();
            return ApiResponse::success('Localidad eliminada exitosamente', 200, $localidad);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Localidad no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar la localidad: ' . $e->getMessage(), 500);
        }
    }
}
