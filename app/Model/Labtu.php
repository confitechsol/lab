<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Labtu extends Model
{
    protected $table = 'm_lab_tu';
    protected $fillable = ['STOCode', 'DTOCode','tuname'];

}
