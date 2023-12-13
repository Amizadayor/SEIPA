<?php

namespace App\Http\Controllers;

use App\Models\ArtePesca;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

class ArtePescaController extends Controller
{
    /**
     * Función para obtener todos los artes de pesca.
     */
    public function index()
    {
        try {
            $artesPesca = ArtePesca::all();
            $result = $artesPesca->map(function ($item) {
                return [
                    'id' => $item->id,
                    'NombreArtePesca' => $item->NombreArtePesca,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de las Artes de Pesca', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de Artes de Pesca: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para crear un arte de pesca.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'NombreArtePesca' => 'required|string|max:50'
            ]);

            $existeArtePesca = ArtePesca::where($data)->exists();
            if ($existeArtePesca) {
                return ApiResponse::error('El arte de pesca ya existe', 422);
            }

            $artePesca = ArtePesca::create($data);
            return ApiResponse::success('Arte de pesca creado exitosamente', 201, $artePesca);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el Arte de pesca: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para mostrar un Arte de Pesca por su id
     */
    public function show($id)
    {
        try {
            $artePesca = ArtePesca::findOrFail($id);
            $result = [
                'id' => $artePesca->id,
                'NombreArtePesca' => $artePesca->NombreArtePesca,
                'created_at' => $artePesca->created_at,
                'updated_at' => $artePesca->updated_at,
            ];
            return ApiResponse::success('Arte de pesca obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Arte de pesca no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el Arte de pesca: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para actualizar un Arte de Pesca por su id
     */
    public function update(Request $request, $id)
    {
        try {

            $data = $request->validate([
                'NombreArtePesca' => 'required|string|max:50'
            ]);

            $existeArtePesca = ArtePesca::where($data)->exists();
            if ($existeArtePesca) {
                return ApiResponse::error('El arte de pesca ya existe', 422);
            }

            $artePesca = ArtePesca::findOrFail($id);
            $artePesca->update($data);
            return ApiResponse::success('Arte de pesca actualizado exitosamente', 200, $artePesca);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Arte de pesca no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el Arte de pesca: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para eliminar un Arte de Pesca por su id
     */
    public function destroy($id)
    {
        try {
            $artePesca = ArtePesca::findOrFail($id);
            $artePesca->delete();
            return ApiResponse::success('Arte de pesca eliminado exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Arte de pesca no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el Arte de pesca: ' . $e->getMessage(), 500);
        }
    }
}
