<?php

namespace App\services;

use App\Http\Traits\ApiResponseTrait;
use App\Models\Doctor;
use Exception;
use Illuminate\Support\Facades\Log;

class DoctorService
{
    use ApiResponseTrait;

    /**
     * Retrieves all doctors from the database.
     *
     * @return array An associative array containing the data, status, and message.
     */
    public function get_all_doctors()
    {
        $data    = [];
        $stats   = 200;
        $message = '';

        $doctors = Doctor::all();

        $data = $doctors;
        $message = "Done!";

        $result = [
            'data'    => $data,
            'status'  => $stats,
            'message' => $message
        ];

        return $result;
    }

    /**
     * Creates a new doctor record in the database.
     *
     * @param array $field_inputs An associative array containing the required fields for creating a doctor.
     * @return array An associative array containing the created doctor data, status, and message.
     *
     * @throws \Throwable If an error occurs during the database operation.
     * @throws Exception If an error occurs during the creation process, it throws an exception with the error response.
     */
    public function create_doctor(array $field_inputs)
    {
        $data    = [];
        $stats   = 201;
        $message = '';

        try {
            $doctor = Doctor::create([
                'medical_point_id' => $field_inputs['medical_point_id'],
                'name'             => $field_inputs['name'],
                'specialis'        => $field_inputs['specialis'],
            ]);

            $data    = $doctor;
            $message = 'Doctor Created Successfully';
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
     * Updates a doctor record in the database.
     *
     * @param array $field_inputs An associative array containing the fields to be updated.
     * @param Doctor $doctor The doctor model instance to be updated.
     * @return array An associative array containing the updated doctor data, status, and message.
     *
     * @throws \Throwable If an error occurs during the database operation.
     * @throws Exception If an error occurs during the update process, it throws an exception with the error response.
     */
    public function update_doctor(array $field_inputs, Doctor $doctor)
    {
        $data    = [];
        $stats   = 200;
        $message = '';

        try {
            $doctor->update(array_filter($field_inputs));

            $data    = $doctor;
            $message = 'Doctor Updated Successfully';
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
