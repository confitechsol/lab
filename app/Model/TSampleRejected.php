<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TSampleRejected extends Model
{
    protected $table = 't_sample_rejected';
    protected $fillable = [
        'sample_id', 
        'state_code', 
        'state_name', 
        'district_code', 
        'district_name', 
        'tbu_code',
        'tbu_name',
        'phi_id',
        'phi_name',
        'created_by',
        'created_at'
    ];
}
