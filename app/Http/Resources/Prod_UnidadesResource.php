<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Prod_UnidadesResource extends JsonResource
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
            'abreviatura_c' => $this->abreviatura_c,
            'abreviatura_v' => $this->abreviatura_v,
            'cantidad_c' => $this->cantidad_c,
            'cantidad_v' => $this->cantidad_v,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}