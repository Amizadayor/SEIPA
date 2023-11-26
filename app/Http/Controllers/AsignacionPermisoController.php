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
                    'Permitido' => $item->Permitido,
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
            $request->validate([
                'Rolid' => 'required|exists:roles,id',
                'Permid' => 'required|exists:permisos,id',
                'Permitido' => 'required|boolean'
            ]);

            $existepermiso = AsignacionPermiso::where('Rolid', $request->Rolid)
                ->where('Permid', $request->Privid)
                ->first();
            if ($existepermiso) {
                return ApiResponse::error('El permiso ya está asignado a este rol', 422);
            }

            $asignacionpermiso = AsignacionPermiso::create($request->all());
            return ApiResponse::success('Permiso asignado creado exitosamente', 201, $asignacionpermiso);
        } catch (ValidationException $e) {
            return ApiResponse::error('Error de validación: ' . $e->getMessage(), 422);
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
        }   catch (Exception $e) {
            return ApiResponse::error('Error al obtener el permiso asignado a un rol: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Función para actualizar un permiso asignado a un rol por su id.
     */
    public function update(Request $request, $id)
    {
        try {
            $asignacionpermiso = AsignacionPermiso::findOrFail($id);
            $request->validate([
                'Rolid' => 'required|integer',
                'Permid' => 'required|integer',
                'Permitido' => 'required|boolean'
            ]);

            $existepermiso = AsignacionPermiso::where('Rolid', $request->Rolid)
                ->where('Permid', $request->Privid)
                ->first();
            if ($existepermiso) {
                return ApiResponse::error('El permiso ya está asignado a este rol', 422);
            }

            $asignacionpermiso->update($request->all());
            return ApiResponse::success('Permiso asignado actualizado exitosamente', 200, $asignacionpermiso);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Permiso asignado no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar el permiso: ' . $e->getMessage(), 422);
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
            return ApiResponse::error('Permiso asignado no encontrado',404);
        }   catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el permiso asignado: ' . $e->getMessage(), 500);
        }
    }
}
