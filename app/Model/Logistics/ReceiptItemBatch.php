<?php

namespace App\Model\Logistics;


use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property ReceiptItem $item
 * @property int $receipt_item_id
 * @property string $lot_no
 * @property \Carbon\Carbon $expiry_on
 * @property float $despatch_qty
 * @property float $accept_qty
 * @property float $reject_qty
 * @property int $user_id
 * @property int $lab_id
 * @property string $remarks
 */
class ReceiptItemBatch extends Model
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