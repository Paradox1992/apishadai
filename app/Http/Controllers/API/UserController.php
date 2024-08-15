<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\user\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $usuarios = User::all();
        if ($usuarios) {
            return $this->sendResponse(UserResource::collection($usuarios), 'lista de usuarios');
        }
        return $this->sendResponse(null, 'No se encontraron usuarios', 404);
    }

    public function show(int $id): JsonResponse
    {
        $user = User::find($id);
        if ($user) {
            return $this->sendResponse(UserResource::make($user), 'User found.');
        }
        return $this->sendResponse(null, 'No se pudo realizar la operacion.', 404);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'rol.id' => 'required|exists:roles,id',
                'name' => 'required|unique:users,name|string|max:20',
                'email' => 'required|string|email|max:100|unique:users',
                'password' => 'required|string|min:6',
                'estado.id' => 'required|exists:user_estados,id',
            ]);

            if ($validator->fails()) {
                return $this->sendResponse(null, $validator->errors()->first(), 400);
            }

            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $input['rol'] = $request->rol['id'];
            $input['estado'] = $request->estado['id'];

            $user = User::create($input);
            if ($user) {
                return $this->sendResponse(null, 'Usuario registrado.');
            }
            return $this->sendResponse(null, 'No se pudo realizar la operacion.', 500);
        } catch (Throwable $th) {
            return $this->sendResponse(null, 'Server Error:' . $th->getMessage(), 500);
        }
    }
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $userId = $id;
            $rules = [
                'rol.id' => 'required|exists:roles,id',
                'name' => "required|string|max:50|unique:users,name,$userId",
                'estado.id' => 'required|exists:user_estados,id',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return $this->sendResponse(null, $validator->errors()->first(), 400);
            }

            $input = $request->all();
            $input['rol'] = $request->rol['id'];
            $input['estado'] = $request->estado['id'];
            unset($input['password']);
            unset($input['email']);

            $user = User::findOrFail($userId);
            $user->update($input);
            return $this->sendResponse(null, 'Usuario actualizado.');
        } catch (Throwable $exception) {
            return $this->sendResponse(null, $exception->getMessage(), 500);
        }
    }
    public function destroy(int $id): JsonResponse
    {
        try {
            $user = User::find($id);
            if ($user) {
                $user->delete();
                return $this->sendResponse(null, 'Usuario eliminado.');
            }
            return $this->sendResponse(null, 'No se pudo realizar la operacion.', 404);
        } catch (Throwable $exception) {
            return $this->sendResponse(null, $exception->getMessage(), 500);
        }
    }
}