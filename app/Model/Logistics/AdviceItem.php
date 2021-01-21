<?php

namespace App\Model\Logistics;


use App\Model\Lab;
use App\Model\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $advice_id
 * @property string $item_code
 * @property int $to_lab_id
 * @property float $advice_qty
 * @property int $user_id
 * @property Item $detail
 * @property Lab $lab
 * @property User $user
 * @property Advice $advice
 * @property float $required_quantity
 * @property RequisitionItem $requisition_item
 * @property float $received_qty
 * @property float $transferred_qty
 */
class AdviceItem extends Model
{

    protected $table = 't_central_advice_item';

    protected $fillable = ['item_code', 'to_lab_id', 'advice_qty'];

    protected $casts = [
        'advice_qty' => 'float',
        'received_qty' => 'float',
        'transferred_qty' => 'float',
    ];


    // Relationships ============================

    public function advice(){
        return $this->belongsTo(Advice::class, 'advice_id', 'id');
    }

    public function detail(){
        return $this->belongsTo(Item::class, 'item_code', 'code');
    }

    public function lab(){
        return $this->belongsTo(Lab::class, 'to_lab_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getRequisitionItemAttribute(){
        return $this->advice->requisition->items->where('item_code', $this->item_code)->first();
    }

    // Attributes ================================
    public function getRequiredQuantityAttribute(){
        if( !$this->advice->requisition ) return 0;
        return $this->advice->requisition->items->where('item_code', $this->item_code)->first()->required_qty ?? NULL;
    }



}