<?php

namespace App\Model\Logistics;


use Illuminate\Database\Eloquent\Model;

/**
 * @property int shipment_dtl_id
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property ShipmentItem $item
 * @property \Carbon\Carbon $expiry_on
 * @property string $lot_no
 * @property ReceiptItemBatch $receipt_item_batch
 * @property mixed $shipment_qty
 */
class ShipmentItemBatch extends Model
{

    protected $table = 't_central_shipment_batch';

    protected $casts = [
        'expiry_on' => 'date',
        'shipment_qty' => 'float',
    ];

    protected $fillable = [
        'shipment_dtl_id', 'lot_no', 'expiry_on', 'shipment_qty', 'user_id'
    ];


    public function item(){
        return $this->belongsTo( ShipmentItem::class, 'shipment_dtl_id', 'id' );
    }


    public function getReceiptItemBatchAttribute(){
//        $this->item->shipment->receipts->items;
    }

}