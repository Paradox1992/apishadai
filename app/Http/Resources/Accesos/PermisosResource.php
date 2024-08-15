<?php

namespace App\Http\Resources\Accesos;

use App\Http\Resources\user\UserResource;
use App\Models\formularios;
use App\Models\modulos;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermisosResource extends JsonResource
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
            'usuario' => UserResource::make(User::find($this->usuario)),
            'modulo' =>  ModulosResource::make(modulos::find($this->modulo)),
            'formulario' => FormulariosResource::make(formularios::find($this->formulario)),
        ];
    }
}