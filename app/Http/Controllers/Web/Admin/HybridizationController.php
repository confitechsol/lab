<?php

namespace App\Http\Controllers\Web\Admin;

use App\Model\Sample;
use App\Model\Microscopy;
use App\Model\ServiceLog;
use App\Model\Microbio;
use App\Model\Hybridization;
use App\Model\DNAextraction;
use App\Model\Pcr;
use App\Model\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HybridizationController extends Controller
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
          $data['sample'] = ServiceLog::select('t_service_log.updated_at as ID','m.enroll_id','m.id as sample_id',
                  'm.receive_date as receive','m.test_reason as reason','is_accepted','s.result',
                  't_service_log.sample_label as samples','t_service_log.service_id','t_service_log.id as log_id',
                   't_service_log.status','m.no_of_samples','t.status as dna_status','t.created_at as date_of_extraction',
                   'p.completed as pcr_completed','t_service_log.tag','d.test_date as decontamination_date','t_service_log.status as STATUS','t_service_log.sample_id','t_service_log.service_id','t_service_log.rec_flag')
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        ->leftjoin('t_dnaextraction as t', function ($join) {
              $join->on('t.sample_id','=','t_service_log.sample_id')
                   ->where('t.status', 1);
          })
        ->leftjoin('t_decontamination as d', function ($join) {
              $join->on('d.sample_id','=','t_service_log.sample_id')
                   ->where('d.status', 1);
          })
        ->leftjoin('t_pcr as p','p.sample_id','=','t_service_log.sample_id')
        ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
        ->where('t_service_log.service_id',14)
        ->whereIn('t_service_log.status',[1]) //  ->whereIn('t_service_log.status',[0,1,2])
        ->orderBy('enroll_id','desc')
        ->groupBy('log_id') // made changes for multiple records displaying in Hybridisation
        ->groupBy('samples')
        ->get();
        //dd($data['sample']);
        foreach ($data['sample'] as $key => $value) {
           //DB::enableQueryLog(); 		
           $value->no_sample = ServiceLog::where('enroll_id',$value->enroll_id)->where('service_id',11)->count();
		   //dd(DB::getQueryLog());	
          $lpa = ServiceLog::select('service_id')->where('enroll_id',$value->enroll_id)->where('sample_id',$value->sample_id)->first();
          if($lpa->service_id==6){
            $value->lpa_type = "LPA 1st line";
          }elseif($lpa->service_id==7){
            $value->lpa_type = "LPA 2nd line";
          }elseif($lpa->service_id==13){
            $value->lpa_type = "LPA Both Line";
          }else{
            $value->lpa_type = "NA";
          }
        }
		//dd($data['sample']);
		//dd($data['sample'][1]['no_sample']);
        $data['services'] = ["Valid","Invalid","Repeat DNA Extraction from same sample","Repeat DNA Extraction from standby sample", "Repeat Hybridization from same DNA extract"];
        return view('admin.hybridization.list',compact('data'));
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
     try{
		 //echo "hi";
		 //dd($request->all());
        $log = ServiceLog::find($request->service_log_id);

        if($request->service_id==0){
            $result = 'Valid';
        }
        else if($request->service_id==1){
          $result = 'Invalid';
        }
        else if($request->service_id==2){
          $result = 'Repeat DNA Extraction from same sample';
        }
        else if($request->service_id==3){
          $result = 'Repeat DNA Extraction from standby sample';
        }
        else{
          $result = 'Repeat Hybridization from same DNA extract';
        }
		//DB::enableQueryLog();
        //$update=Hybridization::where('sample_id',$log->sample_id)->update(['status'=>0]);
		
		if(($request->service_id == 0)||($request->service_id == 1)){//VALID & INVALID
		    Hybridization::where('enroll_id', $log->enroll_id)->where('tag',$request->tag)->delete();
			$hybridization = Hybridization::create([
			   'enroll_id' => $log->enroll_id,
			   'sample_id' => $log->sample_id,
			   'result' => $result,
			   'status' => 1 ,
			   'tag' => $request->tag		   
			 ]);
		}
		 //dd(DB::getQueryLog());
         //dd($hybridization);
        if($request->service_id == 0){//VALID
          $log = ServiceLog::find($request->service_log_id);
          $log->released_dt=date('Y-m-d');
          $log->comments=$request->comments;
          $log->tested_by=$request->user()->name;
          $log->status = 0;
          $log->updated_by = $request->user()->id;
          $log->save();
		  
          $new_service = [
            'enroll_id' => $log->enroll_id,
            'sample_id' => $log->sample_id,
            'service_id' => 15,
            'status' => 1,
            'reported_dt'=>date('Y-m-d'),
            'tag' => $request->tag,
			'rec_flag' => $request->rec_flag,
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id,
            'enroll_label' => $log->enroll_label,
            'sample_label' => $log->sample_label,
          ];

          $nwService = ServiceLog::create($new_service);		  
		  //echo "hi"; die;
		  DB::commit();
          return $nwService;
        }elseif($request->service_id == 1){//INVALID
          $log = ServiceLog::find($request->service_log_id);
          $log->released_dt=date('Y-m-d');
          $log->comments=$request->comments;
          $log->tested_by=$request->user()->name;
          $log->status = 0;
          $log->updated_by = $request->user()->id;
          $log->save();
          $microbio = Microbio::create([
                'enroll_id' => $log->enroll_id,
                'sample_id' => $log->sample_id,
                'service_id' => 14,
				'rec_flag' => $request->rec_flag,
                'next_step' => '',
                'detail' => '',
                'remark' => '',
                'status' => 0,
                'created_by' => $request->user()->id,
                 'updated_by' => $request->user()->id,
              ]);
		   DB::commit();	  
          return $log;
        }elseif($request->service_id == 2){//Repeat DNA Extraction from same sample
          $log = ServiceLog::find($request->service_log_id);

          $old_sample = Sample::select('sample_label')->where('id',$log->sample_id)->first();
          $new_sample = $old_sample->sample_label.'R';
          Sample::where('id',$log->sample_id)->update(['sample_label'=>$new_sample]);
          ServiceLog::where('sample_id',$log->sample_id)->where('status','!=',0)->update(['sample_label'=>$new_sample]);
          $log->released_dt=date('Y-m-d');
          //$log->status = 0;
		  $log->status = 99;
          $log->comments=$request->comments;
          $log->tested_by=$request->user()->name;
          $log->updated_by = $request->user()->id;
          $log->save();
		  
		  DNAextraction::where('enroll_id',$request->enroll_id)->where('sample_id',$request->sampleID)->delete();                                    
		  Pcr::where('enroll_id',$request->enroll_id)->where('sample_id',$request->sampleID)->where('tag','like',$request->tag)->delete();
		  
          $new_service = [
            'enroll_id' => $log->enroll_id,
            'sample_id' => $log->sample_id,
            'service_id' => 8,
            'status' => 1,
            'reported_dt'=>date('Y-m-d'),
			'tag' => $request->tag,
			'rec_flag' => $request->rec_flag+1,
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id,
            'enroll_label' => $log->enroll_label,
            'sample_label' => $new_sample,
          ];

          $nwService = ServiceLog::create($new_service);
		  DB::commit();
          return $nwService;
        }elseif($request->service_id == 3){//Repeat DNA Extraction from standby sample
          $storagelog = ServiceLog::where('enroll_id',$request->enroll_id)->where('service_id',11)->first(); 
		  if($storagelog){
			  //UPDATE STATUS=0 SERVICE LOG WITH SERVICE_ID=14
			  $log_data = ServiceLog::find($request->service_log_id);          
			  $log_data->status = 0;
			  $log_data->released_dt=date('Y-m-d');
			  $log_data->updated_by = $request->user()->id;			 
			  $log_data->save();

             //UPDATE STATUS=0 SERVICE LOG of storage WITH SERVICE_ID=11			           
			  $storagelog->status = 0;
			  $storagelog->released_dt=date('Y-m-d');
			  $storagelog->updated_by = $request->user()->id;			  
			  $storagelog->save();			  
		       
			   //DELETE FROM 2 TABLES
              DNAextraction::where('enroll_id',$request->enroll_id)->where('sample_id',$request->sampleID)->delete();                                    
		      Pcr::where('enroll_id',$request->enroll_id)->where('sample_id',$request->sampleID)->where('tag','like',$request->tag)->delete();
		  	  
			  //INSERT IN TO SERVICE LOG   
			  $new_service = [
				  'enroll_id' => $log_data->enroll_id,
				  'sample_id' => $storagelog->sample_id,
				  'service_id' => 8,
				  'status' => 1,
				  'tag' => $log_data->tag,
				  'rec_flag' => $log_data->rec_flag,
				  'reported_dt'=>date('Y-m-d'),
				  'created_by' => $request->user()->id,
				  'updated_by' => $request->user()->id,
				  'enroll_label' => $storagelog->enroll_label,
				  'sample_label' => $storagelog->sample_label,
				 ];

				 $nwService = ServiceLog::create($new_service);
				 
				 //UPDATE SERVICE LOG AGAIN with old service id=8
				 ServiceLog::where('sample_id',$log_data->sample_id)->where('enroll_id',$log_data->enroll_id)->where('service_id',8)->update(['status'=>99]);
				 
            /*$sample_in_decontamin = ServiceLog::where('sample_id',$log->sample_id)->where('service_id',3)->first();
            if($sample_in_decontamin){
              $log->service_id = 8;
              $log->status = 1;
			  $log->rec_flag = $request->rec_flag;			 
              $log->updated_by = $request->user()->id;
              $data = $log;
              $log->save();
            }else{
              $log->service_id = 3;
              $log->status = 1;
			  $log->rec_flag = $request->rec_flag;
              $log->updated_by = $request->user()->id;
              $data = $log;
              $log->save();
            }*/
			DB::commit();
            return $nwService;
          }
          /*else{
            $log_data->status = 1;
			$log_data->rec_flag = $request->rec_flag;
            $data = $log_data;
            $log_data->save();
            return $data;
          }*/
          //return $data;
        }elseif($request->service_id == 4){//Repeat Hybridization from same DNA extract

          $log = ServiceLog::find($request->service_log_id);
          $old_sample = Sample::select('sample_label')->where('id',$log->sample_id)->first();
          $new_sample = $old_sample->sample_label.'R';
          
		  Sample::where('id',$log->sample_id)->update(['sample_label'=>$new_sample]);
		  
		                                   
		  Pcr::where('enroll_id',$request->enroll_id)->where('sample_id',$request->sampleID)->where('tag','like',$request->tag)->delete();
		  
          //ServiceLog::where('sample_id',$log->sample_id)->where('status','!=',0)->update(['sample_label'=>$new_sample]);

          //INSERT IN TO SERVICE LOG   
		  $new_service = [
			  'enroll_id' => $log->enroll_id,
			  'sample_id' => $log->sample_id,
			  'service_id' => 12,
			  'status' => 1,
			  'tag' => $log->tag,
			  'rec_flag' => $log->rec_flag+1,
			  'reported_dt'=>date('Y-m-d'),
			  'created_by' => $request->user()->id,
			  'updated_by' => $request->user()->id,
			  'enroll_label' => $log->enroll_label,
			  'sample_label' => $new_sample,
			 ];

			 $nwService = ServiceLog::create($new_service);
		  
		  
		 //update service log with 99          
          $log->status = 99;		  
          $log->updated_by = $request->user()->id;          
          $log->save();
          //dd($data);
		  DB::commit();
          return $nwService;

        }
		DB::commit();
		}catch(\Exception $e){ //echo "here"; die;
			DB::rollback();
			return $e->getMessage();
			//echo "here"; die;
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
        //sample_label
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

    public function Hybridizationprint()
    {

        $data = [];
          $data['sample'] = ServiceLog::select('t_service_log.updated_at as ID','m.enroll_id','m.id as sample_id', 'm.receive_date as receive','m.test_reason as reason','is_accepted','s.result','t_service_log.sample_label as samples','t_service_log.service_id','t_service_log.id as log_id', 't_service_log.status','m.no_of_samples','t.status as dna_status','t.created_at as date_of_extraction','p.completed as pcr_completed','t_service_log.tag','d.test_date as decontamination_date')
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        ->leftjoin('t_dnaextraction as t', function ($join) {
              $join->on('t.sample_id','=','t_service_log.sample_id')
                   ->where('t.status', 1);
          })
        ->leftjoin('t_decontamination as d', function ($join) {
              $join->on('d.sample_id','=','t_service_log.sample_id')
                   ->where('d.status', 1);
          })
        ->leftjoin('t_pcr as p','p.sample_id','=','t_service_log.sample_id')
        ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
        ->where('t_service_log.service_id',14)
        ->whereIn('t_service_log.status',[1,2])
        ->orderBy('enroll_id','desc')
        ->get();
        foreach ($data['sample'] as $key => $value) {
          $lpa = ServiceLog::select('service_id')->where('enroll_id',$value->enroll_id)->where('sample_id',$value->sample_id)->first();
          if($lpa->service_id==6){
            $value->lpa_type = "LPA 1st line";
          }elseif($lpa->service_id==7){
            $value->lpa_type = "LPA 2nd line";
          }elseif($lpa->service_id==13){
            $value->lpa_type = "LPA Both Line";
          }else{
            $value->lpa_type = "NA";
          }
        }
         $data['services'] = ["Valid","Invalid","Repeat DNA Extraction from same sample","Repeat DNA Extraction from standby sample", "Repeat Hybridization from same DNA extract"];
        //dd($data['sample']);
        return view('admin.hybridization.print',compact('data'));

    }
}
