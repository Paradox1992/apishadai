<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VistasResource extends JsonResource
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
            'modulo' => ModulosResource::make($this->Modulo),
            'nombre' => $this->nombre,
            'estado' => $this->Estado,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}