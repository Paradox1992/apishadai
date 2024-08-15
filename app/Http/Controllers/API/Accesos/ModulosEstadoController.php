<?php

namespace App\Http\Controllers\API\Accesos;

use App\Http\Controllers\Controller;
use App\Http\Resources\Accesos\Modulos_estadosResource;
use App\Models\modulo_estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ModulosEstadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mstatus = modulo_estado::all();
        if ($mstatus !== null) {
            return $this->sendResponse(Modulos_estadosResource::collection($mstatus), 'Modulos Estados');
        }
        return $this->sendResponse(null, 'No se encontraron datos', 404);
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
        $create = modulo_estado::create($request->all());
        if ($create) {
            return $this->sendResponse(null, 'Estado creado', 200);
        }
        return $this->sendResponse(null, 'No se pudo crear el Estado', 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mstatus = modulo_estado::find($id);
        if ($mstatus) {
            return $this->sendResponse(Modulos_estadosResource::make($mstatus), 'Modulo');
        }
        return $this->sendResponse(null, 'No se encontraron datos', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->sendResponse(null, 'Not Supported Yet', 400);


        /* $validated = $this->validator($request);

        if ($validated->fails()) {
            return $this->sendResponse(null, $validated->errors()->first(), 400);
        }

        $estado = modulo_estado::find($id);
        if (!$estado) {
            return $this->sendResponse(null, 'No se encontro el estado', 404);
        }

        $estado->descripcion = $request->input('descripcion');
        $estado->save();
        if ($estado) {
            return $this->sendResponse(null, 'Estado actualizado');
        }
        return $this->sendResponse('No se pudo actualizar el Estado', 400);*/
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $estado = modulo_estado::find($id);
        if (!$estado) {
            return $this->sendResponse(null, 'No se encontro el estado', 404);
        }
        $estado->delete();
        if ($estado) {
            return $this->sendResponse(null, 'Estado eliminado');
        }
        return $this->sendResponse('No se pudo eliminar el estado', 400);
    }


    private function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'descripcion' => 'required|unique:modulo_estados,descripcion,' . $request->input('id'),
        ]);
    }
}
