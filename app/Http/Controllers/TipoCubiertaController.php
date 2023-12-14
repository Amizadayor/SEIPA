<?php

namespace App\Http\Controllers;

use App\Models\TipoCubierta;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use App\Http\Responses\ApiResponse;
use Exception;

class TipoCubiertaController extends Controller
{
    /**
     * Función para mostrar la lista de tipos de cubierta
     */
    public function index()
    {
        try{
            $tiposcubierta = TipoCubierta::all();
            $result = $tiposcubierta->map(function ($item) {
                return [
                    'id' => $item->id,
                    'NombreCubierta' => $item->NombreCubierta,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los tipos de cubierta', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de tipos de cubierta: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para crear un nuevo tipo de cubierta
     */
    public function store(Request $request)
    {
        try{
            $data = $request->validate([
                'NombreCubierta' => 'required|string|max:50',
            ]);

            $existeTipoCubierta = TipoCubierta::where($data)->exists();
            if ($existeTipoCubierta) {
                return ApiResponse::error('El tipo de cubierta ya existe', 422);
            }

            $tipocubierta = TipoCubierta::create($data);
            return ApiResponse::success('Tipo de cubierta creada exitosamente', 201, $tipocubierta);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        }
    }

    /**
     * Función para mostrar un tipo de cubierta por id.
     */
    public function show($id)
    {
        try{
            $tipocubierta = TipoCubierta::findOrFail($id);
            $result = [
                'id' => $tipocubierta->id,
                'NombreCubierta' => $tipocubierta->NombreCubierta,
                'created_at' => $tipocubierta->created_at,
                'updated_at' => $tipocubierta->updated_at,
            ];
            return ApiResponse::success('Tipo de cubierta obtenida exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de cubierta no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el tipo de cubierta: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para actualizar un tipo de cubierta por id.
     */
    public function update(Request $request, $id)
    {
        try{
            $data = $request->validate([
                'NombreCubierta' => 'required|string|max:50',
            ]);

            $existeTipoCubierta = TipoCubierta::where($data)->exists();
            if ($existeTipoCubierta) {
                return ApiResponse::error('El tipo de cubierta ya existe', 422);
            }

            $tipocubierta = TipoCubierta::findOrFail($id);
            $tipocubierta->update($data);
            return ApiResponse::success('Tipo de cubierta actualizada exitosamente', 200, $tipocubierta);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de cubierta no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el tipo de cubierta: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para eliminar un tipo de cubierta por id.
     */
    public function destroy($id)
    {
        try{
            $tipocubierta = TipoCubierta::findOrFail($id);
            $tipocubierta->delete();
            return ApiResponse::success('Tipo de cubierta eliminada exitosamente', 200, $tipocubierta);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de cubierta no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el tipo de cubierta: ' . $e->getMessage(), 500);
        }
    }
}
