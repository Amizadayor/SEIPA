<?php

namespace App\Http\Controllers;

use App\Models\Distrito;
use App\Models\Region;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

class DistritoController extends Controller
{
    /**
     * Función que obtener todos los distritos.
     */
    public function index()
    {
        try {
            $distritos = Distrito::all();
            $result = $distritos->map(function ($item) {
                return [
                    'id' => $item->id,
                    'NombreDistrito' => $item->NombreDistrito,
                    'Regid' => $item->region->NombreRegion,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los distritos', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de distritos: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para crear un nuevo Distrito
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'NombreDistrito' => 'required|string|max:40',
                'Regid' => 'required|exists:regiones,id'
            ]);

            $existeRegion = Distrito::where('NombreDistrito', $request->NombreDistrito)
                ->where('Regid', $request->Regid)
                ->first();
            if ($existeRegion) {
                return ApiResponse::error('El distrito ya existe en esta región', 422);
            }

            $distrito = Distrito::create($request->all());
            return ApiResponse::success('Distrito creado exitosamente', 201, $distrito);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el distrito: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para obtener un distrito por su id.
     */
    public function show($id)
    {
        try {
            $distrito = Distrito::findOrFail($id);
            $result = [
                'id' => $distrito->id,
                'NombreDistrito' => $distrito->NombreDistrito,
                'Regionid' => $distrito->region->NombreRegion,
                'created_at' => $distrito->created_at,
                'updated_at' => $distrito->updated_at,
            ];
            return ApiResponse::success('Distrito obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Distrito no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el distrito: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para actualizar un distrito por su id.
     */
    public function update(Request $request, $id)
    {
        try {
            $distrito = Distrito::findOrFail($id);
            $request->validate([
                'NombreDistrito' => 'required|string|max:40',
                'Regid' => 'required|exists:regiones,id'
            ]);

            $existeDistrito = Distrito::where('NombreDistrito', $request->NombreDistrito)
                ->where('Regid', $request->Regid)
                ->first();
            if ($existeDistrito) {
                return ApiResponse::error('El distrito ya existe en esta región', 422);
            }

            $distrito->update($request->all());
            return ApiResponse::success('Distrito actualizado exitosamente', 200, $distrito);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Distrito no encontrado', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el distrito: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para eliminar un distrito por su id.
     */
    public function destroy($id)
    {
        try {
            $distrito = Distrito::findOrFail($id);
            $distrito->delete();
            return ApiResponse::success('Distrito eliminado exitosamente', 200, $distrito);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Distrito no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el distrito: ' . $e->getMessage(), 500);
        }
    }
}
