<?php

namespace App\Http\Resources\Accesos;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ModulosResource extends JsonResource
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
            'descripcion' => $this->descripcion,
            'estado' => Modulos_estadosResource::make($this->Estado),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}