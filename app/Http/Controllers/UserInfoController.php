<?php

namespace App\Http\Controllers;

use App\Models\UserInfo;
use Illuminate\Http\Request;
use App\Services\UserInfoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Requests\UserInfoRequest;
use App\Http\Resources\UserInfoResource;
use App\Http\Requests\UpdateUserInfoRequest;

class UserInfoController extends Controller
{
    use ApiResponseTrait;
    /**
     * @var UserInfoService
     */
    protected $userInfoService;

    /**
     *  UserInfoController constructor
     * @param UserInfoService $userInfoService
     */
    public function __construct(UserInfoService $userInfoService){
        $this->userInfoService = $userInfoService;
    }

    /**
     * Display a listing of the resource.
     *  @return JsonResponse
     */
    public function index()
    {
        // Get all user's information
        $userInfos= $this->userInfoService->listUserInfo();

        // Return a success response with all data
        return $this->successResponse(UserInfoResource::collection($userInfos),'success',200);
    }

    /**
     *  Store a newly created UserInfo in storage.
     *  @param UserInfoRequest $request
     *  @return JsonResponse
     */
    public function store(UserInfoRequest $request)
    {
        // Validate the request data
        $data = $request->validated();
        // Create a new userInfo with the validated data
        $userInfo= $this->userInfoService->createUserInfo($data);
        // Return a success response with the created userInfo data
        return $this->successResponse(new UserInfoResource($userInfo),'user info created successfully',200);

    }

    /**
     * Display the specified resource.
     */
    public function show(UserInfo $userInfo)
    {
        try {
            // $userInfo = UserInfo::with('user');
            return $this->successResponse(new UserInfoResource($userInfo),'success',200);
        } catch (\Exception $e) {
            Log::error('Error showing UserInfo '. $e->getMessage());
            return $this->errorResponse(null,'there is something wrong in server',500);
        }
    }

    /**
     * Update a specific userInfo.
     *
     * @param UpdateUserInfoRequest $request
     * @param  UserInfo $userInfo
     * @return JsonResponse
     */
    public function update(UpdateUserInfoRequest $request, UserInfo $userInfo)
    {
        // Validate the request data
        $data = $request->validated();

        // Update the userInfo with the validated data
        $userInfo= $this->userInfoService->updateUserInfo($data, $userInfo);

        // Return a success response with the created userInfo data
        return $this->successResponse(new UserInfoResource($userInfo),'user info updated successfully',200);
    }

    /**
     * Remove the specified userInfo from storage.
      *
     * @param UserInfo $userInfo
     * @return JsonResponse
     */
    public function destroy(UserInfo $userInfo)
    {
        // Delete the userInfo by its ID
        $this->userInfoService->deleteUserInfo($userInfo);

        // Return a success response indicating the author was deleted
        return $this->successResponse(null,'delete successfully',200);

    }
}
