<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Http\Responce;
use Illuminate\Database\Eloquent\Model;

class Microscopy extends Model
{
  protected $table = 't_microscopy';
  protected $fillable = ['enroll_id','sample_id','result','reason_edit_result','status','created_by','updated_by','reason_edit','edit_microbiologist'];

}
