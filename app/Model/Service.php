<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
  protected $table = 'm_services';
  protected $fillable = ['name','created_by','updated_by','record_status'];

}
