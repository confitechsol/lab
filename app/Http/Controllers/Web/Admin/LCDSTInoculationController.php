<?php

namespace App\Http\Controllers\Web\Admin;

use App\Model\Sample;
use App\Model\Service;
use App\Model\ServiceLog;
use App\Model\Microscopy;
use App\Model\Microbio;
use App\Model\LCDST;
use App\Model\LCDSTDrugs;
use App\Model\DSTDrugTR;
use App\Model\LCFlaggedMGIT;
use App\Model\LCDSTInoculation;
use App\Model\CultureInoculation;
use App\Model\ResultEdit;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

class LCDSTInoculationController extends Controller
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
          $data['sample'] = ServiceLog::select('m.enroll_id','m.id as sample_id', DB::raw('date_format(m.receive_date,"%d-%m-%y") as receive'),
		  'm.test_reason as reason','is_accepted',
          's.result','t_service_log.sample_label as samples','t_service_log.enroll_label as enroll_label',
          't_service_log.service_id','t_service_log.id as log_id', 't_service_log.status','m.no_of_samples',
           'ci.mgit_id','ci.tube_id_lj','ci.tube_id_lc','ci.inoculation_date', 'ddt.id as lc_dst_tr_id','ddt.drug_ids as drug_ids',
            'ldi.mgit_seq_id', 'ldi.dst_c_id1', 'ldi.dst_c_id2','ldi.dst_c_id3','t_service_log.enroll_id AS enrollID','t_service_log.sample_id AS sampleID','t_service_log.tag',
		  't_service_log.rec_flag',
            DB::raw('date_format(ldi.inoculation_date,"%d-%m-%y") AS inc_date'))
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        //->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
         ->leftjoin('t_microscopy as s', function ($join) {
              $join->on('s.sample_id','=','t_service_log.sample_id')
                   ->where('s.status', 1);
          })
        ->leftjoin('t_culture_inoculation as ci','ci.rec_flag','=','t_service_log.rec_flag')
       // ->leftjoin('t_dst_drugs_tr as ddt','ddt.enroll_id','=','t_service_log.enroll_id')
	   ->leftjoin('t_dst_drugs_tr as ddt', function ($join) {
            $join->on('ddt.enroll_id', '=', 't_service_log.enroll_id')
            ->on('ddt.rec_flag', '=', 't_service_log.rec_flag')
                 ->where('ddt.service_id', 21);
        })

        ->leftjoin('t_lc_dst_inoculation as ldi', function ($join) {
          $join->on('ldi.enroll_id', '=', 't_service_log.enroll_id')
          ->on('ldi.rec_flag', '=', 't_service_log.rec_flag');           
      })       
       
        ->where('t_service_log.service_id',21)
        //->where('s.status',1)
        ->where('ddt.status',1)
        ->whereIn('t_service_log.status',[1,2]) //      ->whereIn('t_service_log.status',[0,1,2])
        ->orderBy('enroll_id','desc')
        ->get();
 //dd($data['sample']);
        $data['drugs'] = [];
        foreach ($data['sample'] as $key => $value) {
        if($value->drug_ids != ''){
          $drugids = explode(',',$value->drug_ids);
          $druglist = LCDSTDrugs::whereIn('id',$drugids)->pluck('name')->toArray();
          $value->druglist = implode(',',$druglist);
          $data['drugs'] = LCDSTDrugs::whereIn('id',$drugids)->get();


          }
        }
        //dd($data);

        //$data['drugs'] = LCDSTDrugs::all();
        $data['dp_result'] = ["Sensitive (S)","Resistance (R)", "Not done (-)", "Contaminated ( C)", "Error ( E)"];
        return view('admin.lc_dst_inoculation.list',compact('data'));
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
				$resultDate = $request->result_date;
				$sample = Sample::select('id','enroll_id')->where('sample_label',$request->sample_id)->first();
				if($sample){
					foreach ($request->except('_token') as $key => $part) {
					  if($part != ''){
						$lcdstobj = LCDST::select('id','result')->orderBy('id', 'desc')->where('sample_id',$sample->id)->where('drug_name',$key)->first();
						if($lcdstobj){

						  $edit = ResultEdit::create([
							'enroll_id' => $sample->enroll_id,
							'sample_id' => $sample->id,
							'service_id' => $request->service,
							'previous_result' => $lcdstobj->result,
							'updated_result' => $part,
							'updated_by' => Auth::user()->id,
							'status' => 1,
							'reason' => $request->reason_edit,
							'created_at' => date('Y-m-d H:i:s'),
							'updated_at' => ''
						  ]);

						  $lcdst = LCDST::find($lcdstobj->id);
						  $lcdst->result = $part;
						  $lcdst->result_date = $resultDate;
						  $lcdst->created_by = $request->user()->id;
						  $lcdst->reason_edit = $request->reason_edit;
						  $lcdst->is_moved = 0;
						  $lcdst->save();
						}
					  }
					}
				}
				DB::commit();
				return redirect("/microbiologist");
			  }
			$logdata = ServiceLog::find($request->log_id);
			//LCDSTInoculation::where('sample_id',$logdata->sample_id)->delete();
			$data = LCDSTInoculation::create([
			  'sample_id' => $logdata->sample_id,
			  'enroll_id' => $logdata->enroll_id,
			  'mgit_seq_id' => $request->mgit_seq_id,
			  'dst_c_id1' => $request->dst_c_id1,
			  'dst_c_id2' => $request->dst_c_id2,
			  'dst_c_id3' => $request->dst_c_id3,
			  'inoculation_date' => date('Y-m-d', strtotime($request->inoculation_date)),
			  'created_by' => $request->user()->id,
			  'updated_by' => $request->user()->id,
        'rec_flag'  => $logdata->rec_flag
			]);
			$logdata->status = 2;
			$logdata->save();
			DB::commit();
		}catch(\Exception $e){ 		  
			  //dd($e->getMessage());
			  $error = $e->getMessage();		  
			  DB::rollback(); 
			  $success = false;
			   
		}
		 if($success){
			// Return data for successful delete
			 return redirect("/lc_dst_inoculation");
		}else{
			 return redirect("/lc_dst_inoculation")->withErrors(['Sorry!! Action already taken of the selected Sample']);
		}
        //return redirect('/lc_dst_inoculation');
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
      //dd($request->all());
      $success = true;
	  DB::beginTransaction();
      try{
		  
      $serviceLogId = $request->service_log_id;
      $resultDate = $request->result_date;
      $lc_dst_tr_id = $request->lc_dst_tr_id;
      $repeat = $request->repeat;
      $next_step = $request->next_step;
      $logdata = ServiceLog::find($request->service_log_id);
	  
      $request->offsetUnset('_method');
      $request->offsetUnset('service_log_id');
      $request->offsetUnset('result_date');
      $request->offsetUnset('lc_dst_tr_id');
      $request->offsetUnset('repeat');
      $request->offsetUnset('next_step');
	  $request->offsetUnset('enrollId');
	  $request->offsetUnset('tagId');
	  $request->offsetUnset('sampleID');
	  $request->offsetUnset('serviceId');
	  $request->offsetUnset('rec_flag');
	  
     //dd($request->except('_token','comments'));
      foreach ($request->except('_token','comments') as $key => $part) {
        if($part != ''){
          $data = LCDST::create([
            'sample_id' => $logdata->sample_id,
            'enroll_id' => $logdata->enroll_id,
            'lc_dst_tr_id' => $lc_dst_tr_id,
            'drug_name' => $key,
            'result' => $part,
            'result_date' => $resultDate,
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id
          ]);
        }
      }
      if($next_step==1){
        $drug_ids = implode(',',$repeat);
        $dst_d_tr = DSTDrugTR::find($lc_dst_tr_id);
        $dst_d_tr->status = 0;
        $dst_d_tr->save();
        $new_d_tr = [
          'enroll_id' => $dst_d_tr->enroll_id,
          'sample_id' => $dst_d_tr->sample_id,
          'drug_ids' => $drug_ids,
          'status' => 1,
          'created_by' => $request->user()->id,
          'updated_by' => $request->user()->id
        ];

        $nwdtr = DSTDrugTR::create($new_d_tr);
        $logdata->status = 2;


      }elseif($next_step==0){
        $logdata->comments=$request->comments;
        $logdata->tested_by=$request->user()->name;
        $logdata->released_dt=date('Y-m-d');
          $logdata->status = 0;
          $microbio = Microbio::create([
                'enroll_id' => $logdata->enroll_id,
                'sample_id' => $logdata->sample_id,
                'service_id' => 21,
                'next_step' => '',
                'detail' => '',
                'remark' => '',
                'status' => 0,
                'report_type'=>'End Of Report',
                'created_by' => $request->user()->id,
                'updated_by' => $request->user()->id,
                'tag'        => $logdata->tag,
                'rec_flag' => $logdata->rec_flag,
              ]);
      }elseif($next_step==2){
        $logdata->comments=$request->comments;
        $logdata->tested_by=$request->user()->name;
        $logdata->released_dt=date('Y-m-d');
        $logdata->status = 0;
        $microbio = Microbio::create([
              'enroll_id' => $logdata->enroll_id,
              'sample_id' => $logdata->sample_id,
              'service_id' => 21,
              'next_step' => '',
              'detail' => '',
              'remark' => '',
              'status' => 0,
              'report_type'=>'Interim Report',
              'created_by' => $request->user()->id,
               'updated_by' => $request->user()->id,
               'tag'        => $logdata->tag,
               'rec_flag' => $logdata->rec_flag,
            ]);
      }else{
        $logdata->comments=$request->comments;
        $logdata->tested_by=$request->user()->name;
        $logdata->released_dt=date('Y-m-d');
        $logdata->status = 0;
          $microbio = Microbio::create([
                'enroll_id' => $logdata->enroll_id,
                'sample_id' => $logdata->sample_id,
                'service_id' => 21,
                'next_step' => '',
                'detail' => '',
                'remark' => '',
                'status' => 0,
                'created_by' => $request->user()->id,
                 'updated_by' => $request->user()->id,
                 'tag'        => $logdata->tag,
                 'rec_flag' => $logdata->rec_flag,
              ]);
      }
      $logdata->save();
	  
	  DB::commit();		
		 }catch(\Exception $e){ 
		  
			  //dd($e->getMessage());
			  $error = $e->getMessage();		  
			  DB::rollback(); 
			  $success = false;
			   
		}
		 if($success){
			// Return data for successful delete
			 return redirect('/lc_dst_inoculation');
		}else{
			 return redirect('/lc_dst_inoculation')->withErrors(['Sorry!! Action already taken of the selected Sample']);
		}

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

    public function lcdstinoculationprint()
    {

        $data = [];
          $data['sample'] = ServiceLog::select('m.enroll_id','m.id as sample_id', DB::raw('date_format(m.receive_date,"%d-%m-%y") as receive'),'m.test_reason as reason','is_accepted','s.result','t_service_log.sample_label as samples','t_service_log.enroll_label as enroll_label','t_service_log.service_id','t_service_log.id as log_id', 't_service_log.status','m.no_of_samples', 'ci.mgit_id','ci.tube_id_lj','ci.tube_id_lc',DB::raw('date_format(ci.inoculation_date,"%d-%m-%y")'), 'ddt.id as lc_dst_tr_id','ddt.drug_ids as drug_ids', 'ldi.mgit_seq_id', 'ldi.dst_c_id1', 'ldi.dst_c_id2', DB::raw('date_format(ldi.inoculation_date,"%d-%m-%y")'))
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
        ->leftjoin('t_culture_inoculation as ci','ci.sample_id','=','t_service_log.sample_id')
        ->leftjoin('t_dst_drugs_tr as ddt','ddt.enroll_id','=','t_service_log.enroll_id')
        ->leftjoin('t_lc_dst_inoculation as ldi','ldi.sample_id','=','t_service_log.sample_id')
        ->where('t_service_log.service_id',21)
        ->where('s.status',1)
        ->where('ddt.status',1)
        ->whereIn('t_service_log.status',[1,2])
        ->orderBy('enroll_id','desc')
        ->get();
        $data['drugs'] = [];
        foreach ($data['sample'] as $key => $value) {
        if($value->drug_ids != ''){
          $drugids = explode(',',$value->drug_ids);
          $druglist = LCDSTDrugs::whereIn('id',$drugids)->pluck('name')->toArray();
          $value->druglist = implode(',',$druglist);
          $data['drugs'] = LCDSTDrugs::whereIn('id',$drugids)->get();


          }
        }

        $data['dp_result'] = ["Sensitive (S)","Resistance (R)", "Not done (-)", "Contaminated ( C)", "Error ( E)"];
        return view('admin.lc_dst_inoculation.print',compact('data'));

    }
	public function checkForLCDSTInaucolationAlreadyInProcess($enroll_id, $rec_flag)
    { 
	       
		    //echo $sample_id."=".$enroll_id."==".$service_id."===".$tag."====".$recflag; die;
			$ljdstinaucolationlog = DB::select("SELECT IFNULL(count(*),0) AS v_count FROM t_lc_dst_inoculation 
			WHERE  enroll_id = ".$enroll_id." AND rec_flag = ".$rec_flag);
			//dd($ljdstinaucolationlog);
		    //dd($ljdstinaucolationlog[0]->v_count);	   

			echo json_encode($ljdstinaucolationlog[0]->v_count);
			exit;
	}
}
