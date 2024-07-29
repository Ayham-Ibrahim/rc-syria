<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicalPoint\StoreMedicalPointRequest;
use App\Http\Requests\MedicalPoint\UpdateMedicalPointRequest;
use App\Http\Resources\MedicalPointResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\MedicalPoint;
use App\Services\MedicalPointService;
use Illuminate\Http\Request;

class MedicalPointController extends Controller
{
    use ApiResponseTrait;

    /**
     * @var MedicalPointService
     */
    protected $medical_point_service;

    /**
     * MedicalPointController constructor.
     *
     * @param MedicalPointService $medical_point_service
     */
    public function __construct(MedicalPointService $medical_point_service)
    {
        $this->medical_point_service = $medical_point_service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $output         = $this->medical_point_service->get_all_medical_points();
        $output['data'] = MedicalPointResource::collection($output['data']);

        return $this->successResponse($output['data'], $output['message'], $output['status']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMedicalPointRequest $request)
    {
        $field_inputs = $request->validated();

        $output         = $this->medical_point_service->create_medical_point($field_inputs);
        $output['data'] = new MedicalPointResource($output['data']);

        return $this->successResponse($output['data'], $output['message'], $output['status']);
    }

    /**
     * Display the specified resource.
     */
    public function show(MedicalPoint $medicalPoint)
    {
        $data = new MedicalPointResource($medicalPoint);
        return $this->successResponse($data, 'Done!', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMedicalPointRequest $request, MedicalPoint $medicalPoint)
    {
        $field_inputs = $request->validated();

        $output         = $this->medical_point_service->update_medical_point($field_inputs, $medicalPoint);
        $output['data'] = new MedicalPointResource($output['data']);

        return $this->successResponse($output['data'], $output['message'], $output['status']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicalPoint $medicalPoint)
    {
        $medicalPoint->delete();
        return $this->successResponse(null, 'Medical Point Deleted Successfully', 200);
    }
}
