<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SampleQuality extends Model
{
        protected $table = 'req_test';
    protected $fillable = ['enroll_id', 'facility_id', 'facility_type', 'ho_anti_tb', 'predmnnt_symptoms', 'duration', 'state', 'district', 'tbu', 'request_date', 'pmdt_tb_no', 'rntcp_reg_no ', 'req_test_type', 'regimen', 'reason', 'type_of_prsmptv_drtb', 'prsmptv_xdr_tb', 'treatment'];

    public static function sample_quality_list(){
        try{
        	$sample = SampleQuality::all();

      		$data['sample'] = $sample;

      		return view('admin.sample_quality.list',compact('data'));

        }catch(\Exception $e){

            return (['ret'=>[],'err'=>['code'=>1, 'msg'=>$e->getMessage()]]);
        }

    }

    public static function sample_quality_edit($id){
        try{

      		return view('admin.sample_quality.form1',compact('data'));

        }catch(\Exception $e){

            return (['ret'=>[],'err'=>['code'=>1, 'msg'=>$e->getMessage()]]);
        }

    }
}
