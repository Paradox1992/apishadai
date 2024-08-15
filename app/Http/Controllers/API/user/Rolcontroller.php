<?php

namespace App\Http\Controllers\API\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\rolesResource;
use App\Models\roles;
use Illuminate\Http\Request;

class Rolcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = roles::all();
        return $this->sendResponse(rolesResource::collection($roles), 'roles');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $roles = roles::create($request->all());
            if (is_null($roles)) {
                return $this->sendResponse(null, 'rol no creado', 404);
            }
            return $this->sendResponse(null, 'role creado');
        } catch (\Exception $e) {
            return $this->sendResponse($e->getMessage(), 'Error al crear rol', 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $roles = roles::find($id);
        if (is_null($roles)) {
            return $this->sendResponse(null, 'rol no encontrado', 404);
        }
        return $this->sendResponse(rolesResource::make($roles), 'roles');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $roles = roles::find($id);
        if (is_null($roles)) {
            return $this->sendResponse(null, 'roles no encontrado ', 404);
        }
        $roles->update($request->all());
        return $this->sendResponse(null, 'rol actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $roles = roles::find($id);
        if (is_null($roles)) {
            return $this->sendResponse(null, 'rol no encontrado', 404);
        }
        $roles->delete();
        return $this->sendResponse(null, 'rol eliminado');
    }
}