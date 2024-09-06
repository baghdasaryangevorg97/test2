<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SigninRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
            $data = $this->authService->register($request->all());

            return response()->json([
                'message' => 'User registered successfully',
                'success' => true,
                'user' => $data['user'],
                'token' => $data['token']
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Registration failed', 'success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function login(SigninRequest $request)
    {

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $this->authService->login($user);

        return response()->json([
            'token' => $token,
            'user' => $user
        ], 200);
    }
}
