<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $lab_id
 * @property string $lab_name
 * @property string $lab_code
 * @property string $city
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Config extends Model
{
   protected $table = 'm_configuration';
  protected $fillable = ['lab_id','lab_name','lab_code','city','address','details','logo','nabl_logo','nabl_no','micro_name','micro_email','micro_number','barcode_offset','sink_schedule','sink_user','sink_user_id','sink_password','status'];
}
