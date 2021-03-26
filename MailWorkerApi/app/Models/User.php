<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;
use Laravel\Sanctum\HasApiTokens;

class User extends SanctumPersonalAccessToken
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'password'
    ];

    protected $hidden = [
      'password'
    ];

    public function subscribers()
    {
        return $this->belongsToMany( Subscriber::class,'user_subscriber', 'user_id','subscriber_id');
    }

}
