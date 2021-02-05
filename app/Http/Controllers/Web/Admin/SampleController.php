<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Model\Sample;
use App\Model\Cbnaat;
use App\Model\Enroll;
use App\Model\Service;
use App\Model\LJDetail;
use App\Model\FirstLineLpa;
use App\Model\SecondLineLpa;
use App\Model\FinalInterpretation;
use App\Model\LCFlaggedMGITFurther;
use App\Model\LjDstReading;
use App\Model\LCDST;
use App\Model\TestRequest;
use App\Model\ServiceLog;
use App\Model\Config;
use App\Model\RequestServices;
use Illuminate\Support\Facades\DB;
use App\Model\Microbio;
use App\Model\Microscopy;
use App\Model\Hybridization;
use App\Model\Barcodes;
use DateTime;
use App\User;
use \Milon\Barcode\DNS1D;
use Illuminate\Support\Facades\Auth;
use PDF;
use App;
use Redirect;

class SampleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

		$data['lab_details']=Config::select('lab_name as labname','city as labcity')->where('status',1)->first();
		// dd($data['lab_details']->labname);

		$data['labname']='unknown';
		$data['labcity']='unknown';
		if(!empty($data['lab_details']->labname)){

		$data['labname']=$data['lab_details']->labname;
		}

		if(!empty($data['lab_details']->labcity)){
		$data['labcity']=$data['lab_details']->labcity;

		}


        $data['sample'] = Sample::select(DB::raw('sample.id, u.name, sample.others_type,e.patient_id,sample.enroll_id,e.label,group_concat(receive_date) as receive,group_concat(sample.sample_label) as samples,group_concat(test_reason) as reason,group_concat(fu_month) as fu_month,group_concat(sample_type) as sample_type, group_concat(sample_quality) as sample_quality,group_concat(is_accepted) as is_accepted, count(sample_quality) as no_of_samples, group_concat(s.name) as sname'))
		 ->leftjoin('m_services as s','s.id','=','sample.service_id')
		 ->leftjoin('enrolls as e','e.id','=','sample.enroll_id')
		 ->leftJoin('users as u','u.id','=','sample.user_id')
         ->groupBy('sample.enroll_id')
		 ->orderBy('sample.enroll_id','desc')
		 ->distinct()
		 ->limit(20)->get();
// dd($data);

// select distinct sample.id, u.name, sample.others_type,e.patient_id,sample.enroll_id,e.label,group_concat(receive_date) as receive,group_concat(sample.sample_label) as samples,group_concat(test_reason) as reason,group_concat(fu_month) as fu_month,group_concat(sample_type) as sample_type, group_concat(sample_quality) as sample_quality,group_concat(is_accepted) as is_accepted, count(sample_quality) as no_of_samples, group_concat(s.name) as sname from `sample` left join `m_services` as `s` on `s`.`id` = `sample`.`service_id` left join `enrolls` as `e` on `e`.`id` = `sample`.`enroll_id` left join `users` u on `sample`.user_id=u.id group by `sample`.`enroll_id` order by `sample`.`enroll_id` desc




//dd($data['sample']);

        return view('admin.sample.list',compact('data'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //public function create($enroll_id)
	public function create()
    {
        //$data['enroll_id'] = $enroll_id;
        $data['today_date']=DB::select('select date_format(now(),"%d-%m-%y %H:%i:%s") as date');
        $data['today']=$data['today_date'][0]->date;
        $data['labcode']=Config::select('barcode_offset')->where('status',1)->get();
        $data['labcode']=$data['labcode'][0]->barcode_offset;

        $data['labcode']=date('y').substr($data['labcode'],2,3);

        $data['services'] = Service::select('id','name')->get();
        return view('admin.sample.form1',compact('data'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        //dd($request->all());
        $sample_id = $request->sample_id[0] ?? NULL;

        if( $sample_id ){

            // If Sample Exists display errors ==============
            if( Sample::where('sample_label', $sample_id)->count() > 0 ){
                return back()->withErrors(['Oops..! seems like the Sample ID you entered is already in use']);
            }

            // If Sample is rejected, move it to BWM ========
			  if( $request->is_accepted[0] === 'Rejected' ){
                $request->service_id = [ ServiceLog::TYPE_BWM ];
            }

            // incorporated by niladri 
           /* if(count($request->service_id) > 1){
               $service_arr=array('0'=>'26');
               $request->service_id=array_replace($request->service_id,$service_arr);
            }else{
            if( $request->is_accepted[0] === 'Rejected' ){
             $request->service_id = [ ServiceLog::TYPE_BWM ];
            }
            } */
			
			
         
            // Save the Sample & Redirect ===================
			//dd($request->all());
            Sample::store( $request );
            return redirect(route('sample.index'));

        }

        return back()->withErrors(['Oops..! seems like the Sample ID is not present.']);

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $data =  Sample::edit($id);
       return view('admin.sample.form',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        dd($request);
    }

    public function newUpdate(Request $request)
    {
        //dd($request->all());

        $custom_dt=$request->actualtime;
		
		if(!empty($custom_dt)){
		$time_exploded=explode(" " , $custom_dt);
		
		$custom_dt=$time_exploded[0];
		}else{
		  $custom_dt='';
        }
        
        $count = count($request->sample_id);

          if($count){           

            for ($i=0; $i < $count; $i++) {               

                if($request->sample_ID[$i] == '0')
                {
                    //dd($request->is_accepted[$i]);

                    if ($request->has('is_accepted')) {                        
                        if( $request->is_accepted[0] === 'Rejected' ){
                            $request->service_id[$i] = [ ServiceLog::TYPE_BWM ];
                        }
                    }
                    else
                    {
                        $smpdata = Sample::find($request->sample_ID[0]);
                        if( $smpdata->is_accepted === 'Rejected' ){
                            $request->service_id[$i] = [ ServiceLog::TYPE_BWM ];
                        }
                    }                    

                    $update_enroll = Enroll::find($request->EnrollID[$i]);
                    $update_enroll->patient_id = $request->EnrollID[$i];       
                    $update_enroll->save();

                    if($request->sample_type[$i]=="Other"){
                        $sample_type = $request->other_sample_type[$i];
                      }else{
                        $sample_type = $request->sample_type[$i];
                      }

                      if($request->rejection=='Other reason'){
                        $request->rejection = $request->reason_reject;
                      }

                      $request->name =  ucfirst ($request->name);
                    //dd($request->receive_date[$i]);
                    if($request->fu_month[$i]=='Other'){
                    $month=$request->followup_other[$i];
                    }
                    else {
                    $month=$request->fu_month[$i];
                    }

                    if($request->service_id[$i] == '8F' || $request->service_id[$i] == '8S' ){
                        $request->service_id[$i].set('8');
                      }

                      $scan_code=strtoupper($request->sample_id[$i]);
                        $last_index=substr($scan_code,-1);
                        if($last_index == 'A'){
                            Barcodes::where('codeA',$scan_code)->update(['barcode_status_A'=>'Y','barcode_status_B'=>'Y']);

                        }
                        if($last_index == 'B'){
                            Barcodes::where('codeB',$scan_code)->update(['barcode_status_B'=>'Y','barcode_status_A'=>'Y']);
                        }

                        $data = Sample::insertGetId([
                            'name' => $request->name,
                            'nikshay_id' => $request->nikshay_id,
                            'sample_label' => $request->sample_id[$i],
                            'receive_date' => $request->receive_date[$i].' '.$custom_dt,
                            'sample_quality' => $request->sample_quality[$i],
                            'other_samplequality'=>$request->othersample_quality[$i],
                            'sample_type' => $sample_type,
                            'is_accepted' => $smpdata->is_accepted,
                            'rejection'  => $request->rejection[$i],
                            'test_reason' => $request->test_reason[$i],
                            'fu_month' => $month,
                            'enroll_id' => $request->EnrollID[$i],			 
                            'user_id' => $request->user()->id,
                            'no_of_samples' => $request->no_of_samples,
                            'service_id' => $request->service_id[$i],
                            'others_type' => $request->others_type[$i],
                            'created_at' => date('Y-m-d H:i:s'),
                          ]);

                          $status = ServiceLog::STATUS_ACTIVE;
                        if( $request->service_id[ $i ] == ServiceLog::TYPE_STORAGE ){
                            $status = ServiceLog::STATUS_STORAGE;
                        }

                        $type = '';
                        if($request->service_id[$i] == '8F'){
                        $type = 'LPA1';
                        $request->service_id[$i].set('8');
                        }else if($request->service_id[$i] == '8S'){
                        $type = 'LPA2';
                        $request->service_id[$i].set('8');
                        }else if($request->service_id[$i] == 1){
                        $type = 'ZN Microscopy';             
                        }else if($request->service_id[$i] == 2){
                        $type = 'FM Microscopy';             
                        }else if($request->service_id[$i] == 3){
                        $type = 'Decontamination';             
                        }else if($request->service_id[$i] == 4){
                        $type = 'CBNAAT';             
                        }else if($request->service_id[$i] == 16){
                        $type = 'LC';              
                        }else if($request->service_id[$i] == 11){
                        $type = 'STORAGE';              
                        }

                        ServiceLog::create([
                            'enroll_id' => $request->EnrollID[$i],
                            'sample_id' => $data,
                            'service_id' => $request->service_id[$i],
                            'enroll_label' => substr_replace($request->sample_id[0] ,"",-1),
                            'created_by' => $request->user()->id,
                            'updated_by' => $request->user()->id,
                            'sample_label' => $request->sample_id[$i],
                            'reported_dt'=>date('Y-m-d'),
                            'tag' => $type,
                            'status' => $status
                          ]);
                }
                else
                {
                    /* if ($request->has('is_accepted')) {                        
                        if( $request->is_accepted[0] === 'Rejected' ){
                            $request->service_id[$i] = [ ServiceLog::TYPE_BWM ];
                        }
                    }
                    else
                    {
                        $smpdata = Sample::find($request->sample_ID[0]);
                        if( $smpdata->is_accepted === 'Rejected' ){
                            $request->service_id[$i] = [ ServiceLog::TYPE_BWM ];
                        }
                    }                    

                    $update_enroll = Enroll::find($request->EnrollID[$i]);
                    $update_enroll->patient_id = $request->EnrollID[$i];       
                    $update_enroll->save();

                    if($request->sample_type[$i]=="Other"){
                        $sample_type = $request->other_sample_type[$i];
                      }else{
                        $sample_type = $request->sample_type[$i];
                      }

                      if($request->rejection=='Other reason'){
                        $request->rejection = $request->reason_reject;
                      }

                      $request->name =  ucfirst ($request->name);
                    //dd($request->receive_date[$i]);
                    if($request->fu_month[$i]=='Other'){
                    $month=$request->followup_other[$i];
                    }
                    else {
                    $month=$request->fu_month[$i];
                    }

                    if($request->service_id[$i] == '8F' || $request->service_id[$i] == '8S' ){
                        $request->service_id[$i].set('8');
                      }

                      $scan_code=strtoupper($request->sample_id[$i]);
                        $last_index=substr($scan_code,-1);
                        if($last_index == 'A'){
                            Barcodes::where('codeA',$scan_code)->update(['barcode_status_A'=>'Y','barcode_status_B'=>'Y']);

                        }
                        if($last_index == 'B'){
                            Barcodes::where('codeB',$scan_code)->update(['barcode_status_B'=>'Y','barcode_status_A'=>'Y']);
                        }

                        $sampleData = Sample::find($request->sample_ID[0]);

                        $sampleData->name = $request->name;
                        $sampleData->nikshay_id = $request->nikshay_id;
                        $sampleData->sample_label = $request->sample_id[$i];
                        $sampleData->receive_date = $request->receive_date[$i].' '.$custom_dt;
                        $sampleData->sample_quality = $request->sample_quality[$i];
                        $sampleData->other_samplequality=$request->othersample_quality[$i];
                        $sampleData->sample_type = $sample_type;
                        $sampleData->is_accepted = $smpdata->is_accepted;
                        $sampleData->rejection  = $request->rejection[$i];
                        $sampleData->test_reason = $request->test_reason[$i];
                        $sampleData->fu_month = $month;
                        $sampleData->enroll_id = $request->EnrollID[$i];			 
                        $sampleData->user_id = $request->user()->id;
                        $sampleData->no_of_sample = $request->no_of_samples;
                        $sampleData->service_id = $request->service_id[$i];
                        $sampleData->others_type = $request->others_type[$i];
                        $sampleData->created_at = date('Y-m-d H:i:s');
                        $sampleData->save();


                        $type = '';
                        if($request->service_id[$i] == '8F'){
                        $type = 'LPA1';
                        $request->service_id[$i].set('8');
                        }else if($request->service_id[$i] == '8S'){
                        $type = 'LPA2';
                        $request->service_id[$i].set('8');
                        }else if($request->service_id[$i] == 1){
                        $type = 'ZN Microscopy';             
                        }else if($request->service_id[$i] == 2){
                        $type = 'FM Microscopy';             
                        }else if($request->service_id[$i] == 3){
                        $type = 'Decontamination';             
                        }else if($request->service_id[$i] == 4){
                        $type = 'CBNAAT';             
                        }else if($request->service_id[$i] == 16){
                        $type = 'LC';              
                        }else if($request->service_id[$i] == 11){
                        $type = 'STORAGE';              
                        } */

                        
                }
            }
			   
          }

          return redirect(route('sample.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $sample_string
     * @return \Illuminate\Http\Response
     */
    public function barCodePrint($sample_string)
    {
        //echo $sample_string;
        $samples = explode(',', $sample_string);
        foreach ($samples as $key => $value) {
          echo DNS1D::getBarcodeSVG($value,"C93",0.6,20); //C39
          echo "<br/>".$value;
          echo "<br/><br/><br/>";
        }
        //echo DNS1D::getBarcodeSVG("0000000004A", "C39");
    }

    public function sample_preview(request $request, $id)
    {
        $data['enroll']=DB::table('enrolls')->select('label as enroll')->where('id',$id)->first();
        $data['sample_detail']=Sample::select('name','no_of_samples')->where('enroll_id',$id)->first();
        $data['sample'] = Sample::where('enroll_id',$id)->get();
        return view('admin.sample.preview',compact('data'));
    }

    public function pdfview(Request $request, $id, $pdf=null)
    {
        //dd($request->all());
		// dd($pdf);
        //dd($id);
        $data['today'] = '';
		$enroll_id = Sample::select('enroll_id')->where('id', $id)->first();
		//DB::enableQueryLog();
		//$data['hybridization_data'] = Hybridization::where('sample_id', $id)->first();
		//$data['hybridization_data'] = Hybridization::join('sample', 'sample.id', '=', 't_hybridization.sample_id')->select('t_hybridization.*','sample.sample_label')->where('t_hybridization.sample_id', $id)->first();
        $data['hybridization_data'] = Hybridization::select('t_hybridization.*','sample.sample_label')
		                            ->join('sample', 'sample.id', '=', 't_hybridization.sample_id')									
									->join('t_service_log as tsl', function ($join) {
										 $join->on('tsl.sample_id','=','t_hybridization.sample_id');
										 $join->on('tsl.enroll_id', '=','t_hybridization.enroll_id');
										 $join->on('tsl.tag', '=','t_hybridization.tag');
									     $join->where('tsl.sent_to_nikshay', 1);
									 })
									->where('t_hybridization.enroll_id', $enroll_id->enroll_id)
									->get();
		// dd(DB::getQueryLog());							
        $approved_date = Microbio::select('approved_date')
            ->where('sample_id', $id)
            ->first();
        // dd($approved_date);
        if (!empty($approved_date->approved_date)):
            $appr_date = $approved_date->approved_date;

            $data['today'] = $appr_date;
        endif;


        $final = 0;
        // if($final==1){
        //   $data['report_type'] = 'End of Report';
        // }
        // else {
        //   $data['report_type'] = 'Interim Report';
        // }
        $data['labrotory_name'] = Config::select('lab_name')
            ->where('status', 1)
            ->first();

        $data['labrotory_name'] = $data['labrotory_name']->lab_name;

		$data['microbio_name'] = Config::select('micro_name')
			->where('status', 1)
			->first();
			
		$data['microbio_name'] = $data['microbio_name']->micro_name;
		 
        $reportType = Microbio::select('report_type')
            ->where('sample_id', $id)
            ->first();

        // dd($reportType);

        $data['type_of_prsmptv_drtb'] = [];
        $data['date_receipt'] = Sample::select('receive_date')->where('id', $id)->first();
        if ($reportType) {
            $data['report_type'] = $reportType->report_type;
        } else {
            $data['report_type'] = 'Draft Report';
        }



        $data['user'] = Microbio::query()
            ->join('users', 'created_by', 'users.id')
            ->where('sample_id', $id)
            ->first()->name ?? '';


        // dd($data['user']);
        $data['personal'] = Sample::select('sample.*', 'sample.id as smp_id', 'p.name as userName', 'p.*','p.nikshay_id as pnikshay_id', 'e.*', 'district.name as district_name',
            's.name as state_name', 'r.rntcp_reg_no', 'r.regimen', 'r.reason as test_reason', 'r.requestor_name', 'r.designation',
            'r.contact_no as requestor_cno', 'r.email_id as requestor_email', 'ps.name as ps_name', 'r.duration', 'r.type_of_prsmptv_drtb',
            'r.prsmptv_xdrtv', 'r.presumptive_h', 'r.pmdt_tb_no', 'rs.diagnosis', 'p.population_other', 'p.health_establish_id',
            'r.month_week', 'r.treatment', 'rs.regimen_fu', 'rs.fudrtb_regimen_other', 'rs.facility_type_other', 'r.req_test_type',
            'phi.name as phi_name', 'm_tbunits_relation.TBUnitName as mtb', 'ft.name as f_name', 'mdmcs.DMC_PHI_Name', 'mtr.TBUnitName', 'mdr.name AS facility_district','msr.name AS facility_state', 'p.collection_date as collection_dates', 'p.collection_time as collection_time')
            ->leftjoin('req_test as r', 'r.enroll_id', '=', 'sample.enroll_id')
            ->leftjoin('m_predominan_symptom as ps', 'ps.symptom_id', '=', 'r.predmnnt_symptoms')
            ->leftjoin('enrolls as e', 'e.id', '=', 'sample.enroll_id')
            ->leftjoin('t_request_services as rs', 'rs.enroll_id', '=', 'sample.enroll_id')
            ->leftjoin('patient as p', 'p.id', '=', 'e.patient_id')
            ->leftjoin('m_phi as phi', 'phi.id', '=', 'p.phi')
            // ->leftjoin('m_tb as mtb','mtb.id','=','p.tb')
            // ->leftjoin('district as d','d.id','=','p.district')
            ->leftjoin('state as s', 's.STOCode', '=', 'p.state')
            ->leftJoin('m_tbunits_relation', function ($join) {
                $join->on('m_tbunits_relation.tbunitcode', '=', 'p.tb')
                    ->on('m_tbunits_relation.DTOCode', '=', 'p.district')
                    ->on('m_tbunits_relation.STOCode', '=', 'p.state');
            })
            ->leftJoin('district', function ($join) {
                $join->on('district.DTOCode', '=', 'p.district')
                    ->on('district.STOCode', '=', 'p.state');
            })
            ->leftjoin('facility_master as ft', 'ft.id', '=', 'r.facility_type')
            ->leftjoin('m_dmcs_phi_relation as mdmcs', 'mdmcs.id', '=', 'r.facility_id')
			//->leftjoin('m_tbunits_relation as mtr', 'mtr.TBUnitCode', '=', 'r.tbu')
			 ->leftJoin('m_tbunits_relation as mtr', function ($join) {
                $join->on('mtr.tbunitcode', '=', 'r.tbu')
                    ->on('mtr.DTOCode', '=', 'r.district')
                    ->on('mtr.STOCode', '=', 'r.state');
            })
			->leftjoin('district as mdr', 'mdr.DTOCode', '=', 'r.district')
			->leftjoin('state as msr', 'msr.STOCode', '=', 'r.state')
            ->where('sample.id', $id)
            ->first();

        //dd(  $data['personal']);

        //  $res_query = DB::select(DB::raw("select `sample`.*,
        // `sample`.`id` as `smp_id`,
        // `p`.`name` as `userName`,
        // `p`.*, `e`.*, `d`.`name` as `district_name`,
        // `s`.`name` as `state_name`,
        // `r`.`rntcp_reg_no`,
        // `r`.`regimen`,
        // `r`.`reason` as `test_reason`,
        // `r`.`requestor_name`,
        // `r`.`designation`,
        // `r`.`contact_no` as `requestor_cno`,
        // `r`.`email_id` as `requestor_email`,
        // `ps`.`name` as `ps_name`,
        // `r`.`duration`,
        // `r`.`type_of_prsmptv_drtb`,
        // `r`.`prsmptv_xdrtv`,
        // `r`.`presumptive_h`,
        // `r`.`pmdt_tb_no`,
        // `rs`.`diagnosis`,
        // `p`.`population_other`,
        // `p`.`health_establish_id`,
        // `r`.`month_week`,
        // `r`.`treatment`,
        // `rs`.`regimen_fu`,
        // `rs`.`fudrtb_regimen_other`,
        // `rs`.`facility_type_other`,
        // `r`.`req_test_type`,
        // `phi`.`name` as `phi_name`,
        // `mtb`.`TBUnitName` as `mtb`,
        // `ft`.`name` as `f_name`,
        // `p`.`collection_date` as `collection_dates`
        //
        // from `sample`
        // left join `req_test` as `r` on `r`.`enroll_id` = `sample`.`enroll_id`
        // left join `m_predominan_symptom` as `ps` on `ps`.`symptom_id` = `r`.`predmnnt_symptoms`
        // left join `enrolls` as `e` on `e`.`id` = `sample`.`enroll_id`
        // left join `t_request_services` as `rs` on `rs`.`enroll_id` = `sample`.`enroll_id`
        // left join `patient` as `p` on `p`.`id` = `e`.`patient_id`
        // left join `m_phi` as `phi` on `phi`.`id` = `p`.`phi`
        // left join `m_tbunits_relation` as `mtb` on `mtb`.`tbunitcode` = `p`.`tb`  and `mtb`.`DTOCode`=`p`.`district` and `mtb`.`STOCode`= `p`.`state`
        // left join `district` as `d` on `d`.`DTOCode` = `p`.`district` and `d`.`STOCode`= `p`.`state`
        // left join `state` as `s` on `s`.`STOCode` = `p`.`state`
        // left join `facility_master` as `ft` on `ft`.`id` = `r`.`facility_type`
        //
        // where `sample`.`id` = $id"));
//dd($res_query[0]);

//$data['personal']  = $res_query[0];


        //dd($data['personal']);


        $data['microscopy_data'] = ServiceLog::select('m.*', 't_service_log.service_id', 't_service_log.sample_label')
            ->leftjoin('t_microscopy as m', 'm.sample_id', '=', 't_service_log.sample_id')
			//pradip-Microscopy 
			->leftJoin('users as u', 'u.id', '=', 't_service_log.updated_by')
            ->where('t_service_log.enroll_id', $data['personal']->enroll_id)
			 ->where('t_service_log.sent_to_nikshay',1)
            ->whereIn('t_service_log.service_id', [1, 2])//->where('t_service_log.status',0)
            ->get();

        // dd(count($data['microscopy_data']));
        $data['microscopyA'] = new Microscopy;
        $data['microscopyB'] = new Microscopy;
        $data['microscopy'] = 0;
        $data['microscopy2'] = 0;

        if (count($data['microscopy_data']) > 1) {

            foreach ($data['microscopy_data'] as $micro_data) {


                if ($data['microscopy_data']) {
                    $data['microscopy'] = $micro_data->service_id;
                    $sample_type = substr($micro_data->sample_label, -1);
                    if ($sample_type == 'A') {
                        $data['microscopyA'] = $micro_data;
                        $data['microscopy'] = 1;

                    }
                    if ($sample_type == 'B') {
                        $data['microscopyB'] = $micro_data;
                        $data['microscopy2'] = 2;
                        // dd($data['microscopyB']);
                    }
                }


            }

        } else {
            // dd($data['microscopy_data'][0]->service_id);
            if (!empty($data['microscopy_data'][0])) {


                if ($data['microscopy_data']) {
                    $data['microscopy'] = $data['microscopy_data'][0]->service_id;
                    $sample_type = substr($data['microscopy_data'][0]->sample_label, -1);
                    if ($sample_type == 'A') {
                        $data['microscopyA'] = $data['microscopy_data'][0];
                        $data['microscopy'] = 1;
                        // dd($data['microscopyA']);
                    }
                    if ($sample_type == 'B') {
                        $data['microscopyB'] = $data['microscopy_data'][0];
                        $data['microscopy2'] = 2;
                    }
                }
            }
        }
		//dd($data['personal']);
// dd($data);
        // dd($data['microscopyB']);
        $data['culturelj'] = LJDetail::leftjoin('sample as s', 's.id', '=', 't_lj_detail.sample_id')
		    ->leftjoin('t_service_log', 't_service_log.enroll_id', '=', 't_lj_detail.enroll_id')	
			//pradip-Culture LJ
			->leftJoin('users as u', 'u.id', '=', 't_service_log.updated_by')
			->where('t_service_log.sent_to_nikshay',1)
			->whereIn('t_service_log.service_id',[20,22])
            ->where('t_lj_detail.enroll_id', $data['personal']->enroll_id)
            ->where('t_lj_detail.status', 1)
            ->first();


        $data['culturelc'] = LCFlaggedMGITFurther::leftjoin('sample as s', 's.id', '=', 't_lc_flagged_mgit_further.sample_id')
            ->leftjoin('t_service_log', 't_service_log.enroll_id', '=', 't_lc_flagged_mgit_further.enroll_id')		
			//pradip-Culture LC
			->leftJoin('users as u', 'u.id', '=', 't_service_log.updated_by')
			->where('t_service_log.sent_to_nikshay',1)
			->whereIn('t_service_log.service_id',[17,18,19,21])//[17,18,19,21]
			->where('t_lc_flagged_mgit_further.enroll_id', $data['personal']->enroll_id)
            ->where('t_lc_flagged_mgit_further.status', 1)
            ->first();

        //dd($data['culturelc']);
        $data['culture'] = "";
        if ($data['culturelj']) {
            $data['culture-llj'] = 1;
        }
        if ($data['culturelc']) {
            $data['culture'] = 2;
        }
// dd($data['personal']->enroll_id);
        $data['cbnaat'] = Cbnaat::leftjoin('sample as s', 's.id', '=', 't_cbnaat.sample_id')
		    ->leftjoin('t_service_log', 't_service_log.enroll_id', '=', 't_cbnaat.enroll_id')
			//pradip-CBNAAT
			->leftJoin('users as u', 'u.id', '=', 't_service_log.updated_by')
			->where('t_service_log.sent_to_nikshay',1)
			->whereIn('t_service_log.service_id',[4])
            ->whereRaw(DB::raw("t_cbnaat.enroll_id =" . $data['personal']->enroll_id . " order by t_cbnaat.id desc limit 0,1"))->get();
		
	   //dd($data['cbnaat']);
		$data['req_test'] = TestRequest::where('enroll_id', $data['personal']->enroll_id)->first();
        $data['test_requests'] = RequestServices::where('enroll_id', $data['personal']->enroll_id)->first();

        $data['prsm_drtb'] = RequestServices::select('type_of_prsmptv_drtb', 'presumptive_h', 'prsmptv_xdrtv')->where('enroll_id', $data['personal']->enroll_id)->first();
        // dd($data['prsm_drtb']);
        if (!empty($data['prsm_drtb']['type_of_prsmptv_drtb']) || !empty($data['prsm_drtb']['presumptive_h']) || !empty($data['prsm_drtb']['prsmptv_xdrtv'])) {
            $prsm = $data['prsm_drtb']['type_of_prsmptv_drtb'] . ',' . $data['prsm_drtb']['presumptive_h'] . ',' . $data['prsm_drtb']['prsmptv_xdrtv'];

        } else {
            $prsm = null;

        }


        $data['type_of_prsmptv_drtb'] = $prsm != null ? explode(',', $prsm) : [];
// dd($data['type_of_prsmptv_drtb']);
        //$data['lpa1'] = FirstLineLpa::where('enroll_id', $data['personal']->enroll_id)->where('status', 1)->first();
        $data['lpa1'] = FirstLineLpa::join('sample', 'sample.id', '=', 't_1stlinelpa.sample_id')
		->leftjoin('t_service_log', 't_service_log.enroll_id', '=', 't_1stlinelpa.enroll_id') 
		->select('t_1stlinelpa.*','sample.sample_label')
		->where('t_service_log.sent_to_nikshay',1)
		->whereIn('t_service_log.service_id',[8,12,14,15])
		->where('t_service_log.tag','1st line LPA')
		->where('t_1stlinelpa.enroll_id', $data['personal']->enroll_id)
		->where('t_1stlinelpa.status', 1)
		->first();
		
		//dd($data['lpa1']);
		//$data['lpa2'] = SecondLineLpa::where('enroll_id', $data['personal']->enroll_id)->where('status', 1)->first();
        $data['lpa2'] = SecondLineLpa::join('sample', 'sample.id', '=', 't_2stlinelpa.sample_id')
		->leftjoin('t_service_log', 't_service_log.enroll_id', '=', 't_2stlinelpa.enroll_id') 
		->select('t_2stlinelpa.*','sample.sample_label')
		->where('t_service_log.sent_to_nikshay',1)
		->whereIn('t_service_log.service_id',[8,12,14,15])
		->where('t_service_log.tag','2nd line LPA')
		->where('t_2stlinelpa.enroll_id', $data['personal']->enroll_id)
		->where('t_2stlinelpa.status', 1)
		//->toSql();
		->first();
        
		//dd($data['lpa2']);
	   
	   
	   
	   // $data['lpaf'] = FinalInterpretation::where('enroll_id', $data['personal']->enroll_id)->where('status', 1)->first();
        $data['lpaf'] = FinalInterpretation::where('t_lpa_final.enroll_id', $data['personal']->enroll_id)
		 ->leftjoin('t_service_log', function ($join) {
            $join->on('t_lpa_final.enroll_id', '=', 't_service_log.enroll_id')
                ->on('t_service_log.enroll_id','=','t_lpa_final.enroll_id')
		         ->on('t_service_log.sample_id','=','t_lpa_final.sample_id')
		         ->on('t_service_log.tag','=','t_lpa_final.tag');
				
        })	
		
		//pradip-LPA Final
		->leftjoin('users as u', 'u.id', '=', 't_service_log.updated_by')
		->where('t_service_log.sent_to_nikshay',1)
		->whereIn('t_service_log.service_id',[8,12,14,15])		
		->where('t_lpa_final.enroll_id', $data['personal']->enroll_id)
		->where('t_lpa_final.status', 1)
		->get()
		->toArray();
		//->toSql();
		//dd($data['lpaf']);
		$data['test_requested'] = RequestServices::where('enroll_id', $data['personal']->enroll_id)->pluck('service_id')->toArray();

        //dd($data['test_requested'] );
        $data['microbio'] = Microbio::where('t_microbiologist.enroll_id', $data['personal']->enroll_id)
		->leftjoin('t_service_log', 't_service_log.enroll_id', '=', 't_microbiologist.enroll_id') 
		->where('t_service_log.sent_to_nikshay',1)	
		->get()->toArray();
		
        //dd($data['microbio']);
        $data['lj_dst'] = LjDstReading::select('t_lj_dst_reading.drug_reading', 't_lj_dst_reading.created_at','t_service_log.sent_to_nikshay_date','u.name')
		->leftjoin('t_service_log', 't_service_log.enroll_id', '=', 't_lj_dst_reading.enroll_id') 
		//pradip-LJ DST
		->leftjoin('users as u', 'u.id', '=', 't_service_log.updated_by')
		->where('t_service_log.sent_to_nikshay',1)	
		->whereIn('t_service_log.service_id',[22])	
		->where('t_lj_dst_reading.enroll_id', $data['personal']->enroll_id)
		->orderBy('t_lj_dst_reading.id', 'DESC')
		->first();
       //dd($data['lj_dst']);
        $data['lc_dst'] = LCDST::select('t_lc_dst.drug_name as name', 't_lc_dst.result as value', 't_lc_dst.result_date','t_service_log.sent_to_nikshay_date','u.name as uname' )
		->leftjoin('t_service_log', 't_service_log.enroll_id', '=', 't_lc_dst.enroll_id') 
		//pradip-LC DST
		->leftjoin('users as u', 'u.id', '=', 't_service_log.updated_by')
		->where('t_service_log.sent_to_nikshay',1)
        ->whereIn('t_service_log.service_id',[21])		
		->where('t_lc_dst.enroll_id', $data['personal']->enroll_id)
		->orderBy('t_lc_dst.id', 'DESC')
		->get();
		//dd($data['lc_dst']);
		
		
        $data['lab_sr'] = DB::table('sample')->select('sample_label')
		->where('sample.enroll_id', $data['personal']->enroll_id)
		->first();
		//dd($data['lab_sr']);
        $data['lab_serial'] = DB::table('t_lpa_final')->select('type')
		->where('t_lpa_final.enroll_id', $data['personal']->enroll_id)
		->first();
		//dd($data['lab_serial']);
        //$dil = json_decode($data['lj_dst']);
        $data['lc_dst_fld']['s'] = "";
        $data['lc_dst_fld']['H(inh A)'] = "";
        $data['lc_dst_fld']['H(Kat G)'] = "";
        $data['lc_dst_fld']['r'] = "";
        $data['lc_dst_fld']['e'] = "";
        $data['lc_dst_fld']['z'] = "";
        $data['lc_dst_fld']['km'] = "";
        $data['lc_dst_fld']['cm'] = "";
        $data['lc_dst_fld']['am'] = "";
        $data['lc_dst_fld']['lfx'] = "";
        $data['lc_dst_fld']['mfx1'] = "";
        $data['lc_dst_fld']['mfx2'] = "";
        $data['lc_dst_fld']['pas'] = "";
        $data['lc_dst_fld']['lzd'] = "";
        $data['lc_dst_fld']['cfz'] = "";
        $data['lc_dst_fld']['eto'] = "";
        $data['lc_dst_fld']['clr'] = "";
        $data['lc_dst_fld']['azi'] = "";
		$data['lc_dst_fld']['BDQ'] = "";

//      print_r( json_decode( json_encode( $data ), false, 512, JSON_PRETTY_PRINT ) );
//      exit;
		
		
		
	      //echo '<pre>'; print_r($data['lj_dst']); die;
		  //echo '<pre>'; print_r($data['lc_dst']); echo "p"; die;
		  if(!empty($data['lc_dst'])){
			 foreach ($data['lc_dst'] as $key => $value) {
				 if ($value->name == "S") {
					$data['lc_dst_fld']['s'] = $value->value;

				}
			   
				if ($value->name == "H(0_1)" || $value->name == "H(0.1)") {

					$data['lc_dst_fld']['H(inh A)'] = $value->value;

				}
				if ($value->name == "H(0_4)" OR $value->name == "H(0.4)") {
				   $data['lc_dst_fld']['H(Kat G)'] = $value->value;
				}
				if ($value->name == "R") {
				   $data['lc_dst_fld']['r'] = $value->value;
				} 
				if ($value->name == "E") {
					$data['lc_dst_fld']['e'] = $value->value;
				} 
				if ($value->name == "Z") {
					$data['lc_dst_fld']['z'] = $value->value;
				}
				if ($value->name == "Km") {
					$data['lc_dst_fld']['km'] = $value->value;
				}
				if ($value->name == "Cm") {
					$data['lc_dst_fld']['cm'] = $value->value;
				}
				
				if ($value->name == "Am") {
					$data['lc_dst_fld']['am'] = $value->value;
				}
				if ($value->name == "Lfx") {
				   $data['lc_dst_fld']['lfx'] = $value->value;
				} 
				//if ($value->name == "Mfx(0_5)" OR $value->name == "Mfx(0.5)") {
				if ($value->name == "Mfx(0_25)" OR $value->name == "Mfx(0.25)") {	
					$data['lc_dst_fld']['mfx1'] = $value->value;
				}
				//if ($value->name == "Mfx(2)") {
				if ($value->name == "Mfx(1)") {	
					$data['lc_dst_fld']['mfx2'] = $value->value;
				} 
				
				if ($value->name == "PAS") {
					$data['lc_dst_fld']['pas'] = $value->value;
				} 
				if ($value->name == "Lzd") {
					$data['lc_dst_fld']['lzd'] = $value->value;
				} 
				if ($value->name == "Cfz") {
					$data['lc_dst_fld']['cfz'] = $value->value;
				} 
				if ($value->name == "Eto") {
					$data['lc_dst_fld']['eto'] = $value->value;
				}
				if ($value->name == "Clr") {
				   $data['lc_dst_fld']['clr'] = $value->value;
				} 
				if ($value->name == "Azi") {
					$data['lc_dst_fld']['azi'] = $value->value;

				} 
				if ($value->name == "BDQ") {
					$data['lc_dst_fld']['BDQ'] = $value->value;

				} 
				
			 }	
	    }
		
        /*foreach ($data['lc_dst'] as $key => $value) {


            if ($value->name == "S") {
                $data['s'] = $value->value;

            }
            // echo $value->name;
            if ($value->name == "H(inh_A)" OR $value->name == "H(inh A)") {

                $data['H(inh A)'] = $value->value;

            }

            if ($value->name == "H(Kat_G)" OR $value->name == "H(Kat G)") {
                $data['H(Kat G)'] = $value->value;
            }
            if ($value->name == "R") {
                $data['r'] = $value->value;
            }
            if ($value->name == "E") {
                $data['e'] = $value->value;
            }
            if ($value->name == "Z") {
                $data['z'] = $value->value;
            }
            if ($value->name == "Km") {
                $data['km'] = $value->value;
            }
            if ($value->name == "Cm") {
                $data['cm'] = $value->value;
            }
            if ($value->name == "Am") {
                $data['am'] = $value->value;
            }
            if ($value->name == "Lfx") {
                $data['lfx'] = $value->value;
            }
            if ($value->name == "Mfx(0_5)" OR $value->name == "Mfx(0.5)") {
                $data['mfx1'] = $value->value;
            }
            if ($value->name == "Mfx(2)") {
                $data['mfx2'] = $value->value;
            }
            if ($value->name == "PAS") {
                $data['pas'] = $value->value;
            }
            if ($value->name == "Lzd") {
                $data['lzd'] = $value->value;
            }
            if ($value->name == "Cfz") {
                $data['cfz'] = $value->value;
            }
            if ($value->name == "Eto") {
                $data['eto'] = $value->value;
            }
            if ($value->name == "Clr") {
                $data['clr'] = $value->value;
            }
            if ($value->name == "Azi") {
                $data['azi'] = $value->value;

            }
        }*/
		$data['lj_dst_fld']['s'] = "";
        $data['lj_dst_fld']['H(inh A)'] = "";
        $data['lj_dst_fld']['H(Kat G)'] = "";
        $data['lj_dst_fld']['r'] = "";
        $data['lj_dst_fld']['e'] = "";
        $data['lj_dst_fld']['z'] = "";
        $data['lj_dst_fld']['km'] = "";
        $data['lj_dst_fld']['cm'] = "";
        $data['lj_dst_fld']['am'] = "";
        $data['lj_dst_fld']['lfx'] = "";
        $data['lj_dst_fld']['mfx1'] = "";
        $data['lj_dst_fld']['mfx2'] = "";
        $data['lj_dst_fld']['pas'] = "";
        $data['lj_dst_fld']['lzd'] = "";
        $data['lj_dst_fld']['cfz'] = "";
        $data['lj_dst_fld']['eto'] = "";
        $data['lj_dst_fld']['clr'] = "";
        $data['lj_dst_fld']['azi'] = "";
		$data['lj_dst_fld']['BDQ'] = "";
        //dd($data['lj_dst']);
		//echo count((array)$data['lj_dst']); die;
        if(count((array)$data['lj_dst'])>0) {
            $dil = json_decode($data['lj_dst']->drug_reading);
            if (isset($dil->dil_2)) {

                foreach ($dil->dil_2 as $key => $value) {
                    if ($value->name == "S") {
                        $data['lj_dst_fld']['s'] = $value->value;
                    }
                    if ($value->name == "H(0_1)" OR $value->name == "H(0.1)") {
                        $data['lj_dst_fld']['H(inh A)'] = $value->value;
                    }
                    if ($value->name == "H(0_4)" OR $value->name == "H(0.4)") {
                        $data['lj_dst_fld']['H(Kat G)'] = $value->value;
                    }
                    if ($value->name == "R") {
                        $data['lj_dst_fld']['r'] = $value->value;
                    }
                    if ($value->name == "E") {
                        $data['lj_dst_fld']['e'] = $value->value;
                    }
                    if ($value->name == "Z") {
                        $data['lj_dst_fld']['z'] = $value->value;
                    }
                    if ($value->name == "Km") {
                        $data['lj_dst_fld']['km'] = $value->value;
                    }
                    if ($value->name == "Cm") {
                        $data['lj_dst_fld']['cm'] = $value->value;
                    }
                    if ($value->name == "Am") {
                        $data['lj_dst_fld']['am'] = $value->value;
                    }
                    if ($value->name == "Lfx") {
                        $data['lj_dst_fld']['lfx'] = $value->value;
                    }
                    //if ($value->name == "Mfx(0_5)" OR $value->name == "Mfx(0.5)") {
					if ($value->name == "Mfx(0_25)" OR $value->name == "Mfx(0.25)") {	
                        $data['lj_dst_fld']['mfx1'] = $value->value;
                    }
                    //if ($value->name == "Mfx(2)") {
					if ($value->name == "Mfx(1)") {	
                        $data['lj_dst_fld']['mfx2'] = $value->value;
                    }
                    if ($value->name == "PAS") {
                        $data['lj_dst_fld']['pas'] = $value->value;
                    }
                    if ($value->name == "Lzd") {
                        $data['lj_dst_fld']['lzd'] = $value->value;
                    }
                    if ($value->name == "Cfz") {
                        $data['lj_dst_fld']['cfz'] = $value->value;
                    }
                    if ($value->name == "Eto") {
                        $data['lj_dst_fld']['eto'] = $value->value;
                    }
                    if ($value->name == "Clr") {
                        $data['lj_dst_fld']['clr'] = $value->value;
                    }
                    if ($value->name == "Azi") {
                        $data['lj_dst_fld']['azi'] = $value->value;

                    }
					 if ($value->name == "BDQ") {
                        $data['lj_dst_fld']['BDQ'] = $value->value;

                    }
                }
            } elseif (isset($dil->dil_4)) {
                foreach ($dil->dil_4 as $key => $value) {
                    if ($value->name == "S") {
                        $data['lj_dst_fld']['s'] = $value->value;
                    }
                    if ($value->name == "H(0_1)" OR $value->name == "H(0.1)") {
                        $data['lj_dst_fld']['H(inh A)'] = $value->value;
                    }
                    if ($value->name == "H(0_4)" OR $value->name == "H(0.4)") {
                        $data['lj_dst_fld']['H(Kat G)'] = $value->value;
                    }
                    if ($value->name == "R") {
                        $data['lj_dst_fld']['r'] = $value->value;
                    }
                    if ($value->name == "E") {
                        $data['lj_dst_fld']['e'] = $value->value;
                    }
                    if ($value->name == "Z") {
                        $data['lj_dst_fld']['z'] = $value->value;
                    }
                    if ($value->name == "Km") {
                        $data['lj_dst_fld']['km'] = $value->value;
                    }
                    if ($value->name == "Cm") {
                        $data['lj_dst_fld']['cm'] = $value->value;
                    }
                    if ($value->name == "Am") {
                        $data['lj_dst_fld']['am'] = $value->value;
                    }
                    if ($value->name == "Lfx") {
                        $data['lj_dst_fld']['lfx'] = $value->value;
                    }
                    //if ($value->name == "Mfx(0_5)" OR $value->name == "Mfx(0.5)") {
					if ($value->name == "Mfx(0_25)" OR $value->name == "Mfx(0.25)") {	
                        $data['lj_dst_fld']['mfx1'] = $value->value;
                    }
                    //if ($value->name == "Mfx(2)") {
					if ($value->name == "Mfx(1)") {	
                        $data['lj_dst_fld']['mfx2'] = $value->value;
                    }
                    if ($value->name == "PAS") {
                        $data['lj_dst_fld']['pas'] = $value->value;
                    }
                    if ($value->name == "Lzd") {
                        $data['lj_dst_fld']['lzd'] = $value->value;
                    }
                    if ($value->name == "Cfz") {
                        $data['lj_dst_fld']['cfz'] = $value->value;
                    }
                    if ($value->name == "Eto") {
                        $data['lj_dst_fld']['eto'] = $value->value;
                    }
                    if ($value->name == "Clr") {
                        $data['lj_dst_fld']['clr'] = $value->value;
                    }
                    if ($value->name == "Azi") {
                        $data['lj_dst_fld']['azi'] = $value->value;

                    }
					if ($value->name == "BDQ") {
                        $data['lj_dst_fld']['BDQ'] = $value->value;

                    }
                }
            }
        }


        $data['final_remark_list'] = DB::SELECT(DB::RAW("
            SELECT `ms`.name,`detail`,`remark` FROM `t_microbiologist`
            LEFT JOIN `m_services` as ms ON `t_microbiologist`.`service_id`=`ms`.`id`
            WHERE `enroll_id`= " . $data['personal']->enroll_id . "
            AND (`detail` > '' OR `remark`> '')
        "));

        // dd($data['final_remark_list']);
		$data['config'] = Config::where('status',1)->first();//Amrita on  18/05/2020

        if ($pdf == "pdf") {
        // dd($data);

            $pdfname = $data['personal'] ? $data['personal']->userName : "pdfview";
            $elabel = $data['personal'] ? $data['personal']->label : "";
            $pdffilename = $elabel . "" . substr($pdfname, 0, 5) . ".pdf";
            $data['checkflag'] = 1;
            // dd($pdffilename);
            $pdf = PDF::loadView('admin.sample.testpdf', compact('data'));
			$pdf->getDomPDF()->set_option("enable_php", true);//Amrita on  18/05/2020
            // dd($pdf);

            return $pdf->stream($pdffilename);


        }
         //dd($data['lc_dst']);
		  //dd($data['lj_dst']);
		  //dd($data['lj_dst_fld']);
		 // dd($data['lpa2']);
		 //dd($data['lpaf']);
		 
		  
//        dd($data);
        return view('admin.sample.pdfview', compact('data'));
    }



    public function annexurek(Request $request)
    {
      $data['lab'] = Sample::select('sample.sample_label','sample.id', 'sample.receive_date', 'sample.name', 'p.gender', 'p.age', 's.name as state', 'd.name as district', 'p.house_no', 'p.pincode', 'p.key_population', 'sample.test_reason', 'r.prsmptv_xdrtv', 'r.predmnnt_symptoms', 'r.ho_anti_tb','sample.nikshay_id','r.regimen','r.post_treatment as fu_month', 'sample.sample_type', 'sample.sample_quality','mft.name as facility_name')
                          ->leftjoin('req_test as r','r.enroll_id','=','sample.enroll_id')
                          ->leftjoin('m_facility_type as mft','mft.facility_type_id','=','r.facility_type')
                          ->leftjoin('enrolls as e','e.id','=','sample.enroll_id')
                          ->leftjoin('patient as p','p.id','=','e.patient_id')
                          ->leftjoin('district as d','d.id','=','p.district')
                          ->leftjoin('state as s','s.STOCode','=','p.state')
                          ->get();
      $data['result'] = Sample::select('ld.id as ld_id', 'p.hiv_test', 'ld.lj_result_date as ld_date', 'sample.nikshay_id',  'mt.name as tb', 'sample.sample_label', 'sample.receive_date')
                          ->leftjoin('req_test as r','r.enroll_id','=','sample.enroll_id')
                          ->leftjoin('enrolls as e','e.id','=','sample.enroll_id')
                          ->leftjoin('patient as p','p.id','=','e.patient_id')
                          ->leftjoin('t_lj_detail as ld','ld.sample_id','=','sample.id')
                          ->leftjoin('m_tb as mt','mt.id','=','p.tb')
                          ->get();
                          //dd($data);
      return view('admin.sample.annexurek',compact('data'));
    }






    //Change by Vidhi
    public function annexurel(Request $request)
    {
      $data['lab'] = Sample::select('sample.sample_label','sample.id','sample.rejection','p.name as fullname', 'sample.receive_date', 'sample.name', 'p.gender',
      'p.age', 'p.state as state', 'p.district as district', 'p.house_no', 'p.pincode', 'key.key_population', 'sample.test_reason',
      'r.prsmptv_xdrtv', 'r.predmnnt_symptoms', 'r.ho_anti_tb','sample.nikshay_id','r.post_treatment as fu_month',
      'sample.sample_type','sample.sample_quality', 'mft.DMC_PHI_NAME as facility_name', 'pda.TBUnitName as facility_tbunit',
	   'pdb.name as facility_district', 'p.nikshay_id as nikshay', 'p.mobile_number as mobile','r.regimen as regimenname'
      ,'r.request_date','rq.type_of_prsmptv_drtb as prstb','rq.prsmptv_xdrtv as mdrtb','r.duration','dia.name as newpt','ps.name as psymptom','r.pmdt_tb_no',
      'r.treatment','m.result as mresult','p.collection_date','p.regr_date', 'sample.enroll_id', 'e.label')
      ->leftjoin('enrolls as e','e.id','=','sample.enroll_id')
      ->leftjoin("patient as p","p.id","=","e.patient_id")
      ->leftjoin("m_dropdown_key_populations as key","key.key_id","=","p.key_population")
                          ->leftjoin('req_test as r','r.enroll_id','=','sample.enroll_id')
                          ->leftjoin('m_predominan_symptom as ps','r.predmnnt_symptoms','=','ps.symptom_id')
                          //->leftjoin('t_request_services as rq','rq.enroll_id','=','sample.enroll_id')
						  ->leftjoin("t_request_services as rq",function($join){
									$join->on("rq.enroll_id","=","sample.enroll_id");
										 $join->whereRaw('rq.type_of_prsmptv_drtb IS NOT NULL');
										 $join->whereRaw('rq.prsmptv_xdrtv IS NOT NULL');
							})
                          ->leftjoin('m_tbdiagnosis as dia','rq.diagnosis','=','dia.diagnosis_id')
                          ->leftjoin("m_dmcs_phi_relation as mft",function($join){
									$join->on("mft.id","=","r.facility_id")
										->on("mft.TBUCode","=","r.tbu")
										 ->on("mft.DTOCode","=","r.district")
										  ->on("mft.STOCode","=","r.state");
							})
						->leftjoin("m_tbunits_relation as pda",function($join){
									$join->on("pda.TBUnitCode","=","r.tbu")
										->on("pda.DTOCode","=","r.district")
										->on("pda.STOCode","=","r.state");
							})
						->leftjoin("district as pdb",function($join){
									$join->on("pdb.DTOCode","=","r.district")
										->on("pdb.STOCode","=","r.state");
							})
                          ->leftjoin('t_microscopy as m','m.sample_id','sample.id')
						
						  ->leftjoin('m_dropdown_key_populations as z','z.key_id','=','p.key_population')
                          ->leftjoin('district as d','d.id','=','p.district')
                          ->leftjoin('state as s','s.STOCode','=','p.state')
                          ->distinct()
                          ->orderBy('sample.sample_label')
						  //->orderBy('sample.id')
                          ->get();
						  //->toSql();

                         //dd($data['lab']);
    //   foreach($data['lab'] as $key=>$value){
    //       $value->name = [];
    //       $newpt = DB::table('m_tbdiagnosis as dianame')
    //                     ->where('diagnosis_id', $value->diaId)
    //                     ->pluck('dianame.name')
    //                     ->toArray();
       
    //     if($newpt){
    //         $value->name = $newpt;
    //         }
    //   }

      $data['result'] = Sample::select('ld.id as ld_id', 'lfmf.id as lfmf_id', 'lfmf.result as lfmf_result',
       'lfmf.result_date as lfmf_date', 'ld.final_result as ld_result', 'ld.lj_result_date as ld_date','sample.id as sampleId',
       'sample.nikshay_id','sample.receive_date','c.result_MTB as MTB','c.result_RIF as RIF', 'c.id as c_id', 'lf.id as lf_id','flpa.id as flpa_id', 'slpa.id as slpa_id',
       'lf.mtb_result','sample.service_id','h.result as h_result', 
       'lf.rif as lpaRIF', 'lf.inh as INH','lf.type_direct','lf.quinolone','lf.slid','lf.nikshey_final_interpretation as lpaResult','lf.tag','c.result_MTB as mtb')
                        ->leftjoin('t_hybridization as h','h.enroll_id','=','sample.enroll_id')
                        ->leftjoin('t_lj_detail as ld','ld.sample_id','=','sample.id')
                        ->leftjoin('t_lc_flagged_mgit_further as lfmf','lfmf.sample_id','=','sample.id')
                        ->leftjoin('t_cbnaat as c','c.sample_id','=','sample.id')
                        ->leftjoin('t_lpa_final as lf','lf.sample_id','=','sample.id')
                        ->leftjoin('t_1stlinelpa as flpa','flpa.sample_id','=','sample.id')
                        ->leftjoin('t_2stlinelpa as slpa','slpa.sample_id','=','sample.id')
						->distinct()
						//->orderBy('ld.id')
						 ->orderBy('sample.sample_label')
						
                        ->get();
                        //->toSql();
                        //dd($data['result']);  

        foreach($data['result'] as $key=>$value){
        $value->drug_name_lj = [];
        $value->ljdrugresult = [];
        $value->lcdrugresult = [];
        $value->drug_name = [];
        $drugs_result = DB::table('t_lc_dst as lcdrug')
                          ->where('sample_id',$value->sampleId)
                          ->where('status',1)
                          ->pluck('lcdrug.result')
                          ->toArray();
        $drugs_name = DB::table('t_lc_dst as lcdrug')
                          ->where('sample_id',$value->sampleId)
                          ->where('status',1)
                          ->pluck('lcdrug.drug_name')
                          ->toArray();
        $drugs_result_lj = DB::table('t_lj_dst_reading as ljdrug')
                          ->where('sample_id',$value->sampleId)
                          ->where('status',1)
                          ->where('flag',1)
                          ->select('ljdrug.drug_reading')
                          ->first();


         if($drugs_result){
          $value->lcdrugresult = $drugs_result;
          $value->drug_name = $drugs_name;
        }
        if($drugs_result_lj)
        {
          $arrname=[];
          $arrdrug=[];

          $result_data=(array) json_decode($drugs_result_lj->drug_reading);
          foreach($result_data['dil_4'] as $key1=>$value1){
            array_push($arrname,$value1->name);
            array_push($arrdrug,$value1->value);
          }
          $value->drug_name_lj = $arrname;
          $value->ljdrugresult = $arrdrug;

        }
      }


    //     $data['sendNikshay'] = Sample::select('sl.sample_id', 'sl.service_id as service', 'sl.sent_to_nikshay_date as submit')
    //     ->leftjoin('t_service_log as sl','sl.sample_id','=','sample.id')
    //     ->where('sl.sent_to_nikshay',1)
    //     ->get();
    // // dd($data['sendNikshay']);

        $lab_details = Config::select('lab_name as name','city')->where('status',1)->first();
        // $lab_details->name = str_replace( ' ', '_', $lab_details->name ?? 'unknown' );
        // $lab_details->city = str_replace( ' ', '_', $lab_details->city ?? 'unknown' );
        $lab_details->name = $lab_details->name ?? 'Unknown';
        $lab_details->city = $lab_details->city ?? 'Unknown';

      //dd($data);
      return view('admin.sample.annexurel',compact('data', 'lab_details'));
    }



    public function interimview(Request $request, $id, $pdf=null)
    {
        // dd($pdf);
        // dd($id);
        $data['today'] = '';
        $approved_date = Microbio::select('approved_date')->where('sample_id', $id)
            ->first();
        // dd($approved_date);
        if (!empty($approved_date->approved_date)):
            $appr_date = $approved_date->approved_date;

            $data['today'] = $appr_date;
        endif;

        $data['interim_view'] = true;

        $final = 0;
        // if($final==1){
        //   $data['report_type'] = 'End of Report';
        // }
        // else {
        //   $data['report_type'] = 'Interim Report';
        // }
        $data['labrotory_name'] = Config::select('lab_name', 'micro_name')->where('status', 1)->first();

        $data['labrotory_name'] = $data['labrotory_name']->lab_name;
		
		$data['microbio_name'] = Config::select('micro_name')->where('status', 1)->first();

        $data['microbio_name'] = $data['microbio_name']->micro_name;
		
		//$data['microbio_name'] = $data['microbio_name']->micro_name;
		//$microbiologist_details = Config::select('*')->where('status', 1)->first();
		
		$data['config'] = Config::where('status',1)->first();//Amrita on  18/05/2020
		

        $reportType = Microbio::select('report_type')
            ->where('sample_id', $id)
            ->first();

        //dd($reportType);
        $data['type_of_prsmptv_drtb'] = [];
        $data['date_receipt'] = Sample::select('receive_date')
            ->where('id', $id)
            ->first();

        if ($reportType) {
           // $data['report_type'] = $reportType->report_type;
		   $data['report_type'] = 'Draft Report';
        } else {
            $data['report_type'] = 'Draft Report';
        }
		//DB::enableQueryLog();
		$enroll_id = Sample::select('enroll_id')->where('id', $id)->first();
        //$data['hybridization_data'] = Hybridization::where('sample_id', $id)->first();
		//$data['hybridization_data'] = Hybridization::join('sample', 'sample.id', '=', 't_hybridization.sample_id')->select('t_hybridization.*','sample.sample_label')->where('t_hybridization.sample_id', $id)->first();
		$data['hybridization_data'] = Hybridization::select('t_hybridization.*','s.sample_label')		
		->join('sample as s', function ($join) {
										 $join->on('s.enroll_id','=','t_hybridization.enroll_id');
										 $join->on('s.id', '=','t_hybridization.sample_id');										 
									 })
		->where('t_hybridization.enroll_id', $enroll_id->enroll_id)->get();
        //dd(DB::getQueryLog());
		//dd($data['hybridization_data']);

        $data['user'] = Microbio::query()
                ->join('users', 'created_by', 'users.id')
                ->where('sample_id', $id)
                ->first()->name ?? '';
       $data['']=Auth::user()->name;
		//echo "<pre>"; echo Auth::user()->roles; die;
       // dd($data['user']);
        $data['personal'] = Sample::select('sample.*', 'sample.id as smp_id', 'p.name as userName', 'p.*', 'p.nikshay_id as pnikshay_id','e.*', 'district.name as district_name',
            's.name as state_name', 'r.rntcp_reg_no', 'r.regimen', 'r.reason as test_reason', 'r.requestor_name', 'r.designation',
            'r.contact_no as requestor_cno', 'r.email_id as requestor_email', 'ps.name as ps_name', 'r.duration', 'r.type_of_prsmptv_drtb',
            'r.prsmptv_xdrtv', 'r.presumptive_h', 'r.pmdt_tb_no', 'rs.diagnosis', 'p.population_other', 'p.health_establish_id',
            'r.month_week', 'r.treatment', 'rs.regimen_fu', 'rs.fudrtb_regimen_other', 'rs.facility_type_other', 'r.req_test_type',
            'phi.name as phi_name', 'm_tbunits_relation.TBUnitName as mtb', 'ft.name as f_name', 'mdmcs.DMC_PHI_Name', 'mtr.TBUnitName', 'mdr.name AS facility_district','msr.name AS facility_state', 'p.collection_date as collection_dates', 'p.collection_time as collection_time')
            ->leftjoin('req_test as r', 'r.enroll_id', '=', 'sample.enroll_id')
            ->leftjoin('m_predominan_symptom as ps', 'ps.symptom_id', '=', 'r.predmnnt_symptoms')
            ->leftjoin('enrolls as e', 'e.id', '=', 'sample.enroll_id')
            ->leftjoin('t_request_services as rs', 'rs.enroll_id', '=', 'sample.enroll_id')
            ->leftjoin('patient as p', 'p.id', '=', 'e.patient_id')
            ->leftjoin('m_phi as phi', 'phi.id', '=', 'p.phi')
            // ->leftjoin('m_tb as mtb','mtb.id','=','p.tb')
            // ->leftjoin('district as d','d.id','=','p.district')
            ->leftjoin('state as s', 's.STOCode', '=', 'p.state')
            ->leftJoin('m_tbunits_relation', function ($join) {
                $join->on('m_tbunits_relation.tbunitcode', '=', 'p.tb')
                    ->on('m_tbunits_relation.DTOCode', '=', 'p.district')
                    ->on('m_tbunits_relation.STOCode', '=', 'p.state');
            })
            ->leftJoin('district', function ($join) {
                $join->on('district.DTOCode', '=', 'p.district')
                    ->on('district.STOCode', '=', 'p.state');
            })
            ->leftjoin('facility_master as ft', 'ft.id', '=', 'r.facility_type')
            ->leftjoin('m_dmcs_phi_relation as mdmcs', 'mdmcs.id', '=', 'r.facility_id')
			//->leftjoin('m_tbunits_relation as mtr', 'mtr.TBUnitCode', '=', 'r.tbu')
			->leftJoin('m_tbunits_relation as mtr', function ($join) {
                $join->on('mtr.tbunitcode', '=', 'r.tbu')
                    ->on('mtr.DTOCode', '=', 'r.district')
                    ->on('mtr.STOCode', '=', 'r.state');
            })
			->leftjoin('district as mdr', 'mdr.DTOCode', '=', 'r.district')
			->leftjoin('state as msr', 'msr.STOCode', '=', 'r.state')
            ->where('sample.id', $id)
            ->first();
            //->toSql();
        //dd(  $data['personal']);

        //  $res_query = DB::select(DB::raw("select `sample`.*,
        // `sample`.`id` as `smp_id`,
        // `p`.`name` as `userName`,
        // `p`.*, `e`.*, `d`.`name` as `district_name`,
        // `s`.`name` as `state_name`,
        // `r`.`rntcp_reg_no`,
        // `r`.`regimen`,
        // `r`.`reason` as `test_reason`,
        // `r`.`requestor_name`,
        // `r`.`designation`,
        // `r`.`contact_no` as `requestor_cno`,
        // `r`.`email_id` as `requestor_email`,
        // `ps`.`name` as `ps_name`,
        // `r`.`duration`,
        // `r`.`type_of_prsmptv_drtb`,
        // `r`.`prsmptv_xdrtv`,
        // `r`.`presumptive_h`,
        // `r`.`pmdt_tb_no`,
        // `rs`.`diagnosis`,
        // `p`.`population_other`,
        // `p`.`health_establish_id`,
        // `r`.`month_week`,
        // `r`.`treatment`,
        // `rs`.`regimen_fu`,
        // `rs`.`fudrtb_regimen_other`,
        // `rs`.`facility_type_other`,
        // `r`.`req_test_type`,
        // `phi`.`name` as `phi_name`,
        // `mtb`.`TBUnitName` as `mtb`,
        // `ft`.`name` as `f_name`,
        // `p`.`collection_date` as `collection_dates`
        //
        // from `sample`
        // left join `req_test` as `r` on `r`.`enroll_id` = `sample`.`enroll_id`
        // left join `m_predominan_symptom` as `ps` on `ps`.`symptom_id` = `r`.`predmnnt_symptoms`
        // left join `enrolls` as `e` on `e`.`id` = `sample`.`enroll_id`
        // left join `t_request_services` as `rs` on `rs`.`enroll_id` = `sample`.`enroll_id`
        // left join `patient` as `p` on `p`.`id` = `e`.`patient_id`
        // left join `m_phi` as `phi` on `phi`.`id` = `p`.`phi`
        // left join `m_tbunits_relation` as `mtb` on `mtb`.`tbunitcode` = `p`.`tb`  and `mtb`.`DTOCode`=`p`.`district` and `mtb`.`STOCode`= `p`.`state`
        // left join `district` as `d` on `d`.`DTOCode` = `p`.`district` and `d`.`STOCode`= `p`.`state`
        // left join `state` as `s` on `s`.`STOCode` = `p`.`state`
        // left join `facility_master` as `ft` on `ft`.`id` = `r`.`facility_type`
        //
        // where `sample`.`id` = $id"));
//dd($res_query[0]);

//$data['personal']  = $res_query[0];


        // dd($data['personal']);

        $data['microscopy_data'] = ServiceLog::select('m.*', 't_service_log.service_id', 't_service_log.sample_label')->leftjoin('t_microscopy as m', 'm.sample_id', '=', 't_service_log.sample_id')->where('t_service_log.enroll_id', $data['personal']->enroll_id)->whereIn('t_service_log.service_id', [1, 2])//->where('t_service_log.status',0)
        ->get();
// dd($data['microscopy_data']);
        $data['microscopyA'] = new Microscopy;
        $data['microscopyB'] = new Microscopy;
        $data['microscopy'] = 0;
        $data['microscopy2'] = 0;
        if (count($data['microscopy_data']) > 1) {

            foreach ($data['microscopy_data'] as $micro_data) {


                if ($data['microscopy_data']) {
                    $data['microscopy'] = $micro_data->service_id;
                    $sample_type = substr($micro_data->sample_label, -1);
                    if ($sample_type == 'A') {
                        $data['microscopyA'] = $micro_data;
                        $data['microscopy'] = 1;

                    }
                    if ($sample_type == 'B') {
                        $data['microscopyB'] = $micro_data;
                        $data['microscopy2'] = 2;
                        // dd($data['microscopyB']);
                    }
                }


            }

        } else {
// dd($data['microscopy_data'][0]->service_id);
            if (!empty($data['microscopy_data'][0])) {
// dd($data['microscopy_data'][]);
                // dd("hi");
                $data['microscopy'] = $data['microscopy_data'][0]->service_id;
                $sample_type = substr($data['microscopy_data'][0]->sample_label, -1);
// dd($sample_type);
                if ($sample_type == 'A') {
                    $data['microscopyA'] = $data['microscopy_data'][0];
                    $data['microscopy'] = 1;
                    // dd($data['microscopyA']);
                }
                if ($sample_type == 'B') {
                    $data['microscopyB'] = $data['microscopy_data'][0];
                    $data['microscopy2'] = 2;
                }

            }
        }
// dd($data);

        // dd($data['microscopyB']);
        $data['culturelj'] = LJDetail::leftjoin('sample as s', 's.id', '=', 't_lj_detail.sample_id')
            ->where('t_lj_detail.enroll_id', $data['personal']->enroll_id)
            ->where('t_lj_detail.status', 1)
            ->first();


        $data['culturelc'] = LCFlaggedMGITFurther::leftjoin('sample as s', 's.id', '=', 't_lc_flagged_mgit_further.sample_id')
            ->where('t_lc_flagged_mgit_further.enroll_id', $data['personal']->enroll_id)
            ->where('t_lc_flagged_mgit_further.status', 1)
            ->first();
           //->toSql();
        //dd($data['culturelc']);
        $data['culture'] = "";
        if ($data['culturelj']) {
            $data['culture-llj'] = 1;
        }
        if ($data['culturelc']) {
            $data['culture'] = 2;
        }
// dd($data['personal']->enroll_id);
        $data['cbnaat'] = Cbnaat::leftjoin('sample as s', 's.id', '=', 't_cbnaat.sample_id')
            ->whereRaw(DB::raw("t_cbnaat.enroll_id =" . $data['personal']->enroll_id . " order by t_cbnaat.id desc limit 0,1"))->get();


        // dd($data['cbnaat']);
        // dd($data['cbnaat']);
        $data['req_test'] = TestRequest::where('enroll_id', $data['personal']->enroll_id)->first();
        $data['test_requests'] = RequestServices::where('enroll_id', $data['personal']->enroll_id)->first();

        $data['prsm_drtb'] = RequestServices::select('type_of_prsmptv_drtb', 'presumptive_h', 'prsmptv_xdrtv')->where('enroll_id', $data['personal']->enroll_id)->first();
        // dd($data['prsm_drtb']);
        if (!empty($data['prsm_drtb']['type_of_prsmptv_drtb']) || !empty($data['prsm_drtb']['presumptive_h']) || !empty($data['prsm_drtb']['prsmptv_xdrtv'])) {
            $prsm = $data['prsm_drtb']['type_of_prsmptv_drtb'] . ',' . $data['prsm_drtb']['presumptive_h'] . ',' . $data['prsm_drtb']['prsmptv_xdrtv'];

        } else {
            $prsm = null;

        }

// dd($prsm);
        $data['type_of_prsmptv_drtb'] = $prsm != null ? explode(',', $prsm) : [];


        // if(empty($data['type_of_prsmptv_drtb'])){
        //   dd($data['type_of_prsmptv_drtb']);
        //
        // }

        //$data['lpa1'] = FirstLineLpa::where('enroll_id', $data['personal']->enroll_id)->where('status', 1)->first();
        $data['lpa1'] = FirstLineLpa::join('sample', 'sample.id', '=', 't_1stlinelpa.sample_id')->select('t_1stlinelpa.*','sample.sample_label')->where('t_1stlinelpa.enroll_id', $data['personal']->enroll_id)->where('t_1stlinelpa.status', 1)->first();
		
		//dd($data['lpa1']);
		//$data['lpa2'] = SecondLineLpa::where('enroll_id', $data['personal']->enroll_id)->where('status', 1)->first();
        $data['lpa2'] = SecondLineLpa::join('sample', 'sample.id', '=', 't_2stlinelpa.sample_id')->select('t_2stlinelpa.*','sample.sample_label')->where('t_2stlinelpa.enroll_id', $data['personal']->enroll_id)->where('t_2stlinelpa.status', 1)->first();
        
		//dd($data['lpa2']);
		
		//$data['lpaf'] = FinalInterpretation::where('enroll_id', $data['personal']->enroll_id)->where('status', 1)->first();
       $data['lpaf'] = FinalInterpretation::select('t_lpa_final.*','users.name')
            ->join('users as users','users.id','=','t_lpa_final.created_by')->where('t_lpa_final.enroll_id', $data['personal']->enroll_id)->where('t_lpa_final.status', 1)->get()->toArray();
		
		//dd($data['lpaf']);
		$data['test_requested'] = RequestServices::where('enroll_id', $data['personal']->enroll_id)->pluck('service_id')->toArray();

        //dd($data['test_requested'] );
        $data['microbio'] = Microbio::where('enroll_id', $data['personal']->enroll_id)->get()->toArray();
        //dd($data['microbio']);
        $data['lj_dst'] = LjDstReading::select('drug_reading', 'created_at')->where('enroll_id', $data['personal']->enroll_id)->orderBy('id', 'DESC')->first();
        //dd($data['lj_dst']);
        $data['lc_dst'] = LCDST::select('drug_name as name', 'result as value', 'result_date as result_date' )->where('enroll_id', $data['personal']->enroll_id)->orderBy('id', 'DESC')->get();
        //dd($data['lc_dst']);
		$data['lab_sr'] = DB::table('sample')->select('sample_label')->where('sample.enroll_id', $data['personal']->enroll_id)->first();
        $data['lab_serial'] = DB::table('t_lpa_final')->select('type')->where('t_lpa_final.enroll_id', $data['personal']->enroll_id)->first();
        //$dil = json_decode($data['lj_dst']);
        $data['lc_dst_fld']['s'] = "";
        $data['lc_dst_fld']['H(inh A)'] = "";
        $data['lc_dst_fld']['H(Kat G)'] = "";
        $data['lc_dst_fld']['r'] = "";
        $data['lc_dst_fld']['e'] = "";
        $data['lc_dst_fld']['z'] = "";
        $data['lc_dst_fld']['km'] = "";
        $data['lc_dst_fld']['cm'] = "";
        $data['lc_dst_fld']['am'] = "";
        $data['lc_dst_fld']['lfx'] = "";
        $data['lc_dst_fld']['mfx1'] = "";
        $data['lc_dst_fld']['mfx2'] = "";
        $data['lc_dst_fld']['pas'] = "";
        $data['lc_dst_fld']['lzd'] = "";
        $data['lc_dst_fld']['cfz'] = "";
        $data['lc_dst_fld']['eto'] = "";
        $data['lc_dst_fld']['clr'] = "";
        $data['lc_dst_fld']['azi'] = "";
		$data['lc_dst_fld']['BDQ'] = "";
		
		
	      //echo '<pre>'; print_r($data['lj_dst']);
		  //echo '<pre>'; print_r($data['lc_dst']); echo "p"; die;
		  //dd($data['lc_dst']);
		  
		 foreach ($data['lc_dst'] as $key => $value) {
		     if ($value->name == "S") {
                $data['lc_dst_fld']['s'] = $value->value;

            }
           
            if ($value->name == "H(0_1)" || $value->name == "H(0.1)") {

                $data['lc_dst_fld']['H(inh A)'] = $value->value;

            }
            if ($value->name == "H(0_4)" OR $value->name == "H(0.4)") {
               $data['lc_dst_fld']['H(Kat G)'] = $value->value;
            }
			if ($value->name == "R") {
               $data['lc_dst_fld']['r'] = $value->value;
            } 
            if ($value->name == "E") {
                $data['lc_dst_fld']['e'] = $value->value;
            } 
            if ($value->name == "Z") {
                $data['lc_dst_fld']['z'] = $value->value;
            }
            if ($value->name == "Km") {
                $data['lc_dst_fld']['km'] = $value->value;
            }
            if ($value->name == "Cm") {
                $data['lc_dst_fld']['cm'] = $value->value;
            }
			
            if ($value->name == "Am") {
                $data['lc_dst_fld']['am'] = $value->value;
            }
            if ($value->name == "Lfx") {
               $data['lc_dst_fld']['lfx'] = $value->value;
            } 
            //if ($value->name == "Mfx(0_5)" OR $value->name == "Mfx(0.5)") {
			if ($value->name == "Mfx(0_25)" OR $value->name == "Mfx(0.25)") {	
                $data['lc_dst_fld']['mfx1'] = $value->value;
            }
            //if ($value->name == "Mfx(2)") {
			if ($value->name == "Mfx(1)") {	
                $data['lc_dst_fld']['mfx2'] = $value->value;
            } 
			
            if ($value->name == "PAS") {
                $data['lc_dst_fld']['pas'] = $value->value;
            } 
            if ($value->name == "Lzd") {
                $data['lc_dst_fld']['lzd'] = $value->value;
            } 
            if ($value->name == "Cfz") {
                $data['lc_dst_fld']['cfz'] = $value->value;
            } 
            if ($value->name == "Eto") {
                $data['lc_dst_fld']['eto'] = $value->value;
            }
            if ($value->name == "Clr") {
               $data['lc_dst_fld']['clr'] = $value->value;
            } 
            if ($value->name == "Azi") {
                $data['lc_dst_fld']['azi'] = $value->value;

            } 
			 if ($value->name == "BDQ") {
                $data['lc_dst_fld']['BDQ'] = $value->value;

            } 

			
		 }	
		//echo '<pre>'; print_r($data['lc_dst_fld']); echo "p"; die;
        /*foreach ($data['lc_dst'] as $key => $value) {
		//dd($data['lc_dst']);

            if ($value->name == "S") {
                $data['s'] = $value->value;

            }
            //echo $value->name;
            if ($value->name == "H(inh_A)" || $value->name == "H(inh A)") {

                $data['H(inh A)'] = $value->value;

            }
            if ($value->name == "H(Kat_G)" OR $value->name == "H(Kat G)") {
                $data['H(Kat G)'] = $value->value;
            }
            if ($value->name == "R") {
                $data['r'] = $value->value;
            }
            if ($value->name == "E") {
                $data['e'] = $value->value;
            }
            if ($value->name == "Z") {
                $data['z'] = $value->value;
            }
            if ($value->name == "Km") {
                $data['km'] = $value->value;
            }
            if ($value->name == "Cm") {
                $data['cm'] = $value->value;
            }
            if ($value->name == "Am") {
                $data['am'] = $value->value;
            }
            if ($value->name == "Lfx") {
                $data['lfx'] = $value->value;
            }
            if ($value->name == "Mfx(0_5)" OR $value->name == "Mfx(0.5)") {
                $data['mfx1'] = $value->value;
            }
            if ($value->name == "Mfx(2)") {
                $data['mfx2'] = $value->value;
            }
            if ($value->name == "PAS") {
                $data['pas'] = $value->value;
            }
            if ($value->name == "Lzd") {
                $data['lzd'] = $value->value;
            }
            if ($value->name == "Cfz") {
                $data['cfz'] = $value->value;
            }
            if ($value->name == "Eto") {
                $data['eto'] = $value->value;
            }
            if ($value->name == "Clr") {
                $data['clr'] = $value->value;
            }
            if ($value->name == "Azi") {
                $data['azi'] = $value->value;

            }
        } */
		$data['lj_dst_fld']['s'] = "";
        $data['lj_dst_fld']['H(inh A)'] = "";
        $data['lj_dst_fld']['H(Kat G)'] = "";
        $data['lj_dst_fld']['r'] = "";
        $data['lj_dst_fld']['e'] = "";
        $data['lj_dst_fld']['z'] = "";
        $data['lj_dst_fld']['km'] = "";
        $data['lj_dst_fld']['cm'] = "";
        $data['lj_dst_fld']['am'] = "";
        $data['lj_dst_fld']['lfx'] = "";
        $data['lj_dst_fld']['mfx1'] = "";
        $data['lj_dst_fld']['mfx2'] = "";
        $data['lj_dst_fld']['pas'] = "";
        $data['lj_dst_fld']['lzd'] = "";
        $data['lj_dst_fld']['cfz'] = "";
        $data['lj_dst_fld']['eto'] = "";
        $data['lj_dst_fld']['clr'] = "";
        $data['lj_dst_fld']['azi'] = "";
		$data['lj_dst_fld']['BDQ'] = "";
        //dd($data['lj_dst_fld']);
        if ($data['lj_dst']) {
            $dil = json_decode($data['lj_dst']->drug_reading);


            if (isset($dil->dil_4)) {
                // dd($dil->dil_4);
                foreach ($dil->dil_4 as $key => $value) {

                    if ($value->name == "S") {
                        $data['lj_dst_fld']['s'] = $value->value;
                    }
                    if ($value->name == "H(0.1)") {
                        $data['lj_dst_fld']['H(inh A)'] = $value->value;
                    }
                    if ($value->name == "H(0.4)") {
                        $data['lj_dst_fld']['H(Kat G)'] = $value->value;
                    }
                    if ($value->name == "R") {
                        $data['lj_dst_fld']['r'] = $value->value;
                    }
                    if ($value->name == "E") {
                        $data['lj_dst_fld']['e'] = $value->value;
                    }
                    if ($value->name == "Z") {
                        $data['lj_dst_fld']['z'] = $value->value;
                    }
                    if ($value->name == "Km") {
                        $data['lj_dst_fld']['km'] = $value->value;
                    }
                    if ($value->name == "Cm") {
                        $data['lj_dst_fld']['cm'] = $value->value;
                    }
                    if ($value->name == "Am") {
                        $data['lj_dst_fld']['am'] = $value->value;
                    }
                    if ($value->name == "Lfx") {
                        $data['lj_dst_fld']['lfx'] = $value->value;
                    }
                    //if ($value->name == "Mfx(0_5)" OR $value->name == "Mfx(0.5)") {
					if ($value->name == "Mfx(0_25)" OR $value->name == "Mfx(0.25)") {	
                        $data['lj_dst_fld']['mfx1'] = $value->value;
                    }
                    //if ($value->name == "Mfx(2)") {
					if ($value->name == "Mfx(1)") {	
                        $data['lj_dst_fld']['mfx2'] = $value->value;
                    }
                    if ($value->name == "PAS") {
                        $data['lj_dst_fld']['pas'] = $value->value;
                    }
                    if ($value->name == "Lzd") {
                        $data['lj_dst_fld']['lzd'] = $value->value;
                    }
                    if ($value->name == "Cfz") {
                        $data['lj_dst_fld']['cfz'] = $value->value;
                    }
                    if ($value->name == "Eto") {
                        $data['lj_dst_fld']['eto'] = $value->value;
                    }
                    if ($value->name == "Clr") {
                        $data['lj_dst_fld']['clr'] = $value->value;
                    }
                    if ($value->name == "Azi") {
                        $data['lj_dst_fld']['azi'] = $value->value;

                    }
					 if ($value->name == "BDQ") {
                        $data['lj_dst_fld']['BDQ'] = $value->value;

                    }
                }
            } elseif (isset($dil->dil_2)) {
                foreach ($dil->dil_2 as $key => $value) {
                    if ($value->name == "S") {
                        $data['lj_dst_fld']['s'] = $value->value;
                    }
                    if ($value->name == "H(inh A)") {
                        $data['lj_dst_fld']['H(inh A)'] = $value->value;
                    }
                    if ($value->name == "H(Kat G)") {
                        $data['lj_dst_fld']['H(Kat G)'] = $value->value;
                    }
                    if ($value->name == "R") {
                        $data['lj_dst_fld']['r'] = $value->value;
                    }
                    if ($value->name == "E") {
                        $data['lj_dst_fld']['e'] = $value->value;
                    }
                    if ($value->name == "Z") {
                        $data['lj_dst_fld']['z'] = $value->value;
                    }
                    if ($value->name == "Km") {
                        $data['lj_dst_fld']['km'] = $value->value;
                    }
                    if ($value->name == "Cm") {
                        $data['lj_dst_fld']['cm'] = $value->value;
                    }
                    if ($value->name == "Am") {
                        $data['lj_dst_fld']['am'] = $value->value;
                    }
                    if ($value->name == "Lfx") {
                        $data['lj_dst_fld']['lfx'] = $value->value;
                    }
                    //if ($value->name == "Mfx(0.5)") {
					if ($value->name == "Mfx(0_25)" OR $value->name == "Mfx(0.25)") {
                        $data['lj_dst_fld']['mfx1'] = $value->value;
                    }
                    //if ($value->name == "Mfx(2)") {
					if ($value->name == "Mfx(1)") {	
                        $data['lj_dst_fld']['mfx2'] = $value->value;
                    }
                    if ($value->name == "PAS") {
                        $data['lj_dst_fld']['pas'] = $value->value;
                    }
                    if ($value->name == "Lzd") {
                        $data['lj_dst_fld']['lzd'] = $value->value;
                    }
                    if ($value->name == "Cfz") {
                        $data['lj_dst_fld']['cfz'] = $value->value;
                    }
                    if ($value->name == "Eto") {
                        $data['lj_dst_fld']['eto'] = $value->value;
                    }
                    if ($value->name == "Clr") {
                        $data['lj_dst_fld']['clr'] = $value->value;
                    }
                    if ($value->name == "Azi") {
                        $data['lj_dst_fld']['azi'] = $value->value;

                    }
					if ($value->name == "BDQ") {
                        $data['lj_dst_fld']['BDQ'] = $value->value;

                    }
                }
            }
        }
		
		//dd($data['lc_dst_fld']);
		//dd($data['lj_dst_fld']);
		//dd($data['culturelc']);
		//dd( $data['lpaf'] );
		 
        $data['final_remark_list'] = DB::SELECT(DB::RAW("SELECT `ms`.name,`detail`,`remark` FROM `t_microbiologist`
      LEFT JOIN `m_services` as ms ON `t_microbiologist`.`service_id`=`ms`.`id` WHERE `enroll_id`= " . $data['personal']->enroll_id . " AND (`detail` > '' OR `remark`> '')"));
//       dd($data);

// dd($data);
        if ($pdf == "pdf") {
// dd($data);

            $pdfname = $data['personal'] ? $data['personal']->userName : "pdfview";
            $elabel = $data['personal'] ? $data['personal']->label : "";
            $pdffilename = $elabel . "" . substr($pdfname, 0, 5) . ".pdf";
            $data['checkflag'] = 1;
// dd($pdffilename);
            $pdf = PDF::loadView('admin.sample.interimpdf', compact('data'));
            // dd($pdf);

            return $pdf->stream($pdffilename);


        }
        
        //dd($data);
        return view('admin.sample.interimpdfview', compact('data'));
    }

    public function checkForStorage($enroll_id)
    { 
        //dd($enroll_id);
		$result = Sample::select('id','sample_label')
                ->where('enroll_id',$enroll_id)
				->where('sample_label', 'like', '%B')
                ->get();
		//dd($result);		
		$json_data['items']=(array) null;
        if(!empty($result)) {
            foreach ($result as $item_datas) {
                //$json_data['items'][]=array("sample_id"=>$item_datas->id,"sample_label"=>$item_datas->sample_label,"message"=>"");
                $result_service_log = ServiceLog::select('sample_id','sample_label')
				->where('sample_id',$item_datas->id)
                ->where('enroll_id',$enroll_id)
				->where('service_id',11)
				->where('status',2)
				->where('sample_label',$item_datas->sample_label)
                ->get();
			    if(!empty($result_service_log)) {
					foreach ($result_service_log as $item_result_service_log_datas) {
						$json_data['items'][]=array("sample_id"=>$item_result_service_log_datas->sample_id,"sample_label"=>$item_result_service_log_datas->sample_label,"message"=>"");
					}
				}else{
						$json_data['items'][]=array("message"=>"No Sample Found in the Storage");
				}
			
			}
        }else{
			    $json_data['items'][]=array("message"=>"No Sample Found in the Storage");
		}

        echo json_encode($json_data);
        exit;

    }
	
	 public function checkForSampleExist($enroll_id,$sentStep,$tag=null,$recflag)
    { 
        //dd($enroll_id);
		$qry="";
		if($sentStep==8||$sentStep==12||$sentStep==16){
			if(!empty($tag)){
				$qry=" AND A.tag='".$tag."'";
			}
		}
		//DB::enableQueryLog();

		$result = DB::select("SELECT distinct A.enroll_id, A.service_id, B.name, A.tag 
		FROM `t_service_log` AS A, m_services B
		WHERE b.id = A.service_id
		AND A.enroll_id = ".$enroll_id."
		".$qry."
		AND A.service_id = ".$sentStep." AND A.rec_flag = ".$recflag);
		//dd(DB::getQueryLog());
		//dd($result);
		//echo count($result); die;
        $sampleexist=0;		
		
        if(!empty($result)) {
			if(count($result)>0){
				$sampleexist=1;				
			}else{
				$sampleexist=0;				
			}
            
        }else{
			    //echo "3"; die;
			    $sampleexist=0;
		}

        echo json_encode($sampleexist);
        exit;

    }


    /**
     * Show the form for edit resource.
     *
     * @return \Illuminate\Http\Response
     */    
    public function editNew($id)
    { 
        $data['lab_details']=Config::select('lab_name as labname','city as labcity')->where('status',1)->first();
        // dd($data['lab_details']->labname);

        $data['labname']='unknown';
        $data['labcity']='unknown';
        if(!empty($data['lab_details']->labname)){

        $data['labname']=$data['lab_details']->labname;
        }

        if(!empty($data['lab_details']->labcity)){
        $data['labcity']=$data['lab_details']->labcity;

        }


        /*$data['sample'] = Sample::select(DB::raw('sample.id, u.name, sample.others_type,e.patient_id,sample.enroll_id,e.label,group_concat(receive_date) as receive,group_concat(sample.sample_label) as samples,group_concat(test_reason) as reason,group_concat(fu_month) as fu_month,group_concat(sample_type) as sample_type, group_concat(sample_quality) as sample_quality,group_concat(is_accepted) as is_accepted, count(sample_quality) as no_of_samples, group_concat(s.name) as sname'))
         ->leftjoin('m_services as s','s.id','=','sample.service_id')
         ->leftjoin('enrolls as e','e.id','=','sample.enroll_id')
         ->leftJoin('users as u','u.id','=','sample.user_id')
         ->where('sample.id',$id)
         ->groupBy('sample.enroll_id')
         ->orderBy('sample.enroll_id','desc')         
         ->limit(20)->first();*/
        $data['fu_month_list'] = array('End IP','End CP','6 M','12 M','18 M','24 M');
        $data['other_sample_type'] = array('BAL','Pus','CSF','GA','Pericardial fluid','EB tissue', 'Urine', 'AFB MTB positive culture (LJ or LC)', 'Pleural fluid','FNAC');
        $data['enroll']=DB::table('enrolls')->select('label as enroll')->where('id',$id)->get();
        $data['sample_detail']=Sample::select('name','no_of_samples')->where('enroll_id',$id)->get();
        $data['sample'] = Sample::where('enroll_id',$id)->get();

         //dd($data['sample'][0]);
        //dd($data['sample']);
        return view('admin.sample.form1edit',compact('data'));        
    }



}
