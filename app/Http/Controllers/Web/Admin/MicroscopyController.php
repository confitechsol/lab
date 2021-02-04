<?php

namespace App\Http\Controllers\Web\Admin;

use App\Model\Sample;
use App\Model\Service;
use App\Model\ServiceLog;
use App\Model\Microscopy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Model\Microbio;
use App\Model\ResultEdit;
use App\Model\RequestServices;
use Illuminate\Support\Facades\Config;

class MicroscopyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      try{

        $data = [];
        $data['sample'] = ServiceLog::select('s.id as sample_id','t_service_log.updated_at as ID','m.enroll_id', 'e.label', 'm.receive_date as receive',
        'm.test_reason as reason','m.sample_quality','m.sample_type', 'm.others_type', 'is_accepted','s.result','t_service_log.sample_label','t_service_log.stage','t_service_log.service_id',
		't_service_log.id as log_id', 't_service_log.status','m.fu_month','m.service_id as serviceID','t_service_log.enroll_id AS enrollID','t_service_log.tag',
        't_service_log.status as STATUS','t_service_log.sample_id','t_service_log.rec_flag')
        ->leftjoin('enrolls as e','e.id','=','t_service_log.enroll_id')
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
        ->whereIn('t_service_log.service_id',[1,2])
        ->whereIn('t_service_log.status',[1]) //->whereIn('t_service_log.status',[0,1,2]) changed
		->distinct()
        ->orderBy('enroll_id','desc')
        ->get(); 
        
        //dd($data);
		
		//dd(Config::get('m_services_array.tests'));			
			 foreach($data['sample'] as $sampledata){
				//echo $sampledata->enroll_id; die;
				
				$services=RequestServices::select('service_id','enroll_id')->where('enroll_id',$sampledata->enroll_id)->get();
				//dd($services);
				$data['test_requested['.$sampledata->enroll_id.']']='';
				$data['services_col_color['.$sampledata->enroll_id.']']='N';
				if(!$services->isEmpty()){ //echo "hi"; die;					
					//$result[]='';
					
					unset($result);//reinitialize array
					foreach($services as $serv){
						$result[] = Config::get('m_services_array.tests')[$serv->service_id] ?? null;						
					}
					//dd($result);
					//dd(count($result));
					// comma in the array 
                    $data['test_requested['.$sampledata->enroll_id.']'] = implode(', ', $result); 
					//dd($data);
					//For display green colour for more than 1 services
					if(count($result)>1)
					{
						$data['services_col_color['.$sampledata->enroll_id.']']='Y';
					}				
					
				}
			 }

        $data['summaryTotal'] = ServiceLog::whereIn('status',[0,1,2])
                    ->whereIn('service_id',[1,2])
                    ->count();
        $data['summaryDone'] = ServiceLog::where('status',1)
                    ->whereIn('service_id',[1,2])
                    ->count();
        $data['summarySent'] = ServiceLog::where('status',2)
                    ->whereIn('service_id',[1,2])
                    ->count();

        $data['services'] = Service::select('id','name')->where('record_status',1)->get();
		return view('admin.microscopy.list',compact('data'));

      }catch(\Exception $e){
          $error = $e->getMessage();
          return view('admin.layout.error',$error);   // insert query
      }
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
		DB::beginTransaction();
        try {

        if($request->service_id=='Sent for microbiologist review'){         

            $microbio = Microbio::create([
            'enroll_id' => $request->enrollId,
            'sample_id' => $sample_id,
            'service_id' => $request->serviceID,
            'next_step' => '',
            'detail' => '',
            'remark' => '',
            'status' => 0,
            'created_by' => Auth::user()->id,
             'updated_by' => Auth::user()->id
          ]);
        }

        
        if($request->editresult){          
          $sample = Sample::select('id','enroll_id')->where('sample_label',$request->sample_id)->first();
          $microscopyObj = Microscopy::select('id','enroll_id','result')->where('sample_id',$sample->id)->first();
          if($microscopyObj){

            $edit = ResultEdit::create([
              'enroll_id' => $sample->enroll_id,
              'sample_id' => $sample->id,
              'service_id' => $request->service,
              'previous_result' => $microscopyObj->result,
              'updated_result' => $request->result,
              'updated_by' => Auth::user()->id,
              'status' => 1,
              'reason' => $request->reason_edit,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => ''
            ]);

            $data = Microscopy::updateOrCreate(['sample_id' => $sample->id],[
              'sample_id' => $sample->id,
              'enroll_id' => $microscopyObj->enroll_id,
              'result' => $request->result,
              'reason_edit_result' => $request->reason_edit,
              'created_by' => $request->user()->id,
              'updated_by' => $request->user()->id,
              'status' => 1,
            ]);

            $microscopy = $microscopyObj->id;
            $microscopy = Microscopy::find($microscopyObj->id);
            $microscopy->reason_edit = $request->reason_edit;
            $microscopy->is_moved = 0;
            $microscopy->save();
          }
          return redirect('/microbiologist');
        }


  // dd($request->all());


      $logdata = ServiceLog::find($request->service_log_id);
	  //dd($logdata);
        if($request->type=='review'){
          $sample = Sample::select('id')->where('sample_label',$request->sample_id)->first();
          $microscopyObj = Microscopy::select('id','enroll_id','result')->where('sample_id',$sample->id)->first();
		  //dd($microscopyObj);
          if($microscopyObj){
			//DB::enableQueryLog();
			//First delte then create  
			ResultEdit::where('enroll_id',$request->enrollId)->delete(); 
			//dd(DB::getQueryLog());
            $edit = ResultEdit::create([
            'enroll_id' => $request->enrollId,
            'sample_id' => $sample->id,
            'service_id' => $request->serviceID,
            'previous_result' => $microscopyObj->result,
            'updated_result' => $request->result,
            'updated_by' => Auth::user()->id,
            'status' => 1,
            'reason' => $request->reason_other,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => ''
          ]);
        }
      }

     //dd($request->all());
      //Delete from microscopy the add
	  //DB::enableQueryLog();
      //dd('i am here 3');
      Microscopy::where('enroll_id',$logdata->enroll_id)->delete();
      //dd(DB::getQueryLog());	  
	  
      $data = Microscopy::create(['sample_id' => $logdata->sample_id,
        'sample_id' => $logdata->sample_id,
        'enroll_id' => $logdata->enroll_id,
        'result' => $request->result,
        'reason_edit_result' => $request->reason_other,
        'created_by' => $request->user()->id,
        'updated_by' => $request->user()->id,
        'status' => 1,
      ]);
      $logdata->stage=$request->result;
      $logdata->status = 2;
      $logdata->save();
      //ServiceLog::where('enroll_id',$enroll_id->enroll_id)
	  DB::commit();		
	 }catch(\Exception $e){ 
	  
		  //dd($e->getMessage());
		  $error = $e->getMessage();		  
		  DB::rollback(); 		 
		  if($request->type=='review'){
			return redirect('/review_microscopy')->withErrors(['Sorry!! Action already taken of the selected Sample']);
		  }else{
			return redirect('/microscopy')->withErrors(['Sorry!! Action already taken of the selected Sample']);
		  }
		   
	}
      if($request->type=='review'){
        return redirect('/review_microscopy');
      }else{
        return redirect('/microscopy');
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
        //
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

    public function microscopyPrint()
    {
        $data = [];
        $data['sample'] = ServiceLog::select('t_service_log.updated_at as ID','m.enroll_id', 'e.label', 'm.receive_date as receive','m.test_reason as reason','m.sample_quality','is_accepted','s.result','t_service_log.sample_label','t_service_log.service_id','t_service_log.id as log_id', 't_service_log.status')
        ->leftjoin('enrolls as e','e.id','=','t_service_log.enroll_id')
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
        ->whereIn('t_service_log.service_id',[1,2])
        ->whereIn('t_service_log.status',[1,2])
        ->orderBy('enroll_id','desc')
        ->get();
        $data['summaryTotal'] = ServiceLog::whereIn('status',[1,2])
                    ->whereIn('service_id',[1,2])
                    ->count();
        $data['summaryDone'] = ServiceLog::where('status',1)
                    ->whereIn('service_id',[1,2])
                    ->count();
        $data['summarySent'] = ServiceLog::where('status',2)
                    ->whereIn('service_id',[1,2])
                    ->count();
        $data['services'] = Service::select('id','name')->where('record_status',1)->get();
        return view('admin.microscopy.print',compact('data'));
    }


    /**
     *
     * Bulk send to Microscopy Review.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function bulkStore( Request $request ){      


        // Validate User Inputs ===========================================
        $this->validate( $request, [
            'sample_ids' => 'required',
            'test_date'  => 'required|date_format:Y-m-d',
        ] );

       DB::beginTransaction();
        try {
            // User Inputs ====================================================
            $sample_ids = trim( $request->input('sample_ids') );
            $sample_ids = explode(',', $sample_ids);
            $test_date  = $request->input('test_date');
            $result  = $request->input('result');

            // Get Samples from $sample_ids ===================================
            // $samples = Sample::query()->findMany( $sample_ids);
            // dd($sample_ids );
            $data = array();
            foreach($sample_ids as $sample_id){   
           // dd( $sample_id);     

              $data['sample'][$sample_id] = ServiceLog::select('s.id as sample_id', 't_service_log.updated_at as ID','t_service_log.enroll_label',
              't_service_log.enroll_id','t_service_log.sample_label as samples', 't_service_log.stage as stage','t_service_log.status',
              DB::raw('date_format(d.test_date,"%d-%m-%y") as date'),'s.test_reason','m.result','s.fu_month','t_service_log.tag',
                              't_service_log.status as STATUS','t_service_log.sample_id','t_service_log.service_id','t_service_log.rec_flag','d.sent_for AS Deconta_sent_for')
                              ->leftjoin('t_microscopy as m','m.sample_id','=','t_service_log.sample_id')
                              ->leftjoin('t_decontamination as d','d.sample_id','t_service_log.sample_id')
                              ->leftjoin('sample as s','s.id','t_service_log.sample_id')
                             ->whereIn('t_service_log.status',[1]) // ->whereIn('t_service_log.status',[1,2,0])
                             //->where('t_service_log.service_id',3)
                             ->where('t_service_log.id',$sample_id)
                             ->orderBy('t_service_log.enroll_label','desc')
                             ->distinct()
                             ->get();  
                //dd($data['sample']);                                        
              }
             //dd(count($data['sample']));
              if(count($data['sample']) > 0){ 
                 // die(count($data['sample']));
                foreach($data['sample'] as $key => $value){
               //dd($value);
                  // Update if exists or create new if not, in Decontamination ==
                  /** @var Sample $sample */
                 Microscopy::create([
                    'enroll_id' => $value[0]['enroll_id'],
                    'sample_id' => $value[0]['sample_id'],
                    'status'    => '1',        
                    //'status'    => Microscopy::STATUS_ACTIVE,        
                    'test_date' => $test_date,
                    'result' => $result,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id
                  ]);
                  // Log this change to ServiceLog ==============================
                  ServiceLog::where([
                    'id' => $key,
                   // 'enroll_id'     => $data['sample'][0]['enroll_id'],
                   // 'sample_label'  => $data['sample'][0]['enroll_label'],
                    //'service_id'    => $data['sample'][0]['service_id'],
                    
                    //'service_id'    => ServiceLog::TYPE_DECONTAMINATION,
                  ])->update([
                    'tag'=> $value[0]['tag'],
                    'stage'=> $result,
                    'status' => '0',
                    //'status' => Microscopy::SERVICE_STATUS_ACTIVE,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                  ]); 


                  ServiceLog::create([
                    'enroll_id' => $value[0]['enroll_id'],
                    'sample_id' => $value[0]['sample_id'],
                    'service_id' => $value[0]['service_id'],                  
                    'status'    => '2', 
                    'enroll_label'    => $value[0]['enroll_label'], 
                    'sample_label'    => $value[0]['samples'],
                    'tag'    => $value[0]['tag'],
                    //'tag'    => $value->tag, 
                    //'stage'    => $value[0]['stage'], 
                    'stage'=> $result,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id
                  ]);
               }             
            }     
           DB::commit();
        }catch(\Exception $e){
        //dd($e->getMessage()); 
       DB::rollback();
        /*return redirect('/dash_decontamination')->withErrors(['Sorry!! Action already taken of the selected Sample']);*/
        return back(); // Return back from where the request has come.
    }  
   return back(); // Return back from where the request has come.

}
}
