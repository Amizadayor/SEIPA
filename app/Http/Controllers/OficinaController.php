<?php

namespace App\Http\Controllers;

use App\Models\Oficina;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

class OficinaController extends Controller
{
    /**
     * Función que obtener todos las oficinas.
     */
    public function index()
    {
        try {
            $oficinas = Oficina::all();
            $result = $oficinas->map(function ($item) {
                return [
                    'id' => $item->id,
                    'NombreOficina' => $item->NombreOficina,
                    'Ubicacion' => $item->Ubicacion,
                    'Telefono' => $item->Telefono,
                    'Email' => $item->Email,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de oficinas', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de oficinas: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para crear una nueva Oficina
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'NombreOficina' => 'required|string|max:50',
                'Ubicacion' => 'required|string|max:100',
                'Telefono' => 'required|string|max:10',
                'Email' => 'required|string|max:40'
            ]);

            $existeOficina = Oficina::where('NombreOficina', $request->NombreOficina)
                ->where('Ubicacion', $request->Ubicacion)
                ->where('Telefono', $request->Telefono)
                ->where('Email', $request->Email)
                ->first();
            if ($existeOficina) {
                return ApiResponse::error('La oficina ya existe', 422);
            }

            $oficina = Oficina::create($request->all());
            return ApiResponse::success('Oficina creada exitosamente', 201, $oficina);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear la oficina: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función que obtiene una oficina por su id.
     */
    public function show($id)
    {
        try {
            $oficina = Oficina::findOrFail($id);
            $result = [
                'id' => $oficina->id,
                'NombreOficina' => $oficina->NombreOficina,
                'Ubicacion' => $oficina->Ubicacion,
                'Telefono' => $oficina->Telefono,
                'Email' => $oficina->Email,
                'created_at' => $oficina->created_at,
                'updated_at' => $oficina->updated_at,
            ];
            return ApiResponse::success('Oficina obtenida exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Oficina no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la oficina: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para actualizar una oficina.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'NombreOficina' => 'required|string|max:50',
                'Ubicacion' => 'required|string|max:100',
                'Telefono' => 'required|string|max:10',
                'Email' => 'required|string|max:40'
            ]);

            $existeOficina = Oficina::where('NombreOficina', $request->NombreOficina)
                ->where('Ubicacion', $request->Ubicacion)
                ->where('Telefono', $request->Telefono)
                ->where('Email', $request->Email)
                ->first();
            if ($existeOficina) {
                return ApiResponse::error('La oficina ya existe', 422);
            }

            $oficina = Oficina::findOrFail($id);
            $oficina->update($request->all());
            return ApiResponse::success('Oficina actualizada exitosamente', 200, $oficina);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Oficina no encontrada', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar la oficina: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para eliminar una oficina.
     */
    public function destroy($id)
    {
        try {
            $oficina = Oficina::findOrFail($id);
            $oficina->delete();
            return ApiResponse::success('Oficina eliminada exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Oficina no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar la oficina: ' . $e->getMessage(), 500);
        }
    }
}
