<?php

namespace App\Http\Controllers;

use App\Dto\UserDto;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Notifications\VerifyAccount;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = $this->authService->getUser($data['email'], $data['password']);

        return response()->json([
            'token' => $user->createToken('TokenApi')->plainTextToken
        ]);

    }

    public function register(RegistrationRequest $request)
    {
        $userRequest = $request->validated();

        $user = $this->authService->register(new UserDto([
            'email' => $userRequest['email'],
            'lastName' => $userRequest['last_name'],
            'firstName' => $userRequest['first_name'],
            'password' => $userRequest['password']
        ]));
        $user->notify(new VerifyAccount(new UserDto([
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
            'email' => $user->email
        ])));
        return response()->json('Verify email', 201);
    }

    public function verify(Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        $this->authService->verify($request->email);
        return response('Email verified', 201);

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response('Logout success');

    }
}
