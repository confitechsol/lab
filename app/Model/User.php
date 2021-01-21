<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
       protected $table = 'users';
    protected $fillable = ['name','email','password','remember_token','created_at'];
      protected $hidden = [
        'password', 'remember_token',
    ];
}
