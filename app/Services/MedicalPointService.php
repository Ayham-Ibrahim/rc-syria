<?php

namespace App\Services;

use App\Http\Traits\ApiResponseTrait;
use App\Models\MedicalPoint;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MedicalPointService
{
    use ApiResponseTrait;

    /**
     * Retrieves all medical points from the database.
     *
     * @return array An array containing the status, message, and data.
     */
    public function get_all_medical_points()
    {
        $data    = [];
        $stats   = 200;
        $message = '';

        $medical_points = MedicalPoint::all();

        $data = $medical_points;
        $message = "Done!";

        $result = [
            'data'    => $data,
            'status'  => $stats,
            'message' => $message
        ];

        return $result;
    }

    /**
     * Creates a new medical point in the database.
     *
     * @param array $field_inputs An associative array containing the required fields for creating a medical point.
     * @return array An array containing the status, message, and data.
     *
     * @throws \Throwable If an error occurs during the database operation.
     * @throws Exception If an error occurs during the creation process, it throws an exception with the error response.
     */
    public function create_medical_point(array $field_inputs)
    {
        $data    = [];
        $stats   = 201;
        $message = '';

        try {
            $medical_point = MedicalPoint::create([
                'name'    => $field_inputs['name'],
                'address' => $field_inputs['address'],
            ]);

            $data = $medical_point;
            $message = 'Medical Point Created Successfully';
        } catch (\Throwable $th) {
            $message = 'Something went wrong';
            $stats = 500;
            Log::error($message);
            Log::error($th->getMessage());
            throw new Exception($this->errorResponse(null, $message, $stats));
        }

        $result = [
            'data'    => $data,
            'status'  => $stats,
            'message' => $message
        ];

        return $result;
    }

    /**
     * Updates a medical point in the database.
     *
     * @param array $field_inputs An associative array containing the fields to be updated.
     * @param MedicalPoint $medical_point The medical point model instance to be updated.
     * @return array An array containing the status, message, and data.
     *
     * @throws \Throwable If an error occurs during the database operation.
     * @throws Exception If an error occurs during the update process, it throws an exception with the error response.
     */
    public function update_medical_point(array $field_inputs, MedicalPoint $medical_point)
    {
        $data    = [];
        $stats   = 200;
        $message = '';

        try {
            $medical_point->update(array_filter($field_inputs));

            $data    = $medical_point;
            $message = 'Medical Point Updated Successfully';
        } catch (\Throwable $th) {
            $message = 'Something went wrong';
            $stats = 500;
            Log::error($message);
            Log::error($th->getMessage());
            throw new Exception($this->errorResponse(null, $message, $stats));
        }

        $result = [
            'data'    => $data,
            'status'  => $stats,
            'message' => $message
        ];

        return $result;
    }
}
