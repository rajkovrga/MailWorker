<?php
namespace App\Services;

use App\Dto\UserDto;
use App\Exceptions\EmailVerifyException;
use App\Exceptions\NotActiveException;
use App\Exceptions\PasswordUserIsNotCorrectException;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Hashing\Hasher;

class AuthService
{
    private $hasher;
    public function __construct(Hasher $hasher)
    {
        $this->hasher = $hasher;
    }

    public function register(UserDto $userDto)
    {
        $user = new User([
            'email' => $userDto->email,
            'first_name' => $userDto->firstName,
            'last_name' => $userDto->lastName,
            'password' => bcrypt($userDto->password)
        ]);

        $user->saveOrFail();

        return $user;
    }

    public function getUser($email, $password)
    {
        $user = User::query()->where('email', $email)->firstOrFail();

        if($user->email_verified_at == null)
            throw new EmailVerifyException();

        if(!$user->active)
        {
            throw new NotActiveException();
        }

        if(!$this->hasher->check($password, $user->password))
            throw new PasswordUserIsNotCorrectException();

        return $user;
    }

    public function verify($email)
    {
        $user = User::query()->where('email', $email)->firstOrFail();

        $user->email_verified_at = Carbon::now();

        $user->saveOrFail();
    }
}
