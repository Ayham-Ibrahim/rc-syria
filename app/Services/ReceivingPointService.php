<?php

namespace App\Services;

use Exception;
use App\Models\ReceivingPoint;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ApiResponseTrait;

class ReceivingPointService {
    use ApiResponseTrait;
    /**
     * list all receiving points
     */
    public function listReceivingPoint() {
        try {
            return ReceivingPoint::all();
        } catch (Exception $e) {
            Log::error('Error Listing receiving points '. $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }

    /**
     * Create a new receivingPoint
     * @param array $data
     * @return \App\Models\ReceivingPoint
     */
    public function createReceivingPoint(array $data){
        try {
            // Create a new receiving point record with the provided data
            return ReceivingPoint::create([
                'name'         => $data['name'],
                'open_time'    => $data['open_time'],
                'close_time'   => $data['close_time'],
            ]);
        } catch (Exception $e) {
            Log::error('Error creating receiving point.: ' . $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }


    /**
     * Update a specific ReceivingPoint.
     *
     * @param array $data
     * @param ReceivingPoint $receivingPoint
     * @return \App\Models\ReceivingPoint
     */
    public function updateReceivingPoint(array $data,$receivingPoint) {
        try {
            // Update the receivingPoint with the provided data, filtering out null values
            $receivingPoint->update(array_filter($data));
            // Return the updated receivingPoint
            return $receivingPoint;
        } catch (Exception $e) {
            Log::error('Error updating receivingPoint: ' . $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }


    /**
     * Delete a specific receivingPoint by its ID.
     *
     * @param ReceivingPoint $receivingPoint
     * @return void
     */
    public function deleteReceivingPoint($receivingPoint){
        try {
            $receivingPoint->delete();
        } catch (Exception $e) {
            Log::error('Error deleting receivingPoint '. $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }

}