<?php

namespace App\Http\Controllers\Web\Admin;

use App\Model\Sample;
use App\Model\Service;
use App\Model\ServiceLog;
use App\Model\Microscopy;
use App\Model\LCFlaggedMGIT;
use App\Model\LCFlaggedMGITFurther;
use App\Model\CultureInoculation;
use App\Model\ResultEdit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

class LCFlaggedMGITFurtherController extends Controller
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
          $data['sample'] = ServiceLog::select('m.enroll_id','m.id as sample_id', 'm.receive_date as receive','m.test_reason as reason','t_service_log.sample_label as samples','t_service_log.enroll_label as enroll_label','t_service_log.id as log_id','t_service_log.status')
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        ->where('t_service_log.service_id',18)
        ->whereIn('t_service_log.status',[1,4]) //    ->whereIn('t_service_log.status',[0,1,2,4])
        ->orderBy('enroll_id','desc')
        ->get();
        return view('admin.lc_flagged_mgit_further.list',compact('data'));
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
      $success = true;
	  DB::beginTransaction();
      try {
          if($request->editresult){

          //  dd($request->all());
            $sample = Sample::select('id','enroll_id')->where('sample_label',$request->sample_id)->first();
            if($sample)
              $lcobj = LCFlaggedMGITFurther::select('id','result')->where('sample_id',$sample->id)->first();
              if($lcobj){
				          ResultEdit::where('enroll_id', $request->enrollId)->where('service_id', $request->service)->delete();  
                $edit = ResultEdit::create([
                  'enroll_id' => $sample->enroll_id,
                  'sample_id' => $sample->id,
                  'service_id' => $request->service,
                  'previous_result' => $lcobj->result,
                  'updated_result' => $request->result,
                  'updated_by' => Auth::user()->id,
                  'status' => 1,
                  'reason' => $request->reason_edit,
                  'created_at' => date('Y-m-d H:i:s'),
                  'updated_at' => ''
                ]);
          				if(empty($request->result_date)){
          				  $request->result_date=date('Y-m-d');

          				}
				// dd($request->result_date);
                $lc = LCFlaggedMGITFurther::find($lcobj->id);
                $lc->ict = $request->ict;
                $lc->culture_smear = $request->culture_smear;
                $lc->bhi = $request->bhi;
                $lc->result = $request->result;
                $lc->species =$request->result=="NTM"? $request->species:"";
                $lc->other_result = $request->result=="Other Result"?$request->other_result:"";
                $lc->result_date = date('Y-m-d', strtotime($request->result_date));
                $lc->created_by = $request->user()->id;
                $lc->reason_edit = $request->reason_edit;
                $lc->is_moved = 0;
                    // dd($lc);
                $lc->save();

              }
			       DB::commit();  
            return redirect("/microbiologist");
          }

          //dd($request->all());
          $logdata = ServiceLog::find($request->log_id);
          if($request->result!='Mixed culture'){
              $logdata->status=2;
          }else{
              $logdata->status=4;
          }
          $logdata->comments=$request->comments;
          $logdata->tested_by=$request->user()->name;
          $logdata->released_dt=date('Y-m-d');
          $logdata->save();
          if($request->result=='Mixed culture'){
             $sample = Sample::find($logdata->sample_id);
             $sample->sample_label = $logdata->sample_label.'R';
             $sample->save();
         }
         //dd($request->all());
         LCFlaggedMGIT::where(['sample_id'=>$request->sampleID,'enroll_id'=>$request->enrollId])->update(['gu'=> $request->gu]);
        // LCFlaggedMGITFurther::where('sample_id',$logdata->sample_id)->where('enroll_id',$logdata->enroll_id)->delete();

        $get_lab_code = "";
                            $get_lab_code = DB::table('m_configuration')
                                    ->select('lab_code')
                                    ->where('status', '1')
                                    ->first();

       DB::table('t_lc_flagged_mgit_further')
                   ->where('sample_id', $logdata->sample_id)
                   ->where('enroll_id',$logdata->enroll_id)
                   ->update([
                    'result' => $request->result,
                   'species'=>$request->species,
                   'other_result'=>$request->other_result,
                   'result_date'=>date('Y-m-d', strtotime($request->result_date)),
                   'created_by'=>$request->user()->id,
                   'updated_by'=>$request->user()->id,
                   'sample_label' =>$request->sample_id,
                   'lab_code' => $get_lab_code->lab_code,                   
                   'comments' => $request->comments,
                   ]);


         // if($request->result=='Mixed culture'){
         //      $logdata->status = 0;
         //      $logdata->save();
         //  }
         //  else {
         //    $logdata->status = 2;
         //    $logdata->save();
         //  }

        if($request->result=='Mixed culture'){
          // $servicelog_id=ServiceLog::select('id as id')->where('status',1)->where('sample_id',$logdata->sample_id)->first();
          // if(!$servicelog_id){

                $data = ServiceLog::create([
                'enroll_id' => $logdata->enroll_id,
                'sample_id' => $logdata->sample_id,
                'service_id' => 3,
                'status' => 1,
                'created_by' => $request->user()->id,
                'updated_by' => $request->user()->id,
                'enroll_label' => $logdata->enroll_label,
                'sample_label' => $logdata->sample_label.'R',
                'tag' => 'Mixed culture'
              ]);
           // }else{
           //   $servicelog=ServiceLog::find($servicelog_id->id);
           //   $servicelog->sample_label=$logdata->sample_label.'R';
           //   $servicelog->status=1;
           //   $servicelog->save();
           // }

        }

        
		 DB::commit();		
		}catch(\Exception $e){ 
		  
			  //dd($e->getMessage());
			  $error = $e->getMessage();		  
			  DB::rollback(); 
			  $success = false;
			   
		}
		 if($success){
			// Return data for successful delete
			 return redirect("/further_lc_flagged_mgit/$request->log_id/edit");
		}else{
			 return redirect("/further_lc_flagged_mgit/$request->log_id/edit")->withErrors(['Sorry!! Action already taken of the selected Sample']);
		}
        //return redirect("/further_lc_flagged_mgit/$request->log_id/edit");
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
        try{
          $data = [];
          //DB::enableQueryLog();	
            $data['sample'] = ServiceLog::select('m.enroll_id','m.id as sample_id', 'm.receive_date as receive','m.test_reason as reason','is_accepted',
			's.result','t_service_log.sample_label as samples','t_service_log.enroll_label as enroll_label','t_service_log.service_id',
			't_service_log.id as log_id', 't_service_log.status','m.no_of_samples','t.status as dna_status','t.created_at as date_of_extraction',
			'ci.mgit_id','ci.tube_id_lj','ci.tube_id_lc','ci.inoculation_date', 'lfm.gu','lfm.flagging_date','lfmf.ict', 'lfmf.culture_smear', 'lfmf.bhi', 
			'lfmf.result as final_result', 'lfmf.result_date','t_service_log.tag','t_service_log.enroll_id AS enrollID', 't_service_log.sample_id AS sampleID',
		  't_service_log.rec_flag')
          ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
          ->leftjoin('t_dnaextraction as t', function ($join) {
                $join->on('t.sample_id','=','t_service_log.sample_id')
                     ->where('t.status', 1);
            })
           ->leftjoin('t_microscopy as s', function ($join) {
              $join->on('s.sample_id','=','t_service_log.sample_id')
                   ->where('s.status', 1);
          })
          //->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
          ->leftjoin('t_culture_inoculation as ci','ci.rec_flag','=','t_service_log.rec_flag')
          

          /* ->leftjoin('t_lc_flagged_mgit as lfm1','lfm1.enroll_id','=','t_service_log.enroll_id') */
          ->leftjoin('t_lc_flagged_mgit as lfm','lfm.rec_flag','=','t_service_log.rec_flag')

          //->leftjoin('t_lc_flagged_mgit_further as lfmf','lfmf.rec_flag','=','t_service_log.rec_flag')
          ->leftjoin('t_lc_flagged_mgit_further as lfmf', function($join) {
            $join->on('lfmf.rec_flag','=','t_service_log.rec_flag')
                  ->on('lfmf.enroll_id','=','t_service_log.enroll_id');
          })
          //->leftjoin('t_lc_flagged_mgit_further as lfmfk','lfmfk.rec_flag','=','t_service_log.rec_flag')
         

           //->leftjoin('t_lc_flagged_mgit_further as lfmf2','lfmf2.enroll_id','=','t_service_log.enroll_id') 
           //->leftjoin('t_lc_flagged_mgit_further as lfmfc','lfmfc.sample_id','=','t_service_log.sample_id') 
         /* ->join('t_lc_flagged_mgit_further as lfmfk','lfmfk.rec_flag','=','t_service_log.rec_flag') */  
          ->where('t_service_log.id',$id) 
                     
         // ->where('s.status',1)
          ->whereIn('t_service_log.status',[0,1,2,4])
          ->first();
          //dd(DB::getQueryLog());
          //dd($data['sample']);
          return view('admin.lc_flagged_mgit_further.dashboard',compact('data'));
        }catch(\Exception $e){
            $error = $e->getMessage();
            return view('admin.layout.error',$error);   // insert query
        }
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
          $data['sample'] = ServiceLog::select('m.enroll_id','m.id as sample_id', 'm.receive_date as receive','m.test_reason as reason','t_service_log.sample_label as samples','t_service_log.enroll_label as enroll_label','t_service_log.id as log_id')
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        ->where('t_service_log.service_id',18)
        ->whereIn('t_service_log.status',[1,2])
        ->orderBy('enroll_id','desc')
        ->get();
        return view('admin.lc_flagged_mgit_further.print',compact('data'));

    }

    public function ict(Request $request)
    {
      //dd($request->all());
	  $success = true;
	  DB::beginTransaction();
      try {
		  $logdata = ServiceLog::find($request->log_id);
		  $count=  LCFlaggedMGITFurther::where('sample_id',$logdata->sample_id)
                                    ->where('enroll_id',$logdata->enroll_id)
                                    ->where('rec_flag', $logdata->rec_flag)
                                    ->count();
		  //dd($count);
		  if($count < 1){

					 LCFlaggedMGITFurther::create([
					  'sample_id' => $logdata->sample_id,
					  'enroll_id' => $logdata->enroll_id,
					  'ict' => $request->ict,
            'rec_flag' => $logdata->rec_flag
				   ]);

		  }else{
			DB::table('t_lc_flagged_mgit_further')
						->where('sample_id', $logdata->sample_id)
						->where('enroll_id',$logdata->enroll_id)
						->update(['ict' => $request->ict]);

		  }
		  DB::commit();		
		}catch(\Exception $e){ 
		  
			  //dd($e->getMessage());
			  $error = $e->getMessage();		  
			  DB::rollback(); 
			  $success = false;
			   
		}
		 if($success){
			// Return data for successful delete
			 return redirect("/further_lc_flagged_mgit/$request->log_id/edit");
		}else{
			 return redirect("/further_lc_flagged_mgit/$request->log_id/edit")->withErrors(['Sorry!! Action already taken of the selected Sample']);
		}
       //return redirect("/further_lc_flagged_mgit/$request->log_id/edit");

  }



    public function smear_culture(Request $request)
    {
        //  dd($request->all());

        $success = true;
		DB::beginTransaction();
		try {

          $logdata = ServiceLog::find($request->log_id);
          $count=  LCFlaggedMGITFurther::where('sample_id',$logdata->sample_id)
          ->where('enroll_id',$logdata->enroll_id)
          ->where('rec_flag', $logdata->rec_flag)          
          ->count();
            //dd($count);
            if($count < 1){

                       $data = LCFlaggedMGITFurther::create([
                        'sample_id' => $logdata->sample_id,
                        'enroll_id' => $logdata->enroll_id,
                        'culture_smear' => $request->culture_smear,
                        'rec_flag' => $logdata->rec_flag
                     ]);

            }else{
              DB::table('t_lc_flagged_mgit_further')
                          ->where('sample_id', $logdata->sample_id)
                          ->where('enroll_id',$logdata->enroll_id)
                          ->update(['culture_smear' => $request->culture_smear]);

            }
         DB::commit();		
		}catch(\Exception $e){ 
		  
			  //dd($e->getMessage());
			  $error = $e->getMessage();		  
			  DB::rollback(); 
			  $success = false;
			   
		}
		 if($success){
			// Return data for successful delete
			 return redirect("/further_lc_flagged_mgit/$request->log_id/edit");
		}else{
			 return redirect("/further_lc_flagged_mgit/$request->log_id/edit")->withErrors(['Sorry!! Action already taken of the selected Sample']);
		}
           //return redirect("/further_lc_flagged_mgit/$request->log_id/edit");

    }

    public function bhi(Request $request)
    {

    //  dd($request->all());
       $success = true;
		DB::beginTransaction();
		try {
		  $logdata = ServiceLog::find($request->log_id);
		  $count=  LCFlaggedMGITFurther::where('sample_id',$logdata->sample_id)
      ->where('enroll_id',$logdata->enroll_id)
      ->where('rec_flag', $logdata->rec_flag)
      ->count();
		  //  dd($count);
        if($count < 1){

                   $data = LCFlaggedMGITFurther::create([
                    'sample_id' => $logdata->sample_id,
                    'enroll_id' => $logdata->enroll_id,
                    'bhi' => $request->bhi,
                    'rec_flag' => $logdata->rec_flag
                 ]);

        }else{
			DB::table('t_lc_flagged_mgit_further')
						->where('sample_id', $logdata->sample_id)
						->where('enroll_id',$logdata->enroll_id)
						->update(['bhi' => $request->bhi]);
			  }
         DB::commit();		
		}catch(\Exception $e){ 
		  
			  //dd($e->getMessage());
			  $error = $e->getMessage();		  
			  DB::rollback(); 
			  $success = false;
			   
		}
		 if($success){
			// Return data for successful delete
			 return redirect("/further_lc_flagged_mgit/$request->log_id/edit");
		}else{
			 return redirect("/further_lc_flagged_mgit/$request->log_id/edit")->withErrors(['Sorry!! Action already taken of the selected Sample']);
		}
        //return redirect("/further_lc_flagged_mgit/$request->log_id/edit");

    }


}
