<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LJDetail extends Model
{
  protected $table = 't_lj_detail';
  protected $fillable = ['enroll_id','sample_id','test_id','culture_smear', 'final_result','result_week', 'lj_result_date',
  'status','created_by','updated_by','reason_edit','edit_microbiologist','other_result','species', 'lj_result'];
}
