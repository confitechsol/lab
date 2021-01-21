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
        $data['sample'] = Sample::select(DB::raw('e.patient_id,enroll_id,p.reg_by,e.label,e.status_id as status_id,group_concat(receive_date) as receive,group_concat(sample_label) as samples,group_concat(test_reason) as reason,group_concat(sample_type) as sample_type, group_concat(sample_quality) as sample_quality, group_concat(is_accepted) as is_accepted, count(sample_quality) as no_of_samples,group_concat(fu_month) as fu_month'))
                          ->leftjoin('enrolls as e','e.id','=','enroll_id')
                          ->leftjoin('patient as p','p.id','=','e.patient_id')
                          ->where('is_accepted','Accepted')
						  ->whereRaw('((e.status_id in (0,3,5)) OR (e.status_id=4 AND IFNULL(e.nikshay_id,"")=""))')
						  ->whereRaw('e.display_flag=0')
                          ->where('sample.test_reason','!=','EQA')
		                  ->whereRaw('date(e.created_at) between date_add(curdate(), INTERVAL -90 DAY) AND curdate()')
						  ->groupBy('enroll_id')
                          ->orderBy('enroll_id','desc')
						 //->toSql();
                          ->get();
        // $data['sid']=$id;
        //dd($data['sample']);
        return view('admin.enroll.list',compact('data'));
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
