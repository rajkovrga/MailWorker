<?php

namespace App\Http\Controllers;

use App\Dto\FilterSubDto;
use App\Http\Requests\MailRequestRequest;
use App\Http\Requests\SubRequest;
use App\Http\Requests\SubscriberFilterRequest;
use App\Http\Requests\SubsRequest;
use App\Http\Requests\UserFilterRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

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
        $subscriber = $this->workService->addSubscriber($data['email'], $request->user()->id);
        return response()->json($subscriber, 201);
    }

    public function addSubscribers(SubsRequest $request)
    {
        $data = $request->validated();
        $subscribers = $this->workService->addSubscribers($data, $request->user()->id);
        return response()->json($subscribers, 201);

    }

    public function removeSubscriber(Request $request, $id)
    {
        $this->workService->removeSubscriber($id, $request->user()->id);
        return response()->json('Subscriber removed', 204);
    }

    public function removeSubscribers(Request $request)
    {
        $this->workService->removeSubscribers($request->input('data'), $request->user()->id);
        return response()->json('Subscribers removed', 204);
    }

    public function editSubscriber(Request $request, $id)
    {
        $subscriber = $this->workService->editSubscriber($id, $request->input('email'));
        return response()->json($subscriber, 204);
    }

    public function getUsers(Request $request, $page)
    {
        $user = $this->workService->getUsers($page);
        return response()->json($user);

    }

    public function getSubscribers(SubscriberFilterRequest $request, $page)
    {
        $data = $request->validated();
        $user = $this->workService->getSubscribers(new FilterSubDto([
            'search' => $data['email'],
            'userId' => $data['user_id']
        ]), $page);
        return response()->json($user);
    }

    public function getUser(Request $request, $id)
    {
        $user = $this->workService->getUser($id);
        return response()->json($user);

    }

    public function getFilteredUsers(UserFilterRequest $request)
    {
        $data = $request->validated();
        $users = $this->workService->getFilterUsers($data['email']);
        return response()->json($users);

    }

    public function sendMessage(MailRequestRequest $request)
    {
        $data = $request->validated();
        $id = $this->workService->insetRequest($request->user()->id, $data['description'], $data['title']);
        Redis::set($id, $id);
    }
}
