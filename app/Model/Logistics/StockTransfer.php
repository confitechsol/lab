<?php

namespace App\Model\Logistics;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $stocktransfer_no
 * @property string $advice_no
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property Collection $items
 * @property \Carbon\Carbon $stocktransfer_date
 * @property int $from_lab_id
 * @property int $to_lab_id
 */
class StockTransfer extends Model
{

    protected $table = 't_stock_transfer_hdr';

    protected $fillable= [
        'stocktransfer_no', 'stocktransfer_date', 'advice_no', 'user_id'
    ];

    protected $casts = [
        'stocktransfer_date' => 'date',
        'from_lab_id' => 'integer',
        'to_lab_id' => 'integer',
    ];

    public function items(){
        return $this->hasMany( StockTransferItem::class, 'stocktransfer_no', 'stocktransfer_no' );
    }


}