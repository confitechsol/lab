<?php

namespace App\Model\Logistics;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property bool $is_active
 * @property string $code
 * @property string $name
 */
class ItemType extends Model
{

    public $timestamps = false;

    protected $table = 'm_itemtype';

    protected $casts = [
        'is_active' => 'boolean'
    ];

}