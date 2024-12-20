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
    { // resolver las relaciones n+1 
        
        return [
            'id' => $this->id,
            'modulo' => [
                $this->Modulo,
                $this->Modulo->Vista,
            ]

        ];
    }
}
