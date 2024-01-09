<?php

namespace App\Http\Controllers;

use App\Models\EquipoContraincendio;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

class EquipoContraincendioController extends Controller
{
    /**
     * Función para mostrar la lista de equipos de contraincendio
     */
    public function index()
    {
        try{
            $equiposContraincendio = EquipoContraincendio::all();
            $result = $equiposContraincendio->map(function($item){
                return [
                    'id' => $item->id,
                    'NombreEquipoContraincendio' => $item->NombreEquipoContraincendio,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los equipos de contraincendio.', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de equipos de contraincendio: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para crear un nuevo equipo de contraincendio
     */
    public function store(Request $request)
    {
        try{
            $data = $request->validate([
                'NombreEquipoContraincendio' => 'required|string|max:50|alpha',
            ]);

            $existeEquipoContraincendio = EquipoContraincendio::where($data)->exists();
            if($existeEquipoContraincendio){
                return ApiResponse::error('El equipo de contraincendio ya existe', 422);
            }

            $EquipoContraincendio = EquipoContraincendio::create($data);
            return ApiResponse::success('Equipo de contraincendio creado exitosamente', 201, $EquipoContraincendio);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        }
    }

    /**
     * Función para mostrar un equipo de contraincendio por id.
     */
    public function show($id)
    {
        try{
            $EquipoContraincendio = EquipoContraincendio::findOrFail($id);
            $result = [
                'id' => $EquipoContraincendio->id,
                'NombreEquipoContraincendio' => $EquipoContraincendio->NombreEquipoContraincendio,
                'created_at' => $EquipoContraincendio->created_at,
                'updated_at' => $EquipoContraincendio->updated_at,
            ];

            return ApiResponse::success('Equipo de contraincendio obtenido exitosamente.', 200, $EquipoContraincendio);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Error al obtener el equipo de contraincendio: ' . $e->getMessage(), 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el equipo de contraincendio: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para actualizar un equipo de contraincendio por id.
     */
    public function update(Request $request, $id)
    {
        try{
            $data = $request->validate([
                'NombreEquipoContraincendio' => 'required|string|max:50|alpha',
            ]);

            $existeEquipoContraincendio = EquipoContraincendio::where($data)->exists();
            if($existeEquipoContraincendio){
                return ApiResponse::error('El equipo de contraincendio ya existe', 422);
            }

            $EquipoContraincendio = EquipoContraincendio::findOrFail($id);
            $EquipoContraincendio->update($data);
            return ApiResponse::success('Equipo de contraincendio actualizado exitosamente.', 200, $EquipoContraincendio);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Error al obtener el equipo de contraincendio: ' . $e->getMessage(), 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el equipo de contraincendio: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para eliminar un equipo de contraincendio por id.
     */
    public function destroy($id)
    {
        try{
            $EquipoContraincendio = EquipoContraincendio::findOrFail($id);
            $EquipoContraincendio->delete();
            return ApiResponse::success('Equipo de contraincendio eliminado exitosamente.', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Error al obtener el equipo de contraincendio: ' . $e->getMessage(), 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el equipo de contraincendio: ' . $e->getMessage(), 500);
        }
    }
}
