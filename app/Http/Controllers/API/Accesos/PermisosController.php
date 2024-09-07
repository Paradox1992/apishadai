<?php

namespace App\Http\Controllers\API\Accesos;

use App\Http\Controllers\Controller;
use App\Http\Resources\Accesos\PermisosResource;
use App\Models\permisos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermisosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /* $permisos = permisos::all();
        if (!$permisos) {
            return $this->sendResponse(null, 'Permisos no encontrados', 404);
        }*/
        return $this->sendResponse(null, 'Not Supported Yet', 501);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request);
        if ($validator->fails()) {
            return $this->sendResponse(null, $validator->errors()->first(), 400);
        }

        $permiso = $request->all();
        $permiso['last_access'] = now();
        $permiso['usuario'] = $request->input('usuario.id');
        $permiso['modulo'] = $request->input('modulo.id');
        $permiso['formulario'] = $request->input('formulario.id');
        $permiso = permisos::create($permiso);
        if (!$permiso) {
            return $this->sendResponse(null, 'Error al crear permisos', 400);
        }
        return $this->sendResponse(null, 'Permisos creado con exito');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $permisos = permisos::find($id);
        if (!$permisos) {
            return $this->sendResponse(null, 'Permisos no encontrado', 404);
        }
        return $this->sendResponse(PermisosResource::make($permisos), []);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->sendResponse(null, 'Not Supported Yet', 501);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permisos = permisos::find($id);
        if (!$permisos) {
            return $this->sendResponse('Permisos no encontrado', 404);
        }
        $permisos->delete();
        if (!$permisos) {
            return $this->sendResponse(null, 'Error al eliminar permiso');
        }
        return $this->sendResponse(null, 'Permisos eliminado con exito');
    }

    public function search(int $id)
    {
        $permisos = permisos::where('usuario', $id)->get();
        if (!$permisos) {
            return $this->sendResponse(null, 'Permisos no encontrados', 404);
        }
        return $this->sendResponse(PermisosResource::collection($permisos), ' Permisos encontrados');
    }

    private function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'usuario.id' => 'required|exists:users,id',
            'modulo.id' => 'required |exists:modulos,id',
            'formulario.id' => 'required|exists:formularios,id',
        ]);
    }
}