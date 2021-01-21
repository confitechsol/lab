<?php

namespace App\Model\Logistics;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id
 * @property string $item_code
 * @property string $lot_no
 * @property float $lot_qty
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $expiry_on
 * @property int $user_id
 * @property Stock $stock
 * @property Item $item
 */
class StockBatch extends Model
{

    protected $table = 'm_stock_batch';

    protected $fillable = [
        'lab_id', 'item_code', 'lot_no','lot_qty', 'expiry_on', 'user_id'
    ];

    protected $casts = [
        'expiry_on' => 'date',
        'lot_qty' => 'float',
        'user_id' => 'integer'
    ];




    // Relations =========================

    public function stock(){
        // TODO: we cannot change the name of the relation here. The default relation name is to be used everywhere which is "stock" here.
        return $this->belongsTo( Stock::class, 'item_code', 'item_code'/*, 'expiry_on'*/ );
    }


    public function item(){
        return $this->belongsTo( Item::class, 'item_code', 'code' );
    }



    // Scopes ============================

    public static function scopes(){
        return static::query()->where(DB::raw('1'), DB::raw('1'));
    }


    public function scopeNotEmpty( Builder $query ){
        return $query->where('lot_qty', '>', 0);
    }

}
