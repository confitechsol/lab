<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LCFlaggedMGIT extends Model
{
  protected $table = 't_lc_flagged_mgit';
  protected $fillable = ['enroll_id','sample_id','gu','flagging_date','status','created_by','updated_by'];

}
