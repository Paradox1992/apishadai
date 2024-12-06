<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\LaboratoriosResource;
use App\Models\Laboratorios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LaboratoriosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labs = Laboratorios::all();
        if (count($labs) > 0) {
            return $this->sendResponse(LaboratoriosResource::collection($labs), message: 'Registros encontrados');
        }
        return $this->sendResponse(null, 'No hay registros', 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nombre' => 'required|unique:laboratorios,nombre,id',
            'telefono' => 'required',
            'direccion' => 'required',
            'imagen' => 'required|string',
        ]);

        if ($validate->fails()) {
            return $this->sendResponse(null, $validate->errors()->first(), 400);
        }

        $input = $request->all();

        $lab = Laboratorios::create($input);
        if (!$lab) {
            return $this->sendResponse(null, 'Error al crear laboratorio', 400);
        }
        return $this->sendResponse(null, 'Laboratorio creado con exito');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lab = Laboratorios::find($id);
        if (!$lab) {
            return $this->sendResponse(null, 'No se encontro el registro', 404);
        }
        return $this->sendResponse(new LaboratoriosResource($lab), 'Registro encontrado', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'nombre' => 'required|unique:laboratorios,nombre,id',
            'telefono' => 'required',
            'direccion' => 'required',
            'imagen' => 'required|base64image',
        ]);

        if ($validate->fails()) {
            return $this->sendResponse(null, $validate->errors()->first(), 400);
        }
        $lab = Laboratorios::find($id);
        if (!$lab) {
            return $this->sendResponse(null, 'No se encontro el registro', 404);
        }
        $input = $request->all();
        $input['imagen'] = base64_encode(file_get_contents($request->imagen));
        $lab->update($input);
        return $this->sendResponse(new LaboratoriosResource($lab), 'Laboratorio actualizado con exito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lab = Laboratorios::find($id);
        if (!$lab) {
            return $this->sendResponse(null, 'No se encontro el registro', 404);
        }
        $lab->delete();
        if (!$lab) {
            return $this->sendResponse(null, 'Error al eliminar laboratorio', 400);
        }
        return $this->sendResponse(null, 'Laboratorio eliminado con exito');
    }
}
