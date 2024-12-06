<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ModuloEstadosResource;
use App\Models\ModuloEstados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ModuloEstadosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = ModuloEstados::all();
        if (count($list) > 0) {
            return $this->sendResponse(ModuloEstadosResource::collection($list), 'Listado de estados');
        } else {
            return $this->sendResponse(null, 'No hay registros', 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'descripcion' => 'required|string|max:80|unique:modulo_estados,descripcion',
        ]);

        if ($validate->fails()) {
            return $this->sendResponse(null, $validate->errors()->first(), 400);
        }
        $input = $request->all();
        $save = ModuloEstados::create($input);
        if (!$save) {
            return $this->sendResponse(null, 'Error al crear estado', 400);
        }
        return $this->sendResponse(null, 'Estado creado con exito');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = ModuloEstados::find($id);
        if ($data) {
            return $this->sendResponse(ModuloEstadosResource::make($data), 'Registro encontrado');
        }
        return $this->sendResponse(null, 'No se encontro el registro', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->sendResponse(null, 'No implementado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->sendResponse(null, 'No implementado');
    }
}