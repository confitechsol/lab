<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'm_equipment';
  	protected $fillable = ['name_cat','name','tool','status','supplier','make','serial_no',
    'model_no','date_installation','location','created_by','updated_by','provider','donor_name','waranty_status','date_last_maintain','maintainance_report','due_date','contact_name',
    'contact_no','responsible_person','date_decommission',
    'next_calibration','breakdown_eqp','company_name','contact_email',
    'return_function_status','record_instrument','eqp_id',
    'org','curr_warrenty','eqp_maintain','flag',
    'records_inst','date_last_caliberation','cbnaat_equipment_name',
    ];

  	const STATUS_ACTIVE = 1;
  	const STATUS_INACTIVE = 0;

}
