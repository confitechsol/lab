<?php

namespace App\Model\Logistics;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id
 */
class Uom extends Model
{

    public $timestamps = false;

    protected $table = 'm_uom';

}