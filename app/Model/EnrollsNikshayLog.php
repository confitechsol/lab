<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EnrollsNikshayLog extends Model
{
    protected $table = 'enrolls_nikshay_log';
    protected $fillable = ['enroll_id','label','nikshay_id'];
}