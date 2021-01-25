<?php

namespace App\Http\Controllers\Web\Admin;

use App\Model\Sample;
use App\Model\Service;
use App\Model\ServiceLog;
use App\Model\Microscopy;
use App\Model\DNAextraction;
use App\Model\Decontamination;
use App\Model\RequestServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;

class DNAextractionController extends Controller
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
        $data['today'] = date('d-m-Y H:i:s');
		//DB::enableQueryLog();
        $data['sample'] = ServiceLog::select('t_service_log.updated_at as ID','m.enroll_id', 'm.receive_date as receive',
                    'm.test_reason as reason','is_accepted','s.result','t_service_log.sample_label as samples',
                    't_service_log.service_id','t_service_log.id as log_id', 't_service_log.status','m.no_of_samples',
                    't.status as dna_status','t_service_log.tag',DB::raw('date_format(d.test_date,"%d-%m-%y") as decontamination_date'),
                    't.created_at as extraction_date','t_service_log.status as STATUS','t_service_log.rec_flag','t_service_log.sample_id')
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        ->leftjoin('t_dnaextraction as t', function ($join) {
              $join->on('t.sample_id','=','t_service_log.sample_id')
                   ->where('t.status', 1);
          })
        ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
        ->leftjoin('t_decontamination as d', function ($join) {
              $join->on('d.sample_id','=','t_service_log.sample_id')
                   ->where('d.status', 1);
          })
        ->where('t_service_log.service_id',8)
        ->whereIn('t_service_log.status',[1]) //  ->whereIn('t_service_log.status',[0,1,2])
        ->orderBy('enroll_id','desc')
        ->distinct()
        ->groupBy('log_id') //made changes for multiple records displaying in DNA-EXTRACTION
        ->get();
        //dd($data['sample'] );
         //dd(DB::getQueryLog());

        foreach ($data['sample'] as $key => $value) {
            $value->no_sample = ServiceLog::where('enroll_id',$value->enroll_id)->where('service_id',11)->count();
			
		    //Test Request
		    $services=RequestServices::select('service_id','enroll_id')->where('enroll_id',$value->enroll_id)->get();
			//dd($services);
			$data['test_requested['.$value->enroll_id.']']='';
			$data['services_col_color['.$value->enroll_id.']']='N';
			if(!$services->isEmpty()){ //echo "hi"; die;					
				//$result[]='';
				
				unset($result);//reinitialize array
				foreach($services as $serv){
					$result[] = Config::get('m_services_array.tests')[$serv->service_id] ?? null;						
				}
				//dd($result);
				//dd(count($result));
				// comma in the array 
				$data['test_requested['.$value->enroll_id.']'] = implode(', ', $result); 
				//dd($data);
				//For display green colour for more than 1 services
				if(count($result)>1)
				{
					$data['services_col_color['.$value->enroll_id.']']='Y';
				}				
				
			}
        }
		//dd($data['sample']);
		//dd($data['sample'][0]['no_sample']);
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
		//dd($data['sample']);
		
        return view('admin.DNAextraction.list',compact('data'));
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
        $log = ServiceLog::find($request->log_id);
        $data = DNAextraction::create([
          'enroll_id' => $log->enroll_id,
          'sample_id' => $log->sample_id,
          'created_by' => $request->user()->id,
          'updated_by' => $request->user()->id,
          'status' => 1
        ]);
        $log->status = 2;
        $log->save();
        return redirect('/DNAextraction');
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
    /*store datqa from dnaextraction popup*/
    public function DNANext(Request $request)
    {
     dd($request->all());

     $sample_arr = array();
        $sample_arr = $request->logID;
        $data_arr = $request->all();

	 DB::beginTransaction();
     try { 
       
      $log = ServiceLog::find($request->service_log_id);
       if(($request->service_id==4)||($request->service_id== 5)||($request->service_id ==6)){
			  //DB::enableQueryLog();	
			  $data = DNAextraction::create([
				'enroll_id' => $log->enroll_id,
				'sample_id' => $log->sample_id,
				'created_by' => $request->user()->id,
				'updated_by' => $request->user()->id,
				'tag'=>$request->tag,				
				'created_at' => date("Y-m-d H:i:s",strtotime($request->date_ext)),
				'status' => 1
			  ]);
			  //dd(DB::getQueryLog());
	   }
      //dd('ddd');
        if($request->service_id == 1){
		  $storagelog = ServiceLog::where('enroll_id',$request->enroll_id)->where('service_id',11)->first();     
          
          if($storagelog){
			  $log = ServiceLog::find($request->service_log_id);
			  $log->status =99;
			  $log->updated_by = $request->user()->id;			 
			  $log->save();
            
			$new_service = [
				  'enroll_id' => $log->enroll_id,
				  'sample_id' => $storagelog->sample_id,
				  'service_id' => $request->service_id == 1?3:8,
				  'status' => 1,
				  'tag' => $log->tag,
				  'rec_flag' => $log->rec_flag,
				  'reported_dt'=>date('Y-m-d'),
				  'created_by' => $request->user()->id,
				  'updated_by' => $request->user()->id,
				  'enroll_label' => $storagelog->enroll_label,
				  'sample_label' => $storagelog->sample_label,
				 ];

				 $nwService = ServiceLog::create($new_service);
				 
				 //Update storage sample
				$storagelog->updated_by = $request->user()->id;
			    $storagelog->status = 0;           
                $storagelog->save();

          }
          //return redirect('/DNAextraction');
        }elseif($request->service_id == 2){//Extraction with stand by sample
          
          $storagelog = ServiceLog::where('enroll_id',$request->enroll_id)->where('service_id',11)->first();
          if($storagelog){
			  $log = ServiceLog::find($request->service_log_id);
			  //$log->status = 0;
			  $log->status = 99;
			  $log->updated_by = $request->user()->id;
			  //$data = $log;
			  $log->save();
			  
            /*$log->service_id = $request->service_id == 2?8:3;
            $log->updated_by = $request->user()->id;
			$log->rec_flag = $request->rec_flag;
            //$data = $log;
            $log->save();*/
			$new_service = [
				  'enroll_id' => $log->enroll_id,
				  'sample_id' => $storagelog->sample_id,
				  'service_id' => $request->service_id == 2?8:3,
				  'status' => 1,
				  'tag' => $log->tag,
				  'rec_flag' => $log->rec_flag,
				  'reported_dt'=>date('Y-m-d'),
				  'created_by' => $request->user()->id,
				  'updated_by' => $request->user()->id,
				  'enroll_label' => $storagelog->enroll_label,
				  'sample_label' => $storagelog->sample_label,
				 ];

				 $nwService = ServiceLog::create($new_service);
				 
				 //Update storage sample
				$storagelog->updated_by = $request->user()->id;
			    $storagelog->status = 0;           
                $storagelog->save();
          }
          //return redirect('/DNAextraction');
        }elseif($request->service_id == 3){
          $old_sample = Sample::select('sample_label')->where('id',$log->sample_id)->first();
          $new_sample = $old_sample->sample_label.'R';
          Sample::where('id',$log->sample_id)->update(['sample_label'=>$new_sample]);
          ServiceLog::where('sample_id',$log->sample_id)->where('status','!=',0)->update(['sample_label'=>$new_sample]);
          $log = ServiceLog::find($request->service_log_id);
          $log->status = 1;
		  $log->rec_flag = $request->rec_flag;
          $log->sample_label = $new_sample;
          $log->updated_by = $request->user()->id;
          //$data = $log;
          $log->save();
		  
          /*DNAextraction::where('sample_id', $log->sample_id)
          ->where('enroll_id', $request->enroll_id)
          ->where('status',1)
          ->update(['status' => 0]);*/
          //return redirect('/DNAextraction');
        }elseif($request->service_id == 4 || $request->service_id == 5 || $request->service_id == 6){
          if($request->service_log_id > 0){
            $service = ServiceLog::find($request->service_log_id);
			//dd($service);
            $service->released_dt=date('Y-m-d');
            $service->comments=$request->comments;
            $service->tested_by=$request->user()->name;
            $service->status = 0;
            $service->updated_by = $request->user()->id;
            $service->save();
            if($request->service_id == 4 ) {
              $tag = '1st line LPA';
            }
			if($request->service_id == 5){
              $tag = '2nd line LPA';
            }
			
			/*else{
              $tag = '1st line LPA  and for 2nd line LPA';
            }*/
			if($request->service_id == 6){//1st line LPA  and for 2nd line LPA
			  for($i=1;$i<=2;$i++){
				  if($i==1){
					  $tag = '1st line LPA';
				  }else{
					  $tag = '2nd line LPA';
				  }
				  $new_service = [
				  'enroll_id' => $service->enroll_id,
				  'sample_id' => $service->sample_id,
				  'service_id' => 12,
				  'status' => 1,
				  'tag' => $tag,
				  'rec_flag' => $request->rec_flag,
				  'reported_dt'=>date('Y-m-d'),
				  'created_by' => $request->user()->id,
				  'updated_by' => $request->user()->id,
				  'enroll_label' => $service->enroll_label,
				  'sample_label' => $service->sample_label,
				 ];

				 $nwService = ServiceLog::create($new_service);
			  }
			}else{	
				$new_service = [
				  'enroll_id' => $service->enroll_id,
				  'sample_id' => $service->sample_id,
				  'service_id' => 12,
				  'status' => 1,
				  'tag' => $tag,
				   'rec_flag' => $request->rec_flag,
				  'reported_dt'=>date('Y-m-d'),
				  'created_by' => $request->user()->id,
				  'updated_by' => $request->user()->id,
				  'enroll_label' => $service->enroll_label,
				  'sample_label' => $service->sample_label,
				];

				$nwService = ServiceLog::create($new_service);
			}
            //return $nwService;
            //return redirect('/DNAextraction');
         }
        }
		 DB::commit();
       }catch(\Exception $e){
			DB::rollback();
			return redirect('/DNAextraction')
			->withErrors(['Sorry!! Action already taken of the selected Sample']);
	   }
	  
	   return redirect('/DNAextraction');
	}


    public function dnaextractprint()
    {

        $data = [];
        $data['today'] = date('d-m-Y H:i:s');
        $data['sample'] = ServiceLog::select('t_service_log.updated_at as ID','m.enroll_id', DB::raw('date_format(m.receive_date,"%d-%m-%y") as receive'),'m.test_reason as reason','is_accepted','s.result','t_service_log.sample_label as samples','t_service_log.service_id','t_service_log.id as log_id', 't_service_log.status','m.no_of_samples','t.status as dna_status','t_service_log.tag',DB::raw('date_format(d.test_date,"%d-%m-%y") as decontamination_date'),DB::raw('date_format(t.created_at,"%d-%m-%y") as extraction_date'))
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        ->leftjoin('t_dnaextraction as t', function ($join) {
              $join->on('t.sample_id','=','t_service_log.sample_id')
                   ->where('t.status', 1);
          })
        ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
        ->leftjoin('t_decontamination as d', function ($join) {
              $join->on('d.sample_id','=','t_service_log.sample_id')
                   ->where('d.status', 1);
          })
        ->where('t_service_log.service_id',8)
        ->whereIn('t_service_log.status',[1,2])
        ->orderBy('enroll_id','desc')
        ->distinct()
        ->get();
		

        return view('admin.DNAextraction.print',compact('data'));

    }
}
