<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LCFlaggedMGITFurther extends Model
{
  protected $table = 't_lc_flagged_mgit_further';
  protected $fillable = ['enroll_id','sample_id','ict','bhi','result', 'result_date',
  'status','created_by','updated_by','culture_smear','species','other_result','reason_edit','edit_microbiologist', 'sample_label', 'lab_code', 'rec_flag'];
}
