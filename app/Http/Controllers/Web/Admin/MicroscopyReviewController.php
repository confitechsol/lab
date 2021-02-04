<?php

namespace App\Http\Controllers\Web\Admin;

use App\Model\Sample;
use App\Model\Service;
use App\Model\ServiceLog;
use App\Model\Microscopy;
use App\Model\Microbio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Model\RequestServices;
use Illuminate\Support\Facades\Config;

class MicroscopyReviewController extends Controller
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
        $data['sample'] = ServiceLog::select('t_service_log.updated_at as ID','m.enroll_id', 'e.label','m.sample_quality' ,
        'm.receive_date as receive','m.test_reason as reason','is_accepted','s.result','t_service_log.sample_label','t_service_log.stage',
		't_service_log.service_id','t_service_log.id as log_id', 't_service_log.status','m.fu_month','m.service_id as serviceID',
		't_service_log.enroll_id AS enrollID','t_service_log.tag','t_service_log.sample_id','t_service_log.rec_flag' )
        ->leftjoin('enrolls as e','e.id','=','t_service_log.enroll_id')
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
        ->whereIn('t_service_log.service_id',[1,2])
        ->whereIn('t_service_log.status',[2]) //->whereIn('t_service_log.status',[0,2])
        ->orderBy('enroll_id','desc')
        ->get();

      //dd($data['sample']);


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
         $data['microscopy_test'] = ServiceLog::select('id')->whereIn('status',[0,1,2])->whereIn('service_id',[1,2])->count();

         $data['microscopy_tested'] = ServiceLog::select('id')->where('status',1)->whereIn('service_id',[1,2])->count();


         $data['microscopy_review'] = ServiceLog::select('id')->where('status',2)->whereIn('service_id',[1,2])
                        ->count();

        //dd($data['sample']);
        $data['services'] = Service::select('id','name')->get();
		//dd( $data['services']);
        return view('admin.microscopyreview.list',compact('data'));
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
// dd($request->all());
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

    public function mreviewPrint()
    {
        $data = [];
        $data['sample'] = ServiceLog::select('t_service_log.updated_at as ID','m.enroll_id', 'e.label','m.sample_quality' ,'m.receive_date as receive','m.test_reason as reason','is_accepted','s.result','t_service_log.sample_label','t_service_log.service_id','t_service_log.id as log_id', 't_service_log.status' )
        ->leftjoin('enrolls as e','e.id','=','t_service_log.enroll_id')
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
        ->whereIn('t_service_log.service_id',[1,2])
        ->whereIn('t_service_log.status',[2])
        ->orderBy('enroll_id','desc')
        ->get();

         $data['microscopy_test'] = ServiceLog::select('id')->where('status',1)->whereIn('service_id',[1,2])->count();

         $data['microscopy_tested'] = ServiceLog::select('id')->where('status',2)->whereIn('service_id',[1,2])->count();


         $data['microscopy_review'] = ServiceLog::select('id')->where('status',2)->whereIn('service_id',[1,2])
                        ->count();


        $data['services'] = Service::select('id','name')->get();
        return view('admin.microscopyreview.print',compact('data'));
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
            //'test_date'  => 'required|date_format:Y-m-d',
        ] );

       DB::beginTransaction();
        try {            
            // User Inputs ====================================================
            $sample_ids = trim( $request->input('sample_ids') );
            $sample_ids = explode(',', $sample_ids);           
            $comments  = $request->input('comments');
            $service_id1  = $request->input('service_id1');  
            $service_name  = $request->input('service_name');           
            $service_data = Service::where('id',$service_id1)->first();             

            // Get Samples from $sample_ids ===================================
            // $samples = Sample::query()->findMany( $sample_ids);           
            $data = array();
            foreach($sample_ids as $sample_id){ 

                $data['sample'][$sample_id]  = ServiceLog::where('t_service_log.id',$sample_id)->first();                              
            }            
            if(count($data['sample']) > 0){                  
                foreach($data['sample'] as $key => $value){
                    
                   // dd($value);
                  // Log this change to ServiceLog ==============================
                  
                  if($service_id1 == 25){
                      Microbio::create([
                        'enroll_id' => $value->enroll_id,
                        'sample_id' => $value->sample_id,
                        'service_id' => 14,
                        //'service_id' => $value->service_id,
                        //'service_id' => $service_id1,
                        'status'    => '0',        
                        'report_type'    => 'End Of Report',        
                        'tag' => $value->tag,
                        'next_step' => '',
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id
                      ]);


                        ServiceLog::where([
                            'id' => $key,                   
                          ])->update([
                            'comments'=> $comments,
                            'service_id'=> 14,
                            //'stage'=> 0,
                            'status' => 0,                    
                            'created_by' => Auth::user()->id,
                            'updated_by' => Auth::user()->id,
                          ]);


                  }else{
                    //dd($value);
                ServiceLog::where([
                    'id' => $key,                   
                  ])->update([
                    'comments'=> $comments,
                    //'stage'=> 0,
                    'status' => 0,                    
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                  ]); 
                  ServiceLog::create([
                    'enroll_id' => $value->enroll_id,
                    'sample_id' => $value->sample_id,
                    //'service_id' => $value->service_id,
                    'service_id' => $service_id1,
                    'status'    => '1', 
                    'enroll_label'    => $value->enroll_label, 
                    'sample_label'    => $value->sample_label, 
                    //'tag'    => $service_data['name'], 
                    'tag'    => $service_name, 
                    //'tag'    => $value->tag, 
                    //'status'    => '0', 
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id
                  ]);
                  }
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
