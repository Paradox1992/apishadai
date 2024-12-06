<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Prod_EstadoResource;
use App\Models\Prod_Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Prod_EstadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Prod_Estado::all();
        if ($data) {
            return $this->sendResponse(Prod_EstadoResource::collection($data), 'data');
        }

        return $this->sendResponse(null, 'No se encontraron datos', 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'descripcion' => 'required|string|max:150|unique:prod_estado,descripcion',
        ]);

        if ($validate->fails()) {
            return $this->sendError('Error de validación', $validate->errors(), 400);
        }

        $data = Prod_Estado::create([
            'descripcion' => $request->input('descripcion'),
        ]);

        if ($data) {
            return $this->sendResponse(null, 'Registro creado');
        }

        return $this->sendResponse(null, 'No se pudo registrar', 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Prod_Estado::find($id);
        if ($data) {
            return $this->sendResponse(Prod_EstadoResource::make($data), 'data');
        }

        return $this->sendResponse(null, 'No se encontraron datos', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Prod_Estado::find($id);
        if ($data) {
            $validate = Validator::make($request->all(), [
                'descripcion' => "required|string|max:150|unique:prod_estados,descripcion{$data->id}",
            ]);

            if ($validate->fails()) {
                return $this->sendError('Error de validación', $validate->errors(), 400);
            }

            $data->update([
                'descripcion' => $request->input('descripcion'),
            ]);
            if ($data) {
                return $this->sendResponse(null, 'Registro actualizado');
            }
            return $this->sendResponse(null, 'No se pudo actualizar el registro', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Prod_Estado::find($id);
        if ($data) {
            $data->delete();
            return $this->sendResponse(null, 'Registro eliminado');
        }
        return $this->sendResponse(null, 'No se encontro el registro', 404);
    }
}
