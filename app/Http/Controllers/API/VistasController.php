<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\VistasResource;
use App\Models\Vistas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VistasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vistas = Vistas::all();

        if ($vistas->isEmpty()) {
            return $this->sendError(null, 'Vistas not found.', 404);
        }
        return $this->sendResponse(VistasResource::collection($vistas), 'Vistas retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'modulo.id' => 'required|integer|exists:modulos,id',
            'nombre' => 'required|string|max:150|unique:vistas,nombre',
            'estado.id' => 'required|integer|exists:estados,id',
        ]);

        if ($validate->fails()) {
            return $this->sendError(null, $validate->errors(), 400);
        }

        $create = Vistas::create([
            'modulo' => $request->modulo['id'],
            'nombre' => $request->nombre,
            'estado' => $request->estado['id'],
        ]);
        if ($create) {
            return $this->sendResponse(null, 'Vista creada con exito');
        }
        return $this->sendResponse(null, 'No se pudo registrar', 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vista = Vistas::find($id);
        if ($vista) {
            return $this->sendResponse(VistasResource::make($vista), 'Vista encontrada');
        }
        return $this->sendResponse(null, 'Vista no encontrada', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'modulo.id' => 'required|integer|exists:modulos,id',
            'nombre' => "required|string|max:150|unique:vistas,nombre,$id",
            'estado.id' => 'required|integer|exists:estados,id',
        ]);

        if ($validate->fails()) {
            return $this->sendResponse(null, $validate->errors()->first(), 400);
        }
        $vista = Vistas::find($id);
        if (!$vista) {
            return $this->sendResponse(null, 'Vista no encontrada', 404);
        }
        $vista->update([
            'modulo' => $request->modulo['id'],
            'nombre' => $request->nombre,
            'estado' => $request->estado['id'],
        ]);
        return $this->sendResponse(null, 'Vista actualizada con exito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vista = Vistas::find($id);
        if (!$vista) {
            return $this->sendResponse(null, 'Vista no encontrada', 404);
        }
        try {
            $vista->delete();
            return $this->sendResponse(null, 'Vista eliminada con exito');
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'No se pudo eliminar', 400);
        }
    }
}