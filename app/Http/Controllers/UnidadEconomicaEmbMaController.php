<?php

namespace App\Http\Controllers;

use App\Models\UnidadEconomicaEmbMa;
use App\Models\UnidadEconomicaPAFisico;
use App\Models\TipoActividad;
use App\Models\TipoCubierta;
use App\Models\MaterialCasco;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class UnidadEconomicaEmbMaController extends Controller
{
    /**
     * Función para mostrar la lista de unidades económicas de embarcaciones mayores
     */
    public function index()
    {
        try {
            $UEEMMA = UnidadEconomicaEmbMa::all();
            $result = $UEEMMA->map(function ($item) {
                return [
                    'id' => $item->id,
                    'UEDuenoid' => $item->UnidadEconomicaPaFisico->Nombres . ' ' . $item->UnidadEconomicaPaFisico->ApPaterno . ' ' . $item->UnidadEconomicaPaFisico->ApMaterno,
                    'RNPA' => $item->RNPA,
                    'Nombre' => $item->Nombre,
                    'ActivoPropio' => $item->ActivoPropio ? 'Si' : 'No',
                    'NombreEmbMayor' => $item->NombreEmbMayor,
                    'Matricula' => $item->Matricula,
                    'PuertoBase' => $item->PuertoBase,
                    'TPActid' => $item->TipoActividad->NombreActividad,
                    'TPCubid' => $item->TipoCubierta->NombreCubierta,
                    'CdPatrones' => $item->CdPatrones,
                    'CdMotoristas' => $item->CdMotoristas,
                    'CdPescEspecializados' => $item->CdPescEspecializados,
                    'CdPescadores' => $item->CdPescadores,
                    'AnioConstruccion' => $item->AnioConstruccion,
                    'MtrlCascoid' => $item->MaterialCasco->NombreMaterialCasco,
                    'Eslora' => $item->Eslora,
                    'Manga' => $item->Manga,
                    'Puntal' => $item->Puntal,
                    'Calado' => $item->Calado,
                    'ArqueoNeto' => $item->ArqueoNeto,
                    'DocAcreditacionLegalMotor' => $item->DocAcreditacionLegalMotor,
                    'DocCertificadoMatricula' => $item->DocCertificadoMatricula,
                    'DocComprobanteTenenciaLegal' => $item->DocComprobanteTenenciaLegal,
                    'DocCertificadoSegEmbs' => $item->DocCertificadoSegEmbs,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de las unidades económicas de embarcaciones mayores', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de unidades económicas de las embarcaciones mayores', 500);
        }
    }

    /**
     * Función para crear una nueva unidad económica de embarcación mayor
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'UEDuenoid' => 'required|integer',
                'RNPA' => 'required|string|max:10',
                'Nombre' => 'required|string|max:100',
                'ActivoPropio' => 'required|boolean',
                'NombreEmbMayor' => 'required|string|max:50',
                'Matricula' => 'required|string|max:15',
                'PuertoBase' => 'required|string|max:50',
                'TPActid' => 'required|integer',
                'TPCubid' => 'required|integer',
                'CdPatrones' => 'required|integer',
                'CdMotoristas' => 'required|integer',
                'CdPescEspecializados' => 'required|integer',
                'CdPescadores' => 'required|integer',
                'AnioConstruccion' => 'required|integer',
                'MtrlCascoid' => 'required|integer',
                'Eslora' => 'required|numeric|max:9999999999.99',
                'Manga' => 'required|numeric|max:9999999999.99',
                'Puntal' => 'required|numeric|max:9999999999.99',
                'Calado' => 'required|numeric|max:9999999999.99',
                'ArqueoNeto' => 'required|numeric|max:9999999999.99',
                'DocAcreditacionLegalMotor' => 'required|string|max:255',
                'DocCertificadoMatricula' => 'required|string|max:255',
                'DocComprobanteTenenciaLegal' => 'required|string|max:255',
                'DocCertificadoSegEmbs' => 'required|string|max:255',
            ]);

            $existeUEEMMA = UnidadEconomicaEmbMa::where('RNPA', $data['RNPA'])
                ->orwhere('NombreEmbMayor', $data['NombreEmbMayor'])
                ->orwhere('Matricula', $data['Matricula'])
                ->first();

            if ($existeUEEMMA) {
                $errors = [];
                if ($existeUEEMMA->RNPA == $data['RNPA']) {
                    $errors['RNPA'] = 'El RNPA ya esta registrado';
                }
                if ($existeUEEMMA->NombreEmbMayor == $data['NombreEmbMayor']) {
                    $errors['NombreEmbMayor'] = 'El nombre de la embarcación mayor ya esta registrado';
                }
                if ($existeUEEMMA->Matricula == $data['Matricula']) {
                    $errors['Matricula'] = 'La matrícula ya esta registrada';
                }
                return ApiResponse::error('La embarcación mayor ya existe', 422, $errors);
            }

            $UEEMMA = UnidadEconomicaEmbMa::create($data);
            return ApiResponse::success('Unidad económica de embarcación mayor creada exitosamente', 201, $UEEMMA);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ', 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear la unidad económica de embarcación mayor: ', 500);
        }
    }

    /**
     * Función para mostrar una unidad económica de embarcación mayor por id
     */
    public function show($id)
    {
        try {
            $UEEMMA = UnidadEconomicaEmbMa::findOrFail($id);
            $result = [
                'id' => $UEEMMA->id,
                'UEDuenoid' => $UEEMMA->UnidadEconomicaPaFisico->Nombres . ' ' . $UEEMMA->UnidadEconomicaPaFisico->ApPaterno . ' ' . $UEEMMA->UnidadEconomicaPaFisico->ApMaterno,
                'RNPA' => $UEEMMA->RNPA,
                'Nombre' => $UEEMMA->Nombre,
                'ActivoPropio' => $UEEMMA->ActivoPropio ? 'Si' : 'No',
                'NombreEmbMayor' => $UEEMMA->NombreEmbMayor,
                'Matricula' => $UEEMMA->Matricula,
                'PuertoBase' => $UEEMMA->PuertoBase,
                'TPActid' => $UEEMMA->TipoActividad->NombreActividad,
                'TPCubid' => $UEEMMA->TipoCubierta->NombreCubierta,
                'CdPatrones' => $UEEMMA->CdPatrones,
                'CdMotoristas' => $UEEMMA->CdMotoristas,
                'CdPescEspecializados' => $UEEMMA->CdPescEspecializados,
                'CdPescadores' => $UEEMMA->CdPescadores,
                'AnioConstruccion' => $UEEMMA->AnioConstruccion,
                'MtrlCascoid' => $UEEMMA->MaterialCasco->NombreMaterialCasco,
                'Eslora' => $UEEMMA->Eslora,
                'Manga' => $UEEMMA->Manga,
                'Puntal' => $UEEMMA->Puntal,
                'Calado' => $UEEMMA->Calado,
                'ArqueoNeto' => $UEEMMA->ArqueoNeto,
                'DocAcreditacionLegalMotor' => $UEEMMA->DocAcreditacionLegalMotor,
                'DocCertificadoMatricula' => $UEEMMA->DocCertificadoMatricula,
                'DocComprobanteTenenciaLegal' => $UEEMMA->DocComprobanteTenenciaLegal,
                'DocCertificadoSegEmbs' => $UEEMMA->DocCertificadoSegEmbs,
                'created_at' => $UEEMMA->created_at,
                'updated_at' => $UEEMMA->updated_at,
            ];

            return ApiResponse::success('Unidad económica de embarcación mayor obtenida exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Unidad económica de embarcación mayor no encontrada.', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la unidad económica de embarcación mayor: ', 500);
        }
    }

    /**
     * Función para actualizar una unidad económica de embarcación mayor por id
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'UEDuenoid' => 'required|integer',
                'RNPA' => 'required|string|max:10',
                'Nombre' => 'required|string|max:100',
                'ActivoPropio' => 'required|boolean',
                'NombreEmbMayor' => 'required|string|max:50',
                'Matricula' => 'required|string|max:15',
                'PuertoBase' => 'required|string|max:50',
                'TPActid' => 'required|integer',
                'TPCubid' => 'required|integer',
                'CdPatrones' => 'required|integer',
                'CdMotoristas' => 'required|integer',
                'CdPescEspecializados' => 'required|integer',
                'CdPescadores' => 'required|integer',
                'AnioConstruccion' => 'required|integer',
                'MtrlCascoid' => 'required|integer',
                'Eslora' => 'required|numeric|max:9999999999.99',
                'Manga' => 'required|numeric|max:9999999999.99',
                'Puntal' => 'required|numeric|max:9999999999.99',
                'Calado' => 'required|numeric|max:9999999999.99',
                'ArqueoNeto' => 'required|numeric|max:9999999999.99',
                'DocAcreditacionLegalMotor' => 'required|string|max:255',
                'DocCertificadoMatricula' => 'required|string|max:255',
                'DocComprobanteTenenciaLegal' => 'required|string|max:255',
                'DocCertificadoSegEmbs' => 'required|string|max:255',
            ]);

            // Optimización de la consulta de duplicados
            $existUEEMMA = UnidadEconomicaEmbMa::where('id', '!=', $id)
                ->where(function ($query) use ($data) {
                    $query->where('RNPA', $data['RNPA'])
                        ->orWhere(function ($query) use ($data) {
                            $query->where('NombreEmbMayor', $data['NombreEmbMayor'])
                                ->orWhere('Matricula', $data['Matricula']);
                        });
                })
                ->first();

            // Validación de duplicados
            if ($existUEEMMA) {
                $errors = [];
                if ($existUEEMMA->RNPA === $data['RNPA']) {
                    $errors['RNPA'] = 'El RNPA ya está registrado';
                }
                if ($existUEEMMA->NombreEmbMayor === $data['NombreEmbMayor']) {
                    $errors['NombreEmbMayor'] = 'El nombre de la embarcación mayor ya está registrado';
                }
                if ($existUEEMMA->Matricula === $data['Matricula']) {
                    $errors['Matricula'] = 'La matrícula ya está registrada';
                }
                return ApiResponse::error('La embarcación mayor ya existe', 422, $errors);
            }

            // Actualización directa sin recuperar los datos
            /* UnidadEconomicaEmbMa::where('id', $id)->update($data); */

             // Actualización recuperando los datos
            $UEEMMA = UnidadEconomicaEmbMa::findOrFail($id);
            $UEEMMA->update($data);
            return ApiResponse::success('Unidad económica de embarcación mayor actualizada exitosamente', 200);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Unidad económica de embarcación mayor no encontrada.', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar la unidad económica de embarcación mayor: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para eliminar una unidad económica de embarcación mayor por id
     */
    public function destroy($id)
    {
        try {
            $UEEMMA = UnidadEconomicaEmbMa::findOrFail($id);
            $UEEMMA->delete();
            return ApiResponse::success('Unidad económica de embarcación mayor eliminada exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Unidad económica de embarcación mayor no encontrada.', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar la unidad económica de embarcación mayor: ', 500);
        }
    }
}
