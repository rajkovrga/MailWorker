<?php

namespace App\Http\Controllers;

use App\Dto\FilterSubDto;
use App\Http\Requests\SubRequest;
use App\Http\Requests\SubscriberFilterRequest;
use App\Http\Requests\SubsRequest;
use App\Http\Requests\UserFilterRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WorkerController extends Controller
{
    private $workService;

    public function __construct(UserService $workService)
    {
        $this->workService = $workService;
    }

    public function addSubscriber(SubRequest $request)
    {
        $data = $request->validated();

        try {
            $subscriber = $this->workService->addSubscriber($data['email'], $request->user()->id);
            return response()->json($subscriber, 201);
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

    public function addSubscribers(SubsRequest $request)
    {
        $data = $request->validated();

        try {
            $subscribers = $this->workService->addSubscribers($data, $request->user()->id);
            return response()->json($subscribers, 201);
        }
        catch (QueryException $er)
        {
            Log::error($er->getMessage());
            return response()->json('Subscribers is not added', 409);
        }
        catch (\Exception $er)
        {
            Log::error($er->getMessage());
            return response()->json('Server error', 500);
        }

    }

    public function removeSubscriber(Request $request, $id)
    {
        try {
            $this->workService->removeSubscriber($id, $request->user()->id);
            return response()->json('Subscriber removed', 204);
        }
        catch (QueryException $er)
        {
            Log::error($er->getMessage());
            return response()->json('Subscriber is not removed', 409);
        }
        catch (\Exception $er)
        {
            Log::error($er->getMessage());
            return response()->json('Server error', 500);
        }
    }

    public function removeSubscribers(Request $request)
    {
        try {
            $this->workService->removeSubscribers($request->input('data'), $request->user()->id);
            return response()->json('Subscribers removed', 204);
        }
        catch (QueryException $er)
        {
            Log::error($er->getMessage());
            return response()->json('Subscribers is not removed', 409);
        }
        catch (\Exception $er)
        {
            Log::error($er->getMessage());
            return response()->json('Server error', 500);
        }
    }

    public function editSubscriber(Request $request, $id)
    {
        try {
            $subscriber = $this->workService->editSubscriber($id, $request->input('email'));
            return response()->json($subscriber, 204);
        }
        catch (QueryException $er)
        {
            Log::error($er->getMessage());
            return response()->json('Subscribers is not edited', 409);
        }
        catch (ModelNotFoundException $er)
        {
            Log::error($er->getMessage());
            return response()->json('Subscribers is not exist', 404);
        }
        catch (\Exception $er)
        {
            Log::error($er->getMessage());
            return response()->json('Server error', 500);
        }
    }

    public function getUsers(Request $request, $page)
    {
        try {
            $user = $this->workService->getUsers($page);
            return response()->json($user);
        }
        catch (QueryException $er)
        {
            Log::error($er->getMessage());
            return response()->json('System error', 409);
        }
        catch (\Exception $er)
        {
            Log::error($er->getMessage());
            return response()->json('Server error', 500);
        }
    }

    public function getSubscribers(SubscriberFilterRequest $request, $page)
    {
        $data = $request->validated();
        try {
            $user = $this->workService->getSubscribers(new FilterSubDto([
                'search' => $data['email'],
                'userId'=> $data['user_id']
            ]),$page);
            return response()->json($user);
        }
        catch (QueryException $er)
        {
            Log::error($er->getMessage());
            return response()->json('System error', 409);
        }
        catch (\Exception $er)
        {
            Log::error($er->getMessage());
            return response()->json('Server error', 500);
        }
    }

    public function getUser(Request $request, $id)
    {
        try {
            $user = $this->workService->getUser($id);
            return response()->json($user);
        }
        catch (QueryException $er)
        {
            Log::error($er->getMessage());
            return response()->json('System error', 409);
        }
        catch (ModelNotFoundException $er)
        {
            Log::error($er->getMessage());
            return response()->json('User not exist', 404);
        }
        catch (\Exception $er)
        {
            Log::error($er->getMessage());
            return response()->json('Server error', 500);
        }
    }

    public function getFilteredUsers(UserFilterRequest $request)
    {
        $data = $request->validated();

        try {
            $users = $this->workService->getFilterUsers($data['email']);
            return response()->json($users);
        }
        catch (QueryException $er)
        {
            Log::error($er->getMessage());
            return response()->json('System error', 409);
        }
        catch (ModelNotFoundException $er)
        {
            Log::error($er->getMessage());
            return response()->json('Users not exist', 404);
        }
        catch (\Exception $er)
        {
            Log::error($er->getMessage());
            return response()->json('Server error', 500);
        }
    }

    public function sendMessage(Request $request)
    {

    }
}
