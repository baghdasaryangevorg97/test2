<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SigninRequest;
use App\Http\Requests\SignupRequest;
use App\Service\AuthService;

class AuthController extends Controller
{

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(SignupRequest $request)
    {
        try {
            $token = $this->authService->register($request->all());

            return response()->json(['message' => 'User registered successfully', 'success' => true, 'token' => $token], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Registration failed', 'success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function login(SigninRequest $request)
    {

        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials', 'success' => false], 401);
        }

        $token = $this->authService->login();

        return response()->json([
            'token' => $token
        ], 200);
        
    }
}
