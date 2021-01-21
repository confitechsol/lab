<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LCDSTInoculation extends Model
{
  protected $table = 't_lc_dst_inoculation';
  protected $fillable = ['enroll_id','sample_id','mgit_seq_id','dst_c_id1','dst_c_id2','dst_c_id3','inoculation_date','status','created_by','updated_by'];
}
