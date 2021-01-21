<?php

namespace App\Model\Logistics;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property Item $detail
 * @property ItemType $item_type
 * @property Receipt $receipt
 * @property Collection $batches
 * @property int $receipt_id
 * @property int $item_code
 * @property float $shipment_qty
 * @property float $accepted_qty
 * @property float $rejected_qty
 * @property int $lab_id
 */
class ReceiptItem extends Model
{


    protected $table = 't_itemrcpt_dtl';

    protected $casts = [
        'shipment_qty' => 'float',
    ];

    protected $fillable = [];



    // Relations ======================================

    public function receipt(){
        return $this->belongsTo( Receipt::class, 'receipt_id', 'id' );
    }

    public function batches(){
        return $this->hasMany( ReceiptItemBatch::class, 'receipt_item_id', 'id' );
    }

    public function detail(){
        return $this->belongsTo( Item::class, 'item_code', 'code' );
    }

    public function item_type(){
        return $this->belongsTo( ItemType::class, 'item_type_code', 'code' );
    }

}