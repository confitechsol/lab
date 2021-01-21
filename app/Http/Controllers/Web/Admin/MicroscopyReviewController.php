<?php

namespace App\Http\Controllers\Web\Admin;

use App\Model\Sample;
use App\Model\Service;
use App\Model\ServiceLog;
use App\Model\Microscopy;
use Illuminate\Http\Request;
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
}
