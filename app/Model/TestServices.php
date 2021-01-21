<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TestServices extends Model
{
    //
    protected $table = 'm_test_services';
    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';
}
