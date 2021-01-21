<?php

namespace App\Model\Logistics;

use App\Model\Lab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id
 * @property float $effective_stock
 * @property string $item_code
 * @property float $re_order
 * @property float $op_stock
 * @property float $rcp_for_lab
 * @property float $rcp_oth_site
 * @property float $isu_for_lab
 * @property float $isu_oth_site
 * @property float $current_stock
 * @property int $user_id
 * @property int $lab_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property Item $item
 * @property bool $is_in_cart
 * @property bool $below_reorder_level
 * @property Lab $lab
 * @property float re_order_avg
 * @property bool $is_grouped
 * @property bool $is_in_requisition_cart
 * @property Collection $in_requisitions
 * @property float $required_quantity
 * @property Collection $batches
 * @property bool $is_in_issue_cart
 */
class Stock extends Model
{

    protected $table = 'm_stock';


    protected $fillable = [
        'lab_id', 'item_code', 'op_stock', 'current_stock',
        're_order', 'rcp_for_lab', 'rcp_oth_site', 'isu_for_lab',
        'isu_oth_site', 'user_id',
    ];


    protected $casts = [
        're_order'      => 'float',
        're_order_avg'  => 'float',
        'op_stock'      => 'float',
        'rcp_for_lab'   => 'float',
        'rcp_oth_site'  => 'float',
        'isu_for_lab'   => 'float',
        'isu_oth_site'  => 'float',
        'current_stock' => 'float',
        'user_id'       => 'integer',
        'lab_id'        => 'integer',
        'is_grouped'    => 'bool',
    ];




    // Relations =========================

    public function item(){
        return $this->belongsTo( Item::class, 'item_code', 'code' );
    }


    public function batches(){
        return $this->hasMany( StockBatch::class, 'item_code', 'item_code' );
    }


    public function lab(){
        return $this->hasOne( Lab::class, 'id', 'lab_id' );
    }


    public function in_requisitions(){
        return $this->hasMany( RequisitionItem::class, 'item_code', 'item_code' );
    }


    // Attributes ========================

    public function getEffectiveStockAttribute(){
        return $this->current_stock;
    }

    public function getIsInCartAttribute(){
        $mode = \request('mode') ?? 'all';
        $cart_key = "logistics.po-requisition.cart.$mode";
        $cart = session($cart_key, []);
        $key =  $this->item_code . '-' . ( $this->is_grouped ? '' : $this->lab_id );
        return isset( $cart[ $key ] );
    }

    public function getIsInRequisitionCartAttribute(){
        return !empty( session("logistics.requisition.cart.$this->item_code") );
    }

    public function getIsInIssueCartAttribute(){
        return !empty( session("logistics.issue.cart.$this->item_code") );
    }

    public function getBelowReorderLevelAttribute(){
//        dd( $this->is_grouped, $this->re_order_avg, $this->re_order );
        return $this->current_stock <= $this->is_grouped ? $this->re_order_avg : $this->re_order;
    }


    public function getRequiredQuantityAttribute(){
        return floatval( RequisitionItem::with('item', 'requisition')
            ->where('item_code', $this->item_code)
            ->whereHas('requisition', function( Builder $query ){
                $query->where('status', 'pending');
                $query->lab( $this->is_grouped ? NULL : $this->lab_id );
            })->sum('required_qty') );
    }


        // Scopes ============================

    public static function scopes(){
        return static::query()->where(DB::raw('1'), DB::raw('1'));
    }


    public function scopeItemCode(Builder $query, $value = NULL ){
        if( !$value ) return $query;
        return $query->where( 'item_code', 'LIKE', like_param( $value ) );
    }

    public function scopeBelowReorderLevel(Builder $query ){
        return $query->whereColumn( 'current_stock', '<=', 're_order');
    }


}