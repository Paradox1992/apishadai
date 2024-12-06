<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProveedoresResource;
use App\Models\Proveedores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProveedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // last 50 records
        $data = Proveedores::orderBy('created_at', 'desc')->take(50)->get();
        if ($data) {
            return $this->sendResponse(ProveedoresResource::collection($data), 'data');
        }
        return $this->sendResponse(null, 'No se encontraron datos', 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100|unique:proveedor,nombre',
            'telefono' => 'required',
            'direccion' => 'required',
            'imagen' => 'required|string',
        ]);

        if ($validate->fails()) {
            return $this->sendError($validate->errors(), 'Error de validacion');
        }
        $create = Proveedores::create($request->all());

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
        $data = Proveedores::find($id);
        if ($data) {
            return $this->sendResponse(ProveedoresResource::make($data), 'data');
        }
        return $this->sendResponse(null, 'No se encontraron datos', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'nombre' => "required|string|max:100|unique:proveedor,nombre,$id",
            'telefono' => 'required',
            'direccion' => 'required',
            'imagen' => 'required|string',
        ]);

        if ($validate->fails()) {
            return $this->sendError($validate->errors(), 'Error de validacion');
        }
        $data = Proveedores::find($id);
        if ($data) {
            $data->update($request->all());
            return $this->sendResponse(null, 'Registro actualizado');
        }
        return $this->sendResponse(null, 'No se pudo registrar', 400);
    }


    public function destroy(string $id)
    {
        $data = Proveedores::find($id);
        if ($data) {
            try {
                $data->delete();
                return $this->sendResponse(null, 'Registro eliminado');
            } catch (\Throwable $ex) {
                return $this->sendResponse(null, 'No se puede eliminar el registro porque tiene registros relacionados', 400);
            }
        }
        return $this->sendResponse(null, 'No se pudo registrar', 400);
    }
}