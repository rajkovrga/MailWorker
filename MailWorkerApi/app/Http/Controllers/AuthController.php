<?php

namespace App\Http\Controllers;

use App\Dto\UserDto;
use App\Exceptions\EmailVerifyException;
use App\Exceptions\NotActiveException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Notifications\VerifyAccount;
use App\Services\AuthService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
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

        try {
            $user = $this->authService->getUser($data['email'], $data['password']);

            return response()->json([
                'token' => $user->createToken('TokenApi')->plainTextToken
            ]);
        }
        catch (ModelNotFoundException $exception)
        {
            return response('User not found', 404);
        }
        catch (EmailVerifyException $exception)
        {
            return response('Email not verified', 409);
        }
        catch (NotActiveException $exception)
        {
            return response('This user is not active', 403);
        }
        catch (\Exception $exception)
        {
            return response('Server error', 500);
        }
    }

    public function register(RegistrationRequest $request)
    {
        $userRequest = $request->validated();

        try {

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
            return response()->json($user, 201);
        }
        catch (QueryException $exception)
        {
            Log::error($exception->getMessage());
            return  response('User exist', 409);
        }
        catch (\Exception $exception)
        {
            Log::error($exception->getMessage());
            return response($exception->getMessage(), 500);
        }
    }

    public function verify(Request $request)
    {
        if (! $request->hasValidSignature()) {
            abort(401);
        }

        try {
            $this->authService->verify($request->email);
            return response('Email verified', 201);
        }
        catch (QueryException $exception)
        {
            Log::error($exception->getMessage());
            return  response('User is not verified', 409);
        }
        catch (ModelNotFoundException $exception)
        {
            Log::error($exception->getMessage());
            return  response('User not found', 404);
        }
        catch (\Exception $er)
        {
            Log::error($er->getMessage());
            return response($er->getMessage(), 500);
        }
    }
}
