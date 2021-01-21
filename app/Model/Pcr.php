<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Pcr extends Model
{
    protected $table = 't_pcr';
    protected $fillable = ['enroll_id','sample_id','status','test_date','created_by','updated_by','completed','tag'];

}
