<?php

namespace App\Model\Logistics;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property bool $is_active
 * @property string $code
 * @property string $name
 * @property Collection $item
 */
class ItemCategory extends Model
{

    public $timestamps = false;

    protected $table = 'm_itemcategory';

    protected $casts = [
        'is_active' => 'boolean'
    ];


    public function item(){
        return $this->hasMany( Item::class, 'item_category', 'code' );
    }

}