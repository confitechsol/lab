<?php

namespace App\Model\Logistics;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id
 * @property int $requisition_id
 * @property string $item_type_code
 * @property string $item_code
 * @property float $current_stock
 * @property float $required_qty
 * @property float $adviced_qty
 * @property float $shipment_qty
 * @property int $user_id
 * @property boolean $is_moved
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property Item $detail
 * @property ItemType $item_type
 * @property float $received_qty
 * @property Requisition $requisition
 */
class RequisitionItem extends Model
{


    protected $table = 't_requisition_item';

    protected $fillable = [
        'requisition_id', 'item_type_code', 'item_code', 'current_stock', 'required_qty'
    ];


    protected $casts = [
        'current_stock' => 'float',
        'required_qty' => 'float',
        'adviced_qty' => 'float',
        'shipment_qty' => 'float',
        'received_qty' => 'float',
        'is_moved' => 'boolean',
    ];


    public static function scopes(){
        return static::query()->where(DB::raw('1'), DB::raw('1'));
    }

    public function detail(){
        return $this->belongsTo( Item::class, 'item_code', 'code' );
    }

    public function item_type(){
        return $this->belongsTo( ItemType::class, 'item_type_code', 'code' );
    }

    public function requisition(){
        return $this->belongsTo( Requisition::class, 'requisition_id', 'id' );
    }

}