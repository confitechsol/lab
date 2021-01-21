<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TBDiagnosis extends Model
{
    //
    protected $table = 'm_tbdiagnosis';
    protected $fillable = ['name', 'diagnosis_id','record_status'];
    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';
}
