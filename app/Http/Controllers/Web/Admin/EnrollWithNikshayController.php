<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Enroll;
use App\Model\Patient;
use App\Model\EnrollsNikshayLog;
use Illuminate\Support\Facades\Validator;
use App\Model\Sample;
use App\Model\Config;
use Illuminate\Support\Facades\DB;
use App\User;

class EnrollWithNikshayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
// dd("hi");
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
        $data['sample'] = Sample::select(DB::raw('e.patient_id,enroll_id,p.reg_by,e.label,e.nikshay_id,group_concat(receive_date) as receive,group_concat(sample_label) as samples,group_concat(test_reason) as reason,group_concat(sample_type) as sample_type, group_concat(sample_quality) as sample_quality, group_concat(is_accepted) as is_accepted, count(sample_quality) as no_of_samples,group_concat(fu_month) as fu_month,e.status_id as status_id'))
                          ->leftjoin('enrolls as e','e.id','=','enroll_id')
                          ->leftjoin('patient as p','p.id','=','e.patient_id')
                          ->where('is_accepted','Accepted')
						  ->whereRaw('((e.status_id=0) OR ((e.status_id=2 AND e.nikshay_id is not null) or (e.status_id=4 AND e.nikshay_id is not null)))')						  
                          ->where('sample.test_reason','!=','EQA')
						  ->groupBy('enroll_id')
                          ->orderBy('e.label','desc')
						  //->toSql();
                          ->get();
        // $data['sid']=$id;
        //dd($data['sample']);
        return view('admin.enrollwithnikshay.list',compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
		if(!empty($request->nikshayid)){
			$enr = Enroll::find($request->enrollid);
			$enr->nikshay_id = trim($request->nikshayid);
			$enr->status_id = 2;
			$enr->is_moved = 0;
			$enr->save();
			
			//Update patient table
			$pat = Patient::find($request->enrollid);			
			$pat->is_moved = 0;
			$pat->save();
		}else{
			$enr = Enroll::find($request->enrollid);
			$enr->nikshay_id = !empty($request->nikshayid)?trim($request->nikshayid):"";
			$enr->status_id = 0;
			$enr->is_moved = 0;
			$enr->save();
			
			//Update patient table
			$pat = Patient::find($request->enrollid);			
			$pat->is_moved = 0;
			$pat->save();
			
		}
        return redirect('/enrollwithnikshay');
      
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
    public function update($id)
    {
       
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
						  ->whereIn('e.status_id',[2,4])
                          ->groupBy('enroll_id')
                          ->orderBy('enroll_id', 'desc')
                          ->get();
        //dd($data['sample']);
        return view('admin.enrollwithnikshay.print',compact('data'));
    }
	public function changeNikshayIdList()
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
        $data['sample'] = Sample::select(DB::raw('e.patient_id,enroll_id,p.reg_by,e.label,e.nikshay_id,group_concat(receive_date) as receive,group_concat(sample_label) as samples,group_concat(test_reason) as reason,group_concat(sample_type) as sample_type, group_concat(sample_quality) as sample_quality, group_concat(is_accepted) as is_accepted, count(sample_quality) as no_of_samples,group_concat(fu_month) as fu_month,e.status_id as status_id'))
                          ->leftjoin('enrolls as e','e.id','=','enroll_id')
                          ->leftjoin('patient as p','p.id','=','e.patient_id')
                          ->where('is_accepted','Accepted')
						  ->whereRaw('(e.status_id=5)')						  
                          ->where('sample.test_reason','!=','EQA')
						  ->groupBy('enroll_id')
                          ->orderBy('enroll_id','desc')
						  //->toSql();
                          ->get();
        // $data['sid']=$id;
        //dd($data['sample']);
        return view('admin.enrollwithnikshay.changenikshaylist',compact('data'));
    }
	public function updateWithNikshayId(Request $request)
    {
      
        //dd($request->all());
		if(!empty($request->nikshayid)){
			$enr = Enroll::find($request->enrollid);
			//dd($enr->nikshay_id);
			//Insert in to EnrollsNikshayLog(Old Data)
			$enrl_log_data_old= new EnrollsNikshayLog([
				'enroll_id' =>$enr->id,
				'label' => $enr->label,
				'nikshay_id' => trim($enr->nikshay_id)
			]);
			$enrl_log_data_old->saveOrFail();
			
			//Insert in to EnrollsNikshayLog(New Data)
			$enrl_log_data_new = new EnrollsNikshayLog([
				'enroll_id' =>$enr->id,
				'label' => $enr->label,
				'nikshay_id' => trim($request->nikshayid)
			]);
			$enrl_log_data_new->saveOrFail();
			
			//Update Enrolls table
			$enr->nikshay_id = trim($request->nikshayid);
			$enr->status_id = 2;
			$enr->is_moved = 0;
			$enr->save();
			
			//Update patient table
			$pat = Patient::find($request->enrollid);			
			$pat->is_moved = 0;
			$pat->nikshay_id = NULL;
			$pat->is_nikshay = NULL;
			$pat->save();
		}
		
		echo  "<script type='text/javascript'>";
		echo "window.close();";
		echo "</script>";
        return redirect('/enrollwithnikshay');
      
    }
}
