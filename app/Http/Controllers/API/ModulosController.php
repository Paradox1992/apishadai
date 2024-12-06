<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ModulosResource;
use App\Models\Modulos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ModulosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modulos = Modulos::all();
        if (count($modulos) > 0) {
            return $this->sendResponse(ModulosResource::collection($modulos), 'Listado de modulos');
        } else {
            return $this->sendResponse(null, 'No hay registros', 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nombre' => 'required|string|max:80|unique:modulos,nombre',
            'estado.id' => 'required|integer|exists:modulos_estados,id',
        ]);

        if ($validate->fails()) {
            return $this->sendResponse(null, $validate->errors(), 404);
        }

        $modulos = new Modulos();
        $modulos->nombre = $request->nombre;
        $modulos->estado_id = $request->estado['id'];
        $modulos->save();
        if ($modulos) {
            return $this->sendResponse(null, 'Modulo creado con exito');
        }
        return $this->sendResponse(null, 'Error al crear modulo', 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $modulos = Modulos::find($id);
        if ($modulos) {
            return $this->sendResponse(ModulosResource::make($modulos), 'Modulo encontrado');
        }
        return $this->sendResponse(null, 'Modulo no encontrado', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'nombre' => "required|string|max:80|unique:modulos,nombre,{$id}",
            'estado.id' => 'required|integer|exists:modulos_estados,id' . ($id != 0 ? ",$id" : ''),
        ]);

        if ($validate->fails()) {
            return $this->sendResponse(null, $validate->errors()->first(), 400);
        }
        $modulos = Modulos::find($id);
        if (!$modulos) {
            return $this->sendResponse(null, 'Modulo no encontrado', 404);
        }
        $modulos->update([
            'nombre' => $request->input('nombre'),
            'estado_id' => $request->input('estado.id'),
        ]);
        return $this->sendResponse(null, 'Modulo actualizado con exito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $modulos = Modulos::find($id);
        if (!$modulos) {

            return $this->sendResponse(null, 'Modulo no encontrado', 404);
        }

        try {
            $modulos->delete();
            return $this->sendResponse(null, 'Modulo eliminado con exito');
        } catch (\Exception $e) {
            return $this->sendResponse(null, 'No se puede eliminar el modulo', 400);
        }
    }
}