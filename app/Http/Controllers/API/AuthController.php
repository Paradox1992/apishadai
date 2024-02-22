<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Devices;
use App\Models\Devicestatus;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class AuthController extends Controller
{

    public function register(Request $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            return response()->json(['name' => $user->name], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'error al crear usuario.'], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $device = Devices::where('ip', $request->ip())->first();
            if (!$device) {
                return response()->json(['error' => 'Dispositivo Invalido.' . $request->ip()], 401);
            }
            $deviceStatus = Devicestatus::where('id', $device->sts)->first();
            if ($deviceStatus['descripcion'] == 'Disabled') {
                return response()->json(['error' => 'Dispositivo no Autorizado.'], 401);
            }

            if (Auth::attempt(['name' => $request->name, 'password' => $request->password])) {
                $user = Auth::user();
                $token = $user->createToken('MyApp')->accessToken;
                return response()->json(['token' => $token, 'name' => $user->name], 200);
            } else {
                return response()->json(['error' => 'Credenciales Invalidas.'], 401);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'error al crear login.' . $e->getMessage()], 500);
        }
    }
    // logout
    public function logout(Request $request)
    {
        try {
            $token = $request->user()->token();
            $token->revoke();
            return response()->json(['message' => 'Successfully logged out']);
        } catch (Exception $e) {
            return response()->json(['error' => 'algo Salio mal.'], 500);
        }
    }


}