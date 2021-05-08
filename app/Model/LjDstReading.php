<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LjDstReading extends Model
{
  protected $table = 't_lj_dst_reading';
  protected $fillable = [
    'enroll_id',
    'sample_id',
    'service_log_id',
    'service_id',
    'week_no',
    'dilution',
    'drug_media_1',
    'drug_media_2',
    'drug_name',
    'drug_reading',
    'status',
    'flag',
    'created_by',
    'updated_by',
    'reason_edit',
    'edit_microbiologist',
    'lab_code',
    'sample_label',
    'comments',
  ];
}
