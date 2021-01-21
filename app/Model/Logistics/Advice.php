<?php

namespace App\Model\Logistics;


use App\Model\Lab;
use App\Model\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $advice_no
 * @property string $requisition_no
 * @property string $advice_type
 * @property int $user_id
 * @property User $user
 * @property Requisition $requisition
 * @property Collection $items
 * @property boolean $is_purchase
 * @property boolean $is_transfer
 * @property bool $shipment_is_uploaded
 * @property bool $shipment_is_submitted
 * @property Collection $shipments
 * @property Collection $transfers
 */
class Advice extends Model
{


    protected $table = 't_central_advice_hdr';

    protected $fillable = ['requisition_no'];


    const TYPE_PURCHASE = 'purchase';
    const TYPE_TRANSFER = 'transfer';

    const PURCHASE_NUMBER_PREFIX = 'ADV/PO';
    const TRANSFER_NUMBER_PREFIX = 'ADV/STK';


    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETE = 'complete';



    // Relationships ============================

    public function requisition(){
        return $this->belongsTo(Requisition::class, 'requisition_no', 'requisition_no');
    }


    public function shipments(){
        return $this->hasMany(Shipment::class, 'advice_id', 'id');
    }


    public function transfers(){
        return $this->hasMany(StockTransfer::class, 'advice_no', 'advice_no');
    }


    public function items(){
        return $this->hasMany(AdviceItem::class, 'advice_id', 'id');
    }


    public function user(){
        return $this->belongsTo(User::class);
    }





    // Scopes ===================================

    public static function scopes(){
        return static::query()->where(DB::raw('1'), DB::raw('1'));
    }

    public function scopeAdviceType(Builder $query, $value = NULL){
        if( !$value ) return $query;
        return $query->where( 'advice_type', $value );
    }




    // Attributes ================================

    public function getIsPurchaseAttribute(){
        return $this->advice_type === static::TYPE_PURCHASE;
    }

    public function getIsTransferAttribute(){
        return $this->advice_type === static::TYPE_TRANSFER;
    }


    public function getShipmentIsUploadedAttribute(){
        return Storage::disk('shipments')->exists( "$this->id.xlsx" );
    }

    public function getShipmentIsSubmittedAttribute(){
        return $this->shipments()->count() > 0;
    }

}