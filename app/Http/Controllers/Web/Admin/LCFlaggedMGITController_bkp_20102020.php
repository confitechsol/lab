<?php

namespace App\Http\Controllers\Web\Admin;

use App\Model\Sample;
use App\Model\Service;
use App\Model\ServiceLog;
use App\Model\Microscopy;
use App\Model\LCFlaggedMGIT;
use App\Model\CultureInoculation;
use App\Model\RequestServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;

class LCFlaggedMGITController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = [];
          $data['sample'] = ServiceLog::select(DB::raw('DISTINCT(t_service_log.id)  AS ID'),'m.enroll_id','m.id as sample_id', 'm.receive_date as receive',
		  'm.test_reason as reason','is_accepted','s.result','t_service_log.sample_label as samples','t_service_log.enroll_label as enroll_label',
		  't_service_log.service_id','t_service_log.id as log_id', 't_service_log.status','m.no_of_samples','t.status as dna_status',
		  't.created_at as date_of_extraction','t_service_log.mgit','t_service_log.tube_id_lj','t_service_log.tube_id_lc','ci.inoculation_date', 
		  't_service_log.gu','lfm.flagging_date','m.fu_month','t_service_log.tag','t_service_log.enroll_id AS enrollID','t_service_log.sample_id AS sampleID',
		  't_service_log.rec_flag')
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        ->leftjoin('t_dnaextraction as t', function ($join) {
              $join->on('t.sample_id','=','t_service_log.sample_id');
			  $join->on('t.tag', '=','t_service_log.tag')
                   ->where('t.status', 1);
          })
        ->leftjoin('t_microscopy as s', function ($join) {
              $join->on('s.sample_id','=','t_service_log.sample_id')
                   ->where('s.status', 1);
          })
        ->leftjoin('t_culture_inoculation as ci','ci.sample_id','=','t_service_log.sample_id')
        ->leftjoin('t_lc_flagged_mgit as lfm','lfm.sample_id','=','t_service_log.sample_id')
        ->where('t_service_log.service_id',17)
        ->whereIn('t_service_log.status',[1]) //        ->whereIn('t_service_log.status',[0,1,2])
        ->orderBy('enroll_id','desc')
		//->toSql();
        ->get();







//dd($data['sample'] );
        foreach ($data['sample'] as $key => $value) {
          $lpa = ServiceLog::select('service_id')->where('enroll_id',$value->enroll_id)->where('sample_id',$value->sample_id)->first();
          if($lpa->service_id==6){
            $value->lpa_type = "LJ";
          }elseif($lpa->service_id==7){
            $value->lpa_type = "LC";
          }elseif($lpa->service_id==13){
            $value->lpa_type = "Both";
          }else{
            $value->lpa_type = "NA";
          }
        }
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
        return view('admin.lc_flagged_mgit.list',compact('data'));

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
	  $success = true;
	  DB::beginTransaction();
      try {
		$logdata = ServiceLog::find($request->log_id);

        //LCFlaggedMGIT::where('sample_id',$logdata->sample_id)->delete(); //for repeataton of any sample
		LCFlaggedMGIT::where('enroll_id',$logdata->enroll_id)->delete(); //for repeataton of any sample
        $data = LCFlaggedMGIT::create([
          'sample_id' => $logdata->sample_id,
          'enroll_id' => $logdata->enroll_id,
          'gu' => $request->gu,
          'flagging_date' => $request->flagging_date,
          'created_by' => $request->user()->id,
          'updated_by' => $request->user()->id
        ]);
		
        $logdata->comments=$request->comments;
        $logdata->tested_by=$request->user()->name;
        $logdata->released_dt=date('Y-m-d');
        $logdata->status = 0;
        if(!empty($request->gu)){
        $logdata->gu = $request->gu;
        }
        $logdata->save();
		
        $new_service = [
          'enroll_id' => $logdata->enroll_id,
          'sample_id' => $logdata->sample_id,
          'service_id' => 18,
          'status' => 1,
          'created_by' => $request->user()->id,
          'updated_by' => $request->user()->id,
          'reported_dt'=>date('Y-m-d'),
		  'tag' => $request->tagId,
		  'rec_flag' => $request->rec_flag,
          'enroll_label' => $logdata->enroll_label,
          'sample_label' => $logdata->sample_label,
        ];

        $nwService = ServiceLog::create($new_service);
		DB::commit();		
		 }catch(\Exception $e){ 
		  
			  //dd($e->getMessage());
			  $error = $e->getMessage();		  
			  DB::rollback(); 
			  $success = false;
			   
		}
		 if($success){
			// Return data for successful delete
			 return redirect('/lc_flagged_mgit');
		}else{
			 return redirect('/lc_flagged_mgit')->withErrors(['Sorry!! Action already taken of the selected Sample']);
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

     public function lcflagprint()
    {
        $data = [];
          $data['sample'] = ServiceLog::select('m.enroll_id','m.id as sample_id', 'm.receive_date as receive','m.test_reason as reason','is_accepted','s.result','t_service_log.sample_label as samples','t_service_log.enroll_label as enroll_label','t_service_log.service_id','t_service_log.id as log_id', 't_service_log.status','m.no_of_samples','t.status as dna_status','t.created_at as date_of_extraction','ci.mgit_id','ci.tube_id_lj','ci.tube_id_lc','ci.inoculation_date', 'lfm.gu','lfm.flagging_date')
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        ->leftjoin('t_dnaextraction as t', function ($join) {
              $join->on('t.sample_id','=','t_service_log.sample_id')
                   ->where('t.status', 1);
          })
        ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
        ->leftjoin('t_culture_inoculation as ci','ci.sample_id','=','t_service_log.sample_id')
        ->leftjoin('t_lc_flagged_mgit as lfm','lfm.sample_id','=','t_service_log.sample_id')
        ->where('t_service_log.service_id',17)
        ->where('s.status',1)
        ->whereIn('t_service_log.status',[1,2])
        ->orderBy('enroll_id','desc')
        ->get();
        foreach ($data['sample'] as $key => $value) {
          $lpa = ServiceLog::select('service_id')->where('enroll_id',$value->enroll_id)->where('sample_id',$value->sample_id)->first();
          if($lpa->service_id==6){
            $value->lpa_type = "LJ";
          }elseif($lpa->service_id==7){
            $value->lpa_type = "LC";
          }elseif($lpa->service_id==13){
            $value->lpa_type = "Both";
          }else{
            $value->lpa_type = "NA";
          }
        }
        //dd($data['sample']);
        return view('admin.lc_flagged_mgit.print',compact('data'));

    }
}
