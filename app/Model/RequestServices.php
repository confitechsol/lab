<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RequestServices extends Model
{
    //
    protected $table = 't_request_services';
    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';
    protected $fillable = ['enroll_id', 'test_req_id', 'rntcp_reg_no','service_id', 'requestor_name',
    'designation', 'contact_no','email_id','request_date','duration','diagnosis',
    'regimen','reason','post_treatment','pmdt_tb_no','month_week','treatment','ho_anti_tb',
    'type_of_prsmptv_drtb','presumptive_h','prsmptv_xdrtv','regimen_fu','fudrtb_regimen_other','facility_type_other','other_post_treatment','no_of_hcp_visit','history_previous_att','specimen_type_test','visual_appearance_sputum','specimen_type_other','created_by'];


    const TYPE_PRESUMPTIVE = 1;

}
