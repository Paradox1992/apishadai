<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Http\Resources\FamiliaResource;
use App\Models\Familia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class FamiliaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Familia::all();
        if ($data) {
            return $this->sendResponse(FamiliaResource::collection($data), 'data');
        }
        return $this->sendResponse(null, 'No se encontraron datos', 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'presentacion.id' => 'required|integer|exists:fam_presentacion,id',
            'administracion.id' => 'required|integer|exists:fam_administracion,id',
            'descripcion' => 'required|string|max:150|unique:familias,descripcion',
        ]);

        if ($validate->fails()) {
            return $this->sendResponse(null, $validate->errors()->first(), 400);
        }
        $input = $request->all();
        $input['presentacion'] = $request->presentacion['id'];
        $input['administracion'] = $request->administracion['id'];
        $save = Familia::create($input);
        if (!$save) {
            return $this->sendResponse(null, 'Error al crear familia', 400);
        }
        return $this->sendResponse(null, 'Familia creada con exito');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Familia::find($id);
        if ($data) {
            return $this->sendResponse(FamiliaResource::make($data), 'data');
        }
        return $this->sendResponse(null, 'No se encontro el registro', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'presentacion.id' => 'required|integer|exists:fam_presentacion,id' . ($id != 0 ? ",$id" : ''),
            'administracion.id' => 'required|integer|exists:fam_administracion,id' . ($id != 0 ? ",$id" : ''),
            'descripcion' => 'required|string|max:150|unique:familias,descripcion' . ($id != 0 ? ",$id" : ''),
        ]);

        if ($validate->fails()) {
            return $this->sendResponse(null, $validate->errors()->first(), 400);
        }
        $input = $request->all();
        $input['presentacion'] = $request->presentacion['id'];
        $input['administracion'] = $request->administracion['id'];
        $data = Familia::find($id);
        if ($data) {
            $data->update($input);
            return $this->sendResponse(null, 'Registro actualizado');
        }
        return $this->sendResponse(null, 'No se encontro el registro', 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Familia::find($id);
        if ($data) {
            $data->delete();
            return $this->sendResponse(null, 'Registro eliminado');
        }
        return $this->sendResponse(null, 'No se encontro el registro', 404);
    }
}