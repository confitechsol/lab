<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
     protected $table = 'user_has_roles';
    protected $fillable = ['user_id', 'role_id'];
}
