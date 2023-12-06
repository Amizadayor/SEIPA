<?php

namespace App\Http\Controllers;

use App\Models\SocioDetallePAMoral;
use App\Models\UnidadEconomicaPAMoral;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class SocioDetallePAMoralController extends Controller
{
    /**
     * Función para obtener la lista de Socios.
     */
    public function index()
    {
        try {
            $SociosDetallePAMoral = SocioDetallePAMoral::all();
            $result = $SociosDetallePAMoral->map(function ($item) {
                return [
                    'id' => $item->id,
                    'CURP' => $item->CURP,
                    'ActvPesca' => $item->ActvPesca,
                    'ActvAcuacultura' => $item->ActvAcuacultura,
                    'DocActaNacimiento' => $item->DocActaNacimiento,
                    'DocComprobanteDomicilio' => $item->DocComprobanteDomicilio,
                    'DocCURP' => $item->DocCURP,
                    'DocIdentificacionOfc' => $item->DocIdentificacionOfc,
                    'DocRFC' => $item->DocRFC,
                    'UEPAMid' => $item->UnidadEconomicaPAMoral->RazonSocial,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de Socios', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de Socios: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para registrar un nuevo Socio.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'CURP' => 'required|string|max:18',
                'ActvPesca' => 'required|boolean',
                'ActvAcuacultura' => 'required|boolean',
                'DocActaNacimiento' => 'required|string|max:255',
                'DocComprobanteDomicilio' => 'required|string|max:255',
                'DocCURP' => 'required|string|max:255',
                'DocIdentificacionOfc' => 'required|string|max:255',
                'DocRFC' => 'required|string|max:255',
                'UEPAMid' => 'required|integer',
            ]);


            $existeSocio = SocioDetallePAMoral::where('CURP', $request->CURP)
            ->first();
            if ($existeSocio) {
                return ApiResponse::error('Ya existe un Socio con la CURP: ' . $request->CURP, 409);
            }

            $SocioDetallePAMoral = SocioDetallePAMoral::create($request->all());
            return ApiResponse::success('Socio registrado', 201, $SocioDetallePAMoral);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al registrar el Socio: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para obtener un Socio por su ID.
     */
    public function show($id)
    {
        try {
            $SociosDetallePAMoral = SocioDetallePAMoral::findOrfail($id);
            $result = [
                'id' => $SociosDetallePAMoral->id,
                'CURP' => $SociosDetallePAMoral->CURP,
                'ActvPesca' => $SociosDetallePAMoral->ActvPesca,
                'ActvAcuacultura' => $SociosDetallePAMoral->ActvAcuacultura,
                'DocActaNacimiento' => $SociosDetallePAMoral->DocActaNacimiento,
                'DocComprobanteDomicilio' => $SociosDetallePAMoral->DocComprobanteDomicilio,
                'DocCURP' => $SociosDetallePAMoral->DocCURP,
                'DocIdentificacionOfc' => $SociosDetallePAMoral->DocIdentificacionOfc,
                'DocRFC' => $SociosDetallePAMoral->DocRFC,
                'UEPAMid' => $SociosDetallePAMoral->UnidadEconomicaPAMoral->RazonSocial,
                'created_at' => $SociosDetallePAMoral->created_at,
                'updated_at' => $SociosDetallePAMoral->updated_at,
            ];
            return ApiResponse::success('Socio obtenido', 200, $result);
        }   catch (ModelNotFoundException $e) {
            return ApiResponse::error('Socio no encontrado: ' . $e->getMessage(), 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el Socio: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para actualizar un Socio por su ID.
     */
    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'CURP' => 'required|string|max:18',
                'ActvPesca' => 'required|boolean',
                'ActvAcuacultura' => 'required|boolean',
                'DocActaNacimiento' => 'required|string|max:255',
                'DocComprobanteDomicilio' => 'required|string|max:255',
                'DocCURP' => 'required|string|max:255',
                'DocIdentificacionOfc' => 'required|string|max:255',
                'DocRFC' => 'required|string|max:255',
                'UEPAMid' => 'required|integer',
            ]);

            $existeSocio = SocioDetallePAMoral::where('CURP', $request->CURP)
            ->first();
            if ($existeSocio) {
                return ApiResponse::error('Ya existe un Socio con la CURP: ' . $request->CURP, 409);
            }

            $SocioDetallePAMoral = SocioDetallePAMoral::findOrfail($id);
            $SocioDetallePAMoral->update($request->all());
            return ApiResponse::success('Socio actualizado', 200, $SocioDetallePAMoral);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Socio no encontrado: ' . $e->getMessage(), 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el Socio: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para eliminar un Socio por su ID.
     */
    public function destroy($id)
    {
        try {
            $SocioDetallePAMoral = SocioDetallePAMoral::findOrfail($id);
            $SocioDetallePAMoral->delete();
            return ApiResponse::success('Socio eliminado', 200, $SocioDetallePAMoral);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Socio no encontrado: ' . $e->getMessage(), 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el Socio: ' . $e->getMessage(), 500);
        }
    }
}
