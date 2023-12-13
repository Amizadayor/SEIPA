<?php

namespace App\Http\Controllers;

use App\Models\UnidadEconomicaPAMoral;
use App\Models\Oficina;
use App\Models\Localidad;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class UnidadEconomicaPAMoralController extends Controller
{
    /**
     * Función para obtener la lista de unidades económicas de personas morales.
     */
    public function index()
    {
        try {
            $UEPAM = UnidadEconomicaPAMoral::all();
            $result = $UEPAM->map(function ($item) {
                return [
                    'id' => $item->id,
                    'UEDuenoid' => $item->unidadEconomicaPaFisico->Nombres . ' ' . $item->unidadEconomicaPaFisico->ApPaterno . ' ' . $item->unidadEconomicaPaFisico->ApMaterno,
                    'Ofcid' => $item->oficina->NombreOficina,
                    'FechaRegistro' => $item->FechaRegistro,
                    'RNPA' => $item->RNPA,
                    'RFC' => $item->RFC,
                    'RazonSocial' => $item->RazonSocial,
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
                    'CantidadPescadores' => $item->CantidadPescadores,
                    'ActvAcuacultura' => $item->ActvAcuacultura ? 'Si' : 'No',
                    'ActvPesca' => $item->ActvPesca ? 'Si' : 'No',
                    'DocRepresentanteLegal' => $item->DocRepresentanteLegal,
                    'DocActaConstitutiva' => $item->DocActaConstitutiva,
                    'DocActaAsamblea' => $item->DocActaAsamblea,
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
     * Función para crear una nueva unidad económica de persona moral.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'UEDuenoid' => 'required|integer',
                //'Ofcid' => 'required|exists:oficinas,id',
                'Ofcid' => 'required',
                'FechaRegistro' => 'required|date',
                'RNPA' => 'required|string|max:10',
                'RFC' => 'nullable|string|max:13',
                'RazonSocial' => 'nullable|string|max:50',
                'Email' => 'nullable|string|max:40',
                'Calle' => 'nullable|string|max:100',
                'NmExterior' => 'nullable|string|max:6',
                'NmInterior' => 'nullable|string|max:6',
                'CodigoPostal' => 'nullable|string|max:10',
                //'Locid' => 'required|exists:localidades,id',
                'Locid' => 'required',
                'NmPrincipal' => 'nullable|string|max:10',
                'TpNmPrincipal' => 'nullable|string|max:20',
                'NmSecundario' => 'nullable|string|max:10',
                'TpNmSecundario' => 'nullable|string|max:20',
                'IniOperaciones' => 'nullable|date',
                'ActivoEmbMayor' => 'nullable|boolean',
                'ActivoEmbMenor' => 'nullable|boolean',
                'CantidadPescadores' => 'nullable|integer',
                'ActvAcuacultura' => 'nullable|boolean',
                'ActvPesca' => 'nullable|boolean',
                'DocRepresentanteLegal' => 'nullable|string|max:255',
                'DocActaConstitutiva' => 'nullable|string|max:255',
                'DocActaAsamblea' => 'nullable|string|max:255'
            ]);

            $existeUEPAM = UnidadEconomicaPAMoral::where('RFC', $data['RFC'])
            ->orWhere('Email', $data['Email'])
            ->orWhere('RazonSocial', $data['RazonSocial'])
            ->first();

            if ($existeUEPAM) {
                $errors = [];
                if ($existeUEPAM->RFC === $data['RFC']) {
                    $errors['RFC'] = 'El RFC de la organización ya está registrado en una Unidad Economica.';
                }
                if ($existeUEPAM->RazonSocial === $data['RazonSocial']) {
                    $errors['RazonSocial'] = 'El Nombre de la organización ya está registrado en una Unidad Economica.';
                }
                if ($existeUEPAM->Email === $data['Email']) {
                    $errors['Email'] = 'El Email de la organización ya está registrado en una Unidad Economica.';
                }
                return ApiResponse::error('La Unidad Economica ya existe', 422, $errors);
            }

        $UEPAM = UnidadEconomicaPAMoral::create($data);
        return ApiResponse::success('Unidad economica creada exitosamente', 201, $UEPAM);
    } catch (ValidationException $e) {
        return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
    } catch (Exception $e) {
        return ApiResponse::error('Error al crear la unidad economica: ' . $e->getMessage(), 500);
    }
    }

    /**
     * Función para obtener una unidad económica de persona moral.
     */
    public function show($id)
    {
        try {
            $UEPAM = UnidadEconomicaPAMoral::findOrFail($id);
            $result = [
                'id' => $UEPAM->id,
                'UEDuenoid' => $UEPAM->unidadEconomicaPaFisico->Nombres . ' ' . $UEPAM->unidadEconomicaPaFisico->ApPaterno . ' ' . $UEPAM->unidadEconomicaPaFisico->ApMaterno,
                'Ofcid' => $UEPAM->oficina->NombreOficina,
                'FechaRegistro' => $UEPAM->FechaRegistro,
                'RNPA' => $UEPAM->RNPA,
                'RFC' => $UEPAM->RFC,
                'RazonSocial' => $UEPAM->RazonSocial,
                'Email' => $UEPAM->Email,
                'Calle' => $UEPAM->Calle,
                'NmExterior' => $UEPAM->NmExterior,
                'NmInterior' => $UEPAM->NmInterior,
                'CodigoPostal' => $UEPAM->CodigoPostal,
                'Locid' => $UEPAM->localidad->NombreLocalidad,
                'Municipio' => $UEPAM->localidad->municipio->NombreMunicipio,
                'Distrito' => $UEPAM->localidad->municipio->distrito->NombreDistrito,
                'Región' => $UEPAM->localidad->municipio->distrito->region->NombreRegion,
                'NmPrincipal' => $UEPAM->NmPrincipal,
                'TpNmPrincipal' => $UEPAM->TpNmPrincipal,
                'NmSecundario' => $UEPAM->NmSecundario,
                'TpNmSecundario' => $UEPAM->TpNmSecundario,
                'IniOperaciones' => $UEPAM->IniOperaciones,
                'ActivoEmbMayor' => $UEPAM->ActivoEmbMayor ? 'Si' : 'No',
                'ActivoEmbMenor' => $UEPAM->ActivoEmbMenor ? 'Si' : 'No',
                'CantidadPescadores' => $UEPAM->CantidadPescadores,
                'ActvAcuacultura' => $UEPAM->ActvAcuacultura ? 'Si' : 'No',
                'ActvPesca' => $UEPAM->ActvPesca ? 'Si' : 'No',
                'DocRepresentanteLegal' => $UEPAM->DocRepresentanteLegal,
                'DocActaConstitutiva' => $UEPAM->DocActaConstitutiva,
                'DocActaAsamblea' => $UEPAM->DocActaAsamblea,
                'created_at' => $UEPAM->created_at,
                'updated_at' => $UEPAM->updated_at,
            ];
            return ApiResponse::success('Unidad Económica obtenida exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Unidad Económica no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la Unidad Económica: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para actualizar una unidad economica moral por su id.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'UEDuenoid' => 'required|integer',
                //'Ofcid' => 'required|exists:oficinas,id',
                'Ofcid' => 'required',
                'FechaRegistro' => 'required|date',
                'RNPA' => 'required|string|max:10',
                'RFC' => 'nullable|string|max:13',
                'RazonSocial' => 'nullable|string|max:50',
                'Email' => 'nullable|string|max:40',
                'Calle' => 'nullable|string|max:100',
                'NmExterior' => 'nullable|string|max:6',
                'NmInterior' => 'nullable|string|max:6',
                'CodigoPostal' => 'nullable|string|max:10',
                //'Locid' => 'required|exists:localidades,id',
                'Locid' => 'required',
                'NmPrincipal' => 'nullable|string|max:10',
                'TpNmPrincipal' => 'nullable|string|max:20',
                'NmSecundario' => 'nullable|string|max:10',
                'TpNmSecundario' => 'nullable|string|max:20',
                'IniOperaciones' => 'nullable|date',
                'ActivoEmbMayor' => 'nullable|boolean',
                'ActivoEmbMenor' => 'nullable|boolean',
                'CantidadPescadores' => 'nullable|integer',
                'ActvAcuacultura' => 'nullable|boolean',
                'ActvPesca' => 'nullable|boolean',
                'DocRepresentanteLegal' => 'nullable|string|max:255',
                'DocActaConstitutiva' => 'nullable|string|max:255',
                'DocActaAsamblea' => 'nullable|string|max:255'
            ]);

            $existeUEPAM = UnidadEconomicaPAMoral::where('RFC', $data['RFC'])
            ->orWhere('RazonSocial', $data['RazonSocial'])
            ->orWhere('Email', $data['Email'])
            ->first();

            if ($existeUEPAM) {
                $errors = [];
                if ($existeUEPAM->RFC === $data['RFC']) {
                    $errors['RFC'] = 'El RFC de la organización ya está registrado en una Unidad Economica.';
                }
                if ($existeUEPAM->RazonSocial === $data['RazonSocial']) {
                    $errors['RazonSocial'] = 'El Nombre de la organización ya está registrado en una Unidad Economica.';
                }
                if ($existeUEPAM->Email === $data['Email']) {
                    $errors['Email'] = 'El Email de la organización ya está registrado en una Unidad Economica.';
                }
                return ApiResponse::error('La Unidad Economica ya existe', 422, $errors);
            }

        $UEPAM = UnidadEconomicaPAMoral::findOrFail($id);
        $UEPAM->update($data);
        return ApiResponse::success('Unidad Económica actualizada exitosamente', 200, $UEPAM);
    } catch (ModelNotFoundException $e) {
        return ApiResponse::error('Unidad Económica no encontrada', 404);
    } catch (ValidationException $e) {
        return ApiResponse::error('Error de validación, revise sus datos: ' . $e->getMessage(), 422, $e->errors());
    } catch (Exception $e) {
        return ApiResponse::error('Error al actualizar la Unidad Económica: ' . $e->getMessage(), 500);
    }
    }

    /**
     * Función para eliminar una unidad economica por su id.
     */
    public function destroy($id)
    {
        try {
            $UEPAM = UnidadEconomicaPAMoral::findOrFail($id);
            $UEPAM->delete();
            return ApiResponse::success('Unidad Economica eliminada exitosamente', 200, $UEPAM);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Unidad Economica no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar la Unidad Economica: ' . $e->getMessage(), 500);
        }
    }
}
