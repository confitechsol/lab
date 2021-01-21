<?php

namespace App\Model\Logistics;


use App\Model\Lab;
use Carbon\Carbon;
use FontLib\TrueType\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property Lab $lab
 * @property Collection $items
 * @property \Carbon\Carbon $receipt_date
 * @property string receipt_no
 * @property string doc_type
 * @property string document_no
 * @property Carbon document_date
 * @property string tr_no
 * @property Carbon tr_date
 * @property int user_id
 * @property Shipment $shipment
 */
class Receipt extends Model
{

    protected $table = 't_itemrcpt_hdr';

    protected $casts = [
        'receipt_date' => 'date',
        'document_date' => 'date',
        'tr_date' => 'date',
    ];

    protected $fillable = ['lab_id', 'receipt_date', 'doc_type'];


    const NUMBER_PREFIX = 'RCPT';


    // Relations ======================================

    public function items(){
        return $this->hasMany( ReceiptItem::class, 'receipt_id', 'id' );
    }

    public function lab(){
        return $this->belongsTo( Lab::class, 'lab_id', 'id' );
    }


    public function shipment(){
        return $this->belongsTo( Shipment::class, 'document_no', 'shipment_no' );
    }



}