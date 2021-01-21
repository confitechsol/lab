<?php

namespace App\Model\Logistics;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property StockTransfer $transfer
 * @property Collection $batches
 * @property Item $detail
 * @property Stock $stock
 * @property float $transfer_qty
 * @property float $advice_qty
 * @property int $to_lab_id
 */
class StockTransferItem extends Model
{

    protected $table = 't_stock_transfer_item_dtl';

    public $incrementing = false;

    protected $fillable = [
        'id', 'stocktransfer_no', 'item_code', 'from_lab_id', 'to_lab_id',
        'advice_qty', 'transfer_qty', 'user_id',
    ];

    protected $casts = [
        'transfer_qty' => 'float',
    ];

    public function transfer(){
        return $this->belongsTo( StockTransfer::class, 'stocktransfer_no', 'stocktransfer_no' );
    }

    public function batches(){
        return $this->hasMany( StockTransferBatch::class, 'transfer_item', 'id' );
    }

    public function detail(){
        return $this->belongsTo( Item::class, 'item_code', 'code' );
    }

    public function stock(){
        return $this->belongsTo( Stock::class, 'item_code', 'item_code' );
    }


}