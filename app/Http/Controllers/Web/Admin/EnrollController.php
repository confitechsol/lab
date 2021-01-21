<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Enroll;
use App\Model\Patient;
use Illuminate\Support\Facades\Validator;
use App\Model\Sample;
use App\Model\Config;
use Illuminate\Support\Facades\DB;
use App\User;
use Carbon\Carbon;

class EnrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
		
        $data = [];
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
        /*$data['sample'] = Sample::select(DB::raw('e.patient_id,enroll_id,p.reg_by,e.label,e.status_id as status_id,group_concat(receive_date) as receive,group_concat(sample_label) as samples,group_concat(test_reason) as reason,group_concat(sample_type) as sample_type, group_concat(sample_quality) as sample_quality, group_concat(is_accepted) as is_accepted, count(sample_quality) as no_of_samples,group_concat(fu_month) as fu_month'))
                          ->leftjoin('enrolls as e','e.id','=','enroll_id')
                          ->leftjoin('patient as p','p.id','=','e.patient_id')
                          ->where('is_accepted','Accepted')
						  ->whereRaw('((e.status_id in (0,1,3,5)) OR (e.status_id=4 AND IFNULL(e.nikshay_id,"")=""))')
						  ->whereRaw('e.display_flag=0')
                          ->where('sample.test_reason','!=','EQA')
		                  ->whereRaw('date(e.created_at) between date_add(curdate(), INTERVAL -90 DAY) AND curdate()')
						  ->groupBy('enroll_id')
                          ->orderBy('enroll_id','desc')
						 //->toSql();
                          ->get();*/
        // $data['sid']=$id;
        //dd($data['sample']);
        return view('admin.enroll.list',compact('data'));
    }
    public function ajaxEnrollList(Request $request){
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
		   $searchQuery .= " and (p.reg_by like '%".$searchValue."%' or 
			  e.label like '%".$searchValue."%' or 
			  sample.enroll_id like'%".$searchValue."%'  or
			  sample_label like'%".$searchValue."%'  or
			  receive_date like'%".$searchValue."%'  or
			  test_reason like'%".$searchValue."%'  or
			  fu_month like '%".$searchValue."%') ";
		}
		## Total number of records without filtering
		//DB::enableQueryLog();			
		$sel=Sample::select(DB::raw('e.patient_id,enroll_id,p.reg_by,e.label,e.status_id as status_id,group_concat(receive_date) as receive,group_concat(sample_label) as samples,group_concat(test_reason) as reason,group_concat(sample_type) as sample_type, group_concat(sample_quality) as sample_quality, group_concat(is_accepted) as is_accepted, count(sample_quality) as no_of_samples,group_concat(fu_month) as fu_month'))
                          ->leftjoin('enrolls as e','e.id','=','enroll_id')
                          ->leftjoin('patient as p','p.id','=','e.patient_id')
                          ->where('is_accepted','Accepted')
						  ->whereRaw('((e.status_id  in (0,1,3,5)) OR (e.status_id=4 AND IFNULL(e.nikshay_id,"")=""))')
						  //->whereRaw('e.display_flag=0')
                          ->where('sample.test_reason','!=','EQA')						 
						  ->whereRaw("".$dateRangeQuery)
						  ->groupBy('enroll_id')
						  ->orderBy('enroll_id','desc')						  
						  ->get();
		//dd($sel->count());			  
		//dd(DB::getQueryLog());	
		$totalRecords =$sel->count();

		## Total number of records with filtering
		//DB::enableQueryLog();			
		$sel=Sample::select(DB::raw('e.patient_id,enroll_id,p.reg_by,e.label,e.status_id as status_id,group_concat(receive_date) as receive,group_concat(sample_label) as samples,group_concat(test_reason) as reason,group_concat(sample_type) as sample_type, group_concat(sample_quality) as sample_quality, group_concat(is_accepted) as is_accepted, count(sample_quality) as no_of_samples,group_concat(fu_month) as fu_month'))
                          ->leftjoin('enrolls as e','e.id','=','enroll_id')
                          ->leftjoin('patient as p','p.id','=','e.patient_id')
                          ->where('is_accepted','Accepted')
						  ->whereRaw('((e.status_id  in (0,1,3,5)) OR (e.status_id=4 AND IFNULL(e.nikshay_id,"")=""))')
						  //->whereRaw('e.display_flag=0')
                          ->where('sample.test_reason','!=','EQA')
						  ->whereRaw("".$searchQuery)	
						  ->groupBy('enroll_id')
						  ->orderBy('enroll_id','desc')						  
						  ->get();
		//dd(DB::getQueryLog());			  
		//dd($sel->count());			  
		$totalRecordwithFilter = $sel->count();

		## Fetch records
		//DB::enableQueryLog();
		$empQuery=Sample::select(DB::raw('e.patient_id,enroll_id,p.reg_by,e.label,e.status_id as status_id,group_concat(receive_date) as receive,group_concat(sample_label) as samples,group_concat(test_reason) as reason,group_concat(sample_type) as sample_type, group_concat(sample_quality) as sample_quality, group_concat(is_accepted) as is_accepted, count(sample_quality) as no_of_samples,group_concat(fu_month) as fu_month'))
                          ->leftjoin('enrolls as e','e.id','=','enroll_id')
                          ->leftjoin('patient as p','p.id','=','e.patient_id')
                          ->where('is_accepted','Accepted')
						  ->whereRaw('((e.status_id in (0,1,3,5)) OR (e.status_id=4 AND IFNULL(e.nikshay_id,"")=""))')
						  //->whereRaw('e.display_flag=0')
                          ->where('sample.test_reason','!=','EQA')
						  ->whereRaw("".$searchQuery." group by `enroll_id` order by e.label ".$columnSortOrder." limit ".$row.",".$rowperpage)
						  ->get();
		//dd($empQuery);
		//dd(DB::getQueryLog());
		
		$data = array();
		$actionBtn="";
		$bgcolorClass="";
		$custdt="";
		$rsnRejectionBtn="";
		foreach($empQuery as $key=>$samples){
              $dt= explode("," , $samples->receive);
			  $counter= count($dt);
			  if($samples->status_id==0){				 
				  $bgcolorClass="background-white-color";
			  }
			  else if($samples->status_id==1){				 
				  $bgcolorClass="background-green-color";
			  }else if($samples->status_id==2){				 
				  $bgcolorClass="background-purple-color";
			  }else if($samples->status_id==3){				 
				  $bgcolorClass="background-yellow-color";
			  }else if($samples->status_id==4){				  
				  $bgcolorClass="background-pink-color";				 
			  }else if($samples->status_id==5){				 
				  $bgcolorClass="background-brown-color";				 
			  }else{
				  $bgcolorClass="";
			  }
			  
			  foreach( $dt as $recvdates){
			   $custdt= date('d-m-Y h:i:s', strtotime($recvdates));  
			   
			  }
			$actionBtn="<button class='btn btn-default btn-sm' onclick=\"window.open('".url('/enroll/patient/'.$samples->patient_id.'/edit')."');"
  ." $('#exampl tr.bg-selected').removeClass('bg-selected');$(this).parents('tr').addClass('bg-selected') \"> "
  . ($samples->reg_by  ? 'Enrolled' : 'Enroll' )
   ."</button>";
            if($samples->status_id==4){
				$rsnRejectionBtn="<a class='detail_modal' style='color:#1E88E5; cursor:pointer; font-size:12px;' onclick=\"getReasonforRejection(".$samples->label.")\">View</a>";				
			 }else{
				 $rsnRejectionBtn="";
			 }   
			//echo $action; die;	   
			$data[] = array(
			 "DT_RowClass"=> $bgcolorClass,
			 "enroll_id"=>$samples->enroll_id,
			 "reg_by"=>$samples->reg_by,
			 "label"=>$samples->label,
			 "samples"=>$samples->samples,
			 "receive_date"=>$custdt,
			 "reason"=>str_replace(',','<br/>', $samples->reason),
			 "fu_month"=>str_replace(',','<br/>', $samples->fu_month),
			 "action"=>$actionBtn,
			 "reason_for_rejection"=>$rsnRejectionBtn,
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
    public function create()
    {
		 //echo "hi"; die;
         $data = Enroll::enroll_form();
         return view('admin.enroll.form',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // TODO: UNNECESSARY MEANINGLESS SQL EXECUTIONS. REQUIRES CLARIFICATION.
        //dd($request->all());
        if($request->enroll == "1"){
           $patient = Patient::create([]);

           $enroll = Enroll::create([
            'patient_id' => $patient->id

          ]);
          // $enroll = Enroll::create([
          //
          // ]);
          // $enroll=Enroll::find($enroll->id);
          // $enroll->patient_id=$enroll->id;
          // $enroll->save();

          $patient = Patient::create(['id' => $enroll->id ]);
          //$patient = Patient::create(['id' => $enroll->id ]);


          $data['enroll_id'] = $enroll->id;
          return redirect('/sample/create/'.$enroll->id);
        }
        elseif($request->enroll == "2"){
             $enroll = new Enroll;
             $enroll->fill($request->all());
             $enroll->save();
            return redirect('/enroll');
        }
        else{
          return redirect('/sample');
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
    {   //echo "hi"; die;
        $data = Enroll::enroll_edit($id);
        return view('admin.enroll.form',compact('data'));
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
		//dd($request->all());
        try{
                $enroll = Enroll::find($id);
                $enroll->update($request->all());
                return redirect('/enroll');

        }catch(\Exception $e){
            $error = $e->getMessage();
            return view('admin.layout.error',$error);   // insert query
        }
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

    public function enrollPrint()
    {
        $data = [];
        $data['sample'] = Sample::select(DB::raw('e.patient_id,enroll_id,e.label,group_concat(date_format(receive_date,"%d-%m-%y")) as receive,group_concat(sample_label) as samples,group_concat(test_reason) as reason,group_concat(sample_type) as sample_type, group_concat(sample_quality) as sample_quality, group_concat(is_accepted) as is_accepted, count(sample_quality) as no_of_samples'))
                          ->leftjoin('enrolls as e','e.id','=','enroll_id')
                          ->groupBy('enroll_id')
                          ->orderBy('enroll_id', 'desc')
                          ->get();
        //dd($data['sample']);
        return view('admin.enroll.print',compact('data'));
    }
	public function getReasonforRejection(Request $request){
        $sample_label = $request->label;
        //echo $sample_label; die; 		
        $result =DB::select('call show_failed_nikshay_generation(?)',array($sample_label));
        return $result;

    }
}
