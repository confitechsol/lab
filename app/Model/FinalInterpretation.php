<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FinalInterpretation extends Model
{
    protected $table = 't_lpa_final';
    protected $fillable = ['enroll_id','sample_id','test_date','created_by','updated_by','status','lpa_interpretation_id',
    'type',
    'type_direct','type_indirect',
    'mtb_result','rif','inh','quinolone','slid','report_date','reason_edit','edit_microbiologist','tub_band','nikshey_final_interpretation','tag'];
}

