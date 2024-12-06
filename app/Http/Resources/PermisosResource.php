<?php

namespace App\Http\Resources;

use App\Http\Resources\user\UserResource;
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
            'usuario' => UserResource::make($this->Usuario),
            'modulo' => ModulosResource::make($this->Modulo),
            'vista' => VistasResource::make($this->Vista),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
