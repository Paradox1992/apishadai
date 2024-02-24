<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConfigsResources;
use App\Models\configs;
use App\Models\Devices;
use App\Models\Devicestatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class CfgController extends Controller
{

    public function getconfig(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'device_name' => 'required',
                'device_ip' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Error de validacion', $validator->errors(), 404);
            }
            $device = Devices::where('name', $request->device_name)->where('ip', $request->device_ip)->first();
            if (!$device) {
                return $this->sendError('Dispositivo Invadido', [], 404);
            }

            $deviceStatus = Devicestatus::where('id', $device->sts)->first();
            if ($deviceStatus['descripcion'] == 'Disabled') {
                return response()->json(['error' => 'Dispositivo Desactivado.'], 401);
            }

            $idConfig = $device->cfgstocks[0]['cfg'];
            if (!$idConfig) {
                return $this->sendError('Configuracion no encontrada', [], 404);
            }

            $config = ConfigsResources::make(configs::where('id', $idConfig)->get());
            if (!$config) {
                return $this->sendError('Configuracion no encontrada', [], 404);
            }
            $data = Crypt::encryptArray($config, $device->ip . $device->name);
            return $this->sendResponse($data, 'Configuracion encontrada');
        } catch (\Throwable $th) {
            return $this->sendError('Error de servidor', [], 500);
        }
    }
}