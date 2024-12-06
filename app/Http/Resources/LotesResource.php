<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LotesResource extends JsonResource
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
            'producto' => ProductosResource::make($this->Producto),
            'lote' => $this->lote,
            'create' => $this->create,
            'exp' => $this->exp,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
