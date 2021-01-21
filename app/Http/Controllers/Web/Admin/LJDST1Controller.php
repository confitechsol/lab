<?php

namespace App\Http\Controllers\Web\Admin;

use App\Model\ServiceLog;
use App\Model\LjDstInoculation;
use App\Model\LjDstReading;
use App\Model\LCDSTDrugs;
use App\Model\DSTDrugTR;
use App\Model\Microbio;
use App\Model\Enroll;
use App\Model\Sample;
use App\Model\ResultEdit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class LJDST1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $data = [];
        $data['sample'] = ServiceLog::select(
          't_service_log.id as service_log_id',
          'm.enroll_id as enroll_id',
          'm.id as sample_id',
          't_service_log.sample_label as samples',
          't_service_log.enroll_label as enroll_label',
          'ldi.inoculation_date as inoculation_date',
          'w4.id as w4id',
          'w4.week_no as week_no',
          't_service_log.status as ljdst_status',
        //  'w6.id as w6id',
          'ddt.drug_ids as drug_ids',
          'ddt.id as lc_dst_tr_id',
          'lj_result_date',
          't_service_log.status',
          'w4.status as status',
		  't_service_log.tag',
		  't_service_log.service_id',
		  't_service_log.rec_flag'
         )
      ->leftjoin('t_lj_dst_inoculation as ldi', function ($join) {
            $join->on('ldi.service_log_id', '=', 't_service_log.id')
                 ->where('ldi.status', 1);
        })
      ->leftjoin('t_dst_drugs_tr as ddt', function ($join) {
            $join->on('ddt.enroll_id', '=', 't_service_log.enroll_id')
                 ->where('ddt.service_id', 22);
        })
      // ->leftjoin('t_dst_drugs_tr as ddt','ddt.enroll_id','=','t_service_log.enroll_id')

      ->leftjoin('t_lj_detail as ld', function ($join) {
            $join->on('ld.sample_id', '=', 't_service_log.sample_id')
                 ->where('ld.status', 1);
        })
      ->leftjoin('t_lj_dst_reading as w4', function ($join) {
            $join->on('w4.service_log_id', '=', 't_service_log.id')
            //->where('w4.week_no', 4)
            ->where('w4.flag', 1);
        })
        // ->leftjoin('t_lj_dst_reading as w6', function ($join) {
        //       $join->on('w6.service_log_id', '=', 't_service_log.id')
        //       ->where('w6.week_no', 6)
        //       ->where('w6.status', 1);
        //   })
      ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
      ->where('t_service_log.service_id',22)
      ->whereIn('t_service_log.status',[1]) //      ->whereIn('t_service_log.status',[0,1])
      ->where('ddt.status',1)
      ->orderBy('m.enroll_id','desc')
      ->get();

       // dd($data['sample']);

      $data['drugs'] = [];
      foreach ($data['sample'] as $key => $value) {
        if($value->drug_ids != ''){
          $drugids = explode(',',$value->drug_ids);
          $druglist = LCDSTDrugs::whereIn('id',$drugids)->pluck('name')->toArray();

          $value->druglist = implode(',',$druglist);
           $data['drugs'] = LCDSTDrugs::whereIn('id',$drugids)->get();
        }
      }

      $dstdrugs = LCDSTDrugs::select('id','name')->where('status',1)->get();
      $data['dstdrugs'] = $dstdrugs;
	 // dd($data);
      return view('admin.ljdstln1.list',compact('data'));
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
        $en_label = Enroll::select('label as l')->where('id',$request->enrollId)->first();
        $s_id = Sample::select('id as l')->where('sample_label',$request->sampleid)->first();
        $enroll_label=$en_label->l;
        $sample_id=$s_id->l;

        // dd($request->next_step);

        if($request->next_step=='Results Finalization'){
          $microbio = Microbio::create([
            'enroll_id' => $request->enrollId,
            'sample_id' => $sample_id,
            'service_id' => 22,
            'next_step' => '',
            'detail' => '',
            'remark' => '',
            'status' => 0,
            'created_by' => Auth::user()->id,
             'updated_by' => Auth::user()->id
          ]);



          $service_logs = ServiceLog::query()
            ->where('sample_id',$sample_id)
            ->where('service_id',22)
            ->where('status', '!=', 0)
            ->get();

            // dd( $service_log_id, $microbio );

          foreach( $service_logs as $service_log ){
            // $update = ServiceLog::find($service_log->id);
            $service_log->comments=$request->comments;
            $service_log->tested_by=$request->user()->name;
            $service_log->released_dt = date('Y-m-d');
            $service_log->status = 0;
            $service_log->updated_by = $request->user()->id;
            $service_log->save();
          }

        }
        else {
          LjDstReading::where('sample_id',$sample_id)->where('enroll_id',$request->enrollId)->delete();
          return redirect('/lj_dst_ln1');

        }
        return redirect('/lj_dst_ln1');
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


    public function inoculation(Request $request)
    {
        //dd($request->all());
	 DB::beginTransaction();
      try {
			$data = [
			  'sample_id'=>$request->sample_id,
			  'enroll_id'=>$request->enroll_id,
			  'service_log_id'=>$request->service_log_id,
			  'inoculation_for'=>$request->inoculation_for,
			  'inoculation_date'=>date('d-m-Y', strtotime($request->inoculation_date)),
			  'created_by'=>$request->user()->id,
			  'updated_by'=>$request->user()->id,
			];

			if(LjDstInoculation::create($data)){
			   DB::commit();	
			  return "true";
			}else{
			  return "false";
			}
		  		
		 }catch(\Exception $e){ 
		  
			  //dd($e->getMessage());
			  $error = $e->getMessage();		  
			  DB::rollback(); 
			  $success = false;
			   
		}	
    }
    public function reading_review(Request $request)
    {
       //dd($request->all());
      if($request->editresult){
        // dd($request->all());
        $resultDate = $request->result_date;
        $sample = Sample::select('id','enroll_id')->where('sample_label',$request->sample_id)->first();
// dd($sample);

        if($sample){
          $ljdst1obj = LjDstReading::select('id','drug_reading')->orderBy('id', 'desc')->where('sample_id',$sample->id)->where('week_no',4)->where('status',1)->first();

          // dd($ljdst1obj);

          if($ljdst1obj){
			  ResultEdit::where('enroll_id', $sample->enroll_id)->where('service_id', $request->service)->delete();
              $edit = ResultEdit::create([
              'enroll_id' => $sample->enroll_id,
              'sample_id' => $sample->id,
              'service_id' => $request->service,
              'previous_result' => $ljdst1obj->drug_reading,
              'updated_result' => json_encode($request->allData),
              'updated_by' => Auth::user()->id,
              'status' => 1,
              'reason' => $request->reason_edit,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => ''
            ]);

            $ljdst1 = LjDstReading::find($ljdst1obj->id);
                  $ljdst1->drug_reading = json_encode($request->allData);
                  $ljdst1->created_by = $request->user()->id;
                  $ljdst1->reason_edit = $request->reason_edit;
                  $ljdst1->is_moved = 0;
                  $ljdst1->edit_microbiologist = $ljdst1->edit_microbiologist+1;
                  $ljdst1->save();
            return "true";
          }
        }
      }
      return "false";
    }

    public function reading(Request $request)
    {
    
	  //dd($request->all());

      DB::beginTransaction();
      try {
      $repeat_array=[];
      $repeat_array=$request->allData_repeat['dl_2_repeat'];
      $bool = empty($repeat_array)?0:1;
      if($request->week_no==6){
        $reading = LjDstReading::select('id')->where('sample_id',$request->sample_id)->where('week_no',4)->get();
        //dd($reading);
        foreach($reading as $key=>$value){
          $reading_4 = LjDstReading::find($value->id);
          $reading_4->status=0;
          $reading_4->flag=0;
		  $reading_4->save();
        }

      }
      //print_r($bool);die();
      LjDstReading::where('enroll_id',$request->enroll_id)->update(['flag'=>0]);

      if($bool==0){
		  //echo "here"; die;
        $data = [
          'sample_id'=>$request->sample_id,
          'enroll_id'=>$request->enroll_id,
          'service_log_id'=>$request->service_log_id,
          'service_id'=>0,
          'week_no'=>$request->week_no,
          'dilution'=>'2',
          'status' => 1,
		  'service_id' => 22,
          'drug_media_1'=>$request->drug_media_1,
          'drug_media_2'=>$request->drug_media_2,
          'drug_reading'=>json_encode($request->allData),
          'created_by'=>$request->user()->id,
          'updated_by'=>$request->user()->id,
          'flag' => 1,
        ];
        if($request->week_no==4){
          $olddrug=DSTDrugTR::where('enroll_id',$request->enroll_id)->update(['status'=>0]);
          $olddrug=DSTDrugTR::where('enroll_id',$request->enroll_id)->where('flag',1)->update(['status'=>1]);
        }

        // $olddrug=DSTDrugTR::where('enroll_id',$request->enroll_id)->where('status',0)->update(['status'=>1]);
       }
       else{
         $data = [
           'sample_id'=>$request->sample_id,
           'enroll_id'=>$request->enroll_id,
           'service_log_id'=>$request->service_log_id,
           'service_id'=>0,
           'week_no'=>$request->week_no,
           'dilution'=>'2',
           'status' => 0,
		   'service_id' => 22,
           'drug_media_1'=>$request->drug_media_1,
           'drug_media_2'=>$request->drug_media_2,
           'drug_reading'=>json_encode($request->allData),
           'created_by'=>$request->user()->id,
           'updated_by'=>$request->user()->id,
           'flag'=>1,
         ];
       }

        //dd($data);
         //dd($request->all());	  
        if($request->allData_repeat['dl_2_repeat']){
           $drug_str = implode(',',$request->allData_repeat['dl_2_repeat']);
          // DB::connection()->enableQueryLog();

           $olddrug=DSTDrugTR::where('enroll_id',$request->enroll_id)->where('status',1)->update(['status'=>0]);
          //  $queries = DB::getQueryLog();
          DSTDrugTR::create([
            'enroll_id' => $request->enroll_id,
            'sample_id' => '0',
            'drug_ids' => $drug_str,
            'status' => 1,
            'created_by'=>$request->user()->id,
            'updated_by'=>$request->user()->id,
          ]);
        }
        
        //Result for finalization incorporated by Amrita
		$microbio = Microbio::create([
            'enroll_id' => $request->enroll_id,
            'sample_id' => $request->sample_id,
            'service_id' => 22,
            'next_step' => '',
            'detail' => '',
            'remark' => '',
            'status' => 0,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id
          ]);
         

          //DB::enableQueryLog();
          $service_logs = ServiceLog::query()
            ->where('sample_id',$request->sample_id)
            ->where('service_id',22)
            //->where('status', '!=', 0)
            ->whereNotIn('status', [0,99])			
            ->get();
           //dd(DB::getQueryLog());
           //dd( $service_log_id, $microbio );

          foreach( $service_logs as $service_log ){
            // $update = ServiceLog::find($service_log->id);
            $service_log->comments=$request->comments;
            $service_log->tested_by=$request->user()->name;
            $service_log->released_dt = date('Y-m-d');
            $service_log->status = 0;
            $service_log->updated_by = $request->user()->id;
            $service_log->save();
          }
        

        if(LjDstReading::create($data)){
		  DB::commit();		
          return "true";
        }else{
          return "false";
        }
			
		}catch(\Exception $e){ 
		  
			  //dd($e->getMessage());
			  $error = $e->getMessage();		  
			  DB::rollback(); 
			  return "false";
			   
		}
    }

    public function detail($id,$week){
      // dd($week);
      $data = LjDstReading::select('drug_reading')->where('enroll_id',$id)->where('week_no',$week)->get();
      foreach($data as $key=>$value){
        $result = $value->drug_reading;
      }

      //$data = LjDstReading::find($id);
      $ret = json_decode($result);
      return response()->json($ret);
    }


    public function ljdstfirstprint()
    {
      $data = [];
        $data['sample'] = ServiceLog::select(
          't_service_log.id as service_log_id',
          'm.enroll_id as enroll_id',
          'm.id as sample_id',
          't_service_log.sample_label as samples',
          't_service_log.enroll_label as enroll_label',
          'ldi.inoculation_date as inoculation_date',
          'w4.id as w4id',
          'w6.id as w6id',
          'ddt.drug_ids',
          'lj_result_date'
         )
      ->leftjoin('t_lj_dst_inoculation as ldi', function ($join) {
            $join->on('ldi.service_log_id', '=', 't_service_log.id')
                 ->where('ldi.status', 1);
        })
      ->leftjoin('t_dst_drugs_tr as ddt', function ($join) {
            $join->on('ddt.sample_id', '=', 't_service_log.sample_id')
                 ->where('ddt.status', 1);
        })
      ->leftjoin('t_lj_detail as ld', function ($join) {
            $join->on('ld.sample_id', '=', 't_service_log.sample_id')
                 ->where('ld.status', 1);
        })
      ->leftjoin('t_lj_dst_reading as w4', function ($join) {
            $join->on('w4.service_log_id', '=', 't_service_log.id')
            ->where('w4.week_no', 4)
            ->where('w4.status', 1);
        })
        ->leftjoin('t_lj_dst_reading as w6', function ($join) {
              $join->on('w6.service_log_id', '=', 't_service_log.id')
              ->where('w6.week_no', 6)
              ->where('w6.status', 1);
          })
      ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
      ->where('t_service_log.service_id',22)
      ->where('t_service_log.status',1)
      ->orderBy('m.enroll_id','desc')
      ->get();

      //dd($data['sample']);
      foreach ($data['sample'] as $key => $value) {
        if($value->drug_ids != ''){
          $drugids = explode(',',$value->drug_ids);
          $druglist = LCDSTDrugs::whereIn('id',$drugids)->pluck('name')->toArray();
          $value->druglist = implode(',',$druglist);
        }
      }

      $dstdrugs = LCDSTDrugs::select('id','name')->where('status',1)->get();
      $data['dstdrugs'] = $dstdrugs;
      return view('admin.ljdstln1.print',compact('data'));
    }
    public function checkForInaucolationDateAlreadyInProcess($enroll_id)
    { 
	       
		    //echo $sample_id."=".$enroll_id."==".$service_id."===".$tag."====".$recflag; die;
			$ljdstinaucolationlog = DB::select("SELECT IFNULL(count(*),0) AS v_count FROM t_lj_dst_inoculation 
			WHERE  enroll_id = ".$enroll_id);
			//dd($ljdstinaucolationlog);
		    //dd($ljdstinaucolationlog[0]->v_count);	   

			echo json_encode($ljdstinaucolationlog[0]->v_count);
			exit;
	}

}
