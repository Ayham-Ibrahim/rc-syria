<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\MedicalPointResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'name'             => $this->name,
            'specialis'        => $this->specialis,
            'medical_point_id' => new MedicalPointResource($this->medical_point),
        ];
    }
}
