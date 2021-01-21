<?php

namespace App\Model\Logistics;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property mixed $requisitions
 */
class SentTo extends Model
{
    //

    public $timestamps = false;

    protected $table = 'm_sentto';


    public function requisitions(){
        return $this->hasMany( Requisition::class, 'sent_to', 'id' );
    }

}
