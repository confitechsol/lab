<?php

namespace App\Http\Controllers\Web\Admin;

use App\Model\Sample;
use App\Model\Service;
use App\Model\ServiceLog;
use App\Model\Microscopy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Microbio;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

class ServiceLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
		
        if($request->service_log_id > 0){ //service_log_id=auto increment id of t_service_log
		DB::beginTransaction();
        try {
          
		  //check old service id
          $service = ServiceLog::find($request->service_log_id);          
          $pre_service_id =  $service->service_id;

         //dd($pre_service_id);
			if($request->service_id=='12' && ($pre_service_id==1 || $pre_service_id==2)){
				$microbio = Microbio::create([
				'enroll_id' => $service->enroll_id,
				'sample_id' => $service->sample_id,
				'service_id' => $pre_service_id,
				'next_step' => '',
				'detail' => '',
				'remark' => '',
				'status' => 0,
				'created_by' => $request->user()->id,
				 'updated_by' => $request->user()->id
			  ]);
				return $microbio;
			}

            $status = ServiceLog::STATUS_ACTIVE;
            if( $request->service_id == ServiceLog::TYPE_STORAGE ){
                $status = ServiceLog::STATUS_STORAGE;
            }
          
		    $data_exist_chk = ServiceLog::where('sample_id', '=',$service->sample_id)
				->where('service_id', '=',$request->service_id)
				->where('status', '!=',0)
				->count();
				//dd($data_exist_chk); die;
		  if($data_exist_chk>0)
		  {
			  
			  $service->comments=$request->comments;
			  $service->tested_by=$request->user()->name;
			  $service->released_dt=date('Y-m-d');
			  $service->status = 0;
			  $service->updated_by = $request->user()->id;
			  $service->save();
			  
			  
			  //if service id is same update tags		      
			  $nwService =ServiceLog::updateOrCreate(
				['sample_id' => $service->sample_id, 'service_id' => $request->service_id, 'status' => 1],
				['comments' =>$request->comments,'tag' =>$request->tag,'tested_by' =>$request->user()->name,'released_dt' =>date('Y-m-d'),'updated_by' =>$request->user()->id]
			 );
			  //then insert into service log
			  $new_service = [
				'enroll_id' => $service->enroll_id,
				'sample_id' => $service->sample_id,
				'service_id' => $request->service_id,
				'status' => $status,
				'tag' => $request->tag,
				'rec_flag' => $request->rec_flag,
				'reported_dt' => date('Y-m-d'),
				'created_by' => $request->user()->id,
				'updated_by' => $request->user()->id,
				'enroll_label' => $service->enroll_label,
				'sample_label' => $service->sample_label,
			  ];

			  $nwService = ServiceLog::create($new_service);
			  
		  }else{//Else insert
		      //updating the current service status to 0 and creating new service if new service is different
			  $service->comments=$request->comments;
			  $service->tested_by=$request->user()->name;
			  $service->released_dt=date('Y-m-d');
			  $service->status = 0;
			  $service->updated_by = $request->user()->id;
			  $service->save();
			   
			   
			   
			  $new_service = [
				'enroll_id' => $service->enroll_id,
				'sample_id' => $service->sample_id,
				'service_id' => $request->service_id,
				'status' => $status,
				'tag' => $request->tag,
				'rec_flag' => $request->rec_flag,
				'reported_dt' => date('Y-m-d'),
				'created_by' => $request->user()->id,
				'updated_by' => $request->user()->id,
				'enroll_label' => $service->enroll_label,
				'sample_label' => $service->sample_label,
			  ];

			  $nwService = ServiceLog::create($new_service);
		  }
          // if($pre_service_id==1 || $pre_service_id==2){
          //   ServiceLog::microscopyLog($request);
          // }elseif($pre_service_id==8){
          //   ServiceLog::dnaExtractionLog($request);
          // }
		  DB::commit();		
		 }catch(\Exception $e){ 
		  
			  //dd($e->getMessage());
			  $error = $e->getMessage();		  
			  DB::rollback(); 		 
			  return $error;
			   
		}
          return $nwService;
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
	public function checkForSampleAlreadyInProcess($sample_id,$enroll_id,$service_id,$tag=null,$recflag)
    { 
	       
		    //echo $sample_id."=".$enroll_id."==".$service_id."===".$tag."====".$recflag; die;
			$statussql=" AND status = 0 ";
			if($service_id==1 || $service_id==2)
			{
				$statussql=" AND status=2";
			}
			if($service_id==21)
			{
				$statussql=" AND status=0";
			}
            if($service_id==22)
			{
				$statussql=" AND status=0 ";
			}	
            //DB::enableQueryLog();			
			$servicelog = DB::select("SELECT IFNULL(count(*),0) AS v_count FROM t_service_log 
			WHERE sample_id = ".$sample_id."
			AND enroll_id =".$enroll_id."
			AND service_id =".$service_id."
			".$statussql."
			AND tag = '".$tag."'
			AND rec_flag = ".$recflag);
			//dd(DB::getQueryLog());
			//dd($servicelog);
		    //dd($servicelog[0]->v_count);	   

			echo json_encode($servicelog[0]->v_count);
			exit;
	}
	public function checkForSampleAlreadyInProcessMicroscopyNext($sample_id,$enroll_id,$service_id,$tag=null,$recflag)
    { 
	       
		    
			$statussql=" AND status=0 ";
				
            //DB::enableQueryLog();			
			$servicelog = DB::select("SELECT IFNULL(count(*),0) AS v_count FROM t_service_log 
			WHERE sample_id = ".$sample_id."
			AND enroll_id =".$enroll_id."
			AND service_id =".$service_id."
			".$statussql."
			AND tag = '".$tag."'
			AND rec_flag = ".$recflag);
			//dd(DB::getQueryLog());
			//dd($servicelog);
		    //dd($servicelog[0]->v_count);	   

			echo json_encode($servicelog[0]->v_count);
			exit;
	}

	public function checkForSampleAlreadyInProcess12($sample_id,$enroll_id,$service_id,$tag=null,$recflag,$res=null)
    { 
	      // dd('i am here');
		    //echo $sample_id."=".$enroll_id."==".$service_id."===".$tag."====".$recflag."++".$res; die;
			$statussql=" AND status = 0 ";
			if($service_id==1 || $service_id==2)
			{
				$statussql=" AND status=2";
			}
			if($service_id==21)
			{
				$statussql=" AND status=0";
			}
            if($service_id==22)
			{
				$statussql=" AND status=0 ";
			}	
            //DB::enableQueryLog();			
			$servicelog = DB::select("SELECT IFNULL(count(*),0) AS v_count FROM t_service_log 
			WHERE sample_id = ".$sample_id."
			AND enroll_id =".$enroll_id."
			AND service_id =".$service_id."
			".$statussql."
			AND tag = '".$tag."'
			AND rec_flag = ".$recflag);
			//dd(DB::getQueryLog());
			//dd($servicelog);
		    //dd($servicelog[0]->v_count);	

			if($res == null){
				

			}else if($res != null){
			$mrscopy_result = Microscopy::where('sample_id', $sample_id)->where('enroll_id', $enroll_id)->first();
			if(isset($mrscopy_result)){

			Microscopy::where([
			    'sample_id' => $sample_id,                   
			    'enroll_id' => $enroll_id,                   
			  ])->update([
			    'result'=> $res,                            
			  ]);
			}else{

				Microscopy::create([
                    'enroll_id' => $enroll_id,
                    'sample_id' => $sample_id,
                    'status'    => '1', 
                    'result' => $res,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id
                  ]);

			}

			}    

			echo json_encode($servicelog[0]->v_count);
			exit;
	}

	public function checkForSampleAlreadyInProcessPcr($sample_id,$enroll_id,$service_id,$tag=null,$recflag)
    { 
	       
		    //echo $sample_id."=".$enroll_id."==".$service_id."===".$tag."====".$recflag; die;
			$statussql=" AND status = 0 ";
			if($service_id==1 || $service_id==2)
			{
				$statussql=" AND status=2";
			}
			if($service_id==21)
			{
				$statussql=" AND status=0";
			}
            if($service_id==22)
			{
				$statussql=" AND status=0 ";
			}	
            //DB::enableQueryLog();			
			$servicelog = DB::select("SELECT IFNULL(count(*),0) AS v_count FROM t_service_log 
			WHERE sample_id = ".$sample_id."
			AND enroll_id =".$enroll_id."
			AND service_id =".$service_id."
			".$statussql."
			AND tag = '".$tag."'
			AND rec_flag = ".$recflag);
			//dd(DB::getQueryLog());
			//dd($servicelog);
		    //dd($servicelog[0]->v_count);	   

			$result = array(
				'result' => $servicelog[0]->v_count,
				'sample_id' => $sample_id
			);

			echo json_encode($result);
			exit;
	}


	public function checkForSampleAlreadyInProcessDnr($sample_id,$enroll_id,$service_id,$tag=null,$recflag)
    { 
	       
		    //echo $sample_id."=".$enroll_id."==".$service_id."===".$tag."====".$recflag; die;
			$statussql=" AND status = 0 ";
			if($service_id==1 || $service_id==2)
			{
				$statussql=" AND status=2";
			}
			if($service_id==21)
			{
				$statussql=" AND status=0";
			}
            if($service_id==22)
			{
				$statussql=" AND status=0 ";
			}	
            //DB::enableQueryLog();			
			$servicelog = DB::select("SELECT IFNULL(count(*),0) AS v_count FROM t_service_log 
			WHERE sample_id = ".$sample_id."
			AND enroll_id =".$enroll_id."
			AND service_id =".$service_id."
			".$statussql."
			AND tag = '".$tag."'
			AND rec_flag = ".$recflag);
			//dd(DB::getQueryLog());
			//dd($servicelog);
		    //dd($servicelog[0]->v_count);	   

			$result = array(
				'result' => $servicelog[0]->v_count,
				'sample_id' => $sample_id
			);

			echo json_encode($result);
			exit;
	}

	public function checkForSampleAlreadyInProcessMigit($sample_id,$enroll_id,$service_id,$tag=null,$recflag)
    { 
	       
		    //echo $sample_id."=".$enroll_id."==".$service_id."===".$tag."====".$recflag; die;
			$statussql=" AND status = 0 ";
			if($service_id==1 || $service_id==2)
			{
				$statussql=" AND status=2";
			}
			if($service_id==21)
			{
				$statussql=" AND status=0";
			}
            if($service_id==22)
			{
				$statussql=" AND status=0 ";
			}	
            //DB::enableQueryLog();			
			$servicelog = DB::select("SELECT IFNULL(count(*),0) AS v_count FROM t_service_log 
			WHERE sample_id = ".$sample_id."
			AND enroll_id =".$enroll_id."
			AND service_id =".$service_id."
			".$statussql."
			AND tag = '".$tag."'
			AND rec_flag = ".$recflag);
			//dd(DB::getQueryLog());
			//dd($servicelog);
		    //dd($servicelog[0]->v_count);	   

			$result = array(
				'result' => $servicelog[0]->v_count,
				'sample_id' => $sample_id
			);

			echo json_encode($result);
			exit;
	}
	
	public function checkForSampleAlreadyInProcessMicroscopyNextDeconta($sample_id,$enroll_id,$service_id,$tag=null,$recflag)
    {   
		    
			$statussql=" AND status=0 ";
				
            //DB::enableQueryLog();			
			$servicelog = DB::select("SELECT IFNULL(count(*),0) AS v_count FROM t_service_log 
			WHERE sample_id = ".$sample_id."
			AND enroll_id =".$enroll_id."
			AND service_id =".$service_id."
			".$statussql."
			AND tag = '".$tag."'
			AND rec_flag = ".$recflag);
			//dd(DB::getQueryLog());
			//dd($servicelog);
			//dd($servicelog[0]->v_count);	
			$result = array(
						'result' => $servicelog[0]->v_count,
						'sample_id' => $sample_id
			);

			echo json_encode($result);
			exit;
	}
	
}
