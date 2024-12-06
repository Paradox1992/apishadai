<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductosResource;
use App\Models\Productos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductosController extends Controller
{

    public function index()
    {
        $data = Productos::orderBy('created_at', 'desc')->take(50)->get();
        if ($data) {
            return $this->sendResponse(ProductosResource::collection($data), 'data');
        }
        return $this->sendResponse(null, 'No se encontraron datos', 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'categoria.id' => 'required|integer|exists:prod_categorias,id',
            'laboratorio.id' => 'required|integer|exists:laboratorios,id',
            'unidad.id' => 'required|integer|exists:prod_unidades,id',
            'familia.id' => 'required|integer|exists:familia,id',
            'codigo' => 'required|string|max:50|unique:productos,codigo',
            'codigobarra' => 'required|string|max:150|unique:productos,codigobarra',
            'descripcion' => 'required|string|max:150',
            'imagen' => 'required|base64image',
            'estado.id' => 'required|integer|exists:prod_estados,id',
        ]);

        if ($validate->fails()) {
            return $this->sendResponse(null, $validate->errors()->first(), 400);
        }

        $input = $request->all();
        $input['imagen'] = $request->imagen;
        $input['laboratorio'] = $request->laboratorio['id'];
        $input['unidad'] = $request->unidad['id'];
        $input['familia'] = $request->familia['id'];
        $input['estado'] = $request->estado['id'];
        $data = Productos::create($input);
        if ($data) {
            return $this->sendResponse(null, 'Registro creado');
        }
        return $this->sendResponse(null, 'Error al crear el registro', 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Productos::find($id);
        if ($data) {
            return $this->sendResponse(ProductosResource::make($data), 'data');
        }
        return $this->sendResponse(null, 'No se encontraron datos', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Productos::find($id);
        if ($data) {
            $validate = Validator::make($request->all(), [
                'categoria.id' => 'required|integer|exists:prod_categorias,id',
                'laboratorio.id' => 'required|integer|exists:laboratorios,id',
                'unidad.id' => 'required|integer|exists:prod_unidades,id',
                'familia.id' => 'required|integer|exists:familia,id',
                'codigo' => 'required|string|max:50|unique:productos,codigo' . ($id != 0 ? ",$id" : ''),
                'codigobarra' => 'required|string|max:150|unique:productos,codigobarra' . ($id != 0 ? ",$id" : ''),
                'descripcion' => 'required|string|max:150',
                'imagen' => 'required|base64image',
                'estado.id' => 'required|integer|exists:prod_estados,id',
            ]);

            if ($validate->fails()) {
                return $this->sendResponse(null, $validate->errors()->first(), 400);
            }

            $input = $request->all();
            $input['imagen'] = $request->imagen;
            $input['laboratorio'] = $request->laboratorio['id'];
            $input['unidad'] = $request->unidad['id'];
            $input['familia'] = $request->familia['id'];
            $input['estado'] = $request->estado['id'];
            $data->update($input);
            if ($data) {
                return $this->sendResponse(null, 'Registro actualizado');
            }
            return $this->sendResponse(null, 'No se pudo actualizar el registro', 400);
        }
        return $this->sendResponse(null, 'Registro no encontrado', 404);
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Productos::find($id);
        if ($data) {
            try {
                $data->delete();
                return $this->sendResponse(null, 'Registro eliminado');
            } catch (\Throwable $th) {
                return $this->sendResponse(null, 'No se puede eliminar el registro porque tiene registros relacionados', 400);
            }
        }

        return $this->sendResponse(null, 'Registro no encontrado', 404);
    }
}
