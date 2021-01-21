<?php

namespace App\Model\Logistics;


use App\Model\Config;
use App\Model\Lab;
use App\Model\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id
 * @property int $lab_id
 * @property string $requisition_no
 * @property string $status
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property User $user
 * @property Collection $items
 * @property Lab $lab
 * @property float $total_requested_quantity
 * @property float $total_adviced_quantity
 * @property float $total_shipment_quantity
 * @property float $total_received_quantity
 * @property int $sent_to
 * @property string $sent_to_name
 * @property SentTo sentTo
 */
class Requisition extends Model
{


    protected $table = 't_requisition_hdr';


    protected $fillable = [];


    const NUMBER_PREFIX = 'PRQ';

    const STATUS_PENDING = 'pending';
    const STATUS_PARTIAL = 'partial';
    const STATUS_TRANSFER_ADVICED = 'transfer adviced';
    const STATUS_PROCUREMENT_ADVICED = 'procurement adviced';
    const STATUS_COMPLETE = 'complete';


    // Relations ======================

    public function user(){
        return $this->belongsTo(User::class);
    }


    public function items(){
        return $this->hasMany( RequisitionItem::class, 'requisition_id', 'id' );
    }


    public function lab(){
        return $this->belongsTo( Lab::class, 'lab_id', 'id' );
    }

    public function sentTo(){
        return $this->belongsTo( SentTo::class, 'sent_to', 'id' );
    }



    // Scopes ======================

    public static function scopes(){
        return static::query()->where(DB::raw('1'), DB::raw('1'));
    }

    public function scopePending(Builder $query){
        return $query->where( 'status', 'pending' );
    }

    public function scopeStatus(Builder $query, $value = NULL){
        if( !$value ) return $query;
        return $query->where( 'status', $value );
    }

    public function scopeRequisitionNumber(Builder $query, $value = NULL){
        if( !$value ) return $query;
        return $query->where( 'requisition_no', 'LIKE', like_param( $value ) );
    }

    public function scopeLab(Builder $query, $value = NULL){
        if( !$value ) return $query;
        return $query->where( 'lab_id', $value );
    }

    public function scopeSentTo(Builder $query, $value = NULL){
        if( !$value ) return $query;
        return $query->where( 'sent_to', $value );
    }


    // Attributes ===================
    public function getTotalRequestedQuantityAttribute(){
        return floatval( $this->items()->sum('required_qty') );
    }

    public function getTotalAdvicedQuantityAttribute(){
        return floatval( $this->items()->sum('adviced_qty') );
    }

    public function getTotalShipmentQuantityAttribute(){
        return floatval( $this->items()->sum('shipment_qty') );
    }

    public function getTotalReceivedQuantityAttribute(){
        return floatval( $this->items()->sum('received_qty') );
    }

    public function getSentToNameAttribute(){
        return $this->sentTo->name;
    }

}