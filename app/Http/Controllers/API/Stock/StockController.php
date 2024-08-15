<?php

namespace App\Http\Controllers\API\Stock;

use App\Http\Controllers\Controller;
use App\Http\Resources\Stock\StockResource;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stocks = Stock::all();
        if ($stocks->count() < 0) {
            return $this->sendResponse(null, 'No hay registros', 404);
        }
        return $this->sendResponse(StockResource::collection($stocks), 'Registros encontrados', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request);
        if ($validator->fails()) {
            return $this->sendResponse(null, $validator->errors()->first(), 400);
        }
        $stock = Stock::create($request->all());
        if (!$stock) {
            return $this->sendResponse(null, 'No se pudo crear el registro', 400);
        }
        return $this->sendResponse(null, 'Registro creado');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $stock = Stock::find($id);
        if (!$stock) {
            return $this->sendResponse(null, 'No se encontro el registro', 404);
        }
        return $this->sendResponse(StockResource::make($stock), 'Registro encontrado', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $stock = Stock::find($id);
        if (!$stock) {
            return $this->sendResponse(null, 'No se encontro el registro', 404);
        }
        $validator = $this->validator($request);
        if ($validator->fails()) {
            return $this->sendResponse(null, $validator->errors()->first(), 400);
        }
        $stock->update($request->all());
        if (!$stock) {
            return $this->sendResponse(null, 'No se pudo actualizar el registro', 400);
        }
        return $this->sendResponse(null, 'Registro actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stock = Stock::find($id);
        if (!$stock) {
            return $this->sendResponse(null, 'No se encontro el registro', 404);
        }
        $stock->delete();
        if (!$stock) {
            return $this->sendResponse(null, 'No se pudo eliminar el registro', 400);
        }
        return $this->sendResponse(null, 'Registro eliminado');
    }

    private function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'descripcion' => 'required|unique:stocks,descripcion,' . $request->input('id'),
            'telefono' => 'required|unique:stocks,telefono,' . $request->input('id'),
            'ubicacion' => 'required',
        ]);
    }
}