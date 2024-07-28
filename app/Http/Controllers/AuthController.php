<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Requests\RegisterRequest;

/**
 * @SWG\Swagger(
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="Auth API",
 *         description="API for authentication"
 *     )
 * )
 */
class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    protected $authService;
    use ApiResponseTrait;

    /**
     * AuthController constructor.
     *
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService){
        $this->authService = $authService;
    }

    /**
     * @SWG\Post(
     *     path="/api/register",
     *     summary="Register a new user",
     *     tags={"Auth"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         @SWG\Schema(ref="#/definitions/RegisterRequest")
     *     ),
     *     @SWG\Response(response=200, description="Successful operation", @SWG\Schema(ref="#/definitions/UserResource")),
     *     @SWG\Response(response=400, description="Invalid request")
     * )
     */
    public function register(RegisterRequest $request){
        $data = $request->validated();
        $response = $this->authService->register($data);
        return $this->apiResponse(new UserResource($response['user']),$response['token'],'registered successfully',200);
    }

    /**
     * @SWG\Post(
     *     path="/api/login",
     *     summary="Login a user",
     *     tags={"Auth"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         @SWG\Schema(ref="#/definitions/LoginRequest")
     *     ),
     *     @SWG\Response(response=200, description="Successful operation", @SWG\Schema(ref="#/definitions/UserResource")),
     *     @SWG\Response(response=400, description="Invalid request")
     * )
     */
    public function login(LoginRequest $request){
        $credentials = $request->validated();
        $response = $this->authService->login($credentials);
        return $this->apiResponse(new UserResource($response['user']),$response['token'],'logged in successfully',200);
    }

    /**
     * @SWG\Post(
     *     path="/api/logout",
     *     summary="Logout a user",
     *     tags={"Auth"},
     *     @SWG\Response(response=200, description="Successful operation"),
     *     @SWG\Response(response=400, description="Invalid request")
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
