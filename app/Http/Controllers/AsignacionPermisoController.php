<?php

namespace App\Http\Controllers;

use App\Models\AsignacionPermiso;
use App\Models\Rol;
use App\Models\Permiso;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

class AsignacionPermisoController extends Controller
{
    /**
     * Función que obtiene la lista de los permisos asignados a un rol.
     */
    public function index()
    {
        try {
            $asignacionpermisos = AsignacionPermiso::all();
            $result = $asignacionpermisos->map(function ($item) {
                return [
                    'id' => $item->id,
                    'Rolid' => $item->rol->NombreRol,
                    'Permid' => $item->permiso->NombrePermiso,
                    'Permitido' => $item->Permitido ? 'Si' : 'No',
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
            return ApiResponse::success('Lista de los permisos asignados a un rol', 200, $result);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la lista de permisos asignados a un rol: ' . $e->getMessage(), 500);
        }
    }

    /**
     * función que crea un nuevo permiso asignado a un rol.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'Rolid' => 'required|exists:roles,id',
                'Permid' => 'required|exists:permisos,id',
                'Permitido' => 'required|boolean'
            ]);

            // Verifica la existencia de la asignación de permisos
            $existepermiso = AsignacionPermiso::where('Rolid', $data['Rolid'])
                ->where('Permid', $data['Permid'])
                ->first();

            if ($existepermiso) {
                return ApiResponse::error('El permiso ya está asignado a este rol', 422);
            }

            // Crea la nueva asignación de permisos
            $asignacionpermiso = AsignacionPermiso::create($data);
            return ApiResponse::success('Permiso asignado creado exitosamente', 201, $asignacionpermiso);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (Exception $e) {
            return ApiResponse::error('Error al crear la asignación de permiso: ' . $e->getMessage(), 500);
        }
    }

    /**
     * función que obtiene un permiso asignado a un rol por su id.
     */
    public function show($id)
    {
        try {
            $asignacionpermiso = AsignacionPermiso::findOrFail($id);
            $result = [
                'id' => $asignacionpermiso->id,
                'Rolid' => $asignacionpermiso->rol->NombreRol,
                'Permid' => $asignacionpermiso->permiso->NombrePermiso,
                'Permitido' => $asignacionpermiso->Permitido,
                'created_at' => $asignacionpermiso->created_at,
                'updated_at' => $asignacionpermiso->updated_at,
            ];
            return ApiResponse::success('Permiso asignado a un rol obtenido exitosamente', 200, $result);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Permiso asignado a un rol no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el permiso asignado a un rol: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para actualizar un permiso asignado a un rol por su id.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'Rolid' => 'required|exists:roles,id',
                'Permid' => 'required|exists:permisos,id',
                'Permitido' => 'required|boolean'
            ]);

            // Verifica la existencia de la asignación de permisos excluyendo el registro actual
            $existepermiso = AsignacionPermiso::where('Rolid', $data['Rolid'])
                ->where('Permid', $data['Permid'])
                ->where('id', '!=', $id)
                ->first();

            if ($existepermiso) {
                return ApiResponse::error('El permiso ya está asignado a este rol', 422);
            }

            $asignacionpermiso = AsignacionPermiso::findOrFail($id);
            $asignacionpermiso->update($data);

            return ApiResponse::success('Permiso asignado actualizado exitosamente', 200, $asignacionpermiso);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422, $e->errors());
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Asignación de permiso no encontrada', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar la asignación de permiso: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para eliminar un permiso asignado a un rol por su id.
     */
    public function destroy($id)
    {
        try {
            $asignacionpermiso = AsignacionPermiso::findOrFail($id);
            $asignacionpermiso->delete();
            return ApiResponse::success('Permiso asignado eliminado exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Permiso asignado no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el permiso asignado: ' . $e->getMessage(), 500);
        }
    }
}
