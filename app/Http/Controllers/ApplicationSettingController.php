<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationSetting\UpdateApplicationSetting;
use App\Http\Resources\ApplicationSettingResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\ApplicationSetting;
use App\Services\ApplicationSettingService;
use Illuminate\Http\Request;

class ApplicationSettingController extends Controller
{
    use ApiResponseTrait;

    /**
     * @var ApplicationSettingService
     */
    protected $application_setting_service;

    /**
     * ApplicationSettingController constructor.
     *
     * @param ApplicationSettingService $application_setting_service
     */
    public function __construct(ApplicationSettingService $application_setting_service)
    {
        $this->application_setting_service = $application_setting_service;
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $output         = $this->application_setting_service->get_application_setting();
        $output['data'] = new ApplicationSettingResource($output['data']);

        return $this->successResponse($output['data'], $output['message'], $output['status']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApplicationSetting $request)
    {
        $field_inputs = $request->validated();

        $output         = $this->application_setting_service->update_application_setting($field_inputs);
        $output['data'] = new ApplicationSettingResource($output['data']);

        return $this->successResponse($output['data'], $output['message'], $output['status']);
    }

}
