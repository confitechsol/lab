<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Microbio extends Model
{
    protected $table = 't_microbiologist';
    protected $fillable = ['enroll_id','sample_id','service_id','next_step','status','created_by','updated_by','detail',
    'remark','reason_bwm','bwm','print_15a','tag','reason_other','sample_label','report_type','approved_date', 'rec_flag'];
}
