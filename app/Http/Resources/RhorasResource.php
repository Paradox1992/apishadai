<?php

namespace App\Http\Resources;

use App\Models\Devices;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RhorasResource extends JsonResource
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
            'usuario' => UserResource::collection(User::where('id', $this->usuario)->get()),
            'device' => DevicesResource::collection(Devices::where('id', $this->device)->get()),
            'entrada' => $this->entrada,
            'salida' => $this->salida,
            'total' => $this->total
        ];

    }
}
