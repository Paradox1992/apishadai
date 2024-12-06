<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\DistribucionResource;
use App\Models\Distribucion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DistribucionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // last 10 records
        $data = Distribucion::orderBy('created_at', 'desc')->take(10)->get();
        if ($data) {
            return $this->sendResponse(DistribucionResource::collection($data), 'data');
        }
        return $this->sendResponse(null, 'No se encontraron datos', 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'proveedor.id' => 'required|integer|exists:proveedores,id',
            'lote.id' => 'required|integer|exists:lotes,id',
            'precio' => 'required|numeric',
            'costo' => 'required|numeric',
            'isv' => 'required|numeric',
            'valor_isv' => 'required|numeric',
            'dto' => 'required|numeric',
            'valor_dto' => 'required|numeric',
        ]);

        if ($validate->fails()) {
            return $this->sendError(null, $validate->errors(), 400);
        }

        $create = Distribucion::create([
            'proveedor' => $request->proveedor['id'],
            'lote' => $request->lote['id'],
            'precio' => $request->precio,
            'costo' => $request->costo,
            'isv' => $request->isv,
            'valor_isv' => $request->valor_isv,
            'dto' => $request->dto,
            'dto_extra' => $request->dto_extra,
            'valor_dto' => $request->valor_dto,
            'valor_dto_extra' => $request->valor_dto_extra,
        ]);

        if ($create) {
            return $this->sendResponse(null, 'Lote guardado satisfactoriamente');
        }
        return $this->sendResponse(null, 'No se pudo registrar el lote', 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Distribucion::find($id);
        if ($data) {
            return $this->sendResponse(DistribucionResource::make($data), 'data');
        }
        return $this->sendResponse(null, 'No se encontraron datos', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'proveedor.id' => 'required|integer|exists:proveedores,id' . ($id != 0 ? ",$id" : ''),
            'lote.id' => 'required|integer|exists:lotes,id' . ($id != 0 ? ",$id" : ''),
            'precio' => 'required|numeric',
            'costo' => 'required|numeric',
            'isv' => 'required|numeric',
            'valor_isv' => 'required|numeric',
            'dto' => 'required|numeric',
            'dto_extra' => 'required|numeric',
            'valor_dto' => 'required|numeric',
            'valor_dto_extra' => 'required|numeric',
        ]);

        if ($validate->fails()) {
            return $this->sendError(null, $validate->errors(), 400);
        }

        $data = Distribucion::find($id);
        if ($data) {
            $data->update([
                'proveedor' => $request->proveedor['id'],
                'lote' => $request->lote['id'],
                'precio' => $request->precio,
                'costo' => $request->costo,
                'isv' => $request->isv,
                'valor_isv' => $request->valor_isv,
                'dto' => $request->dto,
                'dto_extra' => $request->dto_extra,
                'valor_dto' => $request->valor_dto,
                'valor_dto_extra' => $request->valor_dto_extra,
            ]);
            return $this->sendResponse(null, 'Lote actualizado satisfactoriamente');
        }
        return $this->sendResponse(null, 'No se pudo actualizar el lote', 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Distribucion::find($id);
        if ($data) {
            try {
                $data->delete();
                return $this->sendResponse(null, 'Registro eliminado');
            } catch (\Throwable $ex) {
                return $this->sendResponse(null, 'No se puede eliminar el registro porque tiene registros relacionados', 400);
            }
        }
        return $this->sendResponse(null, 'No se pudo registrar', 400);
    }
    public function findbyLote(string $loteId)
    {
        $data = Distribucion::where('lote', $loteId)->get();
        if ($data) {
            return $this->sendResponse(DistribucionResource::collection($data), 'data');
        }
        return $this->sendResponse(null, 'No se encontraron datos', 404);
    }


    public function findbyProveedor(string $proveedorId)
    {
        $data = Distribucion::where('proveedor', $proveedorId)->get();
        if ($data) {
            return $this->sendResponse(DistribucionResource::collection($data), 'data');
        }
        return $this->sendResponse(null, 'No se encontraron datos', 404);
    }
}