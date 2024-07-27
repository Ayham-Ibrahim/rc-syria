<?php 

namespace App\Services;

use Exception;
use App\Models\ReceivingSchedule;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ApiResponseTrait;

class ReceivingScheduleService
{
    use ApiResponseTrait;
    /**
     * list all Receiving Schedules
     */
    public function listReceivingSchedule() {
        try {
            return ReceivingSchedule::all();
        } catch (Exception $e) {
            Log::error('Error Listing Receiving Schedules '. $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }

    /**
     * Create a new ReceivingSchedule
     * @param array $data
     * @return \App\Models\ReceivingSchedule
     */
    public function createReceivingSchedule(array $data){
        try {
            // Create a new Receiving Schedule record with the provided data
            return ReceivingSchedule::create([
                'user_id'         => $data['user_id'],
                'receiving_point_id'    => $data['receiving_point_id'],
                'receiving_time'   => $data['receiving_time'],
            ]);
        } catch (Exception $e) {
            Log::error('Error creating Receiving Schedule.: ' . $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }


        /**
     * Update a specific ReceivingSchedule.
     *
     * @param array $data
     * @param ReceivingSchedule $receivingSchedule
     * @return \App\Models\ReceivingSchedule
     */
    public function updateReceivingSchedule(array $data,$receivingSchedule) {
        try {
            // Update the receivingSchedule with the provided data, filtering out null values
            $receivingSchedule->update(array_filter($data));
            // Return the updated receivingSchedule
            return $receivingSchedule;
        } catch (Exception $e) {
            Log::error('Error updating receivingSchedule: ' . $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }


    /**
     * Delete a specific Receiving Schedule by its ID.
     *
     * @param ReceivingSchedule $receivingSchedule
     * @return void
     */
    public function deleteReceivingSchedule($receivingSchedule){
        try {
            $receivingSchedule->delete();
        } catch (Exception $e) {
            Log::error('Error deleting receivingSchedule '. $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }
}

