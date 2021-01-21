<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LjDstInoculation extends Model
{
  protected $table = 't_lj_dst_inoculation';
  protected $fillable = [
    'enroll_id',
    'sample_id',
    'service_log_id',
    'inoculation_for',
    'inoculation_date',
    'status',
    'created_by',
    'updated_by'
  ];
}
