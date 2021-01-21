<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Http\Responce;
use Illuminate\Database\Eloquent\Model;

class DNAextraction extends Model
{
  protected $table = 't_dnaextraction';
  protected $fillable = ['enroll_id','sample_id','created_by','updated_by','status','tag','created_at'];
  public $timestamps = false;
}
