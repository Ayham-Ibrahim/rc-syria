<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReceivingPoint;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ApiResponseTrait;
use App\Services\ReceivingPointService;
use App\Http\Requests\ReceivingPointRequest;
use App\Http\Resources\ReceivingPointResource;
use App\Http\Requests\UpdateReceivingPointRequest;

class ReceivingPointController extends Controller
{
    use ApiResponseTrait;
    /**
     * @var ReceivingPointService
     */
    protected $receivingPointService;

    /**
     *  ReceivingPointController constructor
     * @param ReceivingPointService $receivingPointService
     */
    public function __construct(ReceivingPointService $receivingPointService){
        $this->receivingPointService = $receivingPointService;
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index()
    {
        // Get all receiving Points
        $receivingPoints= $this->receivingPointService->listReceivingPoint();

        // Return a success response with all data
        return $this->successResponse(ReceivingPointResource::collection($receivingPoints),'success',200);
    }

    /**
     *  Store a newly created receiving point in storage.
     *  @param ReceivingPointRequest $request
     *  @return JsonResponse
     */
    public function store(ReceivingPointRequest $request)
    {
        // Validate the request data
        $data = $request->validated();
        // Create a new receiving points with the validated data
        $receivingPoint= $this->receivingPointService->createReceivingPoint($data);
        // Return a success response with the created receiving point data
        return $this->successResponse(new ReceivingPointResource($receivingPoint),'receiving point created successfully',200);
    }

    /**
     *  Display the specified receiving points.
     *  @param ReceivingPoint $receivingPoint
     *  @return JsonResponse
     */
    public function show(ReceivingPoint $receivingPoint)
    {

        try {
            return $this->successResponse(new ReceivingPointResource($receivingPoint),'success',200);
        } catch (\Exception $e) {
            Log::error('Error showing Receiving Point '. $e->getMessage());
            return $this->errorResponse(null,'there is something wrong in server',500);
        }
    }

    /**
     * Update a specific userInfo.
     *
     * @param UpdateReceivingPointRequest $request
     * @param  ReceivingPoint $receivingPoint
     * @return JsonResponse
     */
    public function update(UpdateReceivingPointRequest $request, ReceivingPoint $receivingPoint)
    {
        // Validate the request data
        $data = $request->validated();

        // Update the userInfo with the validated data
        $receivingPoint = $this->receivingPointService->updateReceivingPoint($data, $receivingPoint);

        // Return a success response with the created userInfo data
        return $this->successResponse(new ReceivingPointResource($receivingPoint),'receiving point updated successfully',200);
    }


    /**
     * Remove the specified receivingPoint from storage.
     *  @param ReceivingPoint $receivingPoint
     *  @return JsonResponse
     */
    public function destroy(ReceivingPoint $receivingPoint)
    {
        // Delete the userInfo by its ID
        $this->receivingPointService->deleteReceivingPoint($receivingPoint);

        // Return a success response indicating the author was deleted
        return $this->successResponse(null,'delete successfully',200);

    }
}
