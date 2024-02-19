<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\DevicesResource;
use App\Models\devices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DevicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $devices = devices::all();

        return $this->sendResponse(DevicesResource::collection($devices), 'Lista de Dispositivos');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($this->ValidateData($request)) {
            return $this->sendError('Dispositivo ya registrado', [], 409);
        }
        $device = devices::create($request->all());
        if (!$device) {
            return $this->sendError('Dispositivo no creado', [], 500);
        }
        return $this->sendResponse(null, 'Dispositivo creado con exito');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $device = devices::find($id);
        if (!$device) {
            return $this->sendError('Dispositivo no encontrado', [], 404);
        }
        return $this->sendResponse(DevicesResource::make($device), 'Dispositivo encontrado');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    private function ValidateData(Request $request): bool
    {
        $validator = Validator::make($request->all(), [
            'ip' => 'required|string|max:14|unique:devices,ip',
            'stock' => 'required',
            'sts' => 'required',
        ]);
        return $validator->fails();
    }
}
