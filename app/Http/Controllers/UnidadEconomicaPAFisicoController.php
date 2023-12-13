<?php

namespace App\Http\Controllers;

use App\Models\UnidadEconomicaPAFisico;
use App\Models\Oficina;
use App\Models\Localidad;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class UnidadEconomicaPAFisicoController extends Controller
{
    /**
     * Función para obtener la lista de unidades economicas.
     */
    public function index()
    {
        try {
            $UEPAF = UnidadEconomicaPAFisico::all();
            $result = $UEPAF->map(function ($item) {
                return [
                    'id' => $item->id,
                    'Ofcid' => $item->oficina->NombreOficina,
                    'FechaRegistro' => $item->FechaRegistro,
                    'RNPA' => $item->RNPA,
                    'CURP' => $item->CURP,
                    'RFC' => $item->RFC,
                    'Nombres' => $item->Nombres,
                    'ApPaterno' => $item->ApPaterno,
                    'ApMaterno' => $item->ApMaterno,
                    'FechaNacimiento' => $item->FechaNacimiento,
                    'Sexo' => $item->Sexo,
                    'GrupoSanguineo' => $item->GrupoSanguineo,
                    'Email' => $item->Email,
                    'Calle' => $item->Calle,
                    'NmExterior' => $item->NmExterior,
                    'NmInterior' => $item->NmInterior,
                    'CodigoPostal' => $item->CodigoPostal,
                    'Locid' => $item->localidad->NombreLocalidad,
                    'Municipio' => $item->localidad->municipio->NombreMunicipio,
                    'Distrito' => $item->localidad->municipio->distrito->NombreDistrito,
                    'Región' => $item->localidad->municipio->distrito->region->NombreRegion,
                    'NmPrincipal' => $item->NmPrincipal,
                    'TpNmPrincipal' => $item->TpNmPrincipal,
                    'NmSecundario' => $item->NmSecundario,
                    'TpNmSecundario' => $item->TpNmSecundario,
                    'IniOperaciones' => $item->IniOperaciones,
                    'ActivoEmbMayor' => $item->ActivoEmbMayor ? 'Si' : 'No',
                    'ActivoEmbMenor' => $item->ActivoEmbMenor ? 'Si' : 'No',
                    'ActvAcuacultura' => $item->ActvAcuacultura ? 'Si' : 'No',
                    'ActvPesca' => $item->ActvPesca ? 'Si' : 'No',
                    'DocActaNacimiento' => $item->DocActaNacimiento,
                    'DocComprobanteDomicilio' => $item->DocComprobanteDomicilio,
                    'DocCURP' => $item->DocCURP,
                    'DocIdentificacionOfc' => $item->DocIdentificacionOfc,
                    'DocRFC' => $item->DocRFC,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de unidades economicas', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de unidades economicas: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para crear una unidad economica.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'Ofcid' => 'required|exists:oficinas,id',
                'FechaRegistro' => 'required|date',
                'RNPA' => 'required|string|max:50',
                'CURP' => 'required|string|max:18',
                'RFC' => 'required|string|max:13',
                'Nombres' => 'required|string|max:50',
                'ApPaterno' => 'required|string|max:30',
                'ApMaterno' => 'required|string|max:30',
                'FechaNacimiento' => 'required|date',
                'Sexo' => 'required|string|max:1',
                'GrupoSanguineo' => 'required|string|max:4',
                'Email' => 'required|string|max:40',
                'Calle' => 'required|string|max:100',
                'NmExterior' => 'required|string|max:6',
                'NmInterior' => 'nullable|string|max:6',
                'CodigoPostal' => 'required|string|max:10',
                'Locid' => 'required|exists:localidades,id',
                'NmPrincipal' => 'required|string|max:10',
                'TpNmPrincipal' => 'required|string|max:20',
                'NmSecundario' => 'required|string|max:10',
                'TpNmSecundario' => 'required|string|max:20',
                'IniOperaciones' => 'required|date',
                'ActivoEmbMayor' => 'required|boolean',
                'ActivoEmbMenor' => 'required|boolean',
                'ActvAcuacultura' => 'required|boolean',
                'ActvPesca' => 'required|boolean',
                'DocActaNacimiento' => 'required|string|max:255',
                'DocComprobanteDomicilio' => 'required|string|max:255',
                'DocCURP' => 'required|string|max:255',
                'DocIdentificacionOfc' => 'required|string|max:255',
                'DocRFC' => 'required|string|max:255'
            ]);

            // Verifica la existencia de la unidad economica por su CURP,
            // FALTA LA VALIDACIÓN PARA CREAR 2 UNIDADES ECONOMICAS CON LA MISMA CURP, PERO LA ACTIVIDAD PESCA Y ACUACULTURA DEBE SER DIFERENTE

            $existeUEPAF = UnidadEconomicaPAFisico::where('CURP', $data['CURP'])->first();
            if ($existeUEPAF) {
                $errors = [];
                if ($existeUEPAF->CURP === $data['CURP']) {
                    $errors['CURP'] = 'El CURP ya está registrado en una Unidad Economica.';
                }
                return ApiResponse::error('La Unidad Economica ya existe', 422, $errors);
            }

            $UEPAF = UnidadEconomicaPAFisico::create($data);
            return ApiResponse::success('Unidad economica creada exitosamente', 201, $UEPAF);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear la unidad economica: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para obtener una unidad economica por id.
     */
    public function show($id)
    {
        try {
            $UEPAF = UnidadEconomicaPAFisico::findOrFail($id);
            $result = [
                'id' => $UEPAF->id,
                'Oficina' => $UEPAF->oficina->NombreOficina,
                'FechaRegistro' => $UEPAF->FechaRegistro,
                'RNPA' => $UEPAF->RNPA,
                'CURP' => $UEPAF->CURP,
                'RFC' => $UEPAF->RFC,
                'Nombres' => $UEPAF->Nombres,
                'ApPaterno' => $UEPAF->ApPaterno,
                'ApMaterno' => $UEPAF->ApMaterno,
                'FechaNacimiento' => $UEPAF->FechaNacimiento,
                'Sexo' => $UEPAF->Sexo,
                'GrupoSanguineo' => $UEPAF->GrupoSanguineo,
                'Email' => $UEPAF->Email,
                'Calle' => $UEPAF->Calle,
                'NmExterior' => $UEPAF->NmExterior,
                'NmInterior' => $UEPAF->NmInterior,
                'CodigoPostal' => $UEPAF->CodigoPostal,
                'Localidad' => $UEPAF->localidad->NombreLocalidad,
                'Municipio' => $UEPAF->localidad->municipio->NombreMunicipio,
                'Distrito' => $UEPAF->localidad->municipio->distrito->NombreDistrito,
                'Región' => $UEPAF->localidad->municipio->distrito->region->NombreRegion,
                'NmPrincipal' => $UEPAF->NmPrincipal,
                'TpNmPrincipal' => $UEPAF->TpNmPrincipal,
                'NmSecundario' => $UEPAF->NmSecundario,
                'TpNmSecundario' => $UEPAF->TpNmSecundario,
                'IniOperaciones' => $UEPAF->IniOperaciones,
                'ActivoEmbMayor' => $UEPAF->ActivoEmbMayor ? 'Si' : 'No',
                'ActivoEmbMenor' => $UEPAF->ActivoEmbMenor ? 'Si' : 'No',
                'ActvAcuacultura' => $UEPAF->ActvAcuacultura ? 'Si' : 'No',
                'ActvPesca' => $UEPAF->ActvPesca ? 'Si' : 'No',
                'DocActaNacimiento' => $UEPAF->DocActaNacimiento,
                'DocComprobanteDomicilio' => $UEPAF->DocComprobanteDomicilio,
                'DocCURP' => $UEPAF->DocCURP,
                'DocIdentificacionOfc' => $UEPAF->DocIdentificacionOfc,
                'DocRFC' => $UEPAF->DocRFC,
                'created_at' => $UEPAF->created_at,
                'updated_at' => $UEPAF->updated_at,
            ];
            return ApiResponse::success('Unidad Económica obtenida exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Unidad Económica no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la Unidad Económica: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para actualizar una unidad economica por id.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                //'Ofcid' => 'required|exists:oficinas,id',
                'Ofcid' => 'required',
                'FechaRegistro' => 'required|date',
                'RNPA' => 'required|string|max:50',
                'CURP' => 'required|string|max:18',
                'RFC' => 'required|string|max:13',
                'Nombres' => 'required|string|max:50',
                'ApPaterno' => 'required|string|max:30',
                'ApMaterno' => 'required|string|max:30',
                'FechaNacimiento' => 'required|date',
                'Sexo' => 'required|string|max:1',
                'GrupoSanguineo' => 'required|string|max:4',
                'Email' => 'required|string|max:40',
                'Calle' => 'required|string|max:100',
                'NmExterior' => 'required|string|max:6',
                'NmInterior' => 'required|string|max:6',
                'CodigoPostal' => 'required|string|max:10',
                //'Locid' => 'required|exists:localidades,id',
                'Locid' => 'required',
                'NmPrincipal' => 'required|string|max:10',
                'TpNmPrincipal' => 'required|string|max:20',
                'NmSecundario' => 'required|string|max:10',
                'TpNmSecundario' => 'required|string|max:20',
                'IniOperaciones' => 'required|date',
                'ActivoEmbMayor' => 'required|boolean',
                'ActivoEmbMenor' => 'required|boolean',
                'ActvAcuacultura' => 'required|boolean',
                'ActvPesca' => 'required|boolean',
                'DocActaNacimiento' => 'required|string|max:255',
                'DocComprobanteDomicilio' => 'required|string|max:255',
                'DocCURP' => 'required|string|max:255',
                'DocIdentificacionOfc' => 'required|string|max:255',
                'DocRFC' => 'required|string|max:255'
            ]);

            $existeUEPAF = UnidadEconomicaPAFisico::where('RNPA', $request->RNPA)
                ->where('FechaRegistro', $request->FechaRegistro)
                ->where('Ofcid', $request->Ofcid)
                ->where('id', '!=', $id)
                ->first();
            if ($existeUEPAF) {
                return ApiResponse::error('La unidad economica ya existe en esta oficina', 422);
            }

            $UEPAF = UnidadEconomicaPAFisico::findOrFail($id);
            $UEPAF->update($request->all());
            return ApiResponse::success('Unidad Económica actualizada exitosamente', 200, $UEPAF);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Unidad Económica no encontrada', 404);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación, revise sus datos: ' . $e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar la Unidad Económica: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para eliminar una unidad economica por id.
     */
    public function destroy($id)
    {
        try {
            $UEPAF = UnidadEconomicaPAFisico::findOrFail($id);
            $UEPAF->delete();
            return ApiResponse::success('Unidad Economica eliminada exitosamente', 200, $UEPAF);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Unidad Economica no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar la Unidad Economica: ' . $e->getMessage(), 500);
        }
    }
}
