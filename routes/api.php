<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\ReceivingPointController;

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
Route::post('/register',[AuthController::class,'register']);
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

});


