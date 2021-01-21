<?php

namespace App\Model\Logistics;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $user_id
 * @property int $shipment_id
 * @property Collection $batches
 * @property Item $detail
 * @property RequisitionItem $requisition_item
 * @property Shipment $shipment
 * @property int $item_code
 * @property float $shipment_qty
 * @property float $adviced_qty
 * @property \Carbon\Carbon $tr_date
 */
class ShipmentItem extends Model
{

    protected $table = 't_central_shipment_dtl';

    protected $casts = [
        'adviced_qty' => 'float',
        'shipment_qty' => 'float',
        'tr_date' => 'date'
    ];

    protected $fillable = [
        'shipment_id', 'item_code', 'adviced_qty',
        'shipment_qty', 'user_id', 'tr_no', 'tr_date'
    ];


    // Relations ======================================

    public function batches(){
        return $this->hasMany( ShipmentItemBatch::class, 'shipment_dtl_id', 'id' );
    }


    public function shipment(){
        return $this->belongsTo( Shipment::class, 'shipment_id', 'id' );
    }


    public function detail(){
        return $this->belongsTo(Item::class, 'item_code', 'code');
    }


    public function getRequisitionItemAttribute(){
        return $this->shipment->requisition ? $this->shipment->requisition->items()
            ->where('item_code', $this->item_code)
            ->first() : NULL;
    }


}