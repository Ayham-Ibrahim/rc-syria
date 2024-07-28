<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationSetting\UpdateApplicationSetting;
use App\Http\Resources\ApplicationSettingResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\ApplicationSetting;
use App\services\ApplicationSettingService;
use Illuminate\Http\Request;

/**
 * @SWG\Tag(
 *     name="Application Settings",
 *     description="Manage application settings"
 * )
 */
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
     * @SWG\Get(
     *     path="/api/get-application-setting",
     *     summary="Get application settings",
     *     tags={"Application Settings"},
     *     @SWG\Response(response=200, description="Successful operation", @SWG\Schema(ref="#/definitions/ApplicationSettingResource")),
     *     @SWG\Response(response=400, description="Invalid request")
     * )
     */
    public function show()
    {
        $output         = $this->application_setting_service->get_application_setting();
        $output['data'] = new ApplicationSettingResource($output['data']);

        return $this->successResponse($output['data'], $output['message'], $output['status']);
    }

    /**
     * @SWG\Put(
     *     path="/api/admin/update-application-setting",
     *     summary="Update application settings",
     *     tags={"Application Settings"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         @SWG\Schema(ref="#/definitions/UpdateApplicationSetting")
     *     ),
     *     @SWG\Response(response=200, description="Successful operation", @SWG\Schema(ref="#/definitions/ApplicationSettingResource")),
     *     @SWG\Response(response=400, description="Invalid request")
     * )
     */
    public function update(UpdateApplicationSetting $request)
    {
        $field_inputs = $request->validated();

        $output         = $this->application_setting_service->update_application_setting($field_inputs);
        $output['data'] = new ApplicationSettingResource($output['data']);

        return $this->successResponse($output['data'], $output['message'], $output['status']);
    }
}
