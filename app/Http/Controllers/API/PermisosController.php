<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermisosResource;
use App\Models\Permisos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermisosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->sendResponse(null, 'Not implemented', 501);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'usuario.id' => 'required|integer|exists:users,id',
            'modulo.id' => 'required|integer|exists:modulos,id',
            'vista.id' => 'required|integer|exists:vistas,id',
        ]);
        if ($validate->fails()) {
            return $this->sendResponse(null, $validate->errors(), 422);
        }
        $data = [
            'usuario' => $request->input('usuario.id'),
            'modulo' => $request->input('modulo.id'),
            'vista' => $request->input('vista.id'),
        ];
        $create = Permisos::create($data);
        if ($create) {
            return $this->sendResponse(null, 'Registro creado');
        }
        return $this->sendResponse(null, 'No se pudo registrar', 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $obj = Permisos::find($id);
        if ($obj) {
            return $this->sendResponse(PermisosResource::make($obj), 'Permiso');
        }
        return $this->sendResponse(null, 'No se encontraron registros', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'usuario.id' => 'required|integer|exists:users,id' . ($id != 0 ? ",$id" : ''),
            'modulo.id' => 'required|integer|exists:modulos,id' . ($id != 0 ? ",$id" : ''),
            'vista.id' => 'required|integer|exists:vistas,id' . ($id != 0 ? ",$id" : ''),
        ]);
        if ($validate->fails()) {
            return $this->sendResponse(null, $validate->errors(), 422);
        }
        $data = [
            'usuario' => $request->input('usuario.id'),
            'modulo' => $request->input('modulo.id'),
            'vista' => $request->input('vista.id'),
        ];
        $obj = Permisos::find($id);
        if (!$obj) {
            return $this->sendResponse(null, 'No se encontro el registro', 404);
        }
        $obj->update($data);
        if (!$obj) {
            return $this->sendResponse(null, 'No se pudo registrar', 400);
        }
        return $this->sendResponse(null, 'Registro actualizado');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $obj = Permisos::find($id);
        if ($obj) {
           try{
            $obj->delete();
            return $this->sendResponse(null, 'Registro eliminado');
           }catch(\Throwable $e){
            return $this->sendResponse(null, 'No se pudo eliminar', 400);
           }
        }
        return $this->sendResponse(null, 'No se encontraron registros', 404);
    }
}
