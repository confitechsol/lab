<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LCDSTDrugs extends Model
{
  protected $table = 'm_dst_drugs';
  protected $fillable = ['name','status','created_by','updated_by'];
}
