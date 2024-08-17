<?php

namespace App\Http\Controllers;

use App\Http\Resources\Accesos\PermisosResource;
use App\Models\matchtoken;
use App\Models\Pcs;
use App\Models\permisos;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AuthController extends Controller
{
    /**
     * Summary of login
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $Validator = Validator::make($request->all(), [
                'name' => 'required|string|max:25',
                'password' => 'required|string|max:50',
            ]);

            if ($Validator->fails()) {
                return $this->sendResponse(null, $Validator->errors()->first(), 400);
            }

            if (auth()->attempt(['name' => $request->name, 'password' => $request->password])) {
                $user = auth()->user();
                $status = $user->Estado->descripcion;

                if ($status != 'ACTIVO') {
                    return $this->sendResponse(null, 'Usuario inactivo', 400);
                }


                $login['token'] = $user->createToken('MyApp')->accessToken;
                $device = $this->getPcInfo($request);
                $dataMatch = [
                    'usuario' => $user->id,
                    'pc' => $device->id,
                    'token' => $login['token'],
                ];
                $saveMath = matchtoken::create($dataMatch);
                if ($saveMath) {
                    $permisos = permisos::where('usuario', $user->id)->get();
                    $current_stock = $device->Stock;

                    $login['perfil'] = [
                        'usuario' => [
                            'id' => $user->id,
                            'name' => $user->name,
                            'rol' => $user->Rol,
                        ],
                        'stock' => $current_stock,
                    ];
                    $login['permisos'] = PermisosResource::collection($permisos);
                    return $this->sendResponse($login, 'User login successfully.');
                } else {
                    return $this->sendResponse(null, 'Error al crear Login.', 500);
                }
            } else {
                return $this->sendResponse(null, 'Credenciales Incorrectas', 400);
            }
        } catch (Throwable $th) {
            return $this->sendResponse(null, 'Error Interno:' . $th->getMessage(), 500);
        }
    }

    /**
     * Summary of register
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $Validator = Validator::make($request->all(), [
                'rol' => 'required|int',
                'name' => 'required|unique:users,name|string|max:50',
                'email' => 'required|string|email|max:100|unique:users',
                'password' => 'required|string|min:6',
                'estado' => 'required|int',
            ]);

            if ($Validator->fails()) {
                return $this->sendResponse(null, $Validator->errors()->first(), 400);
            }

            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            if ($user) {
                return $this->sendResponse(null, 'User register successfully.');
            }
            return $this->sendResponse(null, 'User register failed.', 500);
        } catch (Throwable $th) {
            return $this->sendResponse(null, 'Server Error:' . $th->getMessage(), 500);
        }
    }
    public function logout()
    {

        try {
            auth()->user()->token()->revoke();
            return $this->sendResponse(null, 'User logout successfully.');
        } catch (Throwable $th) {
            return $this->sendResponse($th->getMessage(), 'Error Interno', 500);
        }
    }

    /**
     * Summary of getPcInfo
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    private function getPcInfo(Request $request)
    {
        try {
            $DeviceName = $request->header('X-Device-Name');
            $DeviceIp = $request->header('X-Device-Ip');
            $device = Pcs::with('estado')->where('name', $DeviceName)->where('ip', $DeviceIp)->first();
            return $device;
        } catch (Throwable $th) {
            return null;
        }
    }
}