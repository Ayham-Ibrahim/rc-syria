<?php

namespace App\Services;

use Exception;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ApiResponseTrait;

class UserInfoService {

    use ApiResponseTrait;

    /**
     * list all user's information
     */
    public function listUserInfo() {
        try {
            return UserInfo::all();
        } catch (Exception $e) {
            Log::error('Error Listing UserInfo '. $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }

    /**
     * Create a new UserInfo.
     * @param array $data
     * @return \App\Models\UserInfo
     */
    public function createUserInfo(array $data){
        try {
            // Create a new author record with the provided data
            return UserInfo::create([
                'full_name'         => $data['full_name'],
                'phone_number'      => $data['phone_number'],
                'id_number'         => $data['id_number'],
                'address'           => $data['address'],
                'status'            => $data['status'],
                'age'               => $data['age'],
                'category_id'       => $data['category_id'],
            ]);
        } catch (Exception $e) {
            Log::error('Error creating UserInfo: ' . $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }

      /**
     * Update a specific userInfo.
     *
     * @param array $data
     * @param UserInfo $userInfo
     * @return \App\Models\UserInfo
     */
    public function updateUserInfo(array $data,$userInfo) {
        try {
            // Update the userInfo with the provided data, filtering out null values
            $userInfo->update(array_filter($data));
            // Return the updated userInfo
            return $userInfo;
        } catch (Exception $e) {
            Log::error('Error updating UserInfo: ' . $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }

    /**
     * Delete a specific userInfo by its ID.
     *
     * @param UserInfo $userInfo
     * @return void
     */
    public function deleteUserInfo($userInfo){
        try {
            $userInfo->delete();
        } catch (Exception $e) {
            Log::error('Error deleting UserInfo '. $e->getMessage());
            throw new Exception($this->errorResponse(null,'there is something wrong in server',500));
        }
    }
}