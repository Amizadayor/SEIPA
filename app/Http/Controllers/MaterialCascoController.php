<?php

namespace App\Http\Controllers;

use App\Models\MaterialCasco;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class MaterialCascoController extends Controller
{
    /**
     * Función para mostrar la lista de materiales de casco
     */
    public function index()
    {
        try{
            $materialescasco = MaterialCasco::all();
            $result = $materialescasco->map(function($item){
                return [
                    'id' => $item->id,
                    'NombreMaterialCasco' => $item->NombreMaterialCasco,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los materiales de casco', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de materiales de casco: ' , 500);
        }
    }

    /**
     * Función para crear un nuevo material de casco
     */
    public function store(Request $request)
    {
        try{
            $data = $request->validate([
                'NombreMaterialCasco' => 'required|string|max:50|alpha',
            ]);

            $existematerialcasco = MaterialCasco::where($data)->exists();
            if ($existematerialcasco) {
                return ApiResponse::error('El material de casco ya existe', 422);
            }

            $materialcasco = MaterialCasco::create($data);
            return ApiResponse::success('Material de casco creado exitosamente', 201, $materialcasco);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ', 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el material de casco: ' , 500);
        }
    }

    /**
     * Función para mostrar un material de casco por id
     */
    public function show($id)
    {
        try{
            $materialcasco = MaterialCasco::findOrFail($id);
            $result = [
                'id' => $materialcasco->id,
                'NombreMaterialCasco' => $materialcasco->NombreMaterialCasco,
                'created_at' => $materialcasco->created_at,
                'updated_at' => $materialcasco->updated_at,
            ];
            return ApiResponse::success('Material de casco obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Material de casco no encontrado.', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el material de casco: ' , 500);
        }
    }

    /**
     * Función para actualizar un material de casco por id
     */
    public function update(Request $request, $id)
    {
        try{
            $data = $request->validate([
                'NombreMaterialCasco' => 'required|string|max:50|alpha',
            ]);

            $existematerialcasco = MaterialCasco::where('id', '!=', $id)->where($data)->exists();
            if ($existematerialcasco) {
                return ApiResponse::error('El material de casco ya existe', 422);
            }

            $materialcasco = MaterialCasco::findOrFail($id);
            $materialcasco->update($data);
            return ApiResponse::success('Material de casco actualizado exitosamente', 200, $materialcasco);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ', 422, $e->errors());
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Material de casco no encontrado.', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el material de casco: ' , 500);
        }
    }

    /**
     * Función para eliminar un material de casco por id
     */
    public function destroy($id)
    {
        try{
            $materialcasco = MaterialCasco::findOrFail($id);
            $materialcasco->delete();
            return ApiResponse::success('Material de casco eliminado exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Material de casco no encontrado.', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el material de casco: ' , 500);
        }
    }
}
