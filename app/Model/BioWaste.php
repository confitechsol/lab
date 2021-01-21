<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BioWaste extends Model
{
    protected $table = 't_biowaste';
    protected $fillable = ['quantity','generated_date','collected_date','status','quantity_status'];
}
