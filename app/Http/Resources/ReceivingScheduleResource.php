<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\ReceivingPointResource;


class ReceivingScheduleResource extends JsonResource
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
            'receiving_time'=> $this->receiving_time,
            'user' => new UserResource($this->user),
            'receiving_point' => new ReceivingPointResource($this->receivingPoint),
        ];
    }
}
