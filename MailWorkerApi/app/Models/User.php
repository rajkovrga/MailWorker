<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'password'
    ];

    public function subscribers()
    {
        return $this->belongsToMany( Subscriber::class,'user_subscriber', 'user_id','subscriber_id');
    }

}
