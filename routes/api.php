<?php

use App\Http\Controllers\ApplicationSettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicalPointController;

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
 * These routes handle Auth user  operations.
 */
Route::middleware('auth:sanctum')->group(function () {
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
     * Application Setting Management Route
     *
     */
    Route::put('admin/update-application-setting', [ApplicationSettingController::class, 'update']);
});
