<?php

namespace App\Model\Logistics;


use App\Model\Lab;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property Lab $lab
 */
class CentralItem extends Model
{


    protected $table = 'm_central_item';


    public function lab(){
        return $this->belongsTo( Lab::class, 'lab_id', 'id' );
    }

}