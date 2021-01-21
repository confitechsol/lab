<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Model\ServiceLog;
use App\Model\Sample;
use App\Model\Cbnaat;
use App\Model\Microbio;
use App\Model\Service;
use App\Model\Enroll;
use Illuminate\Support\Facades\Redirect;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Model\LJDetail;
use App\Model\LCDST;
use App\Model\LCDSTDrugs;
use App\Model\DSTDrugTR;
use App\Model\LCDSTInoculation;
use App\Model\CultureInoculation;
use App\Model\FirstLineLpa;
use App\Model\SecondLineLpa;
use App\Model\FinalInterpretation;
use App\Model\Decontamination;
use App\Model\LCFlaggedMGIT;
use App\Model\LCFlaggedMGITFurther;
use App\Model\LjDstReading;
use App\Model\RequestServices;
use App\Model\Microscopy;
use App\Model\DNAextraction;
use App\Model\Hybridization;
use App\Model\Pcr;
use App\Model\Master_Map_retest;
use App\Model\Master_addtest;
use App\Model\Master_Map_Reqservice_Servicelog;
use Illuminate\Support\Facades\Config;
use PDF;
use Session;


class MicroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            //dd("hi");
            $data = [];
            $data['services'] = "fddg,gdg,gdg";
            //dd($data['services']);
			//DASHBOARD DISPLAY START
            $data['summary']['todo']=DB::select('select m.id as ID,  s.name,  ifnull(count(m.id),0) as cnt from t_microbiologist m join m_services as s on m.service_id = s.id where m.status = 0 and s.id in (1,2,3,4,8,14,15,16,17,20,21,22) group by m.service_id');

            $data['summary']['done']=DB::select('select m.id as ID, s.name, ifnull(count(m.id),0) as cnt from t_microbiologist m join m_services as s on m.service_id = s.id where m.status = 1 and m.print_15A = 1 and s.id in (1,2,3,4,8,14,15,16,17,20,21,22) group by m.service_id');
            //dd($data['summary']);
            $ret = [];
            foreach($data['summary']['todo'] as $sample){
                $data1 = $sample;
                $data2 = [];
                $data3 = [];

                foreach($data['summary']['done'] as $test){
                    if($sample->name == $test->name){
                        $data2 = $test;
                        break;
                    }
                }



                $ret[] = [
                    'todo'=>$data1,
                    'done'=>$data2,

                ];
            }
            $data['ret']=$ret;

           // dd($data['ret']);
             //DASHBOARD DISPLAY END

            
            /* $data['sample'] = ServiceLog::select(
                 's.id as ID','s.tag as tag','t_service_log.id as tslID','t_service_log.tag as stag','t_service_log.print_15a as print_15a','t_service_log.sent_to_nikshay as sent_to_nikshay','f.DMC_PHI_Name as facility_id',
                 'sample.id as sampleID','s.enroll_id as enroll','enrolls.label as enroll_l',
                 'sample.sample_label as samples','s.sample_id as sample','sample.name as p_name',
                 's.created_at as date','sample.sample_type', 'sample.test_reason',
                 's.service_id as service','s.next_step as next','s.detail as m_detail',
                 's.remark as m_remark','m.name as service_name','m.url','s.bwm as bwm_status',
                 'ci.mgit_id','ci.tube_id_lj','ci.tube_id_lc','ci.inoculation_date','ddt.id as lc_dst_tr_id','ddt.drug_ids as drug_ids',
                 'ldi.mgit_seq_id', 'ldi.dst_c_id1', 'ldi.dst_c_id2','ldi.dst_c_id3',
                 'patient.reg_by', 'sample.no_of_samples as no_of_samples','t_service_log.rec_flag',
                  DB::raw('date_format(ldi.inoculation_date,"%d-%m-%y")') )
                 ->leftJoin('t_microbiologist as s', function($join){
                    $join->on('s.sample_id', '=','t_service_log.sample_id');
                    $join->on('s.service_id', '=','t_service_log.service_id')
					->whereRaw(DB::raw("( CONCAT(CONVERT(s.service_id,CHAR(2)),s.next_step) NOT IN ('14Send Sample') )" ));
                })
                ->leftjoin('sample as sample','s.sample_id','=','sample.id')
                ->leftjoin('enrolls as enrolls','enrolls.id','=','sample.enroll_id')
                ->leftjoin('t_cbnaat as cbnaat','s.sample_id','=','cbnaat.sample_id')
                ->leftjoin('t_decontamination as d','s.sample_id','=','d.sample_id')
                ->leftjoin('req_test as rq','rq.enroll_id','=','s.enroll_id')
                ->leftjoin('m_dmcs_phi_relation as f','rq.facility_id','=','f.id')
                ->leftjoin('m_services as m','m.id','=','s.service_id')
                ->leftjoin('t_culture_inoculation as ci','ci.sample_id','=','s.sample_id')
                // ->leftjoin('t_dst_drugs_tr as ddt','ddt.enroll_id','=','t_service_log.enroll_id')
                ->leftjoin('t_lc_dst_inoculation as ldi','ldi.sample_id','=','s.sample_id')
                //->where('ddt.status',1)
                ->leftjoin('t_dst_drugs_tr as ddt', function ($join) {
                     $join->on('ddt.enroll_id','=','s.enroll_id');
					 $join->on('ddt.service_id', '=','t_service_log.service_id');
                          //->where('ddt.status', 1);
                 })
                ->leftjoin('patient as patient','patient.id','=','enrolls.patient_id')
                ->groupby('sample.id')
                ->groupby(['s.service_id','t_service_log.service_id','t_service_log.tag'])
				->where('t_service_log.sent_to_nikshay',0)
                ->where('t_service_log.sent_to_nikshay_date',null)				
                //->where('s.status',0)				
				->orderBy('enrolls.label')
				->orderBy('sample.sample_label')
				->orderBy('t_service_log.service_id')
                ->where('t_service_log.status',0)
                ->where('t_service_log.print_15a',1)
                //->where('s.service_id', '!=', ServiceLog::TYPE_BWM)
				->whereIn('t_service_log.service_id',array(4,14,22,15,17,20,21))
                ->get();
               //->toSql();

              //dd($data['sample']);
              
              //dd(Config::get('m_services_array.tests')); 
            			  
             foreach($data['sample'] as $sampledata){
                //echo $sampledata->enroll_id; die;
                $data['reqServ_service_id['.$sampledata->enroll.']']='';
                $services=RequestServices::select('service_id','enroll_id')->where('enroll_id',$sampledata->enroll)->get();
				//dd($services);
				if(count($services)>0){
				 $data['reqServ_service_id['.$sampledata->enroll.']']=$services[0]->service_id;
				
                }
                $data['test_requested['.$sampledata->enroll.']']='';
                $data['services_col_color['.$sampledata->enroll.']']='N';
				//$result=array();
                //$data['existing_service_ids']=array();
                if(!$services->isEmpty()){ //echo "hi"; die;                    
                    $result=array();
                    $data['existing_service_ids']=array();
                    unset($result);//reinitialize array
					unset($data['existing_service_ids']);
                    foreach($services as $serv){
						//echo Config::get('m_services_array.tests')[5]; die();
                        $result[] = Config::get('m_services_array.tests')[$serv->service_id] ?? null; 
						if(isset(Config::get('m_services_array.tests')[$serv->service_id])&& !empty(Config::get('m_services_array.tests')[$serv->service_id])){
							 $data['existing_service_ids'][]=$serv->service_id;
						}else{
							 $data['existing_service_ids'][]='';
						}
                        //$data['existing_service_ids'][]=Config::get('m_services_array.tests')[$serv->service_id]?$serv->service_id:'';	                       										   
                    }
					//dd( $data['existing_service_ids']);
                    //dd($result);
                    //dd(count($result));
                    // comma in the array 
                    $data['test_requested['.$sampledata->enroll.']'] = implode(', ', $result); 
                    //dd($data);
                    //For display green colour for more than 1 services
                    if(count($result)>1)
                    {
                        $data['services_col_color['.$sampledata->enroll.']']='Y';
                    }               
                    
                }
             }
			 //dd($result);
			 //dd( $data['existing_service_ids']);
			 //dd( $data['test_requested[3]']);
			 //dd($data['reqServ_service_id[1]']);
             //dd($data);
			
              $data['drugs'] = [];
              foreach ($data['sample'] as $key => $value) {
              if($value->drug_ids != ''){
                $drugids = explode(',',$value->drug_ids);
                $druglist = LCDSTDrugs::whereIn('id',$drugids)->pluck('name')->toArray();
                $value->druglist = implode(',',$druglist);
                $data['drugs'] = LCDSTDrugs::whereIn('id',$drugids)->get();
				    unset($data['existing_drugs']);
                    foreach( $data['drugs'] as $dg){                        
                        $data['existing_drugs'][]=$dg->id;						
                    }
                }
              }*/
              //echo "<pre>"; print_r($data['existing_drugs']); die();
               //dd($data['drugs']);
              $data['dp_result'] = ["Sensitive (S)","Resistance (R)", "Not done (-)", "Contaminated ( C)", "Error ( E)"];
              $data['dp_result_value'] = ["Sensitive","Resistance", "Not done", "Contaminated", "Error"];

              /*foreach ($data['sample'] as $key => $value) {
                $value->no_sample = ServiceLog::where('enroll_id',$value->enroll)->where('service_id',11)->count();
              }*/

           

            $services = DB::table('m_test_request')->select('id','name')->whereIn('name',['LCDST','LJ DST','LJ DST 2st line'])->where('status',1)->get();
            $services = json_decode($services, true);
            $data['services'] = $services;
			//druglist
            $dstdrugs = LCDSTDrugs::select('id','name')->where('status',1)->get();
            $data['dstdrugs'] = $dstdrugs;
			$data['sendtolist'] = Master_addtest::select('*')->get();
			$data['addtestlist'] = DB::table('m_test_request')->select('id','name')->where('status',1)->get();
            //dd($data['addtestlist']);
			//dd($data['sample']);
            return view('admin.microbiologist.list',compact('data'));
    }
	public function ajaxMicrobiologistList(Request $request){
		 //dd($request->all());
		## Read value
		$draw = $_POST['draw'];
		$row = $_POST['start'];
		$rowperpage = $_POST['length']; // Rows display per page
		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = $_POST['search']['value']; // Search value  
        //dd($request->all());
		## Search 
		$searchQuery = "";
        if($searchValue != ''){
			   $searchQuery .= " and (t_service_log.enroll_label like '%".$searchValue."%' ) ";
		}
		
        ## Total number of records without filtering
		//DB::enableQueryLog();	
        $sel=DB::select("SELECT IFNULL(COUNT(distinct A.enroll_id),0) AS count FROM t_service_log A, t_microbiologist B
			WHERE B.service_id = A.service_id
			AND   B.sample_id = A.sample_id
			AND   B.enroll_id = A.enroll_id
			AND   A.status = 0 AND IFNULL(A.print_15a,1) = 1 
			AND   IFNULL(A.sent_to_nikshay,0) = 0 AND A.sent_to_nikshay_date IS NULL
			AND  A.service_id in (4,14,15, 17, 20, 21, 22)");
        //dd(DB::getQueryLog());
        //echo "<pre>"; print_r($sel);	echo "</pre>";	die();
	    $totalRecords =$sel[0]->count;
		//dd('totalRecords'.$totalRecords);	
		
        ## Total number of records with filtering
        //DB::enableQueryLog();			
		$sel=DB::select("SELECT IFNULL(COUNT(distinct t_service_log.enroll_id),0) AS count_filtered FROM t_service_log, t_microbiologist B
			WHERE B.service_id = t_service_log.service_id
			AND   B.sample_id = t_service_log.sample_id
			AND   B.enroll_id = t_service_log.enroll_id
			AND   t_service_log.status = 0 AND IFNULL(t_service_log.print_15a,1) = 1 
			AND   IFNULL(t_service_log.sent_to_nikshay,0) = 0 AND t_service_log.sent_to_nikshay_date IS NULL
			AND   t_service_log.service_id in (4,14,15, 17, 20, 21, 22)".$searchQuery);
				
		//dd(DB::getQueryLog());			  
		$totalRecordwithFilter = $sel[0]->count_filtered;
		//dd('totalRecordwithFilter'.$totalRecordwithFilter);
		## Fetch records
		//DB::enableQueryLog();
		/*$empQuery=ServiceLog::select(
                 's.id as ID','s.tag as tag','t_service_log.id as tslID','t_service_log.tag as stag','t_service_log.print_15a as print_15a','t_service_log.sent_to_nikshay as sent_to_nikshay','f.DMC_PHI_Name as facility_id',
                 'sample.id as sampleID','s.enroll_id as enroll','enrolls.label as enroll_l',
                 'sample.sample_label as samples','s.sample_id as sample','sample.name as p_name',
                 's.created_at as date','sample.sample_type', 'sample.test_reason',
                 's.service_id as service','s.next_step as next','s.detail as m_detail',
                 's.remark as m_remark','m.name as service_name','m.url','s.bwm as bwm_status',
                 'ci.mgit_id','ci.tube_id_lj','ci.tube_id_lc','ci.inoculation_date','ddt.id as lc_dst_tr_id','ddt.drug_ids as drug_ids',
                 'ldi.mgit_seq_id', 'ldi.dst_c_id1', 'ldi.dst_c_id2','ldi.dst_c_id3',
                 'patient.reg_by', 'sample.no_of_samples as no_of_samples','t_service_log.rec_flag',
                  DB::raw('date_format(ldi.inoculation_date,"%d-%m-%y")') )
                 ->leftJoin('t_microbiologist as s', function($join){
                    $join->on('s.sample_id', '=','t_service_log.sample_id');
                    $join->on('s.service_id', '=','t_service_log.service_id')
					->whereRaw(DB::raw("( CONCAT(CONVERT(s.service_id,CHAR(2)),s.next_step) NOT IN ('14Send Sample') )" ));
                })
                ->leftjoin('sample as sample','s.sample_id','=','sample.id')
                ->leftjoin('enrolls as enrolls','enrolls.id','=','sample.enroll_id')
                ->leftjoin('t_cbnaat as cbnaat','s.sample_id','=','cbnaat.sample_id')
                ->leftjoin('t_decontamination as d','s.sample_id','=','d.sample_id')
                ->leftjoin('req_test as rq','rq.enroll_id','=','s.enroll_id')
                ->leftjoin('m_dmcs_phi_relation as f','rq.facility_id','=','f.id')
                ->leftjoin('m_services as m','m.id','=','s.service_id')
                ->leftjoin('t_culture_inoculation as ci','ci.sample_id','=','s.sample_id')               
                ->leftjoin('t_lc_dst_inoculation as ldi','ldi.sample_id','=','s.sample_id')               
                ->leftjoin('t_dst_drugs_tr as ddt', function ($join) {
                     $join->on('ddt.enroll_id','=','s.enroll_id');
					 $join->on('ddt.service_id', '=','t_service_log.service_id');                        
                 })
                ->leftjoin('patient as patient','patient.id','=','enrolls.patient_id')               
				->where('t_service_log.sent_to_nikshay',0)
                ->where('t_service_log.sent_to_nikshay_date',null)
                ->where('t_service_log.status',0)
                //->where('t_service_log.print_15a',1)
				->whereIn('t_service_log.service_id',array(4,14,22,15,17,20,21))               
				->whereRaw(" t_service_log.print_15a=1 ".$searchQuery." group by sample.id,s.service_id,t_service_log.service_id,t_service_log.tag  limit ".$row.",".$rowperpage)
                ->get();*/
		$microQry=DB::select("select `s`.`id` as `ID`, `s`.`tag` as `tag`, `t_service_log`.`id` as `tslID`, `t_service_log`.`tag` as `stag`, 
			`t_service_log`.`print_15a` as `print_15a`, `t_service_log`.`sent_to_nikshay` as `sent_to_nikshay`,
			`f`.`DMC_PHI_Name` as `facility_id`, `sample`.`id` as `sampleID`,
			`s`.`enroll_id` as `enroll`, `enrolls`.`label` as `enroll_l`, 
			`sample`.`sample_label` as `samples`, `s`.`sample_id` as `sample`, 
			`sample`.`name` as `p_name`, `s`.`created_at` as `date`,
			`sample`.`sample_type`, `sample`.`test_reason`, 
			`s`.`service_id` as `service`, `s`.`next_step` as `next`, 
			`s`.`detail` as `m_detail`, `s`.`remark` as `m_remark`, 
			`m`.`name` as `service_name`, `m`.`url`, 
			`s`.`bwm` as `bwm_status`,`ddt`.`drug_ids` as `drug_ids`, 
			`patient`.`reg_by`, `sample`.`no_of_samples` as `no_of_samples`, `t_service_log`.`rec_flag` , date_format(ldi.inoculation_date,'%d-%m-%y') 
			from `t_service_log` left join `t_microbiologist` as `s` on `s`.`sample_id` = `t_service_log`.`sample_id` and `s`.`service_id` = `t_service_log`.`service_id` 
			and `s`.`enroll_id` = `t_service_log`.`enroll_id`  left join `sample` as `sample` on `t_service_log`.`sample_id` = `sample`.`id` 
			left join `enrolls` as `enrolls` on `enrolls`.`id` = `t_service_log`.`enroll_id`  
			left join `req_test` as `rq` on `rq`.`enroll_id` = `t_service_log`.`enroll_id` 
			left join `m_dmcs_phi_relation` as `f` on `rq`.`facility_id` = `f`.`id` 
			left join `m_services` as `m` on `m`.`id` = `t_service_log`.`service_id` 
			left join `patient` as `patient` on `patient`.`id` = `enrolls`.`patient_id`
			left join `t_cbnaat` as `cbnaat` on `s`.`sample_id` = `cbnaat`.`sample_id` and `s`.`enroll_id` = `cbnaat`.`enroll_id`
			left join `t_decontamination` as `d` on `s`.`sample_id` = `d`.`sample_id` and `s`.`enroll_id` = `d`.`enroll_id`
			left join `t_culture_inoculation` as `ci` on `s`.`sample_id` = `ci`.`sample_id`  and `s`.`enroll_id` = `ci`.`enroll_id`
			left join `t_lc_dst_inoculation` as `ldi` on `s`.`sample_id` = `ldi`.`sample_id` and `s`.`enroll_id` = `ldi`.`enroll_id`
			left join `t_dst_drugs_tr` as `ddt` on `s`.`enroll_id` = `ddt`.`enroll_id` and `s`.`service_id` = `ddt`.`service_id` 
			where `t_service_log`.`sent_to_nikshay` = 0 and `t_service_log`.`sent_to_nikshay_date` is null and `t_service_log`.`status` = 0 ".$searchQuery." 
			and `t_service_log`.`service_id` in (4,14,15, 17, 20, 21, 22) and  t_service_log.print_15a=1  
			and (CONCAT(CONVERT(s.service_id,CHAR(2)),s.next_step) NOT IN ('14Send Sample'))
			group by s.enroll_id, s.service_id, s.tag  ".$columnSortOrder." limit ".$row.",".$rowperpage);
			
		//dd($microQry);
		//dd(DB::getQueryLog());
		$test_requested = array();
		$services_col_color=array();
		$reqServ_service_id=array();
		foreach($microQry as $sampledata){
                //echo $sampledata->enroll_id; die;
                $reqServ_service_id[$sampledata->enroll]='';
                $services=RequestServices::select('service_id','enroll_id')->where('enroll_id',$sampledata->enroll)->get();
				//dd($services);
				if(count($services)>0){
				 $reqServ_service_id[$sampledata->enroll]=$services[0]->service_id;
				
                }
                $test_requested[$sampledata->enroll]='';
                $services_col_color[$sampledata->enroll]='N';
				//$result=array();
                //$data['existing_service_ids']=array();
                if(!$services->isEmpty()){ //echo "hi"; die;                    
                    $result=array();
                    $data['existing_service_ids']=array();
                    unset($result);//reinitialize array
					unset($data['existing_service_ids']);
                    foreach($services as $serv){
						//echo Config::get('m_services_array.tests')[5]; die();
                        $result[] = Config::get('m_services_array.tests')[$serv->service_id] ?? null; 
						if(isset(Config::get('m_services_array.tests')[$serv->service_id])&& !empty(Config::get('m_services_array.tests')[$serv->service_id])){
							 $data['existing_service_ids'][]=$serv->service_id;
						}else{
							 $data['existing_service_ids'][]='';
						}
                        //$data['existing_service_ids'][]=Config::get('m_services_array.tests')[$serv->service_id]?$serv->service_id:'';	                       										   
                    }
					//dd( $data['existing_service_ids']);
                    //dd($result);
                    //dd(count($result));
                    // comma in the array 
                    $test_requested[$sampledata->enroll] = implode(', ', $result); 
                    //dd($data);
                    //For display green colour for more than 1 services
                    if(count($result)>1)
                    {
                        $services_col_color[$sampledata->enroll]='Y';
                    }               
                    
                }
        }
		//dd($test_requested);
		//dd($reqServ_service_id);
	  $drugs = array();
	  $existing_drugs = array();
	  foreach ($microQry as $key => $value) {
	  if($value->drug_ids != ''){
		$drugids = explode(',',$value->drug_ids);
		$druglist = LCDSTDrugs::whereIn('id',$drugids)->pluck('name')->toArray();
		$value->druglist = implode(',',$druglist);
		$drugs = LCDSTDrugs::whereIn('id',$drugids)->get();
			unset($existing_drugs);
			foreach( $drugs as $dg){                        
				$existing_drugs[]=$dg->id;						
			}
		}
	  }
      //dd($existing_drugs);
		foreach ($microQry as $key => $value) {
            $value->no_sample = ServiceLog::where('enroll_id',$value->enroll)->where('service_id',11)->count();
        }
		
		$data = array();
		$draftRsltBtn="";
		$tdStyle="";
		$editBtn="";
		$editLink="";
		$retestBtn="";
		$addTestBtn="";
		$sendToNikshayBtn="";
		$currentStatusLink="";
		foreach($microQry as $key=>$samples){
			if(($samples->print_15a==1)&&($samples->sent_to_nikshay==0)){
				$draftRsltBtn="<a target='_blank' href=".url('interimview/'.$samples->sampleID)." class='btn btn-info btn-sm'>Draft Result</a>";
				$tdStyle=$services_col_color[$samples->enroll]=="Y"?'style="background-color:#ccffcc;width:100%;height:100%;display:block;"':"";
				$editBtn="<button type='button' onclick=\"openCbnaatForm1('".$samples->enroll."','".$samples->sample."','".$samples->service."','".$samples->samples."','".($samples->service==15?$samples->stag:NULL)."');\" class='btn btn-info btn-sm resultbtn'>View</button>";
				
				if($samples->service_name!='BWM'){
					if($samples->service_name=='LJ - DST Inoculation' || $samples->service_name=='LJ - DST 2nd Line')
					{
					  $editLink="<a href=\"#\" onclick=\"editResultForm('".$samples->sampleID."','".$samples->enroll."','".$samples->samples."','".$samples->service."','','".$samples->druglist."','".$samples->drug_ids."')\">Edit</a>";
					}else{						
					  $editLink="<a href=\"#\" onclick=\"editResultForm('".$samples->sampleID."','".$samples->enroll."','".$samples->samples."','".$samples->service."','".$samples->stag."','".(!empty($samples->druglist)?$samples->druglist:'')."','".(!empty($samples->drug_ids)?$samples->drug_ids:'')."')\">Edit</a>";
					}
				}
				$tag= (!empty($samples->stag))? $samples->stag : '';
				$retestBtn="<button type='button' onclick=\"openCbnaatFormRetest( '".$samples->enroll."','".$samples->samples."','".$samples->service."','".$samples->sampleID."','".$samples->bwm_status."','".$samples->no_sample."', '".$samples->reg_by."','".(($samples->service==14||$samples->service==15)?$samples->stag:NULL)."',".$samples->rec_flag.");\" class='btn btn-info btn-sm resultbtn' >Retest</button>";
				$addTestBtn="<button type='button' onclick=\"openCbnaatFormAddtest('".$samples->enroll."','".$samples->sample."','".$samples->service."','".$samples->samples."',".$samples->rec_flag.")\" class='btn btn-info btn-sm resultbtn addTestBtn' >Add Test</button>";
				$sendToNikshayBtn="<button type='button' onclick=\"openCbnaatFormNikshay('".$samples->tslID."','".$samples->enroll."','".$samples->sample."','".$samples->service."','".$samples->samples."','".$samples->enroll_l."','".($samples->service==15?$samples->stag:'')."',".$reqServ_service_id[$samples->enroll].")\" class='btn btn-info btn-sm resultbtn' >Submit</button>";
				$currentStatusLink="<a class='detail_modal' style='color:#1E88E5; cursor:pointer; font-size:12px;' onclick=\"getdetailsform(".$id=$samples->sampleID.",'".$enrolls_id=$samples->enroll."','".$sample_label=$samples->samples."')\">Show Status</a>";
				$data[] = array(
				     "ID"=>$samples->ID,
					 "enroll_id"=>$samples->enroll_l.'<br/>'.$samples->samples,
					 "patient_name"=>$samples->p_name,
					 "test_requested"=>'<span '.$tdStyle.' >'.$test_requested[$samples->enroll].'</span>',
					 "reason_for_test"=>$samples->test_reason,
					 "test_review"=>$samples->service==15?$samples->stag:$samples->service_name.'<br/>'.$draftRsltBtn,
					 "view_result"=>$editBtn."<br/>".$editLink,
					 "req_retest"=>$retestBtn,
					 "add_test"=>$addTestBtn,
					 "result_to_nikshay"=>$sendToNikshayBtn,
					 "referal_facility"=>$samples->facility_id,
					 "sample_type"=>$samples->sample_type,
					 "date_of_receipt"=>date('d/m/Y', strtotime($samples->date)),
					 "current_status"=>$currentStatusLink,
				   );
			}
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
    public function create()
    {
        //
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
         
		//dd($request->sentstep);
		//echo $request->enrollId1; die;
        $en_label = Enroll::select('label')->where('id', $request->enrollId1)->first();
        $s_id = Sample::select('id')->where('sample_label', $request->sampleid1)->first();

        //dd($s_id);
        $enroll_label = $en_label->label;
        // dd($request->sample);
        $sample_id = $s_id->id;
        //echo $sample_id; die;
        $data['report_type'] = Microbio::select('report_type')->where('sample_id', $sample_id)->whereIn('status', [0, 1])->first();
        //  dd($data['report_type']);
        if (!empty($request->sentstep)) {//Add test from microbiologist

            Microbio::where('enroll_id', $request->enrollId1)
                ->where('sample_id', $sample_id)
                ->where('service_id', $request->service1)
                ->update(['status' => 0]);

            $rec_flag=0;//For Add Test
            // If process comes from Cancel Process Page(Current Status Page), then remove
            // set the invalidate the status of old service log item.
            /*if($request->action === 'cancel-process'){
                ServiceLog::query()->where([
                    'enroll_id'  => $request->enrollId1,
                    'sample_id'  => $sample_id,
                    'service_id' => $request->service1,
                ])->update([
                    //'status' => ServiceLog::STATUS_INVALIDATE,
					'status' => 99,
                ]);
				
            }*/

            //For Another Sample update t_service_log
			ServiceLog::where('enroll_id', $request->enrollId1)
                ->where('sample_id', $sample_id)
                ->where('status', 2)
                ->update(['status' => 0]);
				
            foreach ($request->sentstep as $key => $sent_service) {//Add services and cancel-process from current Status Page
                $sent_service=$sent_service;
                
				//Coming from current status 
				$tag = '';
                $sent_service_arr = explode('-', $sent_service);
                if( count( $sent_service_arr ) > 1 ){

                    // Actual Sent Service -----
                    $sent_service = $sent_service_arr[0];

                    // Tag -----
                    $tag = $sent_service_arr[1];

                   if( $tag === 'LPA1' ){ $tag = '1st line LPA';}
                   if( $tag === 'LPA2' ){ $tag = '2nd line LPA';}
				   if( $tag === 'LC' ){ $tag = 'LC';}
                   if( $tag === 'LJ' ){ $tag = 'LJ';}
				   
                }
				
                if($sent_service==1||$sent_service==2){//MICROSCOPY
					$tag="MICROSCOPY";
				}
			    if($sent_service==4){//CBNAAT
				  $tag="CBNAAT";
			    }

                $status = ServiceLog::STATUS_ACTIVE;
               
				if($sent_service==3){//Decontamination
					$request->lpa_tag="DECONTAMINATION";
				}
				
				// If process comes from Cancel Process Page(Current Status Page), then remove
               // set the invalidate the status of old service log item.
				if($request->action === 'cancel-process'){                
				  $old_tag=ServiceLog::select('tag')->where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->where('service_id',$request->service1)->where('rec_flag',$request->rec_flag)->first();
				  //dd($old_tag);
				  ServiceLog::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->where('service_id',$request->service1)->where('tag','like',$old_tag->tag)->where('rec_flag',$request->rec_flag)->update(['status'=>ServiceLog::STATUS_INVALIDATE]);    
				  switch ($sent_service) {
					        case 1://Microsscopy
                                //ServiceLog::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->where('service_id',$request->service1)->where('tag','like',$old_tag->tag)->where('rec_flag',$request->rec_flag)->update(['status'=>ServiceLog::STATUS_INVALIDATE]);    
                                Microscopy::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->delete();
								Microbio::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->delete();
								break;
					        case 3://Decontamination
                                //ServiceLog::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->where('service_id',$request->service1)->where('tag','like',$old_tag->tag)->where('rec_flag',$request->rec_flag)->update(['status'=>ServiceLog::STATUS_INVALIDATE]);    
                                Decontamination::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->delete();
								Microbio::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->delete();
								break;
                            case 4://CBNAAT
                                //ServiceLog::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->where('service_id',$request->service1)->where('tag','like',$old_tag->tag)->where('rec_flag',$request->rec_flag)->update(['status'=>ServiceLog::STATUS_INVALIDATE]);  
                                Cbnaat::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->delete();
                                Microbio::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->delete();
								break;
							case 8://DNA EXTRACTION
                                //ServiceLog::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->where('service_id',$request->service1)->where('tag','like',$old_tag->tag)->where('rec_flag',$request->rec_flag)->update(['status'=>ServiceLog::STATUS_INVALIDATE]);    
                                DNAextraction::where('enroll_id',$request->enrollId1)->delete();
								Pcr::where('enroll_id',$request->enrollId1)->where('tag','like',$tag)->delete();
								Hybridization::where('enroll_id',$request->enrollId1)->where('tag','like',$tag)->delete(); 
                                break;	
							 case 12:  //PCR                              								
								 //ServiceLog::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->where('service_id',$request->service1)->where('tag','like',$old_tag->tag)->where('rec_flag',$request->rec_flag)->update(['status'=>ServiceLog::STATUS_INVALIDATE]);                                      
								 Pcr::where('enroll_id',$request->enrollId1)->where('tag','like',$tag)->delete();
								 Hybridization::where('enroll_id',$request->enrollId1)->where('tag','like',$tag)->delete();
                                 break; 	
                            case 14://HYBRIDIZATION
								 //ServiceLog::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->where('service_id',$request->service1)->where('tag','like',$old_tag->tag)->where('rec_flag',$request->rec_flag)->update(['status'=>ServiceLog::STATUS_INVALIDATE]); 
								 Hybridization::where('enroll_id',$request->enrollId1)->where('tag','like',$tag)->delete();
                                 break;
                             case 15://LPA INTERPRETATION
								 //ServiceLog::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->where('service_id',$request->service1)->where('tag','like',$old_tag->tag)->where('rec_flag',$request->rec_flag)->update(['status'=>ServiceLog::STATUS_INVALIDATE]); 
								 FinalInterpretation::where('enroll_id',$request->enrollId1)->where('tag','like',$tag)->delete();
								 if($tag == '1st line LPA'||$tag == '1st Line LPA'){                                        
									FirstLineLpa::where('enroll_id',$request->enrollId1)->where('tag','like',$tag)->delete();
                                 }
								 if($tag == '2nd line LPA'||$tag == '2nd Line LPA'){                                        
									SecondLineLpa::where('enroll_id',$request->enrollId1)->where('tag','like',$tag)->delete();
                                 }
								 Microbio::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->where('tag','like',$tag)->delete();
								break;								 
                            case 16: //LC or LJ
							        //ServiceLog::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->where('service_id',$request->service1)->where('tag','like',$old_tag->tag)->where('rec_flag',$request->rec_flag)->update(['status'=>ServiceLog::STATUS_INVALIDATE]); 
									Microbio::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->where('tag','like',$tag)->delete();
                                    CultureInoculation::where('enroll_id',$request->enrollId1)->delete();
									if($tag=='LC'){
										LCFlaggedMGIT::where('enroll_id',$request->enrollId1)->delete();
										LCFlaggedMGITFurther::where('enroll_id',$request->enrollId1)->delete();										
										LCDST::where('enroll_id',$request->enrollId1)->delete();
										LCDSTInoculation::where('enroll_id',$request->enrollId1)->delete();
									}
									else if($tag=='LJ'){
										DB::table('t_lj_detail')->where('enroll_id',$request->enrollId1)->delete();
										DB::table('t_lj_week_log')->where('enroll_id',$request->enrollId1)->delete();
										DB::table('t_lj_dst_reading')->where('enroll_id',$request->enrollId1)->delete();
										DB::table('t_lj_dst_inoculation')->where('enroll_id',$request->enrollId1)->delete();
									}else{
										LCFlaggedMGIT::where('enroll_id',$request->enrollId1)->delete();
										LCFlaggedMGITFurther::where('enroll_id',$request->enrollId1)->delete();										
										LCDST::where('enroll_id',$request->enrollId1)->delete();
										LCDSTInoculation::where('enroll_id',$request->enrollId1)->delete();
										
										DB::table('t_lj_detail')->where('enroll_id',$request->enrollId1)->delete();
										DB::table('t_lj_week_log')->where('enroll_id',$request->enrollId1)->delete();
										DB::table('t_lj_dst_reading')->where('enroll_id',$request->enrollId1)->delete();
										DB::table('t_lj_dst_inoculation')->where('enroll_id',$request->enrollId1)->delete();
									}
								 break;
                           
     
                    }
				
				$rec_flag=$request->rec_flag+1;
               }
                ServiceLog::create([
                    'enroll_id' => $request->enrollId1,
                    'sample_id' => $sample_id,
                    'enroll_label' => $enroll_label,
                    'sample_label' => $request->sampleid1,
                    'service_id' => $sent_service,
                    'reported_dt' => date('Y-m-d'),
                    'status' => $status,
                    'tag' => !empty($request->lpa_tag)?$request->lpa_tag:$tag,
					'rec_flag'=>$rec_flag,
                    'test_date' => date('Y-m-d H:i:s'),
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id
                ]);

            }
			//if drugs exist
            if(isset($request->drugs)){
               if(!empty($request->drugs['lcdst'])){//For LCDST
					$count_drug_exists=DSTDrugTR::where('enroll_id', $request->enrollId1)->where('service_id', 21)->where('status', 1)->count();
					$drug_str = implode(',',$request->drugs['lcdst']);
					 // dd($count_drug_exists);
					if($count_drug_exists < 1){

					  DSTDrugTR::create([
						'enroll_id' => $request->enrollId1,
						'sample_id' => '0',
						'service_id'=>21,
						'drug_ids' => $drug_str,
						'status' => 1,
						'flag' => 1,
						'created_by'=>$request->user()->id,
						'updated_by'=>$request->user()->id,
					  ]);
					}else{
					  DSTDrugTR::where('enroll_id',$request->enrollId1)->where('service_id', 21)->update(['drug_ids'=>$drug_str]);

					}
			   }
			   if(!empty($request->drugs['ljdst'])){//For LJDST
					$count_drug_exists=DSTDrugTR::where('enroll_id', $request->enrollId1)->where('service_id', 22)->where('status', 1)->count();
					$drug_str = implode(',',$request->drugs['ljdst']);
					 // dd($count_drug_exists);
					if($count_drug_exists < 1){

					  DSTDrugTR::create([
						'enroll_id' => $request->enrollId1,
						'sample_id' => '0',
						'service_id'=>22,
						'drug_ids' => $drug_str,
						'status' => 1,
						'flag' => 1,
						'created_by'=>$request->user()->id,
						'updated_by'=>$request->user()->id,
					  ]);
					}else{
					  DSTDrugTR::where('enroll_id',$request->enrollId1)->where('service_id', 22)->update(['drug_ids'=>$drug_str]);

					}
			   }
            }
			
			//if addtest exist
            if(isset($request->addtest)){
              foreach ($request->addtest as $key => $service_id) {
					$count_test_request_exists=RequestServices::where('enroll_id', $request->enrollId1)->where('service_id',$service_id)->count();
					
					//Fetch first row for updation with old values in the new inserted row other than enroll_id,test_req_id,service id
					$data_req_services=RequestServices::select('*')->where('enroll_id', $request->enrollId1)->first();
					
					
					if($count_test_request_exists < 1){

					  RequestServices::create([
						'enroll_id' => $request->enrollId1,
						'test_req_id' => '1',
						'service_id' =>$service_id,
						'requestor_name' =>$data_req_services->requestor_name,
						'designation' =>$data_req_services->designation,
						'contact_no' =>$data_req_services->contact_no,
						'email_id' =>$data_req_services->email_id,
						'diagnosis' =>$data_req_services->diagnosis,
						'duration' =>$data_req_services->duration,
						'rntcp_reg_no' =>$data_req_services->rntcp_reg_no,
						'regimen' =>$data_req_services->regimen,
						'reason' =>$data_req_services->reason,
						'post_treatment' =>$data_req_services->post_treatment,
						'other_post_treatment' =>$data_req_services->other_post_treatment,
						'pmdt_tb_no' =>$data_req_services->pmdt_tb_no,
						'month_week' =>$data_req_services->month_week,
						'treatment' =>$data_req_services->treatment,
						'ho_anti_tb' =>$data_req_services->ho_anti_tb,
						'no_of_hcp_visit' =>$data_req_services->no_of_hcp_visit,
						'history_previous_att' =>$data_req_services->history_previous_att,
						'specimen_type_test' =>$data_req_services->specimen_type_test,
						'visual_appearance_sputum' =>$data_req_services->visual_appearance_sputum,
						'specimen_type_other' =>$data_req_services->specimen_type_other,
						'type_of_prsmptv_drtb' =>$data_req_services->type_of_prsmptv_drtb,
						'presumptive_h' =>$data_req_services->presumptive_h,
						'prsmptv_xdrtv' =>$data_req_services->prsmptv_xdrtv,
						'PresumptiveDRTB' =>$data_req_services->PresumptiveDRTB,
						'regimen_fu' =>$data_req_services->regimen_fu,
						'fudrtb_regimen_other' =>$data_req_services->fudrtb_regimen_other,
						'facility_type_other' =>$data_req_services->facility_type_other,
						'lab_sample_label' =>$data_req_services->lab_sample_label,
						'request_date' => date('Y-m-d'),
						'created_on' => date('Y-m-d'),
						'created_by'=>$request->user()->id,
						'updated_on' => date('Y-m-d'),
						'updated_by'=>$request->user()->id,
					  ]);
					}
			  }
            }

            // Redirect back if action was "cancel-process"
            if( $request->action === 'cancel-process' ){
                return back();
            }


        }
// dd($request->all());


        // dd($get);
        if ($request->print15A == true) {
            $id = $sample_id;
            $pdf = null;



            // ------------------------------------------------------------
            //  Close all other tests for the sample from microbiologist. |
            // ------------------------------------------------------------

            Microbio::where('enroll_id', $request->enrollId1)
                ->where('sample_id', $sample_id)
                ->update([
                    'status' => 1,
                    'detail' => $request->detail,
                    'remark' => $request->remark,
                ]);

            // ------------------------------------------------------------
            // ------------------------------------------------------------



            $app_dt = date('d-m-Y');
            $data['today'] = $app_dt;
            $data['user'] = Microbio::query()
                    ->join('users', 'created_by', 'users.id')
                    ->where('sample_id', $id)
                    ->first()->name ?? '';


            $data['personal'] = Sample::select('sample.*', 'sample.id as smp_id', 'p.name as userName', 'p.*', 'e.*', 'd.name as district_name',
                's.name as state_name', 'r.rntcp_reg_no', 'r.regimen', 'r.reason as test_reason', 'r.requestor_name', 'r.designation',
                'r.contact_no as requestor_cno', 'r.email_id as requestor_email', 'ps.name as ps_name', 'r.duration', 'r.type_of_prsmptv_drtb',
                'r.prsmptv_xdrtv', 'r.presumptive_h', 'r.pmdt_tb_no', 'rs.diagnosis', 'p.population_other',
                'r.month_week', 'r.treatment', 'rs.regimen_fu', 'rs.fudrtb_regimen_other', 'rs.facility_type_other', 'r.req_test_type',
                'phi.name as phi_name', 'mtb.name as mtb', 'ft.name as f_name')
                ->leftjoin('req_test as r', 'r.enroll_id', '=', 'sample.enroll_id')
                ->leftjoin('m_predominan_symptom as ps', 'ps.symptom_id', '=', 'r.predmnnt_symptoms')
                ->leftjoin('enrolls as e', 'e.id', '=', 'sample.enroll_id')
                ->leftjoin('t_request_services as rs', 'rs.enroll_id', '=', 'sample.enroll_id')
                ->leftjoin('patient as p', 'p.id', '=', 'e.patient_id')
                ->leftjoin('m_phi as phi', 'phi.id', '=', 'p.phi')
                ->leftjoin('m_tb as mtb', 'mtb.id', '=', 'p.tb')
                ->leftjoin('district as d', 'd.id', '=', 'p.district')
                ->leftjoin('state as s', 's.STOCode', '=', 'p.state')
                ->leftjoin('facility_master as ft', 'ft.id', '=', 'r.facility_type')
                ->where('sample.id', $id)
                  ->first();

            //     dd($data['personal']);


            $data['microscopy_data'] = ServiceLog::select('m.*', 't_service_log.service_id', 't_service_log.sample_label')
                ->leftjoin('t_microscopy as m', 'm.sample_id', '=', 't_service_log.sample_id')
                ->where('t_service_log.enroll_id', $data['personal']->enroll_id)
                ->whereIn('t_service_log.service_id', [1, 2]) //->where('t_service_log.status',0)
                ->distinct()
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

                if (!empty($data['microscopy_data']->original)) {
                    // dd($data['microscopy_data'][]);


                    if ($data['microscopy_data']) {
                        $data['microscopy'] = $data['microscopy_data']->service_id;
                        $sample_type = substr($data['microscopy_data']->sample_label, -1);
                        if ($sample_type == 'A') {
                            $data['microscopyA'] = $data['microscopy_data'];
                            $data['microscopy'] = 1;
                            // dd($data['microscopyA']);
                        }
                        if ($sample_type == 'B') {
                            $data['microscopyB'] = $data['microscopy_data'];
                            $data['microscopy2'] = 2;
                        }
                    }
                }
            }
            // dd($data);


            $data['culturelj'] = LJDetail::leftjoin('sample as s', 's.id', '=', 't_lj_detail.sample_id')
                ->where('t_lj_detail.enroll_id', $data['personal']->enroll_id)
                ->where('t_lj_detail.status', 1)
                ->first();
            $data['culturelc'] = LCFlaggedMGITFurther::leftjoin('sample as s', 's.id', '=', 't_lc_flagged_mgit_further.sample_id')
                ->where('t_lc_flagged_mgit_further.enroll_id', $data['personal']->enroll_id)
                ->where('t_lc_flagged_mgit_further.status', 1)
                ->first();
            $data['culture'] = "";
            if ($data['culturelj']) {
                $data['culture'] = 1;
            }
            if ($data['culturelc']) {
                $data['culture'] = 2;
            }
            $data['date_receipt'] = Sample::select('receive_date')->where('id', $id)->first();
            $data['cbnaat'] = Cbnaat::leftjoin('sample as s', 's.id', '=', 't_cbnaat.sample_id')
                ->where('t_cbnaat.enroll_id', $data['personal']->enroll_id)
                //->where('t_cbnaat.status', 1)
                ->distinct()
                ->first();
            $data['lpa1'] = FirstLineLpa::where('enroll_id', $data['personal']->enroll_id)->where('status', 1)->first();
            $data['lpa2'] = SecondLineLpa::where('enroll_id', $data['personal']->enroll_id)->where('status', 1)->first();
            $data['lpaf'] = FinalInterpretation::where('enroll_id', $data['personal']->enroll_id)->where('status', 1)->first();
            $data['test_requested'] = RequestServices::where('enroll_id', $data['personal']->enroll_id)->pluck('service_id')->toArray();
            //dd($data['test_requested'] );
            Microbio::where('enroll_id', $data['personal']->enroll_id)->where('service_id', $request->service1)->update(['detail' => $request->detail, 'remark' => $request->remark]);

            $data['microbio'] = Microbio::where('enroll_id', $data['personal']->enroll_id)->get()->toArray();
            $replacement = array('detail' => $request->detail, 'remark' => $request->remark);
            $data['microbio'] = array_replace($data['microbio'][0], $replacement);
            // dd($data['microbio']);
            $data['lj_dst_fld'] = LjDstReading::select('drug_reading')->where('enroll_id', $data['personal']->enroll_id)->orderBy('id', 'DESC')
            ->distinct()
            ->first();

            $data['lc_dst'] = LCDST::select('drug_name as name', 'result as value')->where('enroll_id', $data['personal']->enroll_id)
            ->orderBy('id', 'DESC')
            ->distinct()
            ->get();

            //$dil = json_decode($data['lj_dst_fld']);
            $data['s'] = "";
            $data['H(inh A)'] = "";
            $data['H(Kat G)'] = "";
            $data['r'] = "";
            $data['e'] = "";
            $data['z'] = "";
            $data['km'] = "";
            $data['cm'] = "";
            $data['am'] = "";
            $data['lfx'] = "";
            $data['mfx1'] = "";
            $data['mfx2'] = "";
            $data['pas'] = "";
            $data['lzd'] = "";
            $data['cfz'] = "";
            $data['eto'] = "";
            $data['clr'] = "";
            $data['azi'] = "";
			$data['BDQ'] = "";
            foreach ($data['lc_dst'] as $key => $value) {
                if ($value->name == "S") {
                    $data['s'] = $value->value;
                }
                if ($value->name == "H(inh A)") {
                    $data['H(inh A)'] = $value->value;
                }
                if ($value->name == "H(Kat G)") {
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
                if ($value->name == "Mfx(0.5)") {
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
				 if ($value->name == "BDQ") {
                    $data['BDQ'] = $value->value;

                }
            }
            if ($data['lj_dst_fld']) {
                $dil = json_decode($data['lj_dst_fld']->drug_reading);
                if (isset($dil->dil_2)) {
                    foreach ($dil->dil_2 as $key => $value) {
                        if ($value->name == "S") {
                            $data['s'] = $value->value;
                        }
                        if ($value->name == "H(inh A)") {
                            $data['H(inh A)'] = $value->value;
                        }
                        if ($value->name == "H(Kat G)") {
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
                        if ($value->name == "Mfx(0.5)") {
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
						 if ($value->name == "BDQ") {
                            $data['BDQ'] = $value->value;

                        }
                    }
                } else {
                    foreach ($dil->dil_4 as $key => $value) {
                        if ($value->name == "S") {
                            $data['s'] = $value->value;
                        }
                        if ($value->name == "H(inh A)") {
                            $data['H(inh A)'] = $value->value;
                        }
                        if ($value->name == "H(Kat G)") {
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
                        if ($value->name == "Mfx(0.5)") {
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
						 if ($value->name == "BDQ") {
                            $data['BDQ'] = $value->value;

                        }
                    }

                }
            }

//dd($data);

            if ($pdf == "pdf") {
                $pdfname = $data['personal'] ? $data['personal']->userName : "pdfview";
                $elabel = $data['personal'] ? $data['personal']->label : "";
                $pdffilename = $elabel . "" . substr($pdfname, 0, 5) . ".pdf";
                $pdf = PDF::loadView('admin.sample.pdf view', compact('data'));
                return $pdf->download($pdffilename);
            }

            //$data_decoded = json_decode($data);
            // /  dd($data);

            $lab_id = DB::table('m_configuration')->select('lab_code as ID')->where('status', 1)->first();
            //  dd($lab_id);
            if ($lab_id) {
                DB::table('t_15aformdata')->insert(
                    ['sample_id' => $id,
                        'enroll_id' => $request->enrollId1,
                        'lab_id' => $lab_id->ID,
                        'ismoved' => 0,
                        '15Aresult' => json_encode($data),
                        'patient_name' => $data['personal']->userName,
                        'created_at' => date('Y-m-d')
                    ]
                );
            }
// dd("hi2");
            // dd(json_encode($data));
            $print15A = 1;
            if (!empty($data['report_type']->report_type)) {
                $report_type = $data['report_type']->report_type;
            } else {
                $report_type = 'End Of Report';
            }


        } else {

            $print15A = 0;
            if (!empty($data['report_type']->report_type)) {

                $report_type = $data['report_type']->report_type;

            } else {
                // dd("empty");
                $report_type = 'Interim Report';
            }

        }

        if ($request->type == 'drug') {
            // dd('hi');
            //dd($request->all());
            if ($request->drugs) {
                $count_drug_exists = DSTDrugTR::where('enroll_id', $request->enrollId1)->where('status', 1)->count();
                $drug_str = implode(',', $request->drugs);
                if ($count_drug_exists < 1) {
                    DSTDrugTR::create([
                        'enroll_id' => $request->enrollId1,
                        'sample_id' => '0',
                        'drug_ids' => $drug_str,
                        'status' => 1,
                        'flag' => 1,
                        'created_by' => $request->user()->id,
                        'updated_by' => $request->user()->id,
                    ]);
                } else {
                    DSTDrugTR::where('enroll_id', $request->enrollId1)->update(['drug_ids' => $drug_str]);

                }
                return redirect('/microbiologist');
            }

        }

        if ($request->type == 1) {
            return redirect('/microbiologist');
        }

        //dd($request->all());
        //$next_step = Service::select('id as id')->where('name',$request->nextStep)->first();
        // dd(Microbio::create([
        //     'enroll_id' => $request->enrollId1,
        //     'sample_id' => $sample_id,
        //     'service_id' => $request->service1,
        //     'next_step' => $request->nextStep,
        //     'detail' => $request->detail,
        //     'remark' => $request->remark,
        //     'reason_bwm' => $request->reason_bwm,
        //     'reason_other' => $request->reason_other,
        //     'status' => 1,
        //     'print_15a' => $print15A,
        //     'report_type' => $report_type,
        //     'created_by' => Auth::user()->id,
        //      'updated_by' => Auth::user()->id
        //   ]));

// dd($sample_id);
         ////blocked by Amrita on 25/05/2020
        /*$get = Microbio::where('enroll_id', $request->enrollId1)->where('sample_id', $sample_id)->where('service_id', $request->service1)->count();
        //     dd($request->all());
//  dd($get);
        if ($get > 0) {
            //echo "if"; die;
            $qry = "Select `id` from `t_microbiologist` where `enroll_id` = $request->enrollId1 and `sample_id` = $sample_id ORDER BY `created_at` ASC LIMIT 0,1";
            $query = DB::select(DB::raw($qry));
            $microid = $query[0]->id;
            if (!empty($microid)) {
               // Microbio::where('id', $microid)->delete();
            }

            $qry1 = "Select `id` from `t_microbiologist` where `enroll_id` = $request->enrollId1 and `sample_id` = $sample_id";
            $query1 = DB::select(DB::raw($qry1));
            $microid1 = $query1[0]->id;
            $app_dt = date('d-m-Y');
            
			//blocked by Amrita on 25/05/2020
            //Microbio::where('id', $microid1)->update(['detail' => $request->detail, 'remark' => $request->remark, 'status' => 1, 'approved_date' => $app_dt]);

        } else {
            // dd($request->all());
            $app_dt = date('d-m-Y');
            //dd("else");
            //  dd($app_dt);
            //Microbio::where('enroll_id', $request->enrollId1)->where('sample_id', $sample_id)->where('service_id', $request->service1)->delete();
            if(isset($request->lpa_tag) && !empty($request->lpa_tag)){
                $tagg=$request->lpa_tag;
            }else{
                $tagg='';
            }

            $microbio = Microbio::create([
                'enroll_id' => $request->enrollId1,
                'sample_id' => $sample_id,
                'service_id' => $request->service1,
                'next_step' => $request->nextStep,
                'detail' => $request->detail,
                'remark' => $request->remark,
                'reason_bwm' => $request->reason_bwm,
                'reason_other' => $request->reason_other,
                'status' => 1,
                'tag'=>$tagg,
                'print_15a' => $print15A,
                'report_type' => $report_type,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
                'approved_date' => $app_dt
            ]);
//              dd($microbio);

        }*/
        // $get->delete();

        //dd($request->all());
        if ($request->nextStep == 'Request for Retest'){ //Retest here
			//dd($request->all());

            if (($request->service1 == 15) || ($request->service1 == 14)) {
                $nextService = 8;
            }
            elseif ($request->service1 == 21) {
                $nextService = 16;
            }else{
                $nextService = $request->service1;
            }

            //dd($request->all());
            $log_serviceLog = ServiceLog::where('enroll_id', $request->enrollId1)->
            where('sample_id', $sample_id)->
            where('service_id', $nextService)->first();		

            $log = ServiceLog::where('enroll_id', $request->enrollId1)->where('service_id', 11)->first();
             //dd($log);
			 //dd($log_serviceLog);
			 
			 $get_rec_flag_serviceLog = ServiceLog::where('enroll_id', $request->enrollId1)->where('service_id', $request->service1)->orderBy('id', 'DESC')->first();
			
			//echo $get_rec_flag_serviceLog->rec_flag; die;
			
			 $get_rec_flag_log = ServiceLog::where('enroll_id', $request->enrollId1)->where('service_id', 11)->orderBy('id', 'DESC')->first();
			
            if ($log && $request->service1 == 26 && $request->service1 != 21) {
				//Update the last one old status to 99
				ServiceLog::where('enroll_id', $request->enrollId1)->where('service_id', 11)->orderBy('id', 'DESC')->update(['status'=>99]);			
				
				
				//Insert in to service log
                $log->service_id = $nextService;
                $log->status = 1;
				$log->rec_flag = $get_rec_flag->rec_flag+1;
                $log->updated_by = $request->user()->id;
                $data = $log;
                $log->save();

            }
            // elseif(!$log && $request->service1!=26 && $request->service1!=21){
            //     ServiceLog::create([
            //                 'enroll_id' => $request->enrollId1,
            //                 'sample_id' => $sample_id,
            //                 'enroll_label' => $enroll_label,
            //                 'sample_label' => $request->sampleid1,
            //                 'service_id' => $nextService,
            //                 'status' => 1,
            //                 'tag' => '',
            //                 'test_date' => date('Y-m-d H:i:s'),
            //                 'created_by' => Auth::user()->id,
            //                 'updated_by' => Auth::user()->id
            //         ]);
            //       }
            elseif ($request->service1 != 26) {
               
                if($request->retest_type == 'true'){ //retest with same  sample
					   // echo "retest"; 
					  // dd($request->all());
					   //dd($log);
					   //dd($log_serviceLog);
					   //echo $log_serviceLog->rec_flag; die;
                        $old_sample = Sample::select('sample_label')
                        ->where('id', $sample_id)
                        ->distinct()
                        ->first();

                        $new_sample = $old_sample->sample_label . 'R';
                        Sample::where('id', $sample_id)->update(['sample_label' => $new_sample]);

                            switch ($request->service1) {
                            case 4:
                                ServiceLog::where('sample_id',$sample_id)->where('service_id',$request->service1)->where('rec_flag',$request->rec_flag)->update(['status'=>99]);    
                                Microbio::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->where('service_id',$request->service1)->delete();
                                Cbnaat::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->delete();

                                break;
							 case 14:
                                if(isset($request->lpa_tag) && !empty($request->lpa_tag)){
									//echo $request->enrollId1; die;
                                     ServiceLog::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->where('service_id',$request->service1)->where('tag','like',$request->lpa_tag)->where('rec_flag',$request->rec_flag)->update(['print_15a'=>0,'status'=>99]);                                      
                                     Microbio::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->where('tag','like',$request->lpa_tag)->delete();									 
									
                                     Hybridization::where('enroll_id',$request->enrollId1)->where('tag','like',$request->lpa_tag)->delete();                                    
									 Pcr::where('enroll_id',$request->enrollId1)->where('tag','like',$request->lpa_tag)->delete();
									 
									 if($request->retest_sent_to==8){//DNA EXTRACTION									 
									   DNAextraction::where('enroll_id',$request->enrollId1)->delete();
                                     }
                                     
                                }
                                 break; 	
                            case 15:
                                if(isset($request->lpa_tag) && !empty($request->lpa_tag)){
									//echo $request->enrollId1; die;
                                     ServiceLog::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->where('service_id',$request->service1)->where('tag','like',$request->lpa_tag)->where('rec_flag',$request->rec_flag)->update(['print_15a'=>0,'status'=>99]); 
                                     //FinalInterpretation::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->where('tag','like',$request->lpa_tag)->delete();
									 FinalInterpretation::where('enroll_id',$request->enrollId1)->where('tag','like',$request->lpa_tag)->delete();
                                     /*Microbio::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->where('sample_id',$sample_id)->where('tag','like',$request->lpa_tag)->delete(); */  
                                     Microbio::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->where('tag','like',$request->lpa_tag)->delete();									 
									// Hybridization::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->delete(); 
                                     Hybridization::where('enroll_id',$request->enrollId1)->where('tag','like',$request->lpa_tag)->delete();                                    
									 Pcr::where('enroll_id',$request->enrollId1)->where('tag','like',$request->lpa_tag)->delete();
									 
									 if($request->retest_sent_to==8){//DNA EXTRACTION
									   //DNAextraction::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->delete();
									   DNAextraction::where('enroll_id',$request->enrollId1)->delete();
                                     }
									 
                                     if($request->lpa_tag == '1st line LPA'||$request->lpa_tag == '1st Line LPA'){
                                        //FirstLineLpa::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->where('tag','like',$request->lpa_tag)->delete();
										FirstLineLpa::where('enroll_id',$request->enrollId1)->where('tag','like',$request->lpa_tag)->delete();
                                     }else{
                                        //SecondLineLpa::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->where('tag','like',$request->lpa_tag)->delete();
										SecondLineLpa::where('enroll_id',$request->enrollId1)->where('tag','like',$request->lpa_tag)->delete();
                                     }
                                }
                                 break; 
                            case 17: 
							    //if(isset($request->lj_lc_tag) && !empty($request->lj_lc_tag)){    
                                     $nextService=16;   
                                     //ServiceLog::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->where('service_id',$request->service1)->where('tag','like','LC')->update(['print_15a'=>0,'status'=>99]);   
                                     ServiceLog::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->where('tag','like','LC')->update(['print_15a'=>0,'status'=>99]);                                      									 
                                     //Microbio::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->where('sample_id',$sample_id)->delete();
									 Microbio::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->delete();
                                     //LCFlaggedMGIT::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->delete();
									 LCFlaggedMGIT::where('enroll_id',$request->enrollId1)->delete();
                                     //LCFlaggedMGITFurther::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->delete();
									 LCFlaggedMGITFurther::where('enroll_id',$request->enrollId1)->delete();
                                     //CultureInoculation::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->delete();
									 CultureInoculation::where('enroll_id',$request->enrollId1)->delete();
                                //}
                                break;
                            case 20: 
                                     $nextService=16;   
                                     //ServiceLog::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->where('service_id',$request->service1)->where('tag','like','LJ')->update(['print_15a'=>0,'status'=>99]);                                      
                                     ServiceLog::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->where('tag','like','LJ')->update(['print_15a'=>0,'status'=>99]);                                      
									 //Microbio::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->where('sample_id',$sample_id)->delete();
									 Microbio::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->delete();
                                    // DB::table('t_lj_detail')->where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->delete();
                                     DB::table('t_lj_detail')->where('enroll_id',$request->enrollId1)->delete();
                                     //DB::table('t_lj_week_log')->where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->delete();
                                     DB::table('t_lj_week_log')->where('enroll_id',$request->enrollId1)->delete();
                                     //CultureInoculation::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->delete();
                                     CultureInoculation::where('enroll_id',$request->enrollId1)->delete();
                                break;      
                            case 21: //LC
                                     $nextService=16;   
                                     //ServiceLog::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->where('service_id',$request->service1)->where('tag','like','LC')->update(['print_15a'=>0,'status'=>99]);
                                     ServiceLog::where('enroll_id',$request->enrollId1)->where('service_id',17)->where('tag','like','LC')->update(['print_15a'=>0,'status'=>99]);
									 ServiceLog::where('enroll_id',$request->enrollId1)->where('service_id',21)->where('tag','like','LC')->update(['print_15a'=>0,'status'=>99]);
									 if(isset($request->microbio_comments) && !empty($request->microbio_comments)){
                                        $drug_ids=implode(',',$request->updated_drugs);
                                        // dd($drug_ids);
                                       DSTDrugTR::where('enroll_id',$request->enrollId1)->where('service_id', $request->service1)->update(['drug_ids'=>$drug_ids,'microbiologist_comments'=>$request->microbio_comments]);
                                        
                                     }
                                     //LCDST::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->delete();
									 LCDST::where('enroll_id',$request->enrollId1)->delete();
                                     //Microbio::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->where('sample_id',$sample_id)->delete();
									 Microbio::where('enroll_id',$request->enrollId1)->where('service_id',17)->delete();
									 Microbio::where('enroll_id',$request->enrollId1)->where('service_id',21)->delete();
                                     //LCFlaggedMGIT::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->delete();
									 LCFlaggedMGIT::where('enroll_id',$request->enrollId1)->delete();
                                     //LCFlaggedMGITFurther::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->delete();
									 LCFlaggedMGITFurther::where('enroll_id',$request->enrollId1)->delete();
                                     //CultureInoculation::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->delete();
									 CultureInoculation::where('enroll_id',$request->enrollId1)->delete();
									 //LCDSTInoculation::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->delete();
									 LCDSTInoculation::where('enroll_id',$request->enrollId1)->delete();
                                break;

                                case 22: //LJ
                                     $nextService=16;   
                                     //ServiceLog::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->where('service_id',$request->service1)->where('tag','like','LJ')->update(['print_15a'=>0,'status'=>99]);
									 ServiceLog::where('enroll_id',$request->enrollId1)->where('service_id',20)->where('tag','like','LJ')->update(['print_15a'=>0,'status'=>99]);
									 ServiceLog::where('enroll_id',$request->enrollId1)->where('service_id',22)->where('tag','like','LJ')->update(['print_15a'=>0,'status'=>99]);
                                     if(isset($request->microbio_comments) && !empty($request->microbio_comments)){
                                        $drug_ids=implode(',',$request->updated_drugs);
                                        // dd($drug_ids);
                                        DSTDrugTR::where('enroll_id',$request->enrollId1)->where('service_id',  $request->service1)->update(['drug_ids'=>$drug_ids,'microbiologist_comments'=>$request->microbio_comments]);

                                     }
                                     //Microbio::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->where('sample_id',$sample_id)->delete();
                                     Microbio::where('enroll_id',$request->enrollId1)->where('service_id',20)->delete();
									 Microbio::where('enroll_id',$request->enrollId1)->where('service_id',22)->delete();
                                     //DB::table('t_lj_detail')->where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->delete();
                                     DB::table('t_lj_detail')->where('enroll_id',$request->enrollId1)->delete();
									 
                                     //DB::table('t_lj_week_log')->where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->delete();
									 DB::table('t_lj_week_log')->where('enroll_id',$request->enrollId1)->delete();
                                    
                                     //DB::table('t_lj_dst_reading')->where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->delete();
									 DB::table('t_lj_dst_reading')->where('enroll_id',$request->enrollId1)->delete();

                                     //DB::table('t_lj_dst_inoculation')->where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->delete();
									 DB::table('t_lj_dst_inoculation')->where('enroll_id',$request->enrollId1)->delete();
                                      
                                     //CultureInoculation::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->delete();
									 CultureInoculation::where('enroll_id',$request->enrollId1)->delete();
                                break;  
     
                    }
                        
                       
                        //ServiceLog::where('sample_id',$sample_id)->update(['sample_label'=>$new_sample]);
                             // dd($request->lpa_tag);
							 $tag="";
							 if(!empty($request->lpa_tag)){
								$tag= $request->lpa_tag;
							 }elseif(!empty($request->lj_lc_tag)){
								 $tag=$request->lj_lc_tag;
							 }
							//dd($tag);
							if($tag==""){
								if($request->retest_sent_to==4){
									$tag="CBNAAT";
								}else if($request->retest_sent_to==8){
									$tag="1st line LPA";
								}/*else if($request->retest_sent_to==12){
									$tag="PCR";
								}*/else if($request->retest_sent_to==16){
									$tag="LC";
								}else if($request->retest_sent_to==21){
									$tag="LC";
								}else if($request->retest_sent_to==22){
									$tag="LJ";
								}
							}
							
                            ServiceLog::create([
                            'enroll_id' => $request->enrollId1,
                            'sample_id' => $sample_id,
                            'enroll_label' => $enroll_label,
                            'sample_label' => $request->sampleid1 . 'R',
                            /*'service_id' => $nextService,*/
							'service_id' => $request->retest_sent_to,
                            'status' => 1,
                            'reported_dt' => date('Y-m-d'),
                            'tag' => $tag,
                            'test_date' => date('Y-m-d H:i:s'),
                            'created_by' => Auth::user()->id,
                            'updated_by' => Auth::user()->id,
							'rec_flag' => $get_rec_flag_serviceLog->rec_flag+1
                        ]);

                }else{ //retest another sample
                        //echo $sample_id;
                       //dd($request->all());
                        if($log){
                            $enroll= Sample::select('enroll_id')
                            ->where('id', $sample_id)
                            ->distinct()
                            ->first();
                            $enroll_id=$enroll->enroll_id;//new enroll_id
                            // dd($enroll_id);
							
                            $storage_sample = ServiceLog::select('sample_label')
                            ->where('enroll_id', $enroll_id)
							->where('service_id',11)
                            ->distinct()
                            ->first();							
                            // dd($storage_sample->sample_label);
							
                            $new_sample = $storage_sample->sample_label;
                            // Sample::where('id', $sample_id)->update(['sample_label' => $new_sample]);
							
                            //$new_sample_id= ServiceLog::select('id')
							$new_sample_id= ServiceLog::select('sample_id')
                            ->where('sample_label', $new_sample)->where('service_id',11)
                            ->distinct()
                            ->first();
							
                            //$new_sample_id=$new_sample_id->id;
                            $new_sample_id=$new_sample_id->sample_id;
							
							$old_sample_qry = Sample::select('id')
                            ->where('enroll_id', $enroll_id)->where('service_id',"!=",11)
                            ->distinct()
                            ->first();							
                           
							
                            $old_sample_id = $old_sample_qry->id;
							
                            //For Another Sample update t_service_log
							ServiceLog::where('enroll_id', $request->enrollId1)
								->where('sample_id',$new_sample_id)
								->where('status', 2)
								->update(['status' => 0]);
								
                            switch ($request->service1) {
                            case 4:
                                  //ServiceLog::where('enroll_id',$request->enrollId1)->where('sample_id',$old_sample_id)->where('service_id',$request->service1)->where('rec_flag',$request->rec_flag)->update(['status'=>99]);    
                                //Microbio::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->where('service_id',$request->service1)->delete();
                                  //Cbnaat::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->delete();
                                  //Microbio::where('enroll_id',$request->enrollId1)->where('sample_id',$old_sample_id)->where('service_id',$request->service1)->delete();
								 //Cbnaat::where('enroll_id',$request->enrollId1)->where('sample_id',$old_sample_id)->delete();
								  ServiceLog::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->where('rec_flag',$request->rec_flag)->update(['status'=>99]);    
								  Microbio::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->delete();
                                  Cbnaat::where('enroll_id',$request->enrollId1)->delete();
								  if($request->retest_sent_to==1 || $request->retest_sent_to==2){
									  Microscopy::where('enroll_id',$request->enrollId1)->delete(); 
								  }
                                break;
							case 14:
                                if(isset($request->lpa_tag) && !empty($request->lpa_tag)){
                                     ServiceLog::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->where('tag','like',$request->lpa_tag)->where('rec_flag',$request->rec_flag)->update(['print_15a'=>0,'status'=>99]); 
									 Microbio::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->where('tag','like',$request->lpa_tag)->delete();
                                     DNAextraction::where('enroll_id',$request->enrollId1)->delete();
                                     Hybridization::where('enroll_id',$request->enrollId1)->where('tag','like',$request->lpa_tag)->delete();
                                     Pcr::where('enroll_id',$request->enrollId1)->where('tag','like',$request->lpa_tag)->delete();                                     
									 if($request->retest_sent_to==1 || $request->retest_sent_to==2){
									  Microscopy::where('enroll_id',$request->enrollId1)->delete(); 
								    }
                                }
                                 break; 	
                            case 15:
                                if(isset($request->lpa_tag) && !empty($request->lpa_tag)){
                                     //ServiceLog::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->where('service_id',$request->service1)->where('tag','like',$request->lpa_tag)->where('rec_flag',$request->rec_flag)->update(['print_15a'=>0,'status'=>99]); 
                                     //Microbio::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->where('sample_id',$old_sample_id)->where('tag','like',$request->lpa_tag)->delete();
									 //FinalInterpretation::where('enroll_id',$request->enrollId1)->where('sample_id',$old_sample_id)->where('tag','like',$request->lpa_tag)->delete();
									 //DNAextraction::where('enroll_id',$request->enrollId1)->where('sample_id',$old_sample_id)->delete();
									 //Hybridization::where('enroll_id',$request->enrollId1)->where('sample_id',$old_sample_id)->delete();
									 ServiceLog::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->where('tag','like',$request->lpa_tag)->where('rec_flag',$request->rec_flag)->update(['print_15a'=>0,'status'=>99]); 
									 Microbio::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->where('tag','like',$request->lpa_tag)->delete();
                                     FinalInterpretation::where('enroll_id',$request->enrollId1)->where('tag','like',$request->lpa_tag)->delete();
                                     DNAextraction::where('enroll_id',$request->enrollId1)->delete();
                                     Hybridization::where('enroll_id',$request->enrollId1)->where('tag','like',$request->lpa_tag)->delete();
                                     Pcr::where('enroll_id',$request->enrollId1)->where('tag','like',$request->lpa_tag)->delete();
                                     if($request->lpa_tag == '1st line LPA'){
                                        //FirstLineLpa::where('enroll_id',$request->enrollId1)->where('tag','like',$request->lpa_tag)->where('sample_id',$old_sample_id)->delete();
										FirstLineLpa::where('enroll_id',$request->enrollId1)->where('tag','like',$request->lpa_tag)->delete();
                                     }else{
                                        //SecondLineLpa::where('enroll_id',$request->enrollId1)->where('sample_id',$old_sample_id)->where('tag','like',$request->lpa_tag)->delete();
										SecondLineLpa::where('enroll_id',$request->enrollId1)->where('tag','like',$request->lpa_tag)->delete();
                                     }
									 if($request->retest_sent_to==1 || $request->retest_sent_to==2){
									  Microscopy::where('enroll_id',$request->enrollId1)->delete(); 
								    }
                                }
                                 break; 
                            case 17:
                                     $nextService=16;   
                                     //ServiceLog::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->where('service_id',$request->service1)->where('tag','like','LC')->update(['print_15a'=>0,'status'=>99]);                                      
                                     //Microbio::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->where('sample_id',$old_sample_id)->delete();
                                     //LCFlaggedMGIT::where('enroll_id',$request->enrollId1)->where('sample_id',$old_sample_id)->delete();
                                     ///LCFlaggedMGITFurther::where('enroll_id',$request->enrollId1)->where('sample_id',$old_sample_id)->delete();
                                     //CultureInoculation::where('enroll_id',$request->enrollId1)->where('sample_id',$old_sample_id)->delete();
                                     
									 ServiceLog::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->where('tag','like','LC')->update(['print_15a'=>0,'status'=>99]);  
									 Microbio::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->delete();                                    
									 LCFlaggedMGIT::where('enroll_id',$request->enrollId1)->delete();                                    
									 LCFlaggedMGITFurther::where('enroll_id',$request->enrollId1)->delete();                                   
									 CultureInoculation::where('enroll_id',$request->enrollId1)->delete();
                                break;
                            case 20:
                                     $nextService=16;   
                                     //ServiceLog::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->where('service_id',$request->service1)->where('tag','like','LJ')->update(['print_15a'=>0,'status'=>99]);                                      
                                     //Microbio::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->where('sample_id',$old_sample_id)->delete();
                                     //DB::table('t_lj_detail')->where('enroll_id',$request->enrollId1)->where('sample_id',$old_sample_id)->delete();

                                     //DB::table('t_lj_week_log')->where('enroll_id',$request->enrollId1)->where('sample_id',$old_sample_id)->delete();

                                     //CultureInoculation::where('enroll_id',$request->enrollId1)->where('sample_id',$old_sample_id)->delete();
									 
									ServiceLog::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->where('tag','like','LJ')->update(['print_15a'=>0,'status'=>99]);                                      
									Microbio::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->delete();                                    
								    DB::table('t_lj_detail')->where('enroll_id',$request->enrollId1)->delete();                                     
								    DB::table('t_lj_week_log')->where('enroll_id',$request->enrollId1)->delete();                                     
								    CultureInoculation::where('enroll_id',$request->enrollId1)->delete();
                                
                                break;      
                            case 21:
                                     $nextService=16;   
                                     /*ServiceLog::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->where('service_id',$request->service1)->where('tag','like','LC')->update(['print_15a'=>0,'status'=>99]);
                                     if(isset($request->microbio_comments) && !empty($request->microbio_comments)){
                                        $drug_ids=implode(',',$request->updated_drugs);
                                        // dd($drug_ids);
                                        DSTDrugTR::where('enroll_id',$request->enrollId1)->where('service_id', $request->service1)->update(['drug_ids'=>$drug_ids,'microbiologist_comments'=>$request->microbio_comments]);

                                     }
                                     LCDST::where('enroll_id',$request->enrollId1)->where('sample_id',$old_sample_id)->delete();
                                     Microbio::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->where('sample_id',$old_sample_id)->delete();
                                     LCFlaggedMGIT::where('enroll_id',$request->enrollId1)->where('sample_id',$old_sample_id)->delete();
                                     LCFlaggedMGITFurther::where('enroll_id',$request->enrollId1)->where('sample_id',$old_sample_id)->delete();
                                     CultureInoculation::where('enroll_id',$request->enrollId1)->where('sample_id',$old_sample_id)->delete();
									 LCDSTInoculation::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->delete();*/
									 
									 
									 ServiceLog::where('enroll_id',$request->enrollId1)->where('service_id',17)->where('tag','like','LC')->update(['print_15a'=>0,'status'=>99]);
									 ServiceLog::where('enroll_id',$request->enrollId1)->where('service_id',21)->where('tag','like','LC')->update(['print_15a'=>0,'status'=>99]);
									 if(isset($request->microbio_comments) && !empty($request->microbio_comments)){
                                        $drug_ids=implode(',',$request->updated_drugs);
                                        // dd($drug_ids);
                                       DSTDrugTR::where('enroll_id',$request->enrollId1)->where('service_id', $request->service1)->update(['drug_ids'=>$drug_ids,'microbiologist_comments'=>$request->microbio_comments]);
                                        
                                     }
									 LCDST::where('enroll_id',$request->enrollId1)->delete();                                     
									 Microbio::where('enroll_id',$request->enrollId1)->where('service_id',17)->delete();
									 Microbio::where('enroll_id',$request->enrollId1)->where('service_id',21)->delete();                                    
									 LCFlaggedMGIT::where('enroll_id',$request->enrollId1)->delete();                                    
									 LCFlaggedMGITFurther::where('enroll_id',$request->enrollId1)->delete();                                    
									 CultureInoculation::where('enroll_id',$request->enrollId1)->delete();									
									 LCDSTInoculation::where('enroll_id',$request->enrollId1)->delete();
                                break;

                                case 22:
                                     $nextService=16;   
                                     /*ServiceLog::where('enroll_id',$request->enrollId1)->where('sample_id',$sample_id)->where('service_id',$request->service1)->where('tag','like','LJ')->update(['print_15a'=>0,'status'=>99]);
                                     if(isset($request->microbio_comments) && !empty($request->microbio_comments)){
                                        $drug_ids=implode(',',$request->updated_drugs);
                                        // dd($drug_ids);
                                        DSTDrugTR::where('enroll_id',$request->enrollId1)->where('service_id', $request->service1)->update(['drug_ids'=>$drug_ids,'microbiologist_comments'=>$request->microbio_comments]);

                                     }
                                     Microbio::where('enroll_id',$request->enrollId1)->where('service_id',$request->service1)->where('sample_id',$old_sample_id)->delete();

                                     DB::table('t_lj_detail')->where('enroll_id',$request->enrollId1)->where('sample_id',$old_sample_id)->delete();

                                     DB::table('t_lj_week_log')->where('enroll_id',$request->enrollId1)->where('sample_id',$old_sample_id)->delete();
                                    
                                     DB::table('t_lj_dst_reading')->where('enroll_id',$request->enrollId1)->where('sample_id',$old_sample_id)->delete();

                                     DB::table('t_lj_dst_inoculation')->where('enroll_id',$request->enrollId1)->where('sample_id',$old_sample_id)->delete();
                                      
                                     CultureInoculation::where('enroll_id',$request->enrollId1)->where('sample_id',$old_sample_id)->delete();*/
									 
									 ServiceLog::where('enroll_id',$request->enrollId1)->where('service_id',20)->where('tag','like','LJ')->update(['print_15a'=>0,'status'=>99]);
									 ServiceLog::where('enroll_id',$request->enrollId1)->where('service_id',22)->where('tag','like','LJ')->update(['print_15a'=>0,'status'=>99]);
                                     if(isset($request->microbio_comments) && !empty($request->microbio_comments)){
                                        $drug_ids=implode(',',$request->updated_drugs);
                                        // dd($drug_ids);
                                        DSTDrugTR::where('enroll_id',$request->enrollId1)->where('service_id',  $request->service1)->update(['drug_ids'=>$drug_ids,'microbiologist_comments'=>$request->microbio_comments]);

                                     }                                    
                                     Microbio::where('enroll_id',$request->enrollId1)->where('service_id',20)->delete();
									 Microbio::where('enroll_id',$request->enrollId1)->where('service_id',22)->delete();                                     
                                     DB::table('t_lj_detail')->where('enroll_id',$request->enrollId1)->delete();
									 DB::table('t_lj_week_log')->where('enroll_id',$request->enrollId1)->delete();
									 DB::table('t_lj_dst_reading')->where('enroll_id',$request->enrollId1)->delete();
									 DB::table('t_lj_dst_inoculation')->where('enroll_id',$request->enrollId1)->delete();
									 CultureInoculation::where('enroll_id',$request->enrollId1)->delete();
                                break;  
     
                        }
                                
                             $tag="";
							 if(!empty($request->lpa_tag)){
								$tag= $request->lpa_tag;
							 }elseif(!empty($request->lj_lc_tag)){
								 $tag=$request->lj_lc_tag;
							 }
							//dd($tag);
							if($tag==""){
								if($request->retest_sent_to==1){
									$tag="ZN Microscopy";
								}else if($request->retest_sent_to==2){
									$tag="FM Microscopy";
								}else if($request->retest_sent_to==3){
									$tag="Decontamination";
								}else if($request->retest_sent_to==4){
									$tag="CBNAAT";
								}else if($request->retest_sent_to==16){
									$tag="LC";
								}else if($request->retest_sent_to==21){
									$tag="LC";
								}else if($request->retest_sent_to==22){
									$tag="LJ";
								}
							}
                                ServiceLog::create([
                                'enroll_id' => $request->enrollId1,
                                'sample_id' => $new_sample_id,
                                'enroll_label' => $enroll_label,
                                'sample_label' => $new_sample,
                                 /*'service_id' => $nextService,*/
							    'service_id' => $request->retest_sent_to,
                                'status' => 1,
                                'reported_dt' => date('Y-m-d'),
                                'tag' => $tag,
                                'test_date' => date('Y-m-d H:i:s'),
                                'created_by' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
								'rec_flag' => $get_rec_flag_serviceLog->rec_flag+1
                            ]);

                    }else{

                               return Redirect::back()-> withErrors(['No Sample Found in the Storage']);

                }


            }
  
        }

        }else if ($request->nextStep == 'Print Form-15A') {//Form 15A download

            //Redirect::away('pdfview/1');
            //return redirect::away("pdfview/$sample_id");
            ServiceLog::where('enroll_id', $request->enrollId1)->where('sample_id',$sample_id)->where('service_id',0)->delete();
            Microbio::where('enroll_id', $request->enrollId1)->where('sample_id',$sample_id)->where('next_step','Send Sample')->delete();
            //ServiceLog::where('enroll_id', $request->enrollId1)->where('service_id', $request->service1)->where('print_15a',1)->where('tag',$request->lpa_tag)->update(['print_15a' =>0]);//By Amrita
			//ServiceLog::where('enroll_id', $request->enrollId1)->where('service_id', $request->service1)->where('print_15a',1)->where('sent_to_nikshay',1)->update(['print_15a' =>0]);//By Pradip
			ServiceLog::where('enroll_id', $request->enrollId1)->where('print_15a',1)->where('sent_to_nikshay',1)->update(['print_15a' =>0]);//By amrita
			Microbio::where('enroll_id', $request->enrollId1)->where('service_id', $request->service1)->update(['next_step' =>'Print Form-15A']);//By Amrita
        } 
		//Blocked by Amrita on 25/05/2020
		/*else {
			//dd($request->all());
            $tag = '';
            if ($request->nextStep == 6) {
                $tag = '1st line LPA';
                $request->merge(['nextStep' => 12, 'tag' => $tag]);
                // $request->nextStep = 12;
                // $request->sampleid1= $request->sampleid1.'R';
            }

            if ($request->nextStep == 7) {
                $tag = '2nd line LPA';
                $request->merge(['nextStep' => 12, 'tag' => $tag]);
                // $request->nextStep = 12;
                // $request->sampleid1= $request->sampleid1.'R';
            }
            // dd('fdgfd');
            // dd($request->nextStep);
            ServiceLog::create([
                'enroll_id' => $request->enrollId1,
                'sample_id' => $sample_id,
                'enroll_label' => $enroll_label,
                'sample_label' => $request->sampleid1,
                'service_id' => $request->nextStep,
                'status' => 1,
                'tag' => $tag,
                'reported_dt' => date('Y-m-d'),
                'test_date' => date('Y-m-d H:i:s'),
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id
            ]);

        }*/
        
        if ($request->nextStep == "Print Form-15A") {//for print 15A
			return redirect('/annexure15a');
		}else{//For other 	
            return redirect('/microbiologist');
		}
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

    public function result($serviceId, $sampleId, $enrollmentId,$tagOrServiceName=NULL)
    {
        // try{
                // dd($sampleId.'dfds');
                $service = Service::select('table as table_name')
                ->where('id',$serviceId)
                ->distinct()
                ->first();
              
			  if($tagOrServiceName=='1st line LPA'||$tagOrServiceName=='2nd line LPA'||$tagOrServiceName=='1st Line LPA'||$tagOrServiceName=='2nd Line LPA')
			  {
				  $tag=$tagOrServiceName;
			  }	  
                //$result = ServiceLog::where('sample_id',$sample)->where('enroll_id',$enroll)->get();
                //print_r($service->table_name); die;
                switch($service->table_name){
                   case 't_lpa_final': $data = $this->lpaFinal($service->table_name, $serviceId, $sampleId, $enrollmentId,$tag); break;
                   case 't_culture_inoculation': $data = $this->cultureInno($service->table_name, $serviceId, $sampleId, $enrollmentId); break;
                   case 't_microscopy': $data = $this->microscopy($service->table_name, $serviceId, $sampleId, $enrollmentId); break;
                   case 't_decontamination': $data = $this->decontamination($service->table_name, $serviceId, $sampleId, $enrollmentId); break;
                   case 't_dnaextraction': $data = $this->dna($service->table_name, $serviceId, $sampleId, $enrollmentId); break;
                   case 't_lc_flagged_mgit': $data = $this->flagged_mgit($service->table_name, $serviceId, $sampleId, $enrollmentId); break;
                   case 't_lj_detail': $data = $this->lj($service->table_name, $serviceId, $sampleId, $enrollmentId); break;
                   case 't_cbnaat': $data = $this->cbnaat($service->table_name, $serviceId, $sampleId, $enrollmentId); break;

                   case 't_cbnaat': $data = $this->cbnaat($service->table_name, $serviceId, $sampleId, $enrollmentId); break;
                   // case 't_cbnaat': $data = $this->cbnaat($service->table_name, $serviceId, $sampleId, $enrollmentId); break;
                   case 't_lc_dst_inoculation': $data = $this->lcdst_inno($service->table_name, $serviceId, $sampleId, $enrollmentId); break;
                   //case 't_lj_dst_reading': $data = $this->dstreading($service->table_name, $serviceId, $sampleId, $enrollmentId,$serviceId==22?4:5); break;
                   case 't_lj_dst_reading': $data = $this->dstreading($service->table_name, $serviceId, $sampleId, $enrollmentId); break;
                   case 't_hybridization': $data = $this->hybridization($service->table_name, $serviceId, $sampleId, $enrollmentId); break;
                }
                 // dd($data);

                return ($data);

            // }catch(\Exception $e){
            // $error = $e->getMessage();
            // return view('admin.layout.error',$error);   // insert query
            // }

    }
    public function hybridization($table_name, $serviceId, $sampleId, $enrollmentId){

        $result = DB::table($table_name)
                ->where('sample_id',$sampleId)
                ->where('enroll_id',$enrollmentId)
                ->where('status',1)
                ->select('result')
                ->get();
        $html = '';
        foreach ($result as $key => $value) {
            //print_r($value);
            $html .= "<p>Result : $value->result </p>";

        }

        return $html;
    }
    public function dstreading($table_name, $serviceId, $sampleId, $enrollmentId,$servicelogid=0){
//->where('service_log_id',$servicelogid)
        $result = DB::table($table_name)
                ->where('sample_id',$sampleId)
                ->where('enroll_id',$enrollmentId)
                ->select('drug_reading')
                ->where('status',1)
                ->where('service_id', $serviceId)
                ->orderBy('id','desc')
                ->get();
         //dd($result);

        $html = '';
        $i=0;
        foreach ($result as $key => $value) {
            $data=json_decode($value->drug_reading, true);
            //dd($data['dil_4']);
            //$len=count($data);
            foreach($data['dil_4'] as $per_data){
              //dd($per_data);
              //$html .= "<p> $per_data </p>";
              //foreach($per_data as $per_sub_data){
                //dd($per_sub_data['name']);

                  $html .= "<p>$per_data[name] : $per_data[value] </p>";
              //}
            }
        }

        return $html;
    }

    public function lpaFinal($table_name, $serviceId, $sampleId, $enrollmentId,$tag){

        $result = DB::table($table_name)
                ->where('sample_id',$sampleId)
                ->where('enroll_id',$enrollmentId)
				->where('tag',$tag)
                ->select('rif', 'inh','quinolone', 'slid','mtb_result','tag','nikshey_final_interpretation')
                ->get();
				//->toSql();
		//dd($result);		
        $html = '';
        foreach ($result as $key => $value) {
        
           // print_r($value);
         
            $html .= "<p>MTB Result : $value->mtb_result </p>";
			if($value->tag=='1st line LPA'){	
				  if(!empty($value->rif)){
					$html .= "<p>RIF : $value->rif </p>";
					}
				  if(!empty($value->inh)){
					$html .= "<p>INH : $value->inh </p>";
				   }
			}
			if($value->tag=='2nd line LPA'){		
				 if(!empty($value->quinolone)){
					$html .= "<p>FQ Resi : $value->quinolone </p>";
					}
				 if(!empty($value->slid)){
				   $html .= "<p>SLID : $value->slid </p>";
				 }
			}
			 if(!empty($value->nikshey_final_interpretation)){
				 $html .= "<p>Final Interpretation   : $value->nikshey_final_interpretation </p>";
			 }
        }

        return $html;
    }

    public function microscopy($table_name, $serviceId, $sampleId, $enrollmentId){

        $result = DB::table($table_name)
                ->where('sample_id',$sampleId)
                ->where('enroll_id',$enrollmentId)
                ->select('result')
                ->get();
        $html = '';
        foreach ($result as $key => $value) {
            //print_r($value);
            $html .= "<p>Result : $value->result </p>";

        }

        return $html;
    }

    public function cultureInno($table_name, $serviceId, $sampleId, $enrollmentId){

        $result = DB::table($table_name)
                ->where('sample_id',$sampleId)
                ->where('enroll_id',$enrollmentId)
                ->select('inoculation_date','status')
                ->get();
        $html = '';
        foreach ($result as $key => $value) {
            //print_r($value);
            $html .= "<p>Innoculation Date : $value->inoculation_date </p>";
            if($value->status==9)
            {
                $html .= "<p>Please send another sample</p>";
            }

        }

        return $html;
    }

    public function decontamination($table_name, $serviceId, $sampleId, $enrollmentId){

        $result = DB::table($table_name)
                ->where('sample_id',$sampleId)
                ->where('enroll_id',$enrollmentId)
                //->where('status',1)
                ->select('test_date','status')
                ->get();
        $html = '';
        foreach ($result as $key => $value) {
            //print_r($value);
            $html .= "<p>Tested On : $value->test_date </p>";
            if($value->status==9)
            {
                $html .= "<p>Please send another sample</p>";
            }

        }

        return $html;
    }

    public function dna($table_name, $serviceId, $sampleId, $enrollmentId){

        $result = DB::table($table_name)
                ->where('sample_id',$sampleId)
                ->where('enroll_id',$enrollmentId)
                ->select('created_at')
                ->get();
        $html = '';
        foreach ($result as $key => $value) {
            //print_r($value);
            $html .= "<p>Tested On : $value->created_at </p>";

        }

        return $html;
    }

    public function flagged_mgit($table_name, $serviceId, $sampleId, $enrollmentId){

        $result = DB::table('t_lc_flagged_mgit as b')
                ->join('t_lc_flagged_mgit_further as a','a.sample_id','=','b.sample_id')
                ->where('b.sample_id',$sampleId)
                ->where('b.enroll_id',$enrollmentId)
                ->select('b.flagging_date','b.gu','a.result','a.species','a.other_result','a.result_date')
                ->distinct()
                ->get();
        $html = '';
        foreach ($result as $key => $value) {
            //print_r($value);
            $html .= "<p>Flagged On : $value->flagging_date </p>";
            $html .= "<p>GU : $value->gu </p>";
			if($value->result=='NTM'){
            $html .= "<p>Result : $value->result ( $value->species)</p>";
			}else if($value->result=='Other Result'){
            $html .= "<p>Result : $value->result ( $value->other_result )</p>";
			}else{
            $html .= "<p>Result : $value->result </p>";
			}
			
            $html .= "<p>Further Tested on : $value->result_date </p>";
        }

        return $html;
    }

    public function lj($table_name, $serviceId, $sampleId, $enrollmentId){

        $result = DB::table('t_lj_detail as b')
                ->where('b.sample_id',$sampleId)
                ->where('b.enroll_id',$enrollmentId)
                ->select('b.final_result', 'b.species', 'b.other_result')
				->distinct()
                ->get();
        $html = '';
        foreach ($result as $key => $value) {
            //print_r($value);
			if($value->final_result=='Other Result'){
            $html .= "<p>Final Result : $value->final_result ( $value->other_result )</p>";
			} else if($value->final_result=='NTM'){
            $html .= "<p>Final Result : $value->final_result ( $value->species)</p>";
			} else{
            $html .= "<p>Final Result : $value->final_result </p>";
			}
  
        }

        return $html;
    }

    public function cbnaat($table_name, $serviceId, $sampleId, $enrollmentId){
       // dd($sampleId);
        // dd($enrollmentId);
        $result = DB::table('t_cbnaat as b')
                ->where('b.sample_id',$sampleId)
                ->where('b.enroll_id',$enrollmentId)
                ->select('b.result_MTB','b.result_RIF','b.status','b.error','b.cbnaat_equipment_name')
                ->orderBy('b.id','desc')
                ->first();
                if(is_object($result) == true){
                  $result=array($result);
                  // $result=$result;
                }
// dd($result);
                $html = '';
        foreach ($result as $key => $value) {
          //  dd($value);
            $html .= "<p>MTB Result : $value->result_MTB </p>";
            if($value->error){
              $html .= "<p>Error: $value->error </p>";
            }
            if($value->result_RIF){
              $html .= "<p>RIF Result (if any) : $value->result_RIF </p>";
            }

            if(!empty($value->cbnaat_equipment_name)){
              $html .= "<p>Machine Serial No. : $value->cbnaat_equipment_name </p>";
            }
            if($value->status==10 || $value->status==9)
            {
                $html .= "<p>Please send another sample</p>";
            }

        }

        return $html;
    }

    public function lcdst_inno($table_name, $serviceId, $sampleId, $enrollmentId){

        $result = DB::table('t_lc_dst_inoculation as b')
                ->where('b.sample_id',$sampleId)
                ->where('b.enroll_id',$enrollmentId)
                ->select('b.mgit_seq_id','b.dst_c_id1','b.dst_c_id2')
                ->get();
        $result2 = DB::table('t_lc_dst as b')
                ->where('b.sample_id',$sampleId)
                ->where('b.status',1)
                ->select('b.drug_name','b.result')
                ->get();
        $html = '';
        foreach ($result as $key => $value) {
            //print_r($value);
            $html .= "<p>MGIT Sequence ID : $value->mgit_seq_id </p>";
            $html .= "<p>DST ID1 : $value->dst_c_id1 </p>";
            $html .= "<p>DST ID2 : $value->dst_c_id2 </p>";

        }
        foreach ($result2 as $key => $value) {
            $html .= "<p>Drugs : $value->drug_name </p>";
            $html .= "<p>Results : $value->result </p>";

        }

        return $html;
    }

    public function microbiologistprint()
    {

        $data = [];
            $data['services'] = "fddg,gdg,gdg";

            //dd($data['services']);
            $data['summary']['todo']=DB::select('select s.name, ifnull(count(m.id),0) as cnt from t_microbiologist m join m_services as s on m.service_id = s.id where m.status = 0 group by m.service_id');
            
            $data['summary']['done']=DB::select('select s.name, ifnull(count(m.id),0) as cnt from t_microbiologist m join m_services as s on m.service_id = s.id where m.status = 1 group by m.service_id');


            //dd($data['summary']);
             $data['sample'] = ServiceLog::select('t_service_log.enroll_id as enroll','t_service_log.enroll_label as enroll_l','sample.sample_label as samples','t_service_log.sample_id as sample','sample.name as p_name','s.created_at as date','sample.sample_type','s.service_id as service','s.next_step as next','s.detail','s.remark','m.name as service_name','m.url')
                        ->leftjoin('sample as sample','t_service_log.sample_id','=','sample.id')
                        ->leftjoin('t_microbiologist as s','t_service_log.sample_id','=','s.sample_id')
                        ->leftjoin('m_services as m','m.id','=','s.service_id')
                        ->where('s.status',0)
                        ->distinct()
                        ->orderBy('t_service_log.enroll_id','desc')
                        
                        ->get();

            $data['done'] = ServiceLog::select('t_service_log.enroll_id as enroll','t_service_log.enroll_label as enroll_l','sample.sample_label as samples','t_service_log.sample_id as sample','sample.name as p_name','s.created_at as date','sample.sample_type','s.service_id as service','s.next_step as next','s.detail','s.remark','m.name as service_name','m.url')
                        ->join('sample as sample','t_service_log.sample_id','=','sample.id')
                        ->leftjoin('t_microbiologist as s','t_service_log.sample_id','=','s.sample_id')
                        ->join('m_services as m','m.id','=','s.service_id')
                        ->where('s.status',1)
                        ->distinct()
                        ->orderBy('t_service_log.enroll_id','desc')
                       
                        ->get();


            return view('admin.microbiologist.print',compact('data'));
    }



    public function get_drugs(Request $r){

        $druglist=[];
        $drugs=DB::table('t_dst_drugs_tr')->where('enroll_id',$r->enroll_id)->where('service_id',$r->service_id)->pluck('drug_ids');
       // dd($drugs);
        if(!empty($drugs[0])){
        $explode=explode("," , $drugs[0]);
        }
        // dd($explode);
        $count_drugs=count($explode);
     
        if($count_drugs > 0){
           foreach ($explode as $key => $drug) {
                $druglist[]=DB::table('m_dst_drugs')->select('id','name')->where('id',$drug)->where('status',1)->first();     

            } 
        }
       echo  json_encode($druglist);
    }
	public function getDstDrugs(){

        $dstdrugs = LCDSTDrugs::select('id','name')->where('status',1)->get();		
        $html = '';
       foreach ($dstdrugs as $key=> $drugs){
        
           // print_r($value);
         
            $html .= "<div class='col-md-4'><input class='drugs_array'
value='".$drugs['id']."' name='drugs[]' type='checkbox'>".$drugs['name']."</div>";
			
        }

        return $html;
    }
    public function getAddTestDstDrugs($enroll_id){
		$html ='';
        $existing_drugs_lc=[];
        $drugs=DB::table('t_dst_drugs_tr')->where('enroll_id',$enroll_id)->where('service_id',21)->pluck('drug_ids');
        //dd($drugs);
        if(count($drugs)>0){
			$drugids = explode(',',$drugs[0]);               
			$data['drugs'] = LCDSTDrugs::whereIn('id',$drugids)->get();
			unset($existing_drugs_lc);
			foreach( $data['drugs'] as $dg){                        
				$existing_drugs_lc[]=$dg->id;						
			}
         }      
        
		//dd($existing_drugs_lc); die;
        $dstdrugs = LCDSTDrugs::select('id','name')->where('status',1)->get();		
        $html .= '<div class="row col-md-12 dst_drugs_lc_section" style="display: none;"><label class="col-md-12"><h5>LC DST Drugs:</h5></label>';
        foreach($dstdrugs as $key=>$drugdata){					   
		  $checkedlc = "";
		  $readonlylc ="";
		  $rdonlyclasslc="";
		  if(!empty($existing_drugs_lc)){
			  if (in_array($drugdata->id,$existing_drugs_lc))						  
			  {
				  $checkedlc = "checked";
				  $readonlylc ="readonly";
				  $rdonlyclasslc="readonly_class";
			  }
		  }
           // print_r($value);
         
         $html .= "<div class='col-md-4'><input class='drugs_array ".$rdonlyclasslc."' value='".$drugdata->id."' name='drugs[lcdst][]' type='checkbox' ".$checkedlc." ".$readonlylc.">".$drugdata->name."</div>";
			
        }
		$html .= "</div>";
		 
		//lj section
		$existing_drugs_lj=[];
        $drugs=DB::table('t_dst_drugs_tr')->where('enroll_id',$enroll_id)->where('service_id',22)->pluck('drug_ids');
        //dd($drugs);
        if(count($drugs)>0){
			$drugids = explode(',',$drugs[0]);               
			$data['drugs'] = LCDSTDrugs::whereIn('id',$drugids)->get();
			unset($existing_drugs_lj);
			foreach( $data['drugs'] as $dg){                        
				$existing_drugs_lj[]=$dg->id;						
			}
         }      
        
		//dd($existing_drugs_lj); die;
        $dstdrugs = LCDSTDrugs::select('id','name')->where('status',1)->get();		
        $html  .= '<div class="row col-md-12 dst_drugs_lj_section" style="display: none;"><label class="col-md-12 drug_section_label"><h5>LJ DST Drugs:</h5></label>';
       foreach($dstdrugs as $key=>$drugdata){					   
		  $checkedlj = "";
		  $readonlylj ="";
		  $rdonlyclasslj="";
		  if(!empty($existing_drugs_lj)){
			  if (in_array($drugdata->id,$existing_drugs_lj))						  
			  {
				  $checkedlj = "checked";
				  $readonlylj ="readonly";
				  $rdonlyclasslj="readonly_class";
			  }
		  }
           // print_r($value);
         
            $html .= "<div class='col-md-4'><input class='drugs_array ".$rdonlyclasslj."' value='".$drugdata->id."' name='drugs[ljdst][]' type='checkbox' ".$checkedlj." ".$readonlylj.">".$drugdata->name."</div>";
			
        }
        $html .= "</div>";
        return $html;
    }
	public function getAddTestList($enroll_id){
        $existing_service_ids=[];
        $services=RequestServices::select('service_id','enroll_id')->where('enroll_id',$enroll_id)->get();
        //dd($services);
        if(count($services)>0){			
			unset($existing_service_ids);
			foreach($services as $serv){                        
				$existing_service_ids[]=$serv->service_id;						
			}
         }      
        
		//dd($existing_service_ids); die;
        $addtestlist = DB::table('m_test_request')->select('id','name')->where('status',1)->orderBy('sequence_id','ASC')->get();
            //dd($data['addtestlist']);		
        $html = '';
       foreach($addtestlist as $key=>$addtestdata){					
						  $checked = "";
						  $readonly ="";
						  $readonlyclass="";
						  if(!empty($existing_service_ids)){
							  if(in_array($addtestdata->id,$existing_service_ids))
							  {
								  $checked = "checked";
								  $readonly ="readonly";
								  $readonlyclass="readonly_class_test";
							  }
						  }
         
            $html .= "<div class='col-md-6'><input class='addtest_array ".$readonlyclass."'
value='".$addtestdata->id."' name='addtest[]' type='checkbox' ".$checked." ".$readonly.">".$addtestdata->name."</div>";
			
        }

        return $html;
    }
	public function getExistingServiceIds($enroll_id){
        $existing_service_ids=[];
        $services=RequestServices::select('service_id','enroll_id')->where('enroll_id',$enroll_id)->get();
        //dd($services);
        if(count($services)>0){			
			unset($existing_service_ids);
			foreach($services as $serv){                        
				$existing_service_ids[]=$serv->service_id;						
			}
         }  
		 //dd($existing_service_ids);
        return $existing_service_ids;
    }
	public function sendToNikshay(Request $request)
    {
		//dd($request->all());
		ServiceLog::where('id',$request->tsl_id)->update(['sent_to_nikshay'=>1,'sent_to_nikshay_date' => date('Y-m-d H:i:s'), 'updated_by' => Auth::user()->id, 'updated_at' => date('Y-m-d H:i:s')]);
		//Update enrolls display_flag for display/not display in enrolls listing
		Enroll::where('label',$request->enrolid1)->update(['display_flag'=>1, 'updated_at' => date('Y-m-d H:i:s')]);		
		return redirect('/microbiologist');

	}
    public function getRetestSentToMap($serviceId,$optionId,$tagId){

        $senttolist='';
		//DB::enableQueryLog();
        $senttolist=Master_Map_retest::select('send_to_id','send_to_name')->where('test_id',$serviceId)->where('option_id',$optionId)->where('tag_id',$tagId)->get();
         //dd(DB::getQueryLog());
	   //dd($senttolist);
       
       echo  json_encode($senttolist);
    }
     public function checkForRequestSeviceDataExist($enroll_id)
    { 
        //dd($enroll_id);
		
		$result = DB::select("SELECT id
		FROM `t_request_services` 
		WHERE enroll_id = ".$enroll_id."");
		//dd($result);
		//echo count($result); die;
        $dataexist=0;		
		
        if(!empty($result)) {
			if(count($result)>0){
				$dataexist=1;				
			}else{
				$dataexist=0;				
			}
            
        }else{
			    //echo "3"; die;
			    $dataexist=0;
		}

        echo json_encode($dataexist);
        exit;

    }	
	public function annexure15A()
    {
            //dd("hi"); die;
             $data['sample'] = ServiceLog::select(
                 's.id as ID','s.tag as tag','t_service_log.id as tslID','t_service_log.tag as stag','t_service_log.print_15a as print_15a','t_service_log.sent_to_nikshay as sent_to_nikshay','f.DMC_PHI_Name as facility_id',
                 'sample.id as sampleID','s.enroll_id as enroll','enrolls.label as enroll_l',
                 'sample.sample_label as samples','s.sample_id as sample','sample.name as p_name',
                 's.created_at as date','sample.sample_type', 'sample.test_reason',
                 's.service_id as service','s.next_step as next','s.detail as m_detail',
                 's.remark as m_remark','m.name as service_name','m.url','s.bwm as bwm_status',
                 'ci.mgit_id','ci.tube_id_lj','ci.tube_id_lc','ci.inoculation_date','ddt.id as lc_dst_tr_id','ddt.drug_ids as drug_ids',
                 'ldi.mgit_seq_id', 'ldi.dst_c_id1', 'ldi.dst_c_id2','ldi.dst_c_id3',
                 'patient.reg_by', 'sample.no_of_samples as no_of_samples',
                  DB::raw('date_format(ldi.inoculation_date,"%d-%m-%y")') )
                 ->leftJoin('t_microbiologist as s', function($join){
                    $join->on('s.sample_id', '=','t_service_log.sample_id');
                    $join->on('s.service_id', '=','t_service_log.service_id');
                })
                ->leftjoin('sample as sample','s.sample_id','=','sample.id')
                ->leftjoin('enrolls as enrolls','enrolls.id','=','sample.enroll_id')
                ->leftjoin('t_cbnaat as cbnaat','s.sample_id','=','cbnaat.sample_id')
                ->leftjoin('t_decontamination as d','s.sample_id','=','d.sample_id')
                ->leftjoin('req_test as rq','rq.enroll_id','=','s.enroll_id')
                ->leftjoin('m_dmcs_phi_relation as f','rq.facility_id','=','f.id')
                ->leftjoin('m_services as m','m.id','=','s.service_id')
                ->leftjoin('t_culture_inoculation as ci','ci.sample_id','=','s.sample_id')
                // ->leftjoin('t_dst_drugs_tr as ddt','ddt.enroll_id','=','t_service_log.enroll_id')
                ->leftjoin('t_lc_dst_inoculation as ldi','ldi.sample_id','=','s.sample_id')
                //->where('ddt.status',1)
                ->leftjoin('t_dst_drugs_tr as ddt', function ($join) {
                     $join->on('ddt.enroll_id','=','s.enroll_id');
					 $join->on('ddt.service_id', '=','t_service_log.service_id');
                          //->where('ddt.status', 1);
                 })
                ->leftjoin('patient as patient','patient.id','=','enrolls.patient_id')
                ->groupby('sample.id')
                ->groupby(['s.service_id','t_service_log.service_id','t_service_log.tag'])
                //->where('s.status',0)				
				->orderBy('enrolls.label')
				->orderBy('sample.sample_label')
				->orderBy('t_service_log.service_id')
                ->where('t_service_log.status',0)
                ->where('t_service_log.print_15a',1)
				->where('t_service_log.sent_to_nikshay',1)
                ->where('t_service_log.sent_to_nikshay_date',"!=", null)
                //->where('s.service_id', '!=', ServiceLog::TYPE_BWM)
				->whereIn('t_service_log.service_id',array(4,14,22,15,17,20,21))
                ->get();
                //->toSql();

              //dd($data['sample']);
              
              //dd(Config::get('m_services_array.tests'));          
             foreach($data['sample'] as $sampledata){
                //echo $sampledata->enroll_id; die;
                
                $services=RequestServices::select('service_id','enroll_id')->where('enroll_id',$sampledata->enroll)->get();
                //dd($services);
                $data['test_requested['.$sampledata->enroll.']']='';
                $data['services_col_color['.$sampledata->enroll.']']='N';
				//$result=array();
                //$data['existing_service_ids']=array();
                if(!$services->isEmpty()){ //echo "hi"; die;                    
                    $result=array();
                    $data['existing_service_ids']=array();
                    unset($result);//reinitialize array
					unset($data['existing_service_ids']);
                    foreach($services as $serv){
						//echo Config::get('m_services_array.tests')[5]; die();
                        $result[] = Config::get('m_services_array.tests')[$serv->service_id] ?? null; 
						if(isset(Config::get('m_services_array.tests')[$serv->service_id])&& !empty(Config::get('m_services_array.tests')[$serv->service_id])){
							 $data['existing_service_ids'][]=$serv->service_id;
						}else{
							 $data['existing_service_ids'][]='';
						}
                        //$data['existing_service_ids'][]=Config::get('m_services_array.tests')[$serv->service_id]?$serv->service_id:'';	                       										   
                    }
					//dd( $data['existing_service_ids']);
                    //dd($result);
                    //dd(count($result));
                    // comma in the array 
                    $data['test_requested['.$sampledata->enroll.']'] = implode(', ', $result); 
                    //dd($data);
                    //For display green colour for more than 1 services
                    if(count($result)>1)
                    {
                        $data['services_col_color['.$sampledata->enroll.']']='Y';
                    }               
                    
                }
             }
			 //dd($result);
			 //dd( $data['existing_service_ids']);
			 //dd( $data['test_requested[3]']);
			  
             //dd($data);
			
              $data['drugs'] = [];
              foreach ($data['sample'] as $key => $value) {
              if($value->drug_ids != ''){
                $drugids = explode(',',$value->drug_ids);
                $druglist = LCDSTDrugs::whereIn('id',$drugids)->pluck('name')->toArray();
                $value->druglist = implode(',',$druglist);
                $data['drugs'] = LCDSTDrugs::whereIn('id',$drugids)->get();
				    unset($data['existing_drugs']);
                    foreach( $data['drugs'] as $dg){                        
                        $data['existing_drugs'][]=$dg->id;						
                    }
                }
              }
              //echo "<pre>"; print_r($data['existing_drugs']); die();
               //dd($data['drugs']);
              $data['dp_result'] = ["Sensitive (S)","Resistance (R)", "Not done (-)", "Contaminated ( C)", "Error ( E)"];
              $data['dp_result_value'] = ["Sensitive","Resistance", "Not done", "Contaminated", "Error"];

              foreach ($data['sample'] as $key => $value) {
                $value->no_sample = ServiceLog::where('enroll_id',$value->enroll)->where('service_id',11)->count();
              }

           

            $services = DB::table('m_test_request')->select('id','name')->whereIn('name',['LCDST','LJ DST','LJ DST 2st line'])->where('status',1)->get();
            $services = json_decode($services, true);
            $data['services'] = $services;
			//druglist
            $dstdrugs = LCDSTDrugs::select('id','name')->where('status',1)->get();
            $data['dstdrugs'] = $dstdrugs;
			$data['sendtolist'] = Master_addtest::select('*')->get();
			$data['addtestlist'] = DB::table('m_test_request')->select('id','name')->where('status',1)->get();
            //dd($data['addtestlist']);
            return view('admin.microbiologist.annexure15a',compact('data'));
    }
	public function history(Request $request)
    {
            
            $srchBy=!empty(\request('srch_by'))?\request('srch_by'):1;
			$srchInput=!empty(\request('srch'))?\request('srch'):0;
			//dd($srchInput);
			//if(!empty($srchBy))
            $data['done'] = $result =DB::select('call microbiologist_history_show(?,?)',array($srchBy,$srchInput));
            //dd($data['done']);           
            return view('admin.microbiologist.history',compact('data'));
    }
	public function checkForTestRequest($enroll_id,$service_id,$tag=null,$reqServ_service_id)
    { 
		 
          //DB::enableQueryLog();		  
		 /* $query =Master_Map_Reqservice_Servicelog::where('servicelog_service_id',$service_id);
		     if($tag!='null'){
				
			   $query =$query->where('servicelog_tag',$tag);
		    }	
           $query =$query->where('request_service_id',$reqServ_service_id);		  
		   $query =$query->get();		  
		  //dd($query);
		  //dd(DB::getQueryLog());
		  $request_service_id=$query[0]->request_service_id; 
		 // echo $request_service_id; die;
		  $services=RequestServices::where('enroll_id',$enroll_id)->where('service_id',$request_service_id)->count();
           //dd(DB::getQueryLog());
		   //dd($services);*/
		 //DB::enableQueryLog();
		 if($service_id==15){ //echo "if"; die;
		  $services=DB::select("SELECT IFNULL(COUNT(A.enroll_id),0) AS cnt FROM t_request_services A, t_service_log B, m_map_reqservice_servicelog C
		WHERE A.enroll_id = B.enroll_id
		AND A.service_id = C.request_service_id
		AND C.servicelog_tag = B.tag		
		AND B.enroll_id =".$enroll_id."
		AND B.service_id =".$service_id." AND C.servicelog_service_id = B.service_id");
		 }else{ //echo "else"; die;
			  $services=DB::select("SELECT IFNULL(COUNT(A.enroll_id),0) AS cnt FROM t_request_services A, t_service_log B, m_map_reqservice_servicelog C
		WHERE A.enroll_id = B.enroll_id
		AND A.service_id = C.request_service_id		
		AND B.enroll_id=".$enroll_id."
		AND B.service_id =".$service_id." AND C.servicelog_service_id = B.service_id");
		  }
		 //dd(DB::getQueryLog());
		// dd($services);
		 //dd($services[0]->cnt);
		 $servicesexist=0;		
			
			
			if($services[0]->cnt==0){
				$servicesexist=0;
			}else{
				$servicesexist=1;
			}
			

			echo json_encode($servicesexist);
			

    }
}