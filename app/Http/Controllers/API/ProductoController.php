<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductosResource;
use App\Models\Productos;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ProductoController extends Controller
{
    //index
    public function index(): JsonResponse
    {
        $productos = Productos::all();
        return $this->sendResponse(ProductosResource::collection($productos), 'Listado de Productos');
    }

    //store
    public function store(Request $request): JsonResponse
    {
        try {
            if ($this->validData($request)) {
                return $this->sendError('Error de validacion de Datos', null);
            }

            if (Productos::where('codigo', $request->codigo)->exists()) {
                return $this->sendError('El producto ya existe');
            }

            $productos = Productos::create($request->all());
            return $this->sendResponse(new ProductosResource($productos), 'Producto creado');
        } catch (Throwable $e) {
            return $this->sendError('Error Inesperado', 400);
        }
    }

    // show by id from parameter
    public function show($id): JsonResponse
    {
        $producto = Productos::find($id);
        if (!$producto) {
            return $this->sendError('Producto no encontrado');
        }
        return $this->sendResponse(new ProductosResource($producto), 'Producto encontrado');
    }


    public function update(Request $request, Productos $productos, $id): JsonResponse
    {
        try {
            if ($this->validData($request)) {
                return $this->sendError('Error de validacion de Datos', null);
            }

            if (!Productos::where('id', $id)->exists()) {
                return $this->sendError('El producto no existe');
            }
            $producto = Productos::find($id);
            $producto['descripcion'] = $request->descripcion;
            $producto['updated_at'] = now();
            $producto->update();
            if (!$productos) {
                return $this->sendError('Error al actualizar el producto');
            }
            return $this->sendResponse(null, 'Producto actualizado');
        } catch (Throwable $e) {
            return $this->sendError('Error Inesperado', 400);
        }


    }

    public function destroy($id): JsonResponse
    {
        try {
            if (!Productos::where('id', $id)->exists()) {
                return $this->sendError('El producto no existe');
            }
            $producto = Productos::find($id);
            $producto->delete();
            return $this->sendResponse(null, 'Producto eliminado');
        } catch (Throwable $e) {
            return $this->sendError('Error Inesperado', 400);
        }


    }


    private function validData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'required',
            'descripcion' => 'required',
        ]);
        return $validator->fails();
    }
}