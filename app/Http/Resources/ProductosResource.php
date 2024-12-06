<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductosResource extends JsonResource
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
            'categoria' => $this->Categoria,
            'laboratorio' => $this->Laboratorio,
            'unidad' => $this->Unidad,
            'familia' => $this->Familia,
            'codigo' => $this->codigo,
            'codigobar' => $this->codigobar,
            'descripcion' => $this->descripcion,
            'imagen' => $this->imagen,
            'estado' => $this->Estado,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}