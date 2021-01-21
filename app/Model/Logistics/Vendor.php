<?php

namespace App\Model\Logistics;


use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $vendor_name
 * @property string $vendor_address
 * @property string $vendor_type
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Vendor extends Model
{

    protected $table = 'm_vendor';

}