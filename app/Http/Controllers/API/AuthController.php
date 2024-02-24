<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Devices;
use App\Models\Devicestatus;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:users',
                'password' => 'required|min:6',
                'device_name' => 'required',
                'device_ip' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => 'Error de validacion.'], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->name . '@employee.com',
                'password' => bcrypt($request->password)
            ]);
            return response()->json(['name' => $user->name], 200);
        } catch (Throwable $e) {
            return response()->json(['error' => 'error al crear usuario.'], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'device_name' => 'required',
                'device_ip' => 'required',
                'u_name' => 'required',
                'u_password' => 'required',

            ]);
            if ($validator->fails()) {
                return response()->json(['error' => 'Error de validacion.' . $validator->errors()], 401);
            }

            $device = Devices::where('name', $request->device_name)->where('ip', $request->device_ip)->first();
            if (!$device) {
                return response()->json(['error' => 'Dispositivo no Autorizado.'], 401);
            }

            $deviceStatus = Devicestatus::where('id', $device->sts)->first();
            if ($deviceStatus['descripcion'] == 'Disabled') {
                return response()->json(['error' => 'Dispositivo Desactivado.'], 401);
            }

            $user = User::whereRaw('BINARY name = ?', [$request->u_name])->first();

            if ($user && Auth::attempt(['name' => $request->u_name, 'password' => $request->u_password])) {
                $user = Auth::user();
                $token = $user->createToken('MyApp')->accessToken;
                return response()->json(['token' => $token, 'name' => $user->name], 200);
            } else {
                return response()->json(['error' => 'Credenciales inválidas.'], 401);
            }

        } catch (Exception $e) {
            return response()->json(['error' => "No se pudo crear login:" . $e->getMessage()], 401);
        }
    }
    // logout
    public function logout(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'device_name' => 'required|unique:devices,name',
                'device_ip' => 'required|unique:devices,ip|max:14',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => 'Error de validacion.'], 401);
            }
            $token = $request->user()->token();
            $token->revoke();
            return response()->json(['message' => 'Successfully logged out']);
        } catch (Exception $e) {
            return response()->json(['error' => 'algo Salio mal.'], 500);
        }
    }

}
