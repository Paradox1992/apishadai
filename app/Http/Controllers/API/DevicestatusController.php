<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\DevicestatusResource;
use App\Models\Devicestatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DevicestatusController extends Controller
{
    public function index(): JsonResponse
    {
        $devstatus = Devicestatus::all();
        return $this->sendResponse(DevicestatusResource::collection($devstatus), 'Estados de Dispositivos');
    }
    // store
    public function store(Request $request): JsonResponse
    {
        if (!$this->validation($request)) {
            $input = $request->all();
            $devstatus = Devicestatus::create($input);
        } else {
            return $this->sendError('Error de validacion de Datos', null);
        }

        return $this->sendResponse(new DevicestatusResource($devstatus), 'Dispositivo creado correctamente');
    }

    // show by id
    public function show($id): JsonResponse
    {
        $devstatus = Devicestatus::find($id);
        if (is_null($devstatus)) {
            return $this->sendError('Estado de Dispositivo no encontrado');
        }
        return $this->sendResponse(new DevicestatusResource($devstatus), null);
    }

    //global validation
    public function validation(Request $request): bool
    {
        $validator = Validator::make($request->all(), [
            'descripcion' => 'required|unique:devicestatus,descripcion',
        ]);

        return $validator->fails();
    }

}