<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tbunits_master extends Model
{
  protected $table = 'm_tbunits_relation';
  protected $fillable = ['DistrictCode','STOCode','DTOCode','TBUnitCode','TBUnitName'];
}
