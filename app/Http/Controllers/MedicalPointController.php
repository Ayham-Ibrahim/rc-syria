<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicalPoint\StoreMedicalPointRequest;
use App\Http\Requests\MedicalPoint\UpdateMedicalPointRequest;
use App\Http\Resources\MedicalPointResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\MedicalPoint;
use App\services\MedicalPointService;
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
     * @SWG\Get(
     *     path="/api/get-all-medical-points",
     *     summary="Get a list of medical points",
     *     tags={"Medical Points"},
     *     @SWG\Response(response=200, description="Successful operation"),
     *     @SWG\Response(response=400, description="Invalid request")
     * )
     */
    public function index()
    {
        $output         = $this->medical_point_service->get_all_medical_points();
        $output['data'] = MedicalPointResource::collection($output['data']);

        return $this->successResponse($output['data'], $output['message'], $output['status']);
    }

    /**
     * @SWG\Post(
     *     path="/api/create-medical-points",
     *     summary="Create a new medical point",
     *     tags={"Medical Points"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="Medical point data",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/StoreMedicalPointRequest")
     *     ),
     *     @SWG\Response(response=200, description="Successful operation"),
     *     @SWG\Response(response=400, description="Invalid request")
     * )
     */
    public function store(StoreMedicalPointRequest $request)
    {
        $field_inputs = $request->validated();

        $output         = $this->medical_point_service->create_medical_point($field_inputs);
        $output['data'] = new MedicalPointResource($output['data']);

        return $this->successResponse($output['data'], $output['message'], $output['status']);
    }

    /**
     * @SWG\Get(
     *     path="/api/get-medical-points/{medicalPoint}",
     *     summary="Get a medical point",
     *     tags={"Medical Points"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Medical point ID",
     *         required=true,
     *         type="integer"
     *     ),
     *     @SWG\Response(response=200, description="Successful operation"),
     *     @SWG\Response(response=400, description="Invalid request")
     * )
     */
    public function show(MedicalPoint $medicalPoint)
    {
        $data = new MedicalPointResource($medicalPoint);
        return $this->successResponse($data, 'Done!', 200);
    }

    /**
     * @SWG\Put(
     *     path="/api/update-medical-points/{medicalPoint}",
     *     summary="Update a medical point",
     *     tags={"Medical Points"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Medical point ID",
     *         required=true,
     *         type="integer"
     *     ),
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="Medical point data",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/UpdateMedicalPointRequest")
     *     ),
     *     @SWG\Response(response=200, description="Successful operation"),
     *     @SWG\Response(response=400, description="Invalid request")
     * )
     */
    public function update(UpdateMedicalPointRequest $request, MedicalPoint $medicalPoint)
    {
        $field_inputs = $request->validated();

        $output         = $this->medical_point_service->update_medical_point($field_inputs, $medicalPoint);
        $output['data'] = new MedicalPointResource($output['data']);

        return $this->successResponse($output['data'], $output['message'], $output['status']);
    }

    /**
     * @SWG\Delete(
     *     path="/api/delete-medical-points/{medicalPoint}",
     *     summary="Delete a medical point",
     *     tags={"Medical Points"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Medical point ID",
     *         required=true,
     *         type="integer"
     *     ),
     *     @SWG\Response(response=200, description="Successful operation"),
     *     @SWG\Response(response=400, description="Invalid request")
     * )
     */
    public function destroy(MedicalPoint $medicalPoint)
    {
        $medicalPoint->delete();
        return $this->successResponse(null, 'Medical Point Deleted Successfully', 200);
    }
}
