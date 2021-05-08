<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TestRequest extends Model
{
    protected $table = 'req_test';
     protected $fillable = ['enroll_id', 'facility_id', 'facility_type', 'ho_anti_tb', 'predmnnt_symptoms', 'duration', 'state',
     'district', 'tbu', 'request_date', 'pmdt_tb_no', 'rntcp_reg_no ', 'req_test_type', 'regimen_test', 'reason',
      'type_of_prsmptv_drtb_test', 'prsmptv_xdr_tb_test', 'treatment', 'month_week','requestor_name','designation','contact_no','email_id',
      'prsmptv_xdrtv_test','presumptive_h_test','post_treatment','regimen_fu', 'lab_code', 'nikshay_id', 'enroll_label', 'state_name', 'district_name', 'tbu_name', 'facility_name'];
	  
	protected $casts = [        
		'state' => 'string',
        'district' => 'string',        
		'requestor_name' => 'string',
        'designation' => 'string',
		'contact_no' => 'string',
        'email_id' => 'string',		
		'facility_type_other' => 'string',
		'no_of_hcp_visit' => 'string',
		'specimen_type_other' => 'string',
		'request_date' => 'string'
    ];  


}
