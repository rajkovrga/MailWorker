<?php


namespace App\Services;

use App\Models\Subscriber;
use App\Models\User;

class UserService
{

    public function addSubscribers($data)
    {

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
    }

}
