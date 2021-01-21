<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Master_Map_retest extends Model
{
  protected $table = 'm_map_retest';
  protected $fillable = ['test_id','test_name','tag_id','option_id','option_name','send_to_id','send_to_name'];
}
