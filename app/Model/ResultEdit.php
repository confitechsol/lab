<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ResultEdit extends Model
{
  protected $table = 't_result_edit';
  protected $fillable = ['enroll_id','sample_id','service_id','previous_result','updated_result','updated_by','status','reason','created_at','updated_at'];
}
