<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Prod_UnidadesResource;
use App\Models\Prod_Unidades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Prod_UnidadesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prods_unidades = Prod_Unidades::all();

        if (count($prods_unidades) > 0) {
            return $this->sendResponse(Prod_UnidadesResource::collection($prods_unidades), 'Listado de Unidades');
        }
        return $this->sendResponse(null, 'No hay registros', 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'abreviatura_c' => 'required|string(10)|unique:prod_unidades,abreviatura_c',
            'abreviatura_v' => 'required|string(10)|unique:prod_unidades,abreviatura_v',
            'cantidad_c' => 'required|integer(5)',
            'cantidad_v' => 'required|integer(5)',
        ]);

        if ($validate->fails()) {
            return $this->sendResponse(null, $validate->errors()->first(), 400);
        }

        $input = $request->all();
        $prods_unidades = Prod_Unidades::create($input);
        if (!$prods_unidades) {
            return $this->sendResponse(null, 'Error al crear Unidad', 400);
        }
        return $this->sendResponse(null, 'Unidad creada con exito');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $prods_unidades = Prod_Unidades::find($id);
        if (is_null($prods_unidades)) {
            return $this->sendResponse(null, 'Unidad no encontrada', 404);
        }
        return $this->sendResponse(result: Prod_UnidadesResource::make($prods_unidades), message: 'Unidad encontrada');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'abreviatura_c' => 'required|string(10)|unique:prod_unidades,abreviatura_c',
            'abreviatura_v' => 'required|string(10)|unique:prod_unidades,abreviatura_v',
            'cantidad_c' => 'required|integer(5)',
            'cantidad_v' => 'required|integer(5)',
        ]);

        if ($validate->fails()) {
            return $this->sendResponse(null, $validate->errors()->first(), 400);
        }

        $prods_unidades = Prod_Unidades::find($id);
        if (is_null($prods_unidades)) {
            return $this->sendResponse(null, 'Unidad no encontrada', 404);
        }
        $prods_unidades->update($request->all());
        if (!$prods_unidades) {
            return $this->sendResponse(null, 'No se pudo actualizar el registro', 400);
        }
        return $this->sendResponse(null, 'Unidad actualizada con exito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prods_unidades = Prod_Unidades::find($id);
        if (is_null($prods_unidades)) {
            return $this->sendResponse(null, 'Unidad no encontrada', 404);
        }
        $prods_unidades->delete();
        if (!$prods_unidades) {
            return $this->sendResponse(null, 'No se pudo eliminar el registro', 400);
        }
        return $this->sendResponse(null, 'Unidad eliminada con exito');
    }
}