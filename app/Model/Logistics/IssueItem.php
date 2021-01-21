<?php

namespace App\Model\Logistics;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


class IssueItem extends Model
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