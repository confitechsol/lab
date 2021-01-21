<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class KeyPopulation_master extends Model
{
  protected $table = 'm_dropdown_key_populations';
  protected $fillable = ['key_id','key_population'];
}
