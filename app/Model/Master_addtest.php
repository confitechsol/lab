<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Master_addtest extends Model
{
  protected $table = 'm_add_test';
  protected $fillable = ['test_id','test_name','tag_id'];
}
