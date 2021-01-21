<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
  protected $table = 'facility_master';
  protected $fillable = ['name','created_at', 'updated_at'];
}
