<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Designations extends Model
{
    //
    protected $table = 'm_designations';
    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';
}
