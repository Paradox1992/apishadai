<?php

namespace App\Http\Controllers\API\Accesos;

use App\Http\Controllers\Controller;
use App\Http\Resources\Accesos\ModulosResource;
use App\Models\modulos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ModulosController extends Controller
{

    public function index()
    {

        $modulos = Modulos::orderBy('descripcion', 'asc')->get();
        if (!$modulos) {
            return $this->sendError('Error al obtener los modulos');
        }
        return $this->sendResponse(ModulosResource::collection($modulos), 'lista de modulos');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request);
        if ($validator->fails()) {
            return $this->sendResponse(null, $validator->errors());
        }

        $input = $request->all();
        $input['estado'] = $request->estado['id'];
        $modulo = modulos::create($input);
        if (!$modulo) {
            return $this->sendResponse(null, 'Error al crear el modulo', 400);
        }
        return $this->sendResponse(null, 'Modulo creado con exito');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $modulo = modulos::find($id);
        if (!$modulo) {
            return $this->sendResponse(null, 'Modulo no Disponible');
        }
        return $this->sendResponse(ModulosResource::make($modulo), null);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = Validator::make($request->all(), [
            'estado.id' => 'required|integer|exists:modulo_estados,id',
        ]);

        if ($validated->fails()) {
            return $this->sendResponse(null, $validated->errors()->first(), 400);
        }
        $input = $request->all();
        $input['estado'] = $request->estado['id'];
        $modulo = modulos::findOrFail($id);
        $modulo->update($input);
        if (!$modulo) {
            return $this->sendResponse(null, 'Error al actualizar el modulo', 400);
        }
        return $this->sendResponse(null, 'Modulo actualizado con exito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $modulo = modulos::find($id);
        $modulo->delete();
        if (!$modulo) {
            return $this->sendResponse(null, 'Error al eliminar el modulo');
        }
        return $this->sendResponse(null, 'Modulo eliminado con exito');
    }

    private function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'descripcion' => 'required|string|max:50|unique:modulos,descripcion',
            'estado.id' => 'required|integer|exists:modulo_estados,id',
        ]);
    }
}