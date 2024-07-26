<?php

namespace App\services;

use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\FileStorageTrait;
use App\Models\ApplicationSetting;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ApplicationSettingService
{
    use FileStorageTrait, ApiResponseTrait;

    /**
     * Retrieves the first record from the ApplicationSetting model.
     *
     * @return array An associative array containing the data, status, and message.
     */
    public function get_application_setting()
    {
        $data    = [];
        $stats   = 200;
        $message = '';

        $application_setting = ApplicationSetting::first();

        $data    = $application_setting;
        $message = 'Done!';

        $result = [
            'data'    => $data,
            'status'  => $stats,
            'message' => $message
        ];

        return $result;
    }

    /**
     * Updates the first record in the ApplicationSetting model.
     *
     * @param array $field_inputs An associative array containing the new values for the ApplicationSetting fields.
     *
     * @return array An associative array containing the updated data, status, and message.
     *
     * @throws \Throwable If an error occurs during the database operation.
     * @throws Exception If an error occurs during the creation process, it throws an exception with the error response.
     */
    public function update_application_setting(array $field_inputs)
    {
        $data    = [];
        $stats   = 200;
        $message = '';

        try {
            DB::beginTransaction();
            $application_setting = ApplicationSetting::first();

            $application_setting->name        = $field_inputs['name'] ?? $application_setting->name;
            $application_setting->logo        = $this->fileExists($field_inputs['logo'], $application_setting->logo, 'ApplicationSetting') ?? $application_setting->logo;
            $application_setting->description = $field_inputs['description'] ?? $application_setting->description;
            $application_setting->facebook    = $field_inputs['facebook'] ?? $application_setting->facebook;
            $application_setting->youtube     = $field_inputs['youtube'] ?? $application_setting->youtube;
            $application_setting->save();

            DB::commit();
            $data    = $application_setting;
            $message = 'Application Setting Updated Successfully';
        } catch (\Throwable $th) {
            $message = 'Something went wrong';
            $stats = 500;
            Log::error($message);
            Log::error($th->getMessage());
            DB::rollBack();
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
