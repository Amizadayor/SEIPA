<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

class ProductoController extends Controller
{
    /**
     * Función para mostrar la lista de productos
     */
    public function index()
    {
        try {
            $productos = Producto::all();
            $result = $productos->map(function ($item) {
                return [
                    'id' => $item->id,
                    'NombreComun' => $item->NombreComun,
                    'NombreCientifico' => $item->NombreCientifico,
                    'TPEspecieid' => $item->especie->NombreEspecie,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los productos', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de productos: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para crear un nuevo producto
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'NombreComun' => 'required|string|max:50',
                'NombreCientifico' => 'required|string|max:50',
                'TPEspecieid' => 'required|integer',
            ]);

            // Verifica la existencia del producto por su nombre común o científico
            $existeProducto = Producto::where('NombreComun', $data['NombreComun'])
                ->orWhere('NombreCientifico', $data['NombreCientifico'])
                ->first();

            if ($existeProducto) {
                $errors = [];
                if ($existeProducto->NombreComun === $data['NombreComun']) {
                    $errors['NombreComun'] = ['El nombre común ya existe'];
                }
                if ($existeProducto->NombreCientifico === $data['NombreCientifico']) {
                    $errors['NombreCientifico'] = ['El nombre científico ya existe'];
                }
                return ApiResponse::error('El producto ya existe', 422, $errors);
            }

            $producto = Producto::create($data);
            return ApiResponse::success('Producto creado exitosamente', 201, $producto);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear un producto: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para mostrar un producto por su id
     */
    public function show($id)
    {
        try {
            $producto = Producto::findOrFail($id);
            $result = [
                'id' => $producto->id,
                'NombreComun' => $producto->NombreComun,
                'NombreCientifico' => $producto->NombreCientifico,
                'TPEspecieid' => $producto->especie->NombreEspecie,
                'created_at' => $producto->created_at,
                'updated_at' => $producto->updated_at,
            ];
            return ApiResponse::success('Producto obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('El producto no existe', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener un producto: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para actualizar un producto por su id
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'NombreComun' => 'required|string|max:50',
                'NombreCientifico' => 'required|string|max:50',
                'TPEspecieid' => 'required|integer',
            ]);

            // Verifica la existencia del producto por su nombre común o científico
            $existeProducto = Producto::where('NombreComun', $data['NombreComun'])
                ->orWhere('NombreCientifico', $data['NombreCientifico'])
                ->first();

            if ($existeProducto) {
                $errors = [];
                if ($existeProducto->NombreComun === $data['NombreComun']) {
                    $errors['NombreComun'] = ['El nombre común ya existe'];
                }
                if ($existeProducto->NombreCientifico === $data['NombreCientifico']) {
                    $errors['NombreCientifico'] = ['El nombre científico ya existe'];
                }
                return ApiResponse::error('El producto ya existe', 422, $errors);
            }

            $producto = Producto::findOrFail($id);
            $producto->update($data);
            return ApiResponse::success('Producto actualizado exitosamente', 200, $producto);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('El producto no existe', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar un producto: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para eliminar un producto por su id
     */
    public function destroy($id)
    {
        try {
            $producto = Producto::findOrFail($id);
            $producto->delete();
            return ApiResponse::success('Producto eliminado exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('El producto no existe', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar un producto: ' . $e->getMessage(), 500);
        }
    }
}
