<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\LotesResource;
use App\Models\Lotes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LotesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //last 10 records
        $data = Lotes::orderBy('created_at', 'desc')->take(10)->get();
        if ($data) {
            return $this->sendResponse(LotesResource::collection($data), 'data');
        }
        return $this->sendResponse(null, 'No se encontraron datos', 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'producto.id' => 'required|integer|exists:prod_productos,id',
            'lote' => 'required|string|max:50|unique:lotes,lote',
            'create' => 'required|date',
            'exp' => 'required|date',
        ]);

        if ($validate->fails()) {
            return $this->sendError('Validation Error.', $validate->errors());
        }

        $data = Lotes::create([
            'producto_id' => $request->producto['id'],
            'lote' => $request->lote,
            'create' => $request->create,
            'exp' => $request->exp,
        ]);

        if ($data) {
            return $this->sendResponse(null, 'Lote guardado satisfactoriamente');
        }
        return $this->sendResponse(null, 'No se pudo registrar el lote', 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Lotes::find($id);
        if ($data) {
            return $this->sendResponse(LotesResource::make($data), 'data');
        }
        return $this->sendResponse(null, 'No se encontraron datos', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'producto.id' => 'required|integer|exists:prod_productos,id',
            'lote' => 'required|string|max:50|unique:lotes,lote' . ($id != 0 ? ",$id" : ''),
            'create' => 'required|date',
            'exp' => 'required|date',
        ]);

        if ($validate->fails()) {
            return $this->sendError('Validation Error.', $validate->errors());
        }

        $data = Lotes::find($id);
        if ($data) {
            $data->update([
                'producto_id' => $request->producto['id'],
                'lote' => $request->lote,
                'create' => $request->create,
                'exp' => $request->exp,
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
        $data = Lotes::find($id);
        if ($data) {
            try {
                $data->delete();
                return $this->sendResponse(null, 'Lote eliminado satisfactoriamente');
            } catch (\Throwable $th) {
                return $this->sendResponse(null, 'No se puede eliminar el lote porque tiene registros relacionados', 400);
            }
        }
        return $this->sendResponse(null, 'No se encontraron datos', 404);
    }
}
