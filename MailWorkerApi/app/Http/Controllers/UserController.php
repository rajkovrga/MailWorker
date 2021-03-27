<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubRequest;
use App\Services\UserService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function addSubscriber(SubRequest $request)
    {
        $data = $request->validated();

        try {
            $this->userService->addSubscriber($data['email'], $request->user()->id);
            return response()->json('Subscriber added', 201);
        }
        catch (QueryException $er)
        {
            Log::error($er->getMessage());
            return response()->json('Subscriber is not added', 409);
        }
        catch (\Exception $er)
        {
            Log::error($er->getMessage());
            return response()->json('Server error', 500);
        }
    }

    public function addSubscribers(Request $request)
    {

    }

    public function removeSubscribers()
    {

    }

    public function sendSubscribeMessage()
    {

    }
}
