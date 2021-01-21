<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PrintLog extends Model
{
  protected $table = 't_print_log';
  protected $fillable = ['r_year','r_from','r_to','created_by'];

  public function setUpdatedAt($value){
  }
}
