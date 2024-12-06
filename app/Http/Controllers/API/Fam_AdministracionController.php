<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Fam_AdministracionResource;
use App\Models\Fam_Administracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Fam_AdministracionController extends Controller
{

    public function index()
    {
        $data = Fam_Administracion::all();
        if ($data) {
            return $this->sendResponse(Fam_AdministracionResource::collection($data), 'Lista de admini');
        }
        return $this->sendResponse(null, 'No se encontraron datos', 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'descripcion' => 'required|string|max:150|unique:fam_administracion,descripcion',
        ]);

        if ($validate->fails()) {
            return $this->sendResponse(null, $validate->errors()->first(), 400);
        }

        $data = Fam_Administracion::create([
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
        $data = Fam_Administracion::find($id);
        if ($data) {
            return $this->sendResponse(Fam_AdministracionResource::make($data), 'Registro encontrado');
        }
        return $this->sendResponse(null, 'Registro no encontrado', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Fam_Administracion::find($id);
        if ($data) {
            $validate = Validator::make($request->all(), [
                'descripcion' => "required|string|max:150|unique:fam_administracion,descripcion{$data->id}",
            ]);

            if ($validate->fails()) {
                return $this->sendResponse(null, $validate->errors()->first(), 400);
            }
            $data->update([
                'descripcion' => $request->input('descripcion'),
            ]);
            if ($data) {
                return $this->sendResponse(null, 'Registro actualizado');
            }
            return $this->sendResponse(null, 'No se pudo actualizar el registro', 400);
        }
        return $this->sendResponse(null, 'Registro no encontrado', 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Fam_Administracion::find($id);
        if ($data) {
            $data->delete();
            return $this->sendResponse(null, 'Registro eliminado');
        }
        return $this->sendResponse(null, 'Registro no encontrado', 404);
    }
}