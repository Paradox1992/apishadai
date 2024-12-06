<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Fam_PresentacionResource;
use App\Models\Fam_Presentacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Fam_PresentacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fam_Presentaciones = Fam_Presentacion::all();
        if (count($fam_Presentaciones) > 0) {
            return $this->sendResponse(Fam_PresentacionResource::collection($fam_Presentaciones), 'Presentaciones');
        }
        return $this->sendResponse(null, 'Presentaciones no encontradas', 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'descripcion' => 'required|string|max:150',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(null, $validator->errors(), 400);
        }
        $fam_Presentacion = Fam_Presentacion::create($request->all());
        if (!$fam_Presentacion) {
            return $this->sendResponse(null, 'Error al crear la Presentaciones', 400);
        }
        return $this->sendResponse(null, 'Presentacion creada');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $fam_Presentacion = Fam_Presentacion::find($id);
        if ($fam_Presentacion) {
            return $this->sendResponse(Fam_PresentacionResource::make($fam_Presentacion), 'fam_Presentacion');
        }
        return $this->sendResponse(null, 'Presentacion no encontrada', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'descripcion' => 'required|string|max:150',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(null, $validator->errors(), 400);
        }
        $fam_Presentacion = Fam_Presentacion::find($id);
        if (!$fam_Presentacion) {
            return $this->sendResponse(null, 'Presentacion no encontrada', 404);
        }
        $fam_Presentacion->update($request->all());
        return $this->sendResponse(null, 'Presentacion actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fam_Presentacion = Fam_Presentacion::find($id);
        if (!$fam_Presentacion) {
            return $this->sendResponse(null, 'Presentacion no encontrada', 404);
        }
        $fam_Presentacion->delete();
        if (!$fam_Presentacion) {
            return $this->sendResponse(null, 'Error al eliminar la Presentacion', 400);
        }
        return $this->sendResponse(null, 'Presentacion eliminada');
    }
}