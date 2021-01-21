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

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LJDST2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		//echo "HI2"; die();
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
          // 'w6.id as w6id',
          'ddt.drug_ids as drug_ids',
          'ddt.id as lc_dst_tr_id',
          'lj_result_date',
          't_service_log.status',
          't_service_log.status as ljdst_status',
          'w4.status as status'
         )
      ->leftjoin('t_lj_dst_inoculation as ldi', function ($join) {
            $join->on('ldi.service_log_id', '=', 't_service_log.id')
                 ->where('ldi.status', 1);
        })
      ->leftjoin('t_dst_drugs_tr as ddt', function ($join) {
            $join->on('ddt.enroll_id', '=', 't_service_log.enroll_id');
                 // ->where('ddt.status', 1);
        })
       // ->leftjoin('t_dst_drugs_tr as ddt','ddt.enroll_id','=','t_service_log.enroll_id')
      ->leftjoin('t_lj_detail as ld', function ($join) {
            $join->on('ld.sample_id', '=', 't_service_log.sample_id')
                 ->where('ld.status', 1);
        })
      ->leftjoin('t_lj_dst_reading as w4', function ($join) {
            $join->on('w4.service_log_id', '=', 't_service_log.id')
            // ->where('w4.week_no', 4)
            ->where('w4.flag', 1);
        })
        // ->leftjoin('t_lj_dst_reading as w6', function ($join) {
        //       $join->on('w6.service_log_id', '=', 't_service_log.id')
        //       ->where('w6.week_no', 6)
        //       ->where('w6.status', 1);
        //   })
      ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
      ->where('t_service_log.service_id',23)
      ->whereIn('t_service_log.status',[1]) //      ->whereIn('t_service_log.status',[0,1])
      ->where('ddt.status',1)
      ->orderBy('m.enroll_id','desc')
      ->get();

      // foreach ($data['sample'] as $key => $value) {
      //   if($value->drug_ids != ''){
      //     $drugids = explode(',',$value->drug_ids);
      //     $druglist = LCDSTDrugs::whereIn('id',$drugids)->pluck('name')->toArray();
      //     $value->druglist = implode(',',$druglist);
      //   }
      // }
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
      return view('admin.ljdstln2.list',compact('data'));
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
      $en_label = Enroll::select('label as l')->where('id',$request->enrollId)->first();
      $s_id = Sample::select('id as l')->where('sample_label',$request->sampleid)->first();
      $enroll_label=$en_label->l;
      $sample_id=$s_id->l;

      if($request->next_step=='Results Finalization'){
        $microbio = Microbio::create([
          'enroll_id' => $request->enrollId,
          'sample_id' => $sample_id,
          'service_id' => 23,
          'next_step' => '',
          'detail' => '',
          'remark' => '',
          'status' => 0,
          'created_by' => Auth::user()->id,
           'updated_by' => Auth::user()->id
        ]);

        $service_logs = ServiceLog::query()
          ->where('sample_id', $sample_id)
          ->where('service_id', 23) // 23 => LJDST2
          ->where('status', '!=', 0)
          ->get();

        foreach ($service_logs as $service_log) {
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
        return redirect('/lj_dst_ln2');

      }
      return redirect('/lj_dst_ln2');
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
          return "true";
        }else{
          return "false";
        }
    }

    public function reading(Request $request)
    {
		//echo "hilj2"; die();
      //print_r($request->allData);die();
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
      LjDstReading::where('enroll_id',$request->enroll_id)->update(['flag'=>0]);
      if($bool==0){
        $data = [
          'sample_id'=>$request->sample_id,
          'enroll_id'=>$request->enroll_id,
          'service_log_id'=>$request->service_log_id,
          'service_id'=>23,
          'week_no'=>$request->week_no,
          'dilution'=>'2',
          'drug_media_1'=>$request->drug_media_1,
          'drug_media_2'=>$request->drug_media_2,
          'drug_reading'=>json_encode($request->allData),
          'created_by'=>$request->user()->id,
          'updated_by'=>$request->user()->id,
          'flag' => 1,
          'status' => 1,
        ];
        if($request->week_no==4){
          $olddrug=DSTDrugTR::where('enroll_id',$request->enroll_id)->update(['status'=>0]);
          $olddrug=DSTDrugTR::where('enroll_id',$request->enroll_id)->where('flag',1)->update(['status'=>1]);
        }
      }
      else{
        $data = [
          'sample_id'=>$request->sample_id,
          'enroll_id'=>$request->enroll_id,
          'service_log_id'=>$request->service_log_id,
          'service_id'=>23,
          'week_no'=>$request->week_no,
          'dilution'=>'2',
          'status' => 0,
          'drug_media_1'=>$request->drug_media_1,
          'drug_media_2'=>$request->drug_media_2,
          'drug_reading'=>json_encode($request->allData),
          'created_by'=>$request->user()->id,
          'updated_by'=>$request->user()->id,
          'flag'=>1,
        ];
      }

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
	  //die();
        if(LjDstReading::create($data)){
          return "true";
        }else{
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
    public function ljdstsecondprint()
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
      ->where('t_service_log.service_id',23)
      ->where('t_service_log.status',1)
      ->orderBy('m.enroll_id','desc')
      ->get();
      foreach ($data['sample'] as $key => $value) {
        if($value->drug_ids != ''){
          $drugids = explode(',',$value->drug_ids);
          $druglist = LCDSTDrugs::whereIn('id',$drugids)->pluck('name')->toArray();
          $value->druglist = implode(',',$druglist);
        }
      }

      $dstdrugs = LCDSTDrugs::select('id','name')->where('status',1)->get();
      $data['dstdrugs'] = $dstdrugs;
      return view('admin.ljdstln2.print',compact('data'));
    }

}
