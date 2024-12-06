<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DistribucionResource extends JsonResource
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
            'proveedor' => $this->Proveedor,
            'lote' => LotesResource::make($this->Lote),
            'precio' => $this->precio,
            'costo' => $this->costo,
            'isv' => $this->isv,
            'valor_isv' => $this->valor_isv,
            'dto' => $this->dto,
            'dto_extra' => $this->dto_extra,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}