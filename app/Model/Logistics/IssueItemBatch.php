<?php

namespace App\Model\Logistics;


use Illuminate\Database\Eloquent\Model;


class IssueItemBatch extends Model
{

    protected $table = 't_itemrcpt_batch';

    protected $casts = [
        'expiry_on' => 'date',
        'despatch_qty' => 'float',
        'accept_qty' => 'float',
        'reject_qty' => 'float',
    ];

    protected $fillable = [];



    // Relations ======================================

    public function item(){
        return $this->belongsTo( ReceiptItem::class, 'receipt_item_id', 'id' );
    }


}