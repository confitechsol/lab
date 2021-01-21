<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Socioeconomic_master extends Model
{
  protected $table = 'm_dropdown_socioeconomics';
  protected $fillable = ['socio_id','socioeconomic'];
}
