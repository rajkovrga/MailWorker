<?php


namespace App\Services;

use App\Dto\FilterSubDto;
use App\Models\MailRequest;
use App\Models\Subscriber;
use App\Models\User;

class UserService
{

    public function addSubscribers($data, $userId)
    {
        $user = User::query()->find($userId);

        $ids = Subscriber::query()->insertGetId($data);

        $user->subscribers()->attach($ids);

        return Subscriber::query()->whereIn('id', $ids);
    }

    public function addSubscriber($subscriber, $userId)
    {
        $user = User::query()->find($userId);
        $sub = Subscriber::query()->where('email', $subscriber)->first();

        if($sub == null)
        {
            $sub = Subscriber::query()->create([
                'email' => $subscriber
            ]);

            $sub->saveOrFail();
        }

        $user->subscribers()->attach($sub->id);

        return $sub;
    }

    public function removeSubscriber($subId, $userId)
    {
        $user = User::query()->find($userId);

        $user->subscribers()->dettach($subId);

    }
    public function removeSubscribers($subIds, $userId)
    {
        $user = User::query()->find($userId);

        $user->subscribers()->dettach($subIds);
    }

    public function editSubscriber($id, $email)
    {
        $sub = Subscriber::query()->find($id);

        $sub->email = $email;

        $sub->saveOrFail();

        return $sub;
    }

    public function getUsers($page = 1, $perPage = 15)
    {
        $users = User::query()->paginate($perPage, ['*'], 'page',$page);
        return $users;
    }

    public function getSubscribers(FilterSubDto $filter, $page = 1, $perPage = 40)
    {
        $subscribers = Subscriber::query()->with(['subcribers']);

        if(!empty($filter->search))
        {
            $subscribers = $subscribers->where('email','like', '%'.$filter->search.'%');
        }

        if(!empty($filter->userId))
        {
            $subscribers = $subscribers->where('subscribers.user_id', $filter->userId);
        }

        return $subscribers->paginate($perPage, ['*'], 'page',$page);
    }

    public function getUser($id)
    {
        return User::query()->findOrFail($id);
    }

    public function getFilterUsers($search)
    {
        $users = User::query()->where('email','like','%'.$search.'%')->limit(10);
        return $users;
    }

    public function insetRequest($userId, $description, $title = '')
    {
        $user = User::query()->findOrFail($userId);

        $request = new MailRequest([
            'title' => $title,
            'description' => $description
        ]);

        $user->requests()->save($request);

        return $request->id;
    }

}
