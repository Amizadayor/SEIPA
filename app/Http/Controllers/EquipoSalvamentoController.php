<?php

namespace App\Http\Controllers;

use App\Models\EquipoSalvamento;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

class EquipoSalvamentoController extends Controller
{
    /**
     * Función para mostrar la lista de equipos de salvamento
     */
    public function index()
    {
        try {
            $equiposSalvamento = EquipoSalvamento::all();
            $result = $equiposSalvamento->map(function ($item) {
                return [
                    'id' => $item->id,
                    'NombreEquipoSalvamento' => $item->NombreEquipoSalvamento,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista Equipos de salvamento.', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de equipos de salvamento: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para crear un nuevo equipo de salvamento
     */
    public function store(Request $request)
    {
        try{
            $data = $request->validate([
                'NombreEquipoSalvamento' => 'required|string|max:50',
            ]);

            $existeEquipoSalvamento = EquipoSalvamento::where($data)->exists();
            if ($existeEquipoSalvamento) {
                return ApiResponse::error('El equipo de salvamento ya existe', 422);
            }

            $equipoSalvamento = EquipoSalvamento::create($data);
            return ApiResponse::success('Equipo de salvamento creado exitosamente', 201, $equipoSalvamento);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        }
    }

    /**
     * Función para mostrar un equipo de salvamento por id.
     */
    public function show($id)
    {
        try {
            $equiposSalvamento = EquipoSalvamento::findOrFail($id);
            $result = [
                'id' => $equiposSalvamento->id,
                'NombreEquipoSalvamento' => $equiposSalvamento->NombreEquipoSalvamento,
                'created_at' => $equiposSalvamento->created_at,
                'updated_at' => $equiposSalvamento->updated_at,
            ];
            return ApiResponse::success('Equipo de salvamento encontrado.', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de salvamento no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el equipo de salvamento: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para actualizar un equipo de salvamento por id.
     */
    public function update(Request $request, $id)
    {
        try{
            $data = $request->validate([
                'NombreEquipoSalvamento' => 'required|string|max:50',
            ]);

            $existeEquipoSalvamento = EquipoSalvamento::where($data)->exists();
            if ($existeEquipoSalvamento) {
                return ApiResponse::error('El equipo de salvamento ya existe', 422);
            }

            $equipoSalvamento = EquipoSalvamento::findOrFail($id);
            $equipoSalvamento->update($data);
            return ApiResponse::success('Equipo de salvamento actualizado exitosamente', 200, $equipoSalvamento);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de salvamento no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el equipo de salvamento: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para eliminar un equipo de salvamento por id.
     */
    public function destroy($id)
    {
        try{
            $equipoSalvamento = EquipoSalvamento::findOrFail($id);
            $equipoSalvamento->delete();
            return ApiResponse::success('Equipo de salvamento eliminado exitosamente', 200, $equipoSalvamento);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Equipo de salvamento no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el equipo de salvamento: ' . $e->getMessage(), 500);
        }
    }
}
