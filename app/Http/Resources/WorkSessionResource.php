<?php

namespace App\Http\Resources;

use App\Http\Resources\user\UserResource;
use App\Models\Pcs;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkSessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $pc = Pcs::where('id', $this->pc_work)->first();


        return [
            'id' => $this->id,
            'pc_work' => PcsResource::make($pc),
            'user_id' => UserResource::make($this->User),
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'lunch_start_time' => $this->lunch_start_time,
            'lunch_end_time' => $this->lunch_end_time,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}