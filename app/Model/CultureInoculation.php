<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CultureInoculation extends Model
{
  protected $table = 't_culture_inoculation';
  protected $fillable = ['enroll_id','sample_id', 'tag', 'mgit_id','tube_id_lj','tube_id_lc','inoculation_date','status','created_by','updated_by', 'rec_flag'];
}
