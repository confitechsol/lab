<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
  protected $table = 'm_letter_year';
  protected $fillable = ['letter','year','Bar_Yr_Int1','Bar_Yr_Int2','Bar_Yr_Char1','Bar_Yr_Char2'];

}
