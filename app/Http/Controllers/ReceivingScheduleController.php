<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ReceivingSchedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ApiResponseTrait;
use App\Services\ReceivingScheduleService;
use App\Http\Resources\ReceivingScheduleResource;
use App\Http\Requests\ReceivingSchedule\ReceivingScheduleRequest;
use App\Http\Requests\ReceivingSchedule\UpdateReceivingScheduleRequest;

class ReceivingScheduleController extends Controller
{
    use ApiResponseTrait;
    /**
     * @var ReceivingScheduleService
     */
    protected $receivingScheduleService;

    /**
     *  ReceivingScheduleController constructor
     * @param ReceivingScheduleService $receivingScheduleService
     */
    public function __construct(ReceivingScheduleService $receivingScheduleService){
        $this->receivingScheduleService = $receivingScheduleService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all receiving Schedules
        $receivingSchedules= $this->receivingScheduleService->listReceivingSchedule();

        // Return a success response with all data
        return $this->successResponse(ReceivingScheduleResource::collection($receivingSchedules),'success',200);
    
    }

    /**
     * Store a newly created receiving Schedule in storage.
     * @param ReceivingScheduleRequest $request
     *  @return JsonResponse
     */
    public function store(ReceivingScheduleRequest $request)
    {
        dd(Carbon::now());
        
        // Validate the request data
        $data = $request->validated();
        // Create a new receiving Schedules with the validated data
        $receivingSchedule= $this->receivingScheduleService->createReceivingSchedule($data);
        // Return a success response with the created receiving Schedule data
        return $this->successResponse(new ReceivingScheduleResource($receivingSchedule),'receiving Schedule created successfully',200);
    }

    /**
     * Display the specified resource.
     *  @param ReceivingSchedule $receivingSchedule
     *  @return JsonResponse
     */
    public function show(ReceivingSchedule $receivingSchedule)
    {
        try {
            return $this->successResponse(new ReceivingScheduleResource($receivingSchedule),'success',200);
        } catch (\Exception $e) {
            Log::error('Error showing receiving Schedule '. $e->getMessage());
            return $this->errorResponse(null,'there is something wrong in server',500);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param ReceivingSchedule $receivingSchedule 
     * @return JsonResponse
     */
    public function update(UpdateReceivingScheduleRequest $request, ReceivingSchedule $receivingSchedule)
    {
        // Validate the request data
        $data = $request->validated();

        // Update the receiving Schedule with the validated data
        $receivingSchedule = $this->receivingScheduleService->updateReceivingSchedule($data, $receivingSchedule);

        // Return a success response with the created receiving Schedule data
        return $this->successResponse(new ReceivingScheduleResource($receivingSchedule),' receiving Schedule updated successfully',200);
    }

    /**
     * Remove the specified resource from storage.
     * @param ReceivingSchedule $receivingSchedule 
     * @return JsonResponse
     */
    public function destroy(ReceivingSchedule $receivingSchedule)
    {
        // Delete the receiving Schedule by its ID
        $this->receivingScheduleService->deleteReceivingSchedule($receivingSchedule);
        // Return a success response indicating the author was deleted
        return $this->successResponse(null,'delete successfully',200);

    }
}
