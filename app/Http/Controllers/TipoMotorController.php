<?php

namespace App\Http\Controllers;

use App\Models\TipoMotor;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use App\Http\Responses\ApiResponse;
use Exception;

class TipoMotorController extends Controller
{
    /**
     * Función para mostrar la lista de tipos de motor
     */
    public function index()
    {
        try{
            $tiposmotor = TipoMotor::all();
            $result = $tiposmotor->map(function ($item) {
                return [
                    'id' => $item->id,
                    'NombreTipoMotor' => $item->NombreTipoMotor,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los tipos de motor', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de tipos de motor: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para crear un nuevo tipo de motor
     */
    public function store(Request $request)
    {
        try{
            $data = $request->validate([
                'NombreTipoMotor' => 'required|string|max:50',
            ]);

            $existeTipoMotor = TipoMotor::where($data)->exists();
            if ($existeTipoMotor) {
                return ApiResponse::error('El tipo de motor ya existe', 422);
            }

            $tipomotor = TipoMotor::create($data);
            return ApiResponse::success('Tipo de motor creado exitosamente', 201, $tipomotor);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        }
    }

    /**
     * Función para mostrar un tipo de motor por id.
     */
    public function show($id)
    {
        try{
            $tipomotor = TipoMotor::findOrFail($id);
            $result = [
                'id' => $tipomotor->id,
                'NombreTipoMotor' => $tipomotor->NombreTipoMotor,
                'created_at' => $tipomotor->created_at,
                'updated_at' => $tipomotor->updated_at,
            ];

            return ApiResponse::success('Tipo de motor obtenido exitosamente', 200, $tipomotor);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de motor no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el tipo de motor: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para actualizar un tipo de motor por id.
     */
    public function update(Request $request, $id)
    {
        try{
            $data = $request->validate([
                'NombreTipoMotor' => 'required|string|max:50',
            ]);

            $existeTipoMotor = TipoMotor::where($data)->exists();
            if ($existeTipoMotor) {
                return ApiResponse::error('El tipo de motor ya existe', 422);
            }

            $tipomotor = TipoMotor::findOrFail($id);
            $tipomotor->update($data);
            return ApiResponse::success('Tipo de motor actualizado exitosamente', 200, $tipomotor);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de motor no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el tipo de motor: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para eliminar un tipo de motor por id.
     */
    public function destroy($id)
    {
        try{
            $tipomotor = TipoMotor::findOrFail($id);
            $tipomotor->delete();
            return ApiResponse::success('Tipo de motor eliminado exitosamente', 200, $tipomotor);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Tipo de motor no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el tipo de motor: ' . $e->getMessage(), 500);
        }
    }
}
