<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\MedicalPointController;

use App\Http\Controllers\ReceivingPointController;
use App\Http\Controllers\ReceivingScheduleController;
use App\Http\Controllers\ApplicationSettingController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/**
 * Auth Routes
 *
 * These routes handle user authentication, including login, registration, and logout.
 */
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});





/**
 * Authenticated user Routes
 *
 * These routes handle Auth user  operations (Admin and users).
 */
Route::middleware('auth:sanctum')->group(function () {


    // handle logout method
    Route::post('/logout', [AuthController::class, 'logout']);

    /**
     *  Receiving Point Management Routes
     *
     * These routes handle Receiving Point management operations (index ,show).
     */
    Route::controller(ReceivingPointController::class)->group(function () {
        Route::get('get-receiving-points', 'index');
        Route::get('get-receiving-point/{receivingPoint}', 'show');
    });

    /**
     *  category Management Routes
     *
     * These routes handle category management operations (index ,show).
     */
    Route::controller(CategoryController::class)->group(function () {
        Route::get('get-categories', 'index');
        Route::get('get-category/{category}', 'show');
    });

    /**
     *  user info Management Routes
     *
     * These routes handle user info management operations (store ,update,show).
     */
    Route::controller(UserInfoController::class)->group(function () {
        Route::post('create-userInfo', 'store');
        Route::put('update-userInfo/{userInfo}', 'update')->middleware('owner');
        Route::get('get-userInfo/{userInfo}', 'show');
    });


    /**
     * Medical Point Management Routes
     *
     * These routes handle Medical Point management operations.
     */
    Route::controller(MedicalPointController::class)->group(function () {
        Route::get('get-all-medical-points', 'index');
        Route::get('get-medical-points/{medicalPoint}', 'show');
    });

    /**
     * Doctor Management Routes
     *
     * These routes handle Doctor management operations.
     */
    Route::controller(DoctorController::class)->group(function () {
        Route::get('get-all-doctors', 'index');
        Route::get('get-doctors/{doctor}', 'show');
    });

    /**
     *  receiving schedule Management Routes
     *
     * These routes handle receiving schedule management operations(show).
     */
    Route::controller(ReceivingScheduleController::class)->group(function () {
        Route::get('get-receiving-schedule/{receivingSchedule}', 'show');
    });

    /**
     * Application Setting Management Route
     *
     */
    Route::get('get-application-setting', [ApplicationSettingController::class, 'show']);

});


/**
 * Admin Management Routes
 *
 * These routes handle Admin management operations.
 */
Route::middleware(['auth:sanctum', 'admin'])->group(function () {

    /**
     *  Receiving Point Management Routes
     *
     * These routes handle Receiving Point management operations (store ,update,destroy).
     */
    Route::controller(ReceivingPointController::class)->group(function () {
        Route::post('create-receiving-point', 'store');
        Route::put('update-receiving-point/{receivingPoint}', 'update');
        Route::delete('delete-receiving-point/{receivingPoint}', 'destroy');
    });

    /**
     *  user info Management Routes
     *
     * These routes handle user info management operations (store ,update,destroy).
     */
    Route::controller(UserInfoController::class)->group(function () {
        Route::delete('delete-userInfo/{userInfo}', 'destroy');
        Route::get('get-userInfo', 'index');
    });

    /**
     *  Category Management Routes
     *
     * These routes handle Category management operations (store ,update,destroy).
     */
    Route::controller(CategoryController::class)->group(function () {
        Route::post('create-category', 'store');
        Route::put('update-category/{category}', 'update');
        Route::delete('delete-category/{category}', 'destroy');
    });

    /**
     * Medical Point Management Routes
     *
     * These routes handle Medical Point management operations.
     */
    Route::controller(MedicalPointController::class)->group(function () {
        Route::post('create-medical-points', 'store');
        Route::put('update-medical-points/{medicalPoint}', 'update');
        Route::delete('delete-medical-points/{medicalPoint}', 'destroy');
    });

    /**
     * Doctor Management Routes
     *
     * These routes handle Doctor management operations.
     */
    Route::controller(DoctorController::class)->group(function () {
        Route::post('create-doctors', 'store');
        Route::put('update-doctors/{doctor}', 'update');
        Route::delete('delete-doctors/{doctor}', 'destroy');
    });

    /**
     *  receiving schedule Management Routes
     *
     * These routes handle receiving schedule management operations(create,update,delete,list).
     */
    Route::controller(ReceivingScheduleController::class)->group(function () {
        Route::post('create-receiving-schedule', 'store');
        Route::put('update-receiving-schedule/{receivingSchedule}', 'update');
        Route::delete('delete-receiving-schedule/{receivingSchedule}', 'destroy');
        Route::get('get-receiving-schedules', 'index');
    });




    /**
     * Application Setting Management Route
     *
     */
    Route::put('admin/update-application-setting', [ApplicationSettingController::class, 'update']);
});
