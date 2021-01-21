<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $equipment_id
 */
class EquipmentBreakdownDate extends Model
{
   protected $table = 'm_equip_breakdown_date';
   public $timestamps = false;
}
