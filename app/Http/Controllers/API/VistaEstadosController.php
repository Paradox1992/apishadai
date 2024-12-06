<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\VistaEstadosResource;
use App\Models\VistaEstados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VistaEstadosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = VistaEstados::all();
        if ($list->count() > 0) {
            return $this->sendResponse(VistaEstadosResource::collection($list), 'Listado de estados de estado');
        }
        return $this->sendResponse(null, 'No se encontraron registros', 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'descripcion' => 'required|string|max:80|unique:vista_estados,descripcion',
        ]);

        if ($validate->fails()) {
            return $this->sendResponse(null, $validate->errors(), 400);
        }

        $data = VistaEstados::create([
            'descripcion' => $request->input('descripcion'),
        ]);
        if ($data) {
            return $this->sendResponse(null, 'Registro creado');
        }
        return $this->sendResponse(null, 'No se pudo crear el registro', 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $obj = VistaEstados::find($id);
        if ($obj) {
            return $this->sendResponse(VistaEstadosResource::make($obj), 'Estado de Vista');
        }
        return $this->sendResponse(null, 'No se encontraron registros', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'descripcion' => "required|string|max:80|unique:vista_estados,descripcion,{$id}",
        ]);

        if ($validate->fails()) {
            return $this->sendResponse(null, $validate->errors(), 400);
        }

        $obj = VistaEstados::find($id);
        if ($obj) {
            $obj->update([
                'descripcion' => $request->input('descripcion'),
            ]);
            return $this->sendResponse(null, 'Registro actualizado');
        }
        return $this->sendResponse(null, 'No se encontraron registros', 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $obj = VistaEstados::find($id);
        if ($obj) {
            try {
                $obj->delete();
                return $this->sendResponse(null, 'Registro eliminado');
            } catch (\Throwable $e) {
                return $this->sendResponse(null, 'No se puede eliminar el registro', 400);
            }
        }
        return $this->sendResponse(null, 'No se encontraron registros', 404);
    }
}