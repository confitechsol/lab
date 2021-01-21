<?php

namespace App\Model\Logistics;


use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property StockTransferItem $item
 * @property \Carbon\Carbon $expiry_on
 * @property float $batch_lot_qty
 * @property int $user_id
 * @property string $transfer_item
 * @property string $stocktransfer_no
 * @property string $item_code
 * @property string $lot_no
 *
 */
class StockTransferBatch extends Model
{

    protected $table = 't_stock_transfer_item_batch';

    protected $fillable = [
        'transfer_item', 'stocktransfer_no', 'item_code',
        'lot_no', 'expiry_on', 'batch_lot_qty', 'user_id',
    ];


    protected $casts = [
        'expiry_on' => 'date',
        'batch_lot_qty' => 'float',
        'user_id' => 'integer',
    ];


    public function item(){
        return $this->belongsTo( StockTransferItem::class, 'transfer_item', 'id' );
    }


}