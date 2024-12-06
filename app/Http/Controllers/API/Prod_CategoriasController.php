<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Prod_CategoriasResource;
use App\Models\Prod_Categorias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Prod_CategoriasController extends Controller
{

    public function index()
    {
        $data = Prod_Categorias::all();
        if ($data) {
            return $this->sendResponse(Prod_CategoriasResource::collection($data), 'data');
        }

        return $this->sendResponse(null, 'No se encontro el registro', 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100|unique:prod_categorias,nombre',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(null, $validator->errors()->first(), 400);
        }

        $data = Prod_Categorias::create([
            'nombre' => $request->nombre,
        ]);

        if ($data) {
            return $this->sendResponse(null, 'Categoria Creada con exito');
        }

        return $this->sendResponse(null, 'No se encontro el registro', 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Prod_Categorias::find($id);
        if ($data) {
            return $this->sendResponse(Prod_CategoriasResource::make($data), 'data');
        }
        return $this->sendResponse(null, 'No se encontro el registro', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Prod_Categorias::find($id);
        if (!$data) {
            return $this->sendResponse(null, 'No se encontro el registro', 404);
        }
        $validator = Validator::make($request->all(), [
            'nombre' => "required|string|max:100|unique:prod_categorias,nombre$id",
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(null, $validator->errors()->first(), 400);
        }

        $data->update($request->all());
        return $this->sendResponse(null, 'Categoría actualizada con exito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Prod_Categorias::find($id);
        if (!$data) {
            return $this->sendResponse(null, 'No se encontro el registro', 404);
        }
        $data->delete();
        return $this->sendResponse(null, 'Categoría eliminada con exito');
    }
}