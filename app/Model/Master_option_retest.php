<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Master_option_retest extends Model
{
  protected $table = 'm_option_retest';
  protected $fillable = ['option_id','option_name'];
}
