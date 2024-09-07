<?php

namespace App\Http\Controllers\API\Accesos;

use App\Http\Controllers\Controller;
use App\Http\Resources\Accesos\FormulariosResource;
use App\Models\formularios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormulariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $formularios = formularios::all();
        return $this->sendResponse(FormulariosResource::collection($formularios), 'Formularios encontrados con éxito');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator =
            Validator::make($request->all(), [
                'modulo.id' => 'required|integer|exists:modulos,id',
                'descripcion' => 'required|string|max:100',
                'estado.id' => 'required|integer|exists:frm_estados,id',
            ]);
        if ($validator->fails()) {
            return $this->sendResponse(null,  $validator->errors()->first(), 400);
        }
        $input = $request->all();
        $input['modulo'] = $request->modulo['id'];
        $input['estado'] = $request->estado['id'];
        $save = formularios::create($input);
        if (!$save) {
            return $this->sendResponse(null, 'Error al crear el formulario', 400);
        }
        return $this->sendResponse(null, 'Formularios creado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $formularios = formularios::find($id);
        if (!$formularios) {
            return $this->sendResponse(null, 'Formularios no encontrado', 404);
        }
        return $this->sendResponse(FormulariosResource::make($formularios), ' Formularios encontrado con éxito');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator =    Validator::make($request->all(), [
            'modulo.id' => 'required|integer|exists:modulos,id',
            'estado.id' => 'required|integer|exists:frm_estados,id',
        ]);



        if ($validator->fails()) {
            return $this->sendResponse(null,  $validator->errors()->first(), 400);
        }


        $input = $request->all();
        $formulario = formularios::find($id);
        $input['modulo'] = $request->modulo['id'];
        $input['estado'] = $request->estado['id'];
        unset($input['created_at'], $input['updated_at']);
        if (!$formulario) {
            return $this->sendResponse(null, 'Formularios no encontrado', 404);
        }
        $formulario->update($input);
        if (!$formulario) {
            return $this->sendResponse(null, 'Error al actualizar el formulario', 400);
        }
        return $this->sendResponse(null, 'Formularios actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $formularios = formularios::find($id);
        if (!$formularios) {
            return $this->sendResponse(null, 'Formularios no encontrado', 404);
        }
        $formularios->delete();
        if (!$formularios) {
            return $this->sendResponse(null, 'Error al eliminar el formulario', 400);
        }
        return $this->sendResponse(null, 'Formularios eliminado con éxito');
    }



    public function filterbyModule(int $mid)
    {
        $formularios = formularios::where('modulo', $mid)->get();
        if (!$formularios) {
            return $this->sendResponse(null, 'Formularios no encontrado', 404);
        }
        return $this->sendResponse(FormulariosResource::collection($formularios), 'Formularios encontrados con éxito');
    }
}
