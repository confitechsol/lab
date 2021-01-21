<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LCDST extends Model
{
  protected $table = 't_lc_dst';
  protected $fillable = ['enroll_id','sample_id','lc_dst_tr_id','drug_name','result','result_date','status','created_by',
  'updated_by','reason_edit','edit_microbiologist'];
}
