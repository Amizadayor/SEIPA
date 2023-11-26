<?php

namespace App\Http\Controllers;

use App\Models\Municipio;
use App\Models\Distrito;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

class MunicipioController extends Controller
{
    /**
     * Función que obtener todos los municipios.
     */
    public function index()
    {
        try {
            $municipios = Municipio::all();
            $result = $municipios->map(function ($item) {
                return [
                    'id' => $item->id,
                    'NombreMunicipio' => $item->NombreMunicipio,
                    'Disid' => $item->distrito->NombreDistrito,
                    'Regid' => $item->distrito->region->NombreRegion,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los municipios', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de municipios: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para crear un nuevo Municipio
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'NombreMunicipio' => 'required|string|max:40',
                'Disid' => 'required|exists:distritos,id'
            ]);

            $existeMunicipio = Municipio::where('NombreMunicipio', $request->NombreMunicipio)
                ->where('Disid', $request->Disid)
                ->first();
            if ($existeMunicipio) {
                return ApiResponse::error('El municipio ya existe en este distrito', 422);
            }

            $municipio = Municipio::create($request->all());
            return ApiResponse::success('Municipio creado exitosamente', 201, $municipio);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el municipio: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para obtener un municipio por id
     */
    public function show($id)
    {
        try {
            $municipio = Municipio::findOrFail($id);
            $result = [
                'id' => $municipio->id,
                'NombreMunicipio' => $municipio->NombreMunicipio,
                'Disid' => $municipio->distrito->NombreDistrito,
                'Regid' => $municipio->distrito->region->NombreRegion,
                'created_at' => $municipio->created_at,
                'updated_at' => $municipio->updated_at,
            ];
            return ApiResponse::success('Municipio obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Municipio no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el municipio: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para actualizar un municipio por id
     */
    public function update(Request $request, $id)
    {
        try {
            $municipio = Municipio::findOrFail($id);
            $request->validate([
                'NombreMunicipio' => 'required|string|max:40',
                'Disid' => 'required|exists:distritos,id'
            ]);

            $existeMunicipio = Municipio::where('NombreMunicipio', $request->NombreMunicipio)
                ->where('Disid', $request->Disid)
                ->first();
            if ($existeMunicipio) {
                return ApiResponse::error('El municipio ya existe en este distrito', 422);
            }

            $municipio->update($request->all());
            return ApiResponse::success('Municipio actualizado exitosamente', 200, $municipio);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Municipio no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('El Municipio ya existe: ' . $e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para eliminar un municipio por id
     */
    public function destroy($id)
    {
        try {
            $municipio = Municipio::findOrFail($id);
            $municipio->delete();
            return ApiResponse::success('Municipio eliminado exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Municipio no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error: ' . $e->getMessage(), 500);
        }
    }
}
