<?php

namespace App\Http\Resources\Accesos;

use App\Http\Resources\Accesos\ModulosResource;
use App\Models\modulos;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormulariosResource extends JsonResource
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
            'modulo' =>  ModulosResource::make(modulos::find($this->modulo)),
            'descripcion' => $this->descripcion,
            'estado' => Frm_EstadosResource::make($this->Estado),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}