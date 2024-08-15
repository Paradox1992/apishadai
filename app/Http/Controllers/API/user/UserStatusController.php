<?php

namespace App\Http\Controllers\API\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserStatusResource;
use App\Models\user_estados;
use Illuminate\Http\Request;
use Throwable;

class UserStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = user_estados::all();
        if (!$statuses) {
            return $this->sendResponse(null, 'No hay estados', 404);
        }
        return $this->sendResponse(UserStatusResource::collection($statuses), 'Listado de estados');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            user_estados::create($request->all());
            return $this->sendResponse(null, 'Status creado');
        } catch (Throwable $th) {
            return $this->sendResponse($th->getMessage(), 'Error al crear', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $status = user_estados::find($id);
            if (!$status) {
                return $this->sendResponse(null, 'Status no encontrado', 404);
            }
            return $this->sendResponse(UserStatusResource::make($status), 'Status encontrado');
        } catch (Throwable $th) {
            return $this->sendResponse($th->getMessage(), 'Error en busqueda', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $status = user_estados::find($id);
            if (!$status) {
                return $this->sendResponse(null, 'Status no encontrado', 404);
            }
            $status->update($request->all());
            return $this->sendResponse(null, 'Status actualizado');
        } catch (Throwable $th) {
            return $this->sendResponse($th->getMessage(), 'Error al actualizar', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $status = user_estados::find($id);
            if (!$status) {
                return $this->sendResponse(null, 'Status no encontrado', 404);
            }

            $status->delete();
            return $this->sendResponse(null, 'Status eliminado');
        } catch (Throwable $th) {
            return $this->sendResponse($th->getMessage(), 'Error al eliminar', 500);
        }
    }
}