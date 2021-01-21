<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LJWeekLog extends Model
{
  protected $table = 't_lj_week_log';
  protected $fillable = ['enroll_id','sample_id','result','week', 'status','created_by','updated_by'];
}
