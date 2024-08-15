<?php

namespace App\Http\Resources\user;

use App\Http\Resources\rolesResource;
use App\Http\Resources\UserStatusResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'rol' => $this->Rol,
            'name' => $this->name,
            'email' => $this->email,
            'password' => '0',
            'estado' => $this->Estado,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
