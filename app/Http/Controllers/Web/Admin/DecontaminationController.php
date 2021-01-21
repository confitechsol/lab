<?php

namespace App\Http\Controllers\Web\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Decontamination;
use App\Model\Sample;
use App\Model\Service;
use App\Model\Microscopy;
use App\Model\Enroll;
use App\Model\ServiceLog;
use App\Model\RequestServices;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Model\Microbio;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class DecontaminationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

            $data = [];
            $data['today'] = date('Y-m-d H:i:s');

            // $data['services'] = ['1' => 'ZN Microscopy', '2' => 'FM Microscopy', '3' => 'Culture inoculation for LC', '4' => 'Culture inoculation for LJ', '5' => 'Culture inoculation for LC & LJ', '8' => 'DNA Extraction'];

            $data['services'] = ['1' => 'ZN Microscopy', '2' => 'FM Microscopy', '3' => 'Liquid Culture', '4' => 'Solid Culture', '5' => 'Solid and Liquid Culture','6' => 'Request for another sample', '8' => 'LPA 1st line', '10' => 'LPA 2nd line', '11' => 'LPA 1st & 2nd Line', '7' => 'For storage','9'=>'Cbnaat'];

            // $data['services_copy'] = ['1' => 'ZN Microscopy', '2' => 'FM Microscopy', '5' => 'Liquid Culture', '4' => 'Solid Culture', '5' => 'Solid and Liquid Culture', '8' => 'DNA Extraction', '6' => 'Request for another sample', '7' => 'For storage', '9' => 'BWM'];

            $data['sample'] = ServiceLog::select('t_service_log.updated_at as ID','t_service_log.enroll_label',
            't_service_log.sent_to as sent_for_service',
            't_service_log.enroll_id','t_service_log.sample_label as samples',
            't_service_log.sample_id as sample_id','s.test_reason',
            's.sample_type','m.result as result','t_service_log.tag','s.fu_month',
            's.no_of_samples',
            't_service_log.status','t_service_log.service_id','t_service_log.rec_flag','d.sent_for AS Deconta_sent_for')
             ->leftjoin('t_decontamination as d','d.sample_id','t_service_log.sample_id')
             // ->leftjoin('t_decontamination as d',function($join)
             //            {

             //                  $join->on('t_service_log.sample_id','=','d.sample_id')
             //                        ->where('t_service_log.enroll_id','=','d.enroll_id');
             //            })
             ->leftjoin('sample as s','s.id','=','t_service_log.sample_id')
             // ->leftjoin('m_services as sr','sr.id','=','d.sent_for')
             ->leftjoin('t_microscopy as m',function($join)
                        {

                              $join->on('m.sample_id','=','t_service_log.sample_id')
                                    ;
                        })
            ->whereIn('t_service_log.status',[2]) //        ->whereIn('t_service_log.status',[0,2])
            ->where('t_service_log.service_id','=',3)
            //->where('sr.name','!=',null)
            ->orderBy('t_service_log.enroll_id','desc')
            ->distinct()
            ->get();
            //dd($data['sample']);
            foreach ($data['sample'] as $key => $value) {
              $value->no_sample = ServiceLog::where('enroll_id',$value->enroll_id)->where('service_id',11)->count();
              $date = DB::table('t_decontamination as d')->select(DB::raw('date_format(d.test_date,"%d-%m-%y") as date'))
              ->where('d.sample_id',$value->sample_id)->first();


              $value->date = $date->date ?? null;
            }
            
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

            // $data['sample'] = ServiceLog::select('m.result')
            //             ->leftjoin('t_microscopy as m',function($join)
            //             {

            //                   $join->on('t_service_log.sample_id','=','m.sample_id')
            //                         ->where('t_service_log.enroll_id','=','m.enroll_id');
            //             })
            //             ->get();

            //dd($data['sample']);



            $data['decontamination_test'] = ServiceLog::select('id')->whereIn('status',[0,1,2])->where('service_id',3)->count();

            $data['decontamination_tested'] = ServiceLog::select('id')->where('status',1)->where('service_id',3)->count();


            $data['decontamination_review'] = ServiceLog::select('id')->where('status',2)->where('service_id',3)
                        ->count();


            return view('admin.decontamination.list',compact('data'));

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
			//dd($request->all());
         $en_label = Enroll::select('label as l')->where('id',$request->enrollId)->first();
         $s_id = Sample::select('id as l')->where('sample_label',$request->sample_ids)->first();
         $enroll_label=$en_label->l;
         $sample_id=$s_id->l;
         $services_sent_to='';
         $data['services'] = ['1' => 'ZN Microscopy', '2' => 'FM Microscopy', '3' => 'Liquid Culture', '4' => 'Solid Culture', '5' => 'Solid and Liquid Culture', '6'=> 'Decontamination',  '7' => 'For storage','8' => 'DNA Extraction','9'=>'Cbnaat','Send to BWM' => 'BWM'];
		 //$data['services'] = ['1' => 'ZN Microscopy', '2' => 'FM Microscopy', '3' => 'Liquid Culture', '4' => 'Solid Culture', '5' => 'Solid and Liquid Culture', '8' => 'LPA 1st line', '10' => 'LPA 2nd line', '7' => 'For storage','9'=>'Cbnaat'];
		 $serviceids = $request->service_id;
		 //echo "<pre>"; print_r($serviceids); die;
		 $serviceidpd = $request->service_id;
		 
		 foreach( $serviceids as &$service_id ){
			 if( $service_id == 10 || $service_id == 11 ) $service_id = 8;
			 
		 }
		 $request->service_id = $serviceids ;
		 //echo $service_id; die;
         foreach($data['services'] as $key=>$value){
           if(in_array($key, $request->service_id)){
              $services_sent_to = $services_sent_to . " , " . $value;
           }
         }

         //$services_sent_to = DB::table('m_services')->whereIN('id',$request->service_id)->pluck('name')->toArray();
         $services_sent_to= substr($services_sent_to, 3);
         //dd($services_sent_to);
         //$services_sent_to = implode($services_sent_to,',');
		 //DB::enableQueryLog();
         $logservice_query = ServiceLog::where('enroll_id',$request->enrollId)->where('sample_id',$sample_id);
		 //echo $service_id; die;
         if(\request('from_storage')){			
				$logservice_query->where('service_id', ServiceLog::TYPE_STORAGE);			
         }else{			 
             $logservice_query->where('service_id', ServiceLog::TYPE_DECONTAMINATION);
         }
		 // $logservice = $logservice_query->toSql();
        $logservice = $logservice_query->first();
		//dd($logservice);

             // ->where('service_id',3)->first();
		  if( $service_id == 6 ) 
		  {
			  $services_sent_to = 3;
			  $send_to_service_id = 3;
		  }
		 //echo $services_sent_to; die;
		  
         $logservice->sent_to = $services_sent_to;
         $logservice->save();
		 
		 //dd(DB::getQueryLog());

         //DB::enableQueryLog();
         $log = ServiceLog::where('enroll_id',$request->enrollId)
             ->where('sample_id',$sample_id)			 
			 ->where('sample_label', $request->sample_ids)
			 ->where('service_id', ServiceLog::TYPE_DECONTAMINATION)
			 ->where('rec_flag', $request->rec_flag)
             //->where('status', '!=', 0) // TODO: Need to check behavior for previous logic
			 //->orWhere('status', '!=', 9)			 
             //->orderBy('id', 'desc')
             ->first();
          //dd($log);
		  //dd(DB::getQueryLog());
         if($log){
		   //echo "hh"; die;
           $log->released_dt = date('Y-m-d');
           $log->comments = $request->comments;
           $log->tested_by = $request->user()->name;
           $log->status = 0;
           $log->updated_by = $request->user()->id;
           $data = $log;
           $log->save();
         }
         //dd(DB::getQueryLog());
         if($request->request_another =='on'){
           $log = ServiceLog::where('enroll_id',$request->enrollId)->where('service_id',11)->first();
           if($log){
             $log->service_id = 3;
             $log->status = 1;
             $log->updated_by = $request->user()->id;
             $data = $log;
             $log->save();

           }
           else{
             DB::commit();
             return redirect('/decontamination');
           }
         }
          
		  //echo "<pre>"; print_r($request->service_id); die;
		$tag = '';  
        foreach($request->service_id as $key=>$send_to_service_id){
			
			if($send_to_service_id==1 || $send_to_service_id==2){
                $request->tag = 'MICROSCOPY';
				$tag = 'MICROSCOPY';
            }
            else if($send_to_service_id==3){
                $request->tag = 'LC';
				$tag = 'LC';
            }elseif($send_to_service_id==4){
                $request->tag = 'LJ';
				$tag = 'LJ';
            }elseif($send_to_service_id==5){
                $request->tag = 'LC and LJ Both';
				$tag = 'LC and LJ Both';
            }elseif($send_to_service_id==6){
                $request->tag = 'DECONTAMINATION';
				$tag = 'DECONTAMINATION';
            }elseif($send_to_service_id==9){
                $request->tag = 'CBNAAT';
				$tag = 'CBNAAT';
            }
/*Pradip */
			//echo "<pre>"; print_r($serviceidpd); die;
			if( $send_to_service_id == 8 ){
				
				if($serviceidpd[$key]==8) {
					$request->tag = 'LPA 1st line';
					$tag = 'LPA 1st line';
				}
				if($serviceidpd[$key]==10) {
					$request->tag = 'LPA 2nd line';
					$tag = 'LPA 2nd line';
				}
				if($serviceidpd[$key]==11) {
					$request->tag = 'Both LPA 1st & 2nd Line';
				    $tag = 'Both LPA 1st & 2nd Line';
				}
			}
			//echo "tag".$request->tag; die;
            if($send_to_service_id=='Send to BWM') {
				$decon = Decontamination::select('id')->where('sample_id',$sample_id)->where('enroll_id',$request->enrollId)->first();
				if(!empty($decon)) {
					$decon_obj = Decontamination::find($decon->id);
				}
                $microbio = Microbio::create([
                    'enroll_id' => $request->enrollId,
                    'sample_id' => $sample_id,
                    'service_id' => 26,
                    'next_step' => '',
                    'detail' => '',
                    'remark' => '',
                    'bwm' => 1,
                    'status' => 0,
                    'released_dt'=>date('Y-m-d'),
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id
                ]);
				
				if(!empty($decon)) {
					$decon_obj->status = 9;
					$decon_obj->updated_by = $request->user()->id;
					$decon_obj->save();
				}
                ServiceLog::create([
                   'enroll_id' => $request->enrollId,
                   'sample_id' => $sample_id,
                   'enroll_label' => $enroll_label,
                   'sample_label' => $request->sample_ids,
                   'previous_step' => 'Decontamination',
                   'service_id' => 26,	
                   'reported_dt'=>date('Y-m-d'),
                   'status' => 1,
                   /*'tag' => $request->tag,*/
				   'tag' => 'BWM',				   
                   'test_date' => date('Y-m-d H:i:s'),
                   'created_by' => Auth::user()->id,
                   'updated_by' => Auth::user()->id
                 ]);
              //break;
            }

            if($send_to_service_id==-1) {
			  DB::commit();	
              return redirect('/decontamination');
            }

            if(!$request->other) {
                $request->other='';
            }


            //DB::enableQueryLog();
            ServiceLog::where('enroll_id', $request->enrollId)
                ->where('sample_id', $sample_id)
                ->where('sample_label', $request->sample_ids)
                ->where('service_id', ServiceLog::TYPE_DECONTAMINATION)
				->where('rec_flag', $request->rec_flag)
                ->update([
                    'status' => 0,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                    'released_dt'=>date('Y-m-d'),
                    'tested_by' =>Auth::user()->name
                ]);
                // echo $send_to_service_id;
            //dd(DB::getQueryLog());

            if(
                $send_to_service_id == ServiceLog::TYPE_DECONTAMINATION OR
                $send_to_service_id == ServiceLog::TYPE_CBNAAT OR
                $send_to_service_id == ServiceLog::TYPE_AFB_CULTURE
            ){
                $send_to_service_id = ServiceLog::TYPE_CULTURE_INOCULATION;
            }


            if($send_to_service_id == ServiceLog::TYPE_LPA_2ND_LINE){
                $send_to_service_id = ServiceLog::TYPE_STORAGE;
            }


            if($send_to_service_id == 9){ // Unknown Service ID.
              $send_to_service_id = ServiceLog::TYPE_CBNAAT;
            }
			
			//PD
			 


            Decontamination::create([
                'enroll_id'  => $request->enrollId,
                'sample_id'  => $sample_id,
                'sent_for'   => $send_to_service_id,
                'status'     => 2,
                'test_date'  => date('Y-m-d H:i:s'),
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id
            ]);



            // if($request->service_id=='micro'){
            //  $microbio = Microbio::create([
            //      'enroll_id' => $request->enrollId,
            //      'sample_id' => $sample_id,
            //      'service_id' => 3,
            //      'next_step' => '',
            //      'detail' => '',
            //      'remark' => '',
            //      'status' => 0,
            //      'created_by' => $request->user()->id,
            //       'updated_by' => $request->user()->id
            //    ]);
            //  return redirect('/decontamination');
            // }



            // Default Service status should be "SERVICE_STATUS_ACTIVE".
            $status = ServiceLog::STATUS_ACTIVE;
            if( $send_to_service_id == ServiceLog::TYPE_STORAGE ){
                $status = ServiceLog::STATUS_STORAGE;
            }

			if($service_id == 6 ) 
			{
				$send_to_service_id = 3;
			}
	        if($send_to_service_id!='Send to BWM') {
		    //DB::enableQueryLog();		
            ServiceLog::create([
              'enroll_id' => $request->enrollId,
              'sample_id' => $sample_id,
              'enroll_label' => $enroll_label,
              'sample_label' => $request->sample_ids,
              'service_id' => $send_to_service_id,
              'reported_dt'=>date('Y-m-d'),
              'status' => $status,
              'tag' => !empty($tag)?$tag:$request->tag,
			  'rec_flag' => $request->rec_flag,
              'test_date' => date('Y-m-d H:i:s'),
              'created_by' => Auth::user()->id,
              'updated_by' => Auth::user()->id
            ]);
			//dd(DB::getQueryLog());
		  }
        }

        // if($service_id=='Send to BWM'){
        //   $decon = Decontamination::select('id')->where('sample_id',$sample_id)->where('enroll_id',$request->enrollId)->first();
        //   $decon_obj = Decontamination::find($decon->id);
        //     $microbio = Microbio::create([
        //       'enroll_id' => $request->enrollId,
        //       'sample_id' => $sample_id,
        //       'service_id' => 3,
        //       'next_step' => '',
        //       'detail' => '',
        //       'remark' => '',
        //       'bwm' => 1,
        //       'status' => 0,
        //       'created_by' => Auth::user()->id,
        //        'updated_by' => Auth::user()->id
        //     ]);
        //     $decon_obj->status = 9;
        //     $decon_obj->updated_by = $request->user()->id;
        //     $decon_obj->save();
        //   }

        if( \request('from_storage') ){
			 DB::commit();
             return redirect( route('sample-storage.index') );
        }
		DB::commit();
		return redirect( route('decontamination.index') );
		//return true;
       }catch(\Exception $e){
		    //dd($e->getMessage()); 
			DB::rollback();
			return redirect( route('decontamination.index') )
			->withErrors(['Sorry!! Action already taken of the selected Sample']);
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

    public function decontaminationPrint()
    {

            $data = [];
            $data['today'] = date('Y-m-d H:i:s');

            $data['services'] = ['1' => 'ZN Microscopy', '2' => 'FM Microscopy', '3' => 'Culture inoculation for LC', '4' => 'Culture inoculation for LJ', '5' => 'Culture inoculation for LC & LJ', '8' => 'DNA Extraction'];


            $data['sample'] = ServiceLog::select('t_service_log.updated_at as ID','t_service_log.enroll_label','t_service_log.enroll_id','t_service_log.sample_label as samples','t_service_log.sample_id','d.test_date','d.sent_for','s.test_reason','s.sample_type','m.result as result','t_service_log.tag',DB::raw('date_format(m.created_at,"%d-%m-%y") as date'))
             ->leftjoin('t_decontamination as d',function($join)
                        {

                              $join->on('t_service_log.sample_id','=','d.sample_id')
                                    ->where('t_service_log.enroll_id','=','d.enroll_id');
                        })
             ->join('sample as s','s.id','=','t_service_log.sample_id')
             ->leftjoin('t_microscopy as m',function($join)
                        {

                              $join->on('m.sample_id','=','t_service_log.sample_id')
                                    ;
                        })
            ->where('t_service_log.status',2)
            ->where('t_service_log.service_id',3)
            ->orderBy('t_service_log.enroll_id','desc')
            ->distinct()
            ->get();



            return view('admin.decontamination.print',compact('data'));

    }
	public function checkForSampleAlreadyInProcessInDecontamination($sample_id,$enroll_id,$sent_for=0,$DecontStatus=1)
    { 
	       
		    //echo $sample_id."=".$enroll_id."==".$service_id."===".$tag."====".$recflag; die;
			//echo $sent_for; die;
			$qry=" AND sent_for = 0 ";
			if(!empty($sent_for) || $sent_for!="NULL")
			{
				$qry=" AND sent_for = ".$sent_for." ";
			}	
			//DB::enableQueryLog();		
			$decontlog = DB::select("SELECT IFNULL(count(*),0) AS v_count FROM t_decontamination 
			WHERE sample_id = ".$sample_id."
			AND enroll_id =".$enroll_id."
             ".$qry."			
			AND status = ".$DecontStatus);
			//dd(DB::getQueryLog());
			//dd($decontlog);
		    //dd($decontlog[0]->v_count);	   

			echo json_encode($decontlog[0]->v_count);
			exit;
	}
}
