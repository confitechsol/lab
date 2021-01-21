<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Hiv_status_master extends Model
{
  protected $table = 'm_dropdown_hiv_status';
  protected $fillable = ['hiv_id','hiv_status'];
}
