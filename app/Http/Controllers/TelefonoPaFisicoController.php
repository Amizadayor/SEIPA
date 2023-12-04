<?php

namespace App\Http\Controllers;

use App\Models\TelefonoPaFisico;
use App\Models\UnidadEconomicaPAFisico;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class TelefonoPaFisicoController extends Controller
{
    /**
     *  Función que retorna todos los teléfonos de una unidad económica de persona física
     */
    public function index()
    {
        try {
            $telefonospafis = TelefonoPaFisico::all();
            $result = $telefonospafis->map(function ($item) {
                return [
                    'id' => $item->id,
                    'Numero' => $item->Numero,
                    'Principal' => $item->Principal,
                    'Tipo' => $item->Tipo,
                    'UEPAFid' => $item->UEPAFid,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de Telefonos', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de Telefonos: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para crear un nuevo Telefono
     */
    public function store(Request $request)
    {

        try {
            $request->validate([
                'Numero' => 'required|string|max:10',
                'Principal' => 'required|boolean',
                'Tipo' => 'required|string|max:20',
            ]);

            // se obtiene última unidad económica creada
            $ultimaUEPAF = UnidadEconomicaPAFisico::latest()->first();

            if (!$ultimaUEPAF) {
                return ApiResponse::error('No hay ninguna unidad económica disponible', 422);
            }

            // Verifica si ya existe un teléfono principal para la unidad económica
            $existePrincipal = TelefonoPaFisico::where('UEPAFid', $ultimaUEPAF->id)
            ->where('Principal', true)
            ->exists();

            if ($request->Principal && $existePrincipal) {
                return ApiResponse::error('Ya hay un teléfono principal para esta unidad económica', 422);
            }

            //se asocia el nuevo teléfono a la última unidad económica creada
            $telefonosPaFisico = new TelefonoPaFisico([
                'Numero' => $request->Numero,
                'Principal' => $request->Principal,
                'Tipo' => $request->Tipo,
                'UEPAFid' => $ultimaUEPAF->id,
            ]);

            $telefonosPaFisico->save();

            return ApiResponse::success('Teléfono creado exitosamente', 201, $telefonosPaFisico);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422);
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear el Teléfono: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para obtener un Telefono por su id
     */
    public function show($id)
    {
        try {
            $telefonoPaFisico = TelefonoPaFisico::findOrFail($id);
            $result = [
                'id' => $telefonoPaFisico->id,
                'Numero' => $telefonoPaFisico->Numero,
                'Principal' => $telefonoPaFisico->Principal,
                'Tipo' => $telefonoPaFisico->Tipo,
                'UEPAFid' => $telefonoPaFisico->UEPAFid,
                'created_at' => $telefonoPaFisico->created_at,
                'updated_at' => $telefonoPaFisico->updated_at,
            ];
            return ApiResponse::success('Telefono obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Telefono no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el Telefono: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para actualizar un Telefono por su id
     */
    public function update(Request $request, $id)
    {
        try {
            $telefonosPaFisico = TelefonoPaFisico::findOrFail($id);

            // Validar los campos que se pueden editar
            $request->validate([
                'Numero' => 'required|string|max:10',
                'Principal' => 'required|boolean',
                'Tipo' => 'required|string|max:20',
            ]);

            // Verificar si se está intentando marcar como principal y ya hay un principal
            if ($request->Principal && TelefonoPaFisico::where('UEPAFid', $telefonosPaFisico->UEPAFid)
            ->where('Principal', true)
            ->where('id', '!=', $id)
            ->exists()) {
                return ApiResponse::error('Ya existe un teléfono principal para esta unidad económica', 422);
            }

            // Actualizar los campos permitidos
            $telefonosPaFisico->update([
                'Numero' => $request->Numero,
                'Principal' => $request->Principal,
                'Tipo' => $request->Tipo,
            ]);

            return ApiResponse::success('Teléfono actualizado exitosamente', 200, $telefonosPaFisico);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Teléfono no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el Teléfono: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para eliminar un Telefono por su id
     */
    public function destroy($id)
    {
        try {
            $telefonoPaFisico = TelefonoPaFisico::findOrFail($id);
            $telefonoPaFisico->delete();
            return ApiResponse::success('Telefono eliminado exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Telefono no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el Telefono: ' . $e->getMessage(), 500);
        }
    }
}
