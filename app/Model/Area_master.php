<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Area_master extends Model
{
  protected $table = 'm_dropdown_areas';
  protected $fillable = ['id','area_name'];
}
