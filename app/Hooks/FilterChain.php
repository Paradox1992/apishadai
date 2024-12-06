<?php

namespace App\Hooks;

use App\Models\Devices;
use App\Models\MatchToken;
use App\Models\permisos;
use App\Models\User;
use Illuminate\Support\Facades\DB;


/**
 * Validate Data Transfer
 */
trait FilterChain
{
    private $request;
    private $userId;
    private $DeviceUUID;
    private $DeviceName;
    private $DeviceIp;
    private $DeviceIp2;
    private $Token;

    private $method;
    public function __construct()
    {
        $this->AccesDataBase();
        $this->request = request();
        $this->method = $this->request->method();
        $this->DeviceName = $this->request->header('X-Device-Name');
        $this->DeviceIp = $this->request->header('X-Device-Ip');
        $this->DeviceIp2 = $this->request->header($this->request->ip());
        $this->Token = $this->request->bearerToken();

        if (!$this->comparePathLogin()) {
            $this->ExpiredToken();
            $this->checkDevice();
            $this->setUserId();
            $this->checkUser();
            $this->MatchTokenUser();
             $this->AccessControl();
        } else {
            $this->checkDevice();
        }
    }


    private function checkUser()
    {
        $decodedToken = $this->getDecodeToken($this->Token);
        if (!$decodedToken) {
            $this->Send('Token Invalido', 401);
        }

        $this->userId = $decodedToken->sub;
        $user = User::where('id', $this->userId)->first();
        if (!$user) {
            $this->Send(null, 'Usuario Invalido', 401);
        }
        $status = $user->Estado->descripcion;

        if ($status != 'ACTIVO') {
            $this->Send(null, 'Usuario Inactivo', 401);
        }
    }

    private function checkDevice()
    {

        $device = Devices::where('name', $this->DeviceName)
            ->where('ip', $this->DeviceIp)
            ->where('ip2', $this->request->ip())
            ->first();
        if (!$device) {
            $this->Send(null, 'Dispositivo Invalido', 401);
        }
        if ($device->Estado->descripcion != 'ACTIVO') {
            $this->Send(null, 'Dispositivo no Autorizado', 401);
        }
    }
    public function ExpiredToken()
    {
        $token = $this->getDecodeToken($this->Token);
        if (!$token) {
            $this->Send('Token Invalido', 401);
        }
        $tokenExp = $token->exp;
        $currentDateTime = time();
        if ($tokenExp < $currentDateTime) {
            MatchToken::where('token', $this->Token)->delete();
            $this->Send(null, 'Session Expirada', 401);
        }
    }


    public function send($result, $message, $code = 200)
    {
        $response = [
            'message' => $message,
            'code' => $code,
            'data' => $result,
        ];
        http_response_code($code);
        die(json_encode($response));
    }

    private function AccessControl()
    {
        $path = $this->getURL();

        $status = $this->get_md_vw($this->userId, $path['md'], $path['vw']);
        if (!$status) {
            $this->Send(null, 'Acceso Denegado', 401);
        }

        $data_status = $status ->first();
        if ($data_status['md_status'] != 'ACTIVO') {
            $this->Send(null, 'Modulo no Disponible', 401);
        }

        if ($data_status['vw_status'] != 'ACTIVO') {
            $this->Send(null, 'Vista no Disponible', 401);
        }
    }


    private function getURL()
    {

        $partes = explode('/', trim(parse_url($this->request->url(), PHP_URL_PATH), '/'));

        $modulo = '';
        $frm = '';

        $numPartes = count($partes);
        if ($numPartes >= 2) {
            $frm = $partes[$numPartes - 1];
            $modulo = $partes[$numPartes - 2];
            if ($numPartes > 2 && is_numeric($frm)) {

                $frm = $modulo;
                $modulo = $partes[$numPartes - 3];
            }
        }
        $result = [
            'md' => $modulo,
            'vw' => $frm
        ];

        return $result;
    }

    private function getDecodeToken($jwt)
    {
        $token = explode('.', $jwt);
        $token = base64_decode($token[1]);
        $token = json_decode($token);
        return $token;
    }

    private function MatchTokenUser()
    {

        $matchToken = MatchToken::where('token', $this->Token)
            ->whereHas('usuario', function ($query) {
                $query->where('id', $this->userId);
            })
            ->whereHas('device', function ($query) {
                $query->where('ip', $this->DeviceIp)
                    ->where('ip2', $this->request->ip())
                    ->where('name', $this->DeviceName);
            })
            ->first();

        if (!$matchToken) {
            $this->Send(null, 'Acceso Denegado', 401);
        }
    }

    private function get_md_vw($user_id, $modulo_id, $view_id)
{
    return Permisos::where('usuario', $user_id)
        ->whereHas('modulo', function ($query) use ($modulo_id) {
            $query->where('nombre', $modulo_id);
        })
        ->whereHas('vista', function ($query) use ($view_id) {
            $query->where('nombre', $view_id);
        })
        ->with([
            'modulo.estado' => function ($query) {
                $query->select('id', 'descripcion');
            },
            'vista.estado' => function ($query) {
                $query->select('id', 'descripcion');
            }
        ])
        ->get()
        ->map(function ($permiso) {
            return [
                'md_status' => $permiso->Modulo->Estado->descripcion,
                'vw_status' => $permiso->Vista->Estado->descripcion,
            ];
        });
}

    private function comparePathLogin()
    {
        $path = $this->getURL();
        if ($path['md'] == 'auth' && $path['vw'] == 'login') {
            return true;
        }
        return false;
    }

    private function AccesDataBase()
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            $this->Send(null, 'Aplicacion no Disponible', 400);
        }
    }


    private function setUserId()
    {
        $decodeToken = $this->getDecodeToken($this->Token);
        $this->userId = $decodeToken->sub;
    }
}