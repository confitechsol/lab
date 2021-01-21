<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Decontamination extends Model
{
    protected $table = 't_decontamination';
    protected $fillable = ['enroll_id','sample_id','status','test_date','created_by','updated_by','sent_for','other'];


    const STATUS_INACTIVE   = 0;
    const STATUS_ACTIVE     = 1;

    // Service status constant usable in ServiceLog.
    const SERVICE_STATUS_PENDING    = 1;
    const SERVICE_STATUS_ACTIVE     = 2;
    const SERVICE_STATUS_INACTIVE   = 0;

}
