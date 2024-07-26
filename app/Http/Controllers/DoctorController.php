<?php

namespace App\Http\Controllers;

use App\Http\Requests\Doctor\StoreDoctorRequest;
use App\Http\Requests\Doctor\UpdateDoctorRequest;
use App\Http\Resources\DoctorResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Doctor;
use App\services\DoctorService;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    use ApiResponseTrait;

    /**
     * @var DoctorService
     */
    protected $doctor_service;

    /**
     * DoctorController constructor.
     *
     * @param DoctorService $doctor_service
     */
    public function __construct(DoctorService $doctor_service)
    {
        $this->doctor_service = $doctor_service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $output         = $this->doctor_service->get_all_doctors();
        $output['data'] = DoctorResource::collection($output['data']);

        return $this->successResponse($output['data'], $output['message'], $output['status']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDoctorRequest $request)
    {
        $field_inputs = $request->validated();

        $output         = $this->doctor_service->create_doctor($field_inputs);
        $output['data'] = new DoctorResource($output['data']);

        return $this->successResponse($output['data'], $output['message'], $output['status']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        $data = new DoctorResource($doctor);
        return $this->successResponse($data, 'Done!', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        $field_inputs = $request->validated();

        $output         = $this->doctor_service->update_doctor($field_inputs, $doctor);
        $output['data'] = new DoctorResource($output['data']);

        return $this->successResponse($output['data'], $output['message'], $output['status']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return $this->successResponse(null, 'Doctor Deleted Successfully', 200);
    }
}
