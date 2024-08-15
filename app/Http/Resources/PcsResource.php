<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PcsResource extends JsonResource
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
            'name' => $this->name,
            'ip' => '0',
            'stock' => $this->Stock,
            'estado' => $this->Estado,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}