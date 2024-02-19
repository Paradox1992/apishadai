<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConfigsResources;
use App\Http\Resources\ConfigStocksResource;
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
        $device = Devices::where('ip', $request->ip())->first();
        if (!$device) {
            return $this->sendError('Dispositivo Invadido', [], 404);
        }

        $statusId = $device['sts'];
        $dataStatus = Devicestatus::where('id', $statusId)->get();

        if ($dataStatus[0]['descripcion'] == 'Disabled') {
            return $this->sendError('Dispositivo no Autorizado', [], 404);
        }

        $id_cfg = $device->cfgstocks[0]['cfg'];
        $config = ConfigsResources::make(configs::where('id', $id_cfg)->get());
        if (!$config) {
            return $this->sendError('Configuracion no encontrada', [], 404);
        }
        $data = Crypt::encryptArray($config, $request->ip());
        return $this->sendResponse($data, 'Configuracion encontrada');
    }
}