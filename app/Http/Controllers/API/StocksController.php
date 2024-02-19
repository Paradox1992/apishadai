<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\StocksResource;
use App\Models\stocks;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StocksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $stocks = stocks::all();
        return $this->sendResponse(StocksResource::collection($stocks), 'Listado de Stocks');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($this->validData($request)) {
            return $this->sendError('Error de validacion', $this->validData($request));
        }
        $stock = stocks::create($request->all());
        if (!$stock) {
            return $this->sendError('Error creando Stock');
        }
        return $this->sendResponse(null, 'Stock Creado');

    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $stock = stocks::find($id);
        if (!$stock) {
            return $this->sendError('Stock no encontrado');
        }
        return $this->sendResponse(new StocksResource($stock), 'Stock');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        if ($this->validData($request)) {
            return $this->sendError('Error de validacion', $this->validData($request));
        }
        $stock = stocks::find($id);
        if (!$stock) {
            return $this->sendError('Stock no encontrado');
        }
        $stock->update($request->all());
        if (!$stock) {
            return $this->sendError('Error actualizando Stock');
        }
        return $this->sendResponse(null, 'Stock Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    //global validations
    public function validData($request)
    {
        $validator = Validator::make($request->all(), [
            'descripcion' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
        ]);
        return $validator->fails();
    }
}
