<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\SampleQuality;
use App\Model\Sample;
use App\Model\State;
use App\Model\District;
use App\Model\Facility;
use App\Model\FacilityType;
use App\Model\ServiceLog;
use App\Model\Service;
use App\Model\Config;
use App\Model\Enroll;
use App\Model\TBUnit;
use App\Model\TBDiagnosis;
use App\Model\LCDSTDrugs;
use App\Model\DSTDrugTR;
use App\Model\Master_PresumptiveDRTB;
use App\Model\Master_Followup_testreason;
use App\Model\Master_Followup_reason;
use App\Model\TBPredominanSymptom;
use App\Model\TestServices;
use App\Model\RequestServices;
use App\Model\Designations;
use App\User;
use App\Model\TestRequest;
use App\Model\Tbunits_master;
use App\Model\PHI_master;
use Illuminate\Support\Facades\DB;

class TestRequestController extends Controller
{
    public $test_request_type = ['N/A','Diagnosis TB', 'Follow Up (smear)','DSTB','DRTB'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

          $data = [];

        // dd("hi");
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
        //DB::enableQueryLog();
       /* $data['sample'] = Sample::select(DB::raw('e.patient_id,sample.enroll_id,u.name,e.label, ifnull(max(tr.id),0) as tr_id, receive_date as receive,
		                   group_concat(distinct sample_label) as samples,group_concat(distinct test_reason) as reason, fu_month'))
                          ->leftjoin('enrolls as e','e.id','=','enroll_id')
                          ->leftjoin('req_test as tr','sample.enroll_id','=','tr.enroll_id')
                          ->leftjoin('t_request_services as trs' ,'trs.enroll_id','=','e.id')
                          ->leftjoin('users as u','u.id','=','trs.created_by')                         
                          ->where('is_accepted','Accepted')
                          ->where('sample.test_reason','!=','EQA')
						  ->whereRaw('date(e.created_at) between date_add(curdate(), INTERVAL -90 DAY) AND curdate()')
						  ->groupBy('enroll_id')
                          ->orderBy('enroll_id','desc')
                          ->get();*/
		 //dd(DB::getQueryLog());				  
        //dd($data);
        return view('admin.test_request.list',compact('data'));

    }

    public function searchTestRequest(Request $request){
		   //dd($request->all());
		
			## Read value
			$draw = $_POST['draw'];
			$row = $_POST['start'];
			$rowperpage = $_POST['length']; // Rows display per page
			$columnIndex = $_POST['order'][0]['column']; // Column index
			$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
			$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
			$searchValue = $_POST['search']['value']; // Search value

			## Custom Field value
			$searchByEnrollmentNo = $request->searchByEnrollmentNo;
			
			## Search 
			$dateRangeQuery = " date(e.created_at) between date_add(curdate(), INTERVAL -90 DAY) AND curdate()";;
			$searchQuery = "";
			if($searchByEnrollmentNo != ''){
			   $searchQuery .= "  (e.label like '%".$searchByEnrollmentNo."%' ) ";
			}else{
			   $searchQuery .= "  date(e.created_at) between date_add(curdate(), INTERVAL -90 DAY) AND curdate()";
			}
			//echo $searchQuery; die;
			if($searchValue != ''){
			   $searchQuery .= " and (u.name like '%".$searchValue."%' or 
				  e.label like '%".$searchValue."%' or 
				  sample.enroll_id like'%".$searchValue."%'  or
				  sample_label like'%".$searchValue."%'  or
				  receive_date like'%".$searchValue."%'  or
				  test_reason like'%".$searchValue."%'  or
				  fu_month like '%".$searchValue."%') ";
			}

			## Total number of records without filtering
            //DB::enableQueryLog();			
			$sel=Sample::select(DB::raw('e.patient_id,sample.enroll_id,u.name,e.label, ifnull(max(tr.id),0) as tr_id, receive_date as receive,
		                   group_concat(distinct sample_label) as samples,group_concat(distinct test_reason) as reason, fu_month'))
                          ->leftjoin('enrolls as e','e.id','=','enroll_id')
                          ->leftjoin('req_test as tr','sample.enroll_id','=','tr.enroll_id')
                          ->leftjoin('t_request_services as trs' ,'trs.enroll_id','=','e.id')
                          ->leftjoin('users as u','u.id','=','trs.created_by')                         
                          ->where('is_accepted','Accepted')
                          ->where('sample.test_reason','!=','EQA')						 
						  ->whereRaw("".$dateRangeQuery)
                          ->groupBy('label')
                          ->orderBy('label','desc')						  
                          ->get();
			//dd($sel->count());			  
			//dd(DB::getQueryLog());	
			$totalRecords =$sel->count();

			## Total number of records with filtering
            //DB::enableQueryLog();			
			$sel=Sample::select(DB::raw('e.patient_id,sample.enroll_id,u.name,e.label, ifnull(max(tr.id),0) as tr_id, receive_date as receive,
		                   group_concat(distinct sample_label) as samples,group_concat(distinct test_reason) as reason, fu_month'))
                          ->leftjoin('enrolls as e','e.id','=','enroll_id')
                          ->leftjoin('req_test as tr','sample.enroll_id','=','tr.enroll_id')
                          ->leftjoin('t_request_services as trs' ,'trs.enroll_id','=','e.id')
                          ->leftjoin('users as u','u.id','=','trs.created_by')                         
                          ->where('is_accepted','Accepted')
                          ->where('sample.test_reason','!=','EQA')
						  ->whereRaw("".$searchQuery)	
                          ->groupBy('label')
                          ->orderBy('label','desc')						  
                          ->get();
			//dd(DB::getQueryLog());			  
			//dd($sel->count());			  
			$totalRecordwithFilter = $sel->count();

			## Fetch records
			//DB::enableQueryLog();
			$empQuery=Sample::select(DB::raw('e.patient_id,sample.id, sample.enroll_id,u.name,e.label, ifnull(max(tr.id),0) as tr_id, receive_date as receive,
		                   group_concat(distinct sample_label) as samples,group_concat(distinct test_reason) as reason, fu_month'))
                          ->leftjoin('enrolls as e','e.id','=','enroll_id')
                          ->leftjoin('req_test as tr','sample.enroll_id','=','tr.enroll_id')
                          ->leftjoin('t_request_services as trs' ,'trs.enroll_id','=','e.id')
                          ->leftjoin('users as u','u.id','=','trs.created_by')                         
                          ->where('is_accepted','Accepted')
                          ->where('sample.test_reason','!=','EQA')
						  ->whereRaw("".$searchQuery." group by `label` ".$columnSortOrder." limit ".$row.",".$rowperpage)
                          ->get();
			//dd($empQuery);
			//dd(DB::getQueryLog());
			
			$data = array();
			$actionBtn="";
            foreach($empQuery as $key=>$samples){	
              
          $naatresult="<a class='detail_modal bmwoff' style='color:#1E88E5; cursor:pointer; font-size:12px;' onclick=\"showNaatResult()\">View Field Naat Result</a>";

				$actionBtn="<button class='btn btn-info btn-sm' onclick=\"window.open('".( $samples->tr_id > 0 ? url('/test_request/'.$samples->tr_id.'/'.'edit') : url('/test_request/create/'.$samples->enroll_id.'/'.$samples->id))."');"
      ." $('#exampl tr.bg-selected').removeClass('bg-selected');$(this).parents('tr').addClass('bg-selected') \"> "
      . ($samples->tr_id > 0 ? 'Request' : 'Create' )
       ."</button>";	
                //echo $action; die;	   
				$data[] = array(
				 "enroll_id"=>$samples->enroll_id,
				 "name"=>$samples->name,
				 "label"=>$samples->label,
				 "samples"=>$samples->samples,
				 "receive_date"=>date('d-m-Y h:i:s',strtotime($samples->receive)),
				 "reason"=>str_replace(',','<br/>', $samples->reason),
				 "fu_month"=>str_replace(',','<br/>', $samples->fu_month),
         'naatresult' => $naatresult,
				 "action"=>$actionBtn,
			   );
			}	
			

			## Response
			$response = array(
			  "draw" => intval($draw),
			  "iTotalRecords" => $totalRecords,
			  "iTotalDisplayRecords" => $totalRecordwithFilter,
			  "aaData" => $data
			);
			echo json_encode($response);
	}	
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function districtWiseTSF()
     {
        //dd('here');
        $get_lab_code = "";
        $get_lab_code = DB::table('m_configuration')
                            ->select('lab_code')
                            ->where('status', '1')
                            ->first();
        //dd($get_lab_code);

        $get_dmcs_phi_relation = "";
        $get_tub_data = "";
        $get_state_data = "";
        $get_district_data = "";

        if(!empty($get_lab_code))
        {
          $get_dmcs_phi_relation = DB::table('m_dmcs_phi_relation')
                                    ->select('id', 'STOCode', 'DTOCode', 'TBUCode', 'DMC_PHI_Code', 'DMC_PHI_Name')
                                    ->where('id', $get_lab_code->lab_code)
                                    ->first();

          if(!empty($get_dmcs_phi_relation))
          {
            $get_tub_data = DB::table('m_tbunits_relation')
                            ->select('TBUnitCode', 'TBUnitName')
                            ->where('STOCode', $get_dmcs_phi_relation->STOCode)
                            ->where('DTOCode', $get_dmcs_phi_relation->DTOCode)
                            ->where('TBUnitCode', $get_dmcs_phi_relation->TBUCode)
                            ->first();

            $get_state_data = DB::table('state')
                              ->select('STOCode', 'name')
                              ->where('STOCode', $get_dmcs_phi_relation->STOCode)
                              ->first();
            
            $get_district_data = DB::table('district')
                                  ->select('DTOCode', 'name')
                                  ->where('DTOCode', $get_dmcs_phi_relation->DTOCode)
                                  ->first();            
          }         

        }

        $response = array(
          'dmcs_phi_relation' => $get_dmcs_phi_relation,
          'get_tub_data'      => $get_tub_data,
          'get_state_data'    => $get_state_data,
          'get_district_data' =>$get_district_data
        );

        echo json_encode($response);
     }

    public function create($enrollId, $sample_id)
    {

      $get_lab_code = "";
      $get_lab_code = DB::table('m_configuration')
                          ->select('lab_code')
                          ->where('status', '1')
                          ->first();

        

      $data['master_presumptive_drtb']=Master_PresumptiveDRTB::all();
      $data['master_follow_up_reasons']=Master_Followup_reason::all('Follow_up_Reason_FUTB')->keyBy('Follow_up_Reason_FUTB')->toArray();
	  //dd($data['master_follow_up_reasons']);
      $data['master_follow_up_testreasons']=Master_Followup_testreason::all();
      // dd($data['master_presumptive_drtb']);
      $data['enroll_id'] = $enrollId;
      $data['sample_id'] = $sample_id;
      $data['date'] = date('Y-m-d H:i:s');
      $data['testrequest'] = [];
      $reqservices = RequestServices::all();
      $data['testrequestservices'] = new RequestServices();
	  //dd($data['testrequestservices']);
      //$data['diagnosis_value'] = new TBDiagnosis();
      $data['prsmptv_xdrtv']=[];
      $data['type_of_prsmptv_drtb']=[];
      $data['regimen']=[];
      $data['diagnosis_value'] = [];
      $diagnosis = TBDiagnosis::select('diagnosis_id','name')->where('record_status',1)->get();
      $state = State::orderBy('name')->get();
      $facility_type = FacilityType::select('facility_type_id','name')->where('record_status',1)->get();
      $predominan_symptom = TBPredominanSymptom::select('symptom_id','name')->where('record_status',1)->get();
      $services = DB::table('m_test_request')->select('id','name')->where('status',1)->orderBy('sequence_id','ASC')->get();
      $services = json_decode($services, true);
      $designations = Designations::select('designation_id','name')->where('record_status',1)->get();
      $dstdrugs = LCDSTDrugs::select('id','name')->where('status',1)->get();
      $test_reason = Sample::select(DB::raw('test_reason as reason, sample_type, others_type as sample_type_other,sample_quality,fu_month'))->where('enroll_id',$enrollId)->first();
      $enroll_label = Enroll::select('label as enroll_label')->where('id',$enrollId)->first();
      $nikshay_id   = Enroll::select('nikshay_id')->where('id',$enrollId)->first();
      //dd($test_reason);
      
      $data['reason'] = $test_reason->reason;
      $data['sample_type'] = $test_reason->sample_type;
      $data['sample_type_other'] = $test_reason->sample_type_other;
      $data['sample_quality'] = $test_reason->sample_quality;
      $data['fu_month'] = $test_reason->fu_month;
	  //dd($data['fu_month']);
	 // echo $data['sample_quality']; die;
	   //echo $data['sample_type']; echo "<br/>"; echo $data['sample_type_other']; die;
      $data['state'] = $state;
      $data['reqservices'] = $reqservices;
	  //dd($data['reqservices']);
      $data['enroll_label'] = $enroll_label->enroll_label;
      //dd( $data['enroll_label'] );
      $data['dstdrugs'] = $dstdrugs;
      $data['district'] = [];
      $data['facility_types'] = Facility::all();
      $data['facility'] = [];
	  //dd($data['facility']);
      $data['facility_type'] = $facility_type;
      $data['tbunit'] = [];
      $data['diagnosis'] = $diagnosis;
      $data['predominan_symptom'] = $predominan_symptom;
      $data['services'] = $services;
      $data['designations'] = $designations;
      //dd($data['designations']);
      $data['dst_id'] = env("DST_ID", "21,22,23");
      $data['lab_code'] = $get_lab_code->lab_code;
      $data['nikshay_id'] = $nikshay_id->nikshay_id;
	  $lab_id=this_lab()->id;//login user lab id
	  //dd($lab_id);
	  $data['login_user_phi_rln']=PHI_master::find($lab_id);
	  //dd($data['login_user_phi_rln']);
      return view('admin.test_request.form1',compact('data'));
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

        DB::beginTransaction();
            try {	
        $xdr='';
        $mdr='';
        $mdr_val=array();
        $xdr_val=array();
        $ph_val=array();
        $ph='';
        $post_treatment='';
        $reason='';

        if(!empty($request->reason)){
			
          $source=Master_Followup_reason::select('source')->where('Follow_up_Reason_FUTB',$request->reason)->get();
		 //dd($source);
         if(count($source)>0){
			  if($source[0]['source'] == 'PT'){
				  if($request->reason=="Other"){
				   $reason=$request->followup_otherA; 
				  }else{  
					$post_treatment=$request->reason;
					$reason=$request->reason;
				  }
			  }elseif ($source[0]['source'] == 'RS') {
				$reason=$request->reason;
			  }
		  }else{
			  if($request->reason=="Other"){
				 $reason=$request->followup_otherA; 
			  }else{
				  $reason=$request->reason;
			  }
			  
		  }	  
        }else{
			$sampl=Sample::select('fu_month')->where('enroll_id',$request->enroll_id)->get();
			//dd($sampl);
			$reason=$sampl[0]['fu_month'];
		}
		//dd($reason);
		
        $test_req = Sample::updateOrCreate(['enroll_id'=>$request->enroll_id], ['fu_month' => $reason]);
       
        if(!empty($request->type_of_prsmptv_drtb)){

          foreach ($request->type_of_prsmptv_drtb as $key => $value) {
            $source2=Master_PresumptiveDRTB::select('source')->where('typeof_Presumptive_DRTB',$value)->get();
            if($source2[0]['source'] == 'MDR'){

                $mdr_val[]=$value;

            }elseif($source2[0]['source'] == 'XDR'){


             $xdr_val[]=$value;

            }elseif($source2[0]['source'] == 'PH'){

             $ph_val[]=$value;

            }


          }

        }
       //
		 if(!empty($mdr_val)){

		   $mdr=implode(',',$mdr_val);
		 }
		if(!empty($xdr_val)){

		  $xdr=implode(',',$xdr_val);
		}
		if(!empty($ph_val)){

		  $ph=implode(',',$ph_val);
		}


        //dd($request->all());
        //DB::enableQueryLog();
        $test_req = TestRequest::updateOrCreate(['enroll_id'=>$request->enroll_id],$request->except(['services']));
		//dd($test_req);
        //dd(DB::getQueryLog());
        RequestServices::where('enroll_id', $request->enroll_id)->delete();
        #RequestServices::
        $en_label = Enroll::select('label as label')->where('id',$request->enroll_id)->first();
        $s_id = Sample::select('id as sample_id')->where('sample_label',$request->samplelable)->first();
        // dd($request->diagnosis?  implode(',',$request->diagnosis) : '');
		$diagnosis='';

		$regimen='';


		// if(!empty($request->prsmptv_xdrtv)){
		//   if(is_array($request->prsmptv_xdrtv) == true){
		//   $prsmptv_xdrtv=implode(',',$request->prsmptv_xdrtv);
		//   }else{
		//   $prsmptv_xdrtv=$request->prsmptv_xdrtv;
		// }
		// }

      $diagnosis_arr = [];
      $diagnosis_name_arr = [];
      $diagnosis_name = "";

			if(!empty($request->diagnosis)){

				 if(is_array($request->diagnosis) == true){

				  $diagnosis=implode(',',$request->diagnosis);

          foreach( $request->diagnosis as $value )
          {
            $diagnosis_arr[] = $value;
          }

				}else{

					$diagnosis=$request->diagnosis;
          $diagnosis_arr[] = $request->diagnosis;

				}

          $diagnosis_name = DB::table('m_tbdiagnosis')
                            ->select('name')
                            ->whereIn('diagnosis_id', $diagnosis_arr)
                            ->get();

                            foreach($diagnosis_name as $diagonosis_name)
                            {
                             $diagnosis_name_arr[] = $diagonosis_name->name;
                            }
                     
                            if(!empty($diagnosis_name_arr))
                            {
                               $diagnosis_name = implode(',', $diagnosis_name_arr);
                            }
			}

			

       

			// dd($diagnosis);

			// if(!empty($request->type_of_prsmptv_drtb)){
			//   if(is_array($request->type_of_prsmptv_drtb) == true){
			//   $type_of_prsmptv_drtb=implode(',',$request->type_of_prsmptv_drtb);
			// }else{
			//   $type_of_prsmptv_drtb=$request->type_of_prsmptv_drtb;
			// }
			// }




        //for futb regimen

		if(!empty($request->regimen)){
			if(is_array($request->regimen) == true){
				$regimen=implode(',',$request->regimen);
			}else{
				$regimen=$request->regimen;
			}
		}

        $services = $request->services;
		//dd($services);
        //DB::enableQueryLog();
 
        if($services){ //echo "if block"; die;
            foreach($services as $service){
              $data = [
                'enroll_id' => $request->enroll_id,
                'test_req_id' => $test_req->id,
                'service_id' => $service,
                'requestor_name' => $request->requestor_name,
                'designation' => $request->designation,
                'month_week' => $request->month_week,
                'duration' => $request->duration,
                'diagnosis' => $diagnosis,
                'contact_no' => $request->contact_no,
                'email_id' => $request->email_id,
                'created_by' => $request->user()->id,
                'request_date' => $request->request_date,
                'type_of_prsmptv_drtb' => $mdr,
                'presumptive_h' => $ph,
                'prsmptv_xdrtv' => $xdr,
                'PresumptiveDRTB' => $mdr.$ph.$xdr,
                'post_treatment' => $post_treatment,
                'other_post_treatment' => $request->other_post_treatment,
                'regimen_fu' => $request->regimen_fu,
                'rntcp_reg_no' => $request->rntcp_reg_no,
                'regimen' => $regimen,
                'reason' => $reason,
                'pmdt_tb_no' => $request->pmdt_tb_no,
                'month_week' => $request->month_week,
                'treatment' => $request->treatment,
                'ho_anti_tb' => $request->ho_anti_tb,
                'regimen_fu' => $request->regimen_fu,
                'fudrtb_regimen_other' => $request->fudrtb_regimen_other,
                'facility_type_other' => $request->facility_type_other,
                'lab_sample_label'    => $request->enroll_label,
                'no_of_hcp_visit'=>$request->no_of_hcp_visit,
                'history_previous_att'=>$request->history_previous_att,
                'specimen_type_test'=>$request->specimen_type_test,
                'visual_appearance_sputum'=>$request->visual_appearance_sputum,
                'specimen_type_other'=>$request->specimen_type_other,
                'field_SampleSpecimenType' => $request->specimen_type_test,
                'field_SampleSpecimenTypeIfOther' => $request->specimen_type_other,
                'field_SampleDescription' => $request->visual_appearance_sputum,
                'requestFacilityId'       => $request->facility_id,
                'diagnosis_name'     =>  $diagnosis_name

              ];

              //  $servicelog = [
              //   'enroll_id' => $request->enroll_id,
              //   'sample_id' => $s_id->sample_id,
              //   'enroll_label' => $en_label->label,
              //   'sample_label' => $request->samplelable,
              //   'service_id' => $service,
              //   'status' => 1,
              //   'tag' => '',
              //   'test_date' => date('Y-m-d H:i:s'),
              //   'created_by' => $request->user()->id,
              //   'updated_by' => $request->user()->id
              // ];

//                dd( $data );

              RequestServices::create($data);

          //    ServiceLog::create($servicelog);
            }
          }else{ //echo "else block"; die;
            $tmp_regimen = '';
            if(gettype($request->regimen)=='string'){
              $tmp_regimen = $request->regimen;
            }
            else if(gettype($request->regimen)=='array'){
              $tmp_regimen = implode(',',$request->regimen);
            }
            //if($request->regimen)
            $data = [
                'enroll_id' => $request->enroll_id,
                'test_req_id' => $test_req->id,
                'requestor_name' => $request->requestor_name,
                'designation' => $request->designation,
                'duration' => $request->duration,
                'month_week' => $request->month_week,
                'diagnosis' => $request->diagnosis?  implode(',',$request->diagnosis) : '',
                'contact_no' => $request->contact_no,
                'email_id' => $request->email_id,
                'created_by' => $request->user()->id,
                'request_date' => $request->request_date,
                'type_of_prsmptv_drtb' => $mdr,
                'presumptive_h' => $ph,
                'prsmptv_xdrtv' => $xdr,
                'PresumptiveDRTB' => $mdr.$ph.$xdr,
                'post_treatment' => $post_treatment,
                'other_post_treatment' => $request->other_post_treatment,
                'regimen_fu' => $request->regimen_fu,
                'rntcp_reg_no' => $request->rntcp_reg_no,
                'regimen' => $tmp_regimen,
                'reason' => $reason,
                'pmdt_tb_no' => $request->pmdt_tb_no,
                'month_week' => $request->month_week,
                'treatment' => $request->treatment,
                'ho_anti_tb' => $request->ho_anti_tb,
                'regimen_fu' => $request->regimen_fu,
                'fudrtb_regimen_other' => $request->fudrtb_regimen_other,
                'facility_type_other' => $request->facility_type_other,
                'lab_sample_label'    => $request->enroll_label,
                'no_of_hcp_visit'=>$request->no_of_hcp_visit,
                'history_previous_att'=>$request->history_previous_att,
                'specimen_type_test'=>$request->specimen_type_test,
                'visual_appearance_sputum'=>$request->visual_appearance_sputum,
                'specimen_type_other'=>$request->specimen_type_other,
                'lab_sample_label'    => $en_label

              ];
              RequestServices::create($data);
          }
          //dd(DB::getQueryLog());

			if($request->drugs){ //echo "h1"; die;

				if(!empty($request->drugs['lcdst'])){//For LCDST

					$count_drug_exists=DSTDrugTR::where('enroll_id', $request->enroll_id)->where('service_id', 21)->where('status', 1)->count();
					$drug_str = implode(',',$request->drugs['lcdst']);

          //$get_sample_id = 
					// dd($count_drug_exists);
					if($count_drug_exists < 1){
					  DSTDrugTR::create([
						'enroll_id' => $request->enroll_id,
						'sample_id' => $request->sample_id,
						'service_id'=>21,
						'drug_ids' => $drug_str,
						'status' => 1,
						'flag' => 1,
						'created_by'=>$request->user()->id,
						'updated_by'=>$request->user()->id,
					  ]);
					}else{
					  DSTDrugTR::where('enroll_id',$request->enroll_id)->where('service_id', 21)->update(['drug_ids'=>$drug_str]);

					}
				}
				
				if(!empty($request->drugs['ljdst'])){//For LJDST

					$count_drug_exists=DSTDrugTR::where('enroll_id', $request->enroll_id)->where('service_id', 22)->where('status', 1)->count();
					$drug_str = implode(',',$request->drugs['ljdst']);
					// dd($count_drug_exists);
					if($count_drug_exists < 1){
					  DSTDrugTR::create([
						'enroll_id' => $request->enroll_id,
						'sample_id' => $request->sample_id,
						'service_id'=>22,
						'drug_ids' => $drug_str,
						'status' => 1,
						'flag' => 1,
						'created_by'=>$request->user()->id,
						'updated_by'=>$request->user()->id,
					  ]);
					}else{
					  DSTDrugTR::where('enroll_id',$request->enroll_id)->where('service_id', 22)->update(['drug_ids'=>$drug_str]);

					}
				}
			}
			
		  DB::commit();		
		}catch(\Exception $e){ 
		  
			 //dd($e->getMessage());
			  $error = $e->getMessage();		  
			  DB::rollback(); 
			  //$success = false;
			   
		}
        // DO NOT REDIRECT, RATHER CLOSE THE WINDOW. ==========        
        return "<script> window.opener.location.reload(); window.close();</script>";
		//return redirect('/test_request');
    }

    /**
     * Display the specified resource.'month_week' => $request->month_week,
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $testrequest = TestRequest::where('id',$id)->first();
        $data['testrequest'] = $testrequest;
        $state = State::select('name')->where('STOCode', $testrequest->state)->first();
        $district = District::select('name')->where('id', $testrequest->district)->first();
        $facility = PHI_master::all();

        $data['state'] = $state;
        $data['district'] = $district;
        $data['facility'] = $facility;
        $data['test_type'] = $this->test_request_type[$testrequest->req_test_type];

        //dd($data);
        return view('admin.test_request.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        //dd($id);
        $data['master_presumptive_drtb']=Master_PresumptiveDRTB::all();
        $data['master_follow_up_reasons']=Master_Followup_reason::all();
        $data['master_follow_up_testreasons']=Master_Followup_testreason::all();
        $testrequest = TestRequest::where('id',$id)->first();
        $data['testrequest'] = $testrequest;
		//dd($data['testrequest']);
      $data['lab_code'] = $testrequest->lab_code;
      $data['nikshay_id'] = $testrequest->nikshay_id;
        $data['testrequestservices']=RequestServices::where('enroll_id',$testrequest->enroll_id)->first();
		$data['prsm_drtb']=RequestServices::select('type_of_prsmptv_drtb','presumptive_h','prsmptv_xdrtv')->where('enroll_id',$testrequest->enroll_id)->first();
		// dd($data['prsm_drtb']);
		$prsm=$data['prsm_drtb']['type_of_prsmptv_drtb'].','.$data['prsm_drtb']['presumptive_h'].','.$data['prsm_drtb']['prsmptv_xdrtv'];
		 // dd($prsm);
          // dd(  $data['testrequestservices'] );
        $data['prsmptv_xdrtv'] = $data['testrequestservices']->prsmptv_xdrtv != null ?  explode(',',$data['testrequestservices']->prsmptv_xdrtv) : [];
        $data['type_of_prsmptv_drtb'] = $prsm != null ?  explode(',',$prsm) : [];
        $data['regimen'] = $data['testrequestservices']->regimen != null ?  explode(',',$data['testrequestservices']->regimen) : [];
        $state = State::orderBy('name')->get();
        $facility_type = FacilityType::select('facility_type_id','name')->where('record_status',1)->get();
        $diagnosis = TBDiagnosis::select('diagnosis_id','name')->where('record_status',1)->get();
        $data['diagnosis'] = TBDiagnosis::select('diagnosis_id','name')->where('record_status',1)->get();
        $diagnosis_id = $data['testrequestservices']->diagnosis != null ?  explode(',',$data['testrequestservices']->diagnosis) : [];
        $data['diagnosis_value'] = TBDiagnosis::where('record_status',1)->whereIn('diagnosis_id',$diagnosis_id)->pluck('diagnosis_id')->toArray();
        $predominan_symptom = TBPredominanSymptom::select('symptom_id','name')->where('record_status',1)->get();
        $services = DB::table('m_test_request')->select('id','name')->where('status',1)->get();
        $services = json_decode($services, true);
        $reqservices = RequestServices::where('enroll_id',$testrequest->enroll_id)->get();
        $designations = Designations::select('designation_id','name')->where('record_status',1)->get();


        $data['selected_dstdrugs'] = DSTDrugTR::join('t_service_log', 't_dst_drugs_tr.enroll_id', '=', 't_service_log.enroll_id')
            ->select('t_dst_drugs_tr.drug_ids')
            ->distinct()
            ->getQuery()
            ->get();

		if(!empty($data['selected_dstdrugs'])){

			foreach($data['selected_dstdrugs'] as $seldrugs){

			$data['sel_drugs']=DB::select(DB::raw("select id,name from `m_dst_drugs` where id in ($seldrugs->drug_ids)"));
			$data['selected_drugs']=$data['sel_drugs'];
			}
		  // echo "<pre>";  print_r($drugs);
		}

       //dd($data['selected_drugs']);
       // dd($data['selected_drugs']);
        $data['existing_drugs_lc']=[];
        
        $drugs=DB::table('t_dst_drugs_tr')->where('enroll_id',$testrequest->enroll_id)->where('service_id',21)->pluck('drug_ids');
        //dd($drugs);
        if(count($drugs)>0){

          unset($data['existing_drugs_lc']);

          foreach($drugs as $dg)
          {
            //print_r($dg->id);
            $drugids = explode(',',$dg); 

            foreach($drugids as $dg_id)
            {
              $data['existing_drugs_lc'][]=$dg_id;
            }

          }         

         }      
        
		//dd($data['existing_drugs_lc']); die;
		
		$data['existing_drugs_lj']=[];
        $drugs=DB::table('t_dst_drugs_tr')->where('enroll_id',$testrequest->enroll_id)->where('service_id',22)->pluck('drug_ids');
        //dd($drugs);
        if(count($drugs)>0){
          unset($data['existing_drugs_lj']);
          foreach($drugs as $dg)
          {
            //print_r($dg->id);
            $drugids = explode(',',$dg); 

            foreach($drugids as $dg_id)
            {
              $data['existing_drugs_lj'][]=$dg_id;
            }
          }
			  
        //dd($drugids);
			//$data['drugs'] = LCDSTDrugs::whereIn('id',$drugids)->get();
      //dd($data['drugs']);
			
			/* foreach( $drugids as $dg){                        
				$data['existing_drugs_lj'][]=$dg;						
			} */
         }      
        
		  //dd($data['existing_drugs_lj']); //die;
        $dstdrugs = LCDSTDrugs::select('id','name')->where('status',1)->get();
        $enroll_label = Enroll::select('label as enroll_label')->where('id',$testrequest->enroll_id)->first();
        $test_reason = Sample::select(DB::raw('id as sample_id, test_reason as reason, sample_type, others_type as sample_type_other,sample_quality,fu_month'))->where('enroll_id', $testrequest->enroll_id)->first();
        $data['sample_id'] = $test_reason->sample_id;
        //dd($test_reason);
        $data['reason'] = $test_reason->reason;
        $data['sample_type'] = $test_reason->sample_type;
        $data['sample_type_other'] = $test_reason->sample_type_other;
		$data['sample_quality'] = $test_reason->sample_quality;
		$data['fu_month'] = $test_reason->fu_month;
        $data['dstdrugs'] = $dstdrugs;
        $data['enroll_label'] = $enroll_label->enroll_label;
        $data['enroll_id'] = $testrequest->enroll_id;
        $data['state'] = $state;
        $district= District::where('district.STOCode',$data['testrequest']->state)->distinct('district.name')->get();
        $data['district'] = $district;
        $facility = PHI_master::select('m_dmcs_phi_relation.id','m_dmcs_phi_relation.DMC_PHI_Name','m_dmcs_phi_relation.DMC_PHI_Code')->where('m_dmcs_phi_relation.TBUCode',$data['testrequest']->tbu)->where('m_dmcs_phi_relation.DTOCode',$data['testrequest']->district)->get();
        $data['facility'] = $facility;
        $data['facility_type'] = $facility_type;
        $tbunit = Tbunits_master::select('m_tbunits_relation.id','m_tbunits_relation.TBUnitCode','m_tbunits_relation.TBUnitName')->where('m_tbunits_relation.DTOCode',$data['testrequest']->district)->where('m_tbunits_relation.STOCode',$data['testrequest']->state)->get();
        $data['tbunit'] = $tbunit;
        $data['diagnosis'] = $diagnosis;
        $data['facility_types'] = Facility::all();
        $data['predominan_symptom'] = $predominan_symptom;
        $data['services'] = $services;
        $_reqservices = [];
        foreach ($reqservices as $value) {
          $_reqservices[] = $value->service_id;
        }
        $data['reqservices'] = $reqservices;
        $data['_reqservices'] = $_reqservices;
        //dd($data['reqservices']);
        $data['designations'] = $designations;
		//dd($data['designations']);
        $data['dst_id'] = env("DST_ID", "21,22,23");
        $lab_id=this_lab()->id;//login user lab id
	  //dd($lab_id);
	   $data['login_user_phi_rln']=PHI_master::find($lab_id);
	  //dd($data['login_user_phi_rln']);

 // dd($data);
        // return SampleQuality::sample_quality_edit($id);
        return view('admin.test_request.form1',compact('data'));
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
        //
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
    public function testrequestPrint()
    {
        $data['sample'] = Sample::select(DB::raw('e.patient_id,sample.enroll_id,e.label, ifnull(max(tr.id),0) as tr_id, group_concat(date_format(receive_date,"%d-%m-%y")) as receive,group_concat(sample_label) as samples,group_concat(test_reason) as reason'))
                          ->leftjoin('enrolls as e','e.id','=','enroll_id')
                          ->leftjoin('req_test as tr','sample.enroll_id','=','tr.enroll_id')
                          ->groupBy('enroll_id')
                          ->orderBy('enroll_id','desc')
                          ->get();
        //dd($data['sample']);
        return view('admin.test_request.print',compact('data'));
    }

    public function phi_collect($state,$tbu,$district)
    {
        try{


            $phi_val = DB::table('m_dmcs_phi_relation')->orderBy('DMC_PHI_Name')->select('id','DMC_PHI_Name')
                        ->where('isPhiContinue',1)->where('STOCode',$state)->where('TBUCode',$tbu)->where('DTOCode',$district)->distinct()->get();
            //$district_val = District::all();

            return response()->json([
              "phi" => $phi_val
            ]);



        }catch(\Exception $e){

            $error = $e->getMessage();
            return view('admin.layout.error',$error);   // insert query
        }
    }

    public function tbunit_collect($state,$district)
    {
        try{


            $tbunit_val = DB::table('m_tbunits_relation')->orderBy('TBUnitName')->select('id','TBUnitCode','TBUnitName')->where('isTuContinue',1)->where('STOCode',$state)->where('DTOCode',$district)->distinct()->get();
            //$district_val = District::all();

            return response()->json([
              "tbunit" => $tbunit_val
            ]);



        }catch(\Exception $e){
            $error = $e->getMessage();
            return view('admin.layout.error',$error);   // insert query
        }
    }

    public function new_tbunit_collect($state,$district)
    {
        try{


            $tbunit_val = DB::table('m_lab_tu')->orderBy('tuname')->select('id','tuname')->where('STOCode',$state)->where('DTOCode',$district)->distinct()->get();
            //$district_val = District::all();

            return response()->json([
              "tbunit" => $tbunit_val
            ]);



        }catch(\Exception $e){
            $error = $e->getMessage();
            return view('admin.layout.error',$error);   // insert query
        }
    }


	public function checkForSampleAlreadyInProcessInTestRequest($enroll_id)
    { 
	       
		    //echo $enroll_id; die;
			$testreqlog = DB::select("SELECT IFNULL(count(*),0) AS v_count FROM req_test 
			WHERE enroll_id =".$enroll_id);
			//dd($testreqlog);
		    //dd($testreqlog[0]->v_count);	   

			echo json_encode($testreqlog[0]->v_count);
			exit;
	}
	public function checkForSampleAlreadyInProcessInTestRequestService($enroll_id,$service_id)
    { 
	       
		    //echo $enroll_id."====".$service_id; die;
			$testreqServlog = DB::select("SELECT IFNULL(count(*),0) AS v_count FROM t_request_services 
			WHERE service_id =".$service_id."
			AND enroll_id =".$enroll_id);
			//dd($testreqServlog);
		    //dd($testreqServlog[0]->v_count);	   

			echo json_encode($testreqServlog[0]->v_count);
			exit;
	}
}
