<?php

namespace App\Hooks;

use App\Models\matchtoken;
use App\Models\Pcs;
use App\Models\permisos;
use App\Models\User;
use Illuminate\Support\Facades\DB;


trait FilterChain
{
    private $request;
    private $userId;
    private $DeviceName;
    private $DeviceIp;
    private $Token;

    private $method;
    public function __construct()
    {
        $this->AccesDataBase();
        $this->request = request();
        $this->method = $this->request->method();
        $this->userId = $this->request->header('X-User-Id');
        $this->DeviceName = $this->request->header('X-Device-Name');
        $this->DeviceIp = $this->request->header('X-Device-Ip');
        $this->Token = $this->request->bearerToken();

        if (!$this->comparePathLogin()) {
            $this->checkUser();
            $this->checkDevice();
            $this->ExpireToken();
            $this->MatchTokenUser();
            $this->AccessControl();
        } else {
            $this->checkDevice();
        }
    }



    private function checkUser()
    {

        $user = User::where('id', $this->userId)->first();
        if (!$user) {
            $this->Send(null, 'Usuario Invalido', 400);
        }

        if ($user->Estado->descripcion != 'ACTIVO') {
            $this->Send('Usuario Inactivo', 400);
        }
    }

    private function checkDevice()
    {
        $device = Pcs::with('estado')->where('name', $this->DeviceName)->where('ip', $this->DeviceIp)->first();
        if (!$device) {
            $this->Send(null, 'Dispositivo Invalido', 400);
        }
        if ($device->Estado->descripcion != 'ACTIVO') {
            $this->Send(null, 'Dispositivo no Autorizado', 400);
        }
    }
    public function ExpireToken()
    {
        $token = $this->getDecodeToken($this->Token);
        if (!$token) {
            $this->Send('Token Invalido', 401);
        }
        $tokenExp = $token->exp;
        $currentDateTime = time();
        if ($tokenExp < $currentDateTime) {
            matchtoken::where('token', $this->Token)->delete();
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
        $access = $this->get_accesStatus($this->userId, $path['mdl'], $path['frm']);

        if (empty($access->toArray())) {
            $this->Send(null, 'Acceso Denegado', 400);
        }

        if ($access[0]['mestado'] != 'ACTIVO') {
            $this->Send(null, ' Modulo no Disponible', 400);
        }

        if ($access[0]['festado'] != 'ACTIVO') {
            $this->Send(null, 'Formulario no Disponible', 400);
        }

        // logout
        if ($path['mdl'] == 'auth' && $path['frm'] == 'logout') {
            matchtoken::where('token', $this->Token)->delete();
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
            'mdl' => $modulo,
            'frm' => $frm
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
        $pci_id = Pcs::where('name', $this->DeviceName)
            ->where('ip', $this->DeviceIp)->first()->id;
        $hasMatch = matchtoken::where('usuario', $this->userId)
            ->where('pc', $pci_id)
            ->where('token', $this->Token)->first();
        if (!$hasMatch) {
            $this->Send(null, 'Token Invalido', 400);
        }
    }

    private function get_accesStatus($uId, $modulo, $frm)
    {
        return Permisos::select('modulo_estados.descripcion as mestado', 'frm_estados.descripcion as festado')
            ->join('modulos', 'permisos.modulo', '=', 'modulos.id')
            ->join('formularios', 'permisos.formulario', '=', 'formularios.id')
            ->join('modulo_estados', 'modulos.estado', '=', 'modulo_estados.id')
            ->join('frm_estados', 'formularios.estado', '=', 'frm_estados.id')
            ->where('permisos.usuario', '=', $uId)
            ->where('modulos.descripcion', '=', $modulo)
            ->where('formularios.descripcion', '=', $frm)
            ->get();
    }


    private function comparePathLogin()
    {
        $path = $this->getURL();
        if ($path['mdl'] == 'auth' && $path['frm'] == 'login') {
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
}
