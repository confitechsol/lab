<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Http\Responce;
use Illuminate\Database\Eloquent\Model;

class Hybridization extends Model
{
  // protected $table = 'hybridization';
  // protected $fillable = ['sample_id','result','status'];
  protected $table = 't_hybridization';
  protected $fillable = ['sample_id','enroll_id','result','status','tag'];
}
