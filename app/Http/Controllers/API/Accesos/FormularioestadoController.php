<?php

namespace App\Http\Controllers\API\Accesos;

use App\Http\Controllers\Controller;
use App\Http\Resources\Accesos\Frm_EstadosResource;
use App\Models\frm_estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormularioestadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estados = frm_estado::all();
        if ($estados != null) {
            return $this->sendResponse(Frm_EstadosResource::collection($estados), 'Listado de Estados');
        }
        return $this->sendResponse([], 'No se encontraron datos');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validator($request);

        if ($validated->fails()) {
            return $this->sendResponse(null, $validated->errors()->first(), 400);
        }

        $estado = frm_estado::create($request->all());
        if ($estado != null) {
            return $this->sendResponse(Frm_EstadosResource::make($estado), 'Formulario(Estado) creado con exito');
        }
        return $this->sendResponse(null, 'No se pudo crear el estado', 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $estado = frm_estado::find($id);
        if ($estado != null) {
            return $this->sendResponse(Frm_EstadosResource::make($estado), 'Estado');
        }
        return $this->sendResponse(null, 'No se encontraron datos', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->sendResponse(null, 'Not Supported Yet', 404);

        /*  if ($this->validator($request)) {
            $estado = frm_estado::find($id);
            $estado->fill($request->all());
            $estado->save();
            return $this->sendResponse(new Frm_EstadosResource($estado), 'Formulario(Estado) actualizado con exito');
        }
        return $this->sendError('Error de validacion');*/
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $estado = frm_estado::find($id);
        if ($estado != null) {
            $estado->delete();
            return $this->sendResponse(null, 'Formulario(Estado) eliminado con exito');
        }
        return $this->sendResponse(null, 'No se encontraron datos', 404);
    }


    private function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'descripcion' => 'required|unique:frm_estados,descripcion,' . $request->input('id'),
        ]);
    }
}
