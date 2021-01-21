<?php

namespace App\Model\Logistics;


use App\Model\Lab;
use FontLib\TrueType\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string shipment_no
 * @property string advice_id
 * @property string requisition_no
 * @property int vendor_id
 * @property string tr_no
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property Advice $advice
 * @property Requisition $requisition
 * @property Collection $items
 * @property int lab_id
 * @property Lab lab
 * @property Collection $receipts
 * @property \Carbon\Carbon $shipment_date
 * @property string $status
 */
class Shipment extends Model
{

    protected $table = 't_central_shipment_hdr';

    protected $casts = [
        'shipment_date' => 'date'
    ];

    protected $fillable = [
        'shipment_date', 'vendor_name', 'po_no', 'lab_id', 'requisition_no',
        'advice_id', 'shipment_no', 'shipment_date', 'vendor_name', 'courier_name',
        'status', 'user_id'
    ];


    const STATUS_PENDING = 'pending';
    const STATUS_RECEIVED = 'received';


    const NUMBER_PREFIX = 'SHP';


    // Relations ======================================

    public function advice(){
        return $this->belongsTo(Advice::class, 'advice_id', 'id');
    }

    public function requisition(){
        return $this->belongsTo(Requisition::class, 'requisition_no', 'requisition_no');
    }

    public function items(){
        return $this->hasMany( ShipmentItem::class, 'shipment_id', 'id' );
    }

    public function lab(){
        return $this->belongsTo( Lab::class, 'lab_id', 'id' );
    }


    public function receipts(){
        return $this->hasMany( Receipt::class, 'document_no', 'shipment_no' )
            ->where('doc_type', Advice::TYPE_PURCHASE);
    }



}