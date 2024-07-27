<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ReceivingPointResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoResource extends JsonResource
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
            'full_name'         => $this->full_name,
            'phone_number'      => $this->phone_number,
            'id_number'         => $this->id_number,
            'address'           => $this->address,
            'status'            => $this->status,
            'age'               => $this->age,
            'user'              => new UserResource($this->user),
            'category'           => new CategoryResource($this->category),
        ];
    }
}
