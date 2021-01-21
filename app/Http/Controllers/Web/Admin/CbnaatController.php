<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Cbnaat;
use App\Model\Sample;
use App\Model\ServiceLog;
use App\Model\Equipment;
use App\Model\Enroll;
use App\User;
use App\Model\RequestServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Model\Microbio;
use App\Model\ResultEdit;
use Illuminate\Support\Facades\Config;

class CbnaatController extends Controller
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
            $data['today'] = date('Y-m-d H:i:s');

$data['equipments_list']=Equipment::select('serial_no as eqipments')->where('name_cat','=','CBNAAT Machines')->get();

// dd($data['equipments_list']);

             $data['sample'] = ServiceLog::select('t_service_log.updated_at as ID','t_service_log.enroll_id','t_service_log.sample_id','t_service_log.service_id','t_service_log.tag','t_service_log.rec_flag',
                              't_service_log.enroll_label','t_service_log.sample_label as samples',DB::raw('sample.receive_date as receive'),'sample.test_reason as reason',
                              'sample.sample_type','sample.sample_quality','sample.no_of_samples','s.result_MTB','s.result_RIF','s.next_step',
                              's.error',DB::raw('date_format(s.test_date,"%d-%m-%y") as test_date'),'t_service_log.status as STATUS')
                        ->join('sample as sample','t_service_log.sample_id','=','sample.id')
                        ->leftjoin('t_cbnaat as s','sample.id','=','s.sample_id')
                        ->whereIn('t_service_log.status',[1]) //    ->whereIn('t_service_log.status',[0,1])
                        ->where('t_service_log.service_id',4)
                        ->orderBy('t_service_log.enroll_id','desc')
                        ->groupBy('samples')
                        ->distinct()
                        ->get();

              foreach ($data['sample'] as $key => $value) {
                $value->no_sample = ServiceLog::where('enroll_id',$value->enroll_id)->where('service_id',11)->count();
              
			    //test request
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
             // dd($data['test_requested[5]']);
            // /  dd($data['sample']);
            // $data['sample'] = Sample::select(DB::raw('enroll_id,group_concat(receive_date) as receive,group_concat(sample_id) as samples,group_concat(test_reason) as reason,group_concat(sample_type) as sample_type, group_concat(sample_quality) as sample_quality, group_concat(is_accepted) as is_accepted, count(sample_quality) as no_of_samples'))

                              // ->groupBy('enroll_id')
                              // ->orderBy('enroll_id','desc')
                              // ->get();


            return view('admin.cbnaat.list',compact('data'));
        }catch(\Exception $e){
              $error = $e->getMessage();
              return view('admin.layout.error',$error);   // insert query
        }
        // return Cbnaat::cbnaat_list();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
			$en_label = Enroll::select('label as l')->where('id',$request->enrollId)->first();
			$s_id = Sample::select('id as l')->where('sample_label',$request->sampleid)->first();
			 // dd( $s_id);
			$enroll_label=$en_label->l;
			$sample_id=$s_id->l;

		  // dd($request->enrollId,$sample_id);
			if(!$request->error){
				$request->error=0000;
			}

			
            
			if($request->editresult=='edit'){
			  // dd($request->all());

			  $cbnaat = Cbnaat::select('id as id')->where('enroll_id', $request->enrollId)->where('sample_id', $sample_id)->first();
			  //dd($cbnaat);
			  if($cbnaat){
				$cbnaat_obj = Cbnaat::find($cbnaat->id);
				if($cbnaat_obj){				  
				  ResultEdit::where('enroll_id', $request->enrollId)->where('service_id', $request->service)->delete();
				  $edit = ResultEdit::create([
					'enroll_id' => $request->enrollId,
					'sample_id' => $sample_id,
					'service_id' => $request->service,
					'previous_result' => 'MTB: '.$cbnaat_obj->result_MTB.', RIF: '.$cbnaat_obj->result_RIF,
					'updated_result' => 'MTB: '.$request->mtb.', RIF: '.$request->rif,
					'updated_by' => Auth::user()->id,
					'status' => 1,
					'reason' => $request->reason_edit,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => ''
				  ]);
				  if(!empty($request->mtb) && !empty($request->rif) ){
				    $cbnaat_obj->error = NULL; //0;
				  }else{
				    $cbnaat_obj->error= $request->error;
				  }
				  $cbnaat_obj->cbnaat_equipment_name=$request->equipment_name;
				  $cbnaat_obj->reason_edit=$request->reason_edit;
				  $cbnaat_obj->is_moved = 0;
				  $cbnaat_obj->result_MTB = $request->mtb;
				  $cbnaat_obj->result_RIF = $request->rif;
				  $cbnaat_obj->save();
				}

			  }
              DB::commit();
			  return redirect('/microbiologist');
			}
			// dd($request->all());
			
            Cbnaat::where('enroll_id', $request->enrollId)->where('sample_id', $sample_id)->delete();
			$cbnaat = Cbnaat::create([
				'enroll_id' => $request->enrollId,
				'sample_id' => $sample_id,
				'result_MTB' => $request->mtb,
				//'error' => $request->error,
				'result_RIF' => $request->rif,
				'next_step' => $request->next_step,
				'cbnaat_equipment_name'=>$request->cbnaat_equipment_name,
				'error' => NULL,
				'status' => 1,
				'test_date' => date('Y-m-d H:i:s'),
				'created_by' => Auth::user()->id,
				 'updated_by' => Auth::user()->id
			  ]);
			  $cbnaat = Cbnaat::select('id as id')->where('enroll_id', $request->enrollId)->where('sample_id', $sample_id)->first();
			  $cbnaat_obj = Cbnaat::find($cbnaat->id);

			  $service_log_id = ServiceLog::select('id as id')->where('sample_id',$sample_id)->where('status',1)->where('service_id',4)->first();
	          //dd($service_log_id);
			  $cbnaat_update = ServiceLog::find($service_log_id->id);
			  $cbnaat_update->comments=$request->comments;
			  $cbnaat_update->tested_by=$request->user()->name;
			  $cbnaat_update->released_dt=date('Y-m-d');
			 
			  if($request->next_step=='Repeat Test with same sample' || $request->next_step=='Repeat Test with another sample'){
			  $cbnaat_update->status = 99;
			  }else{
			   $cbnaat_update->status = 0;
			  }
			  $cbnaat_update->updated_by = $request->user()->id;
			  $cbnaat_update->save();



			  if($request->next_step=='Submit result for finalization'){

				  $microbio = Microbio::create([
					'enroll_id' => $request->enrollId,
					'sample_id' => $sample_id,
					'service_id' => 4,
					'next_step' => '',
					'detail' => '',
					'report_type'=>'End Of Report',
					'remark' => '',
					'sample_label' => $cbnaat_update->sample_label,
					'status' => 0,
					'created_by' => Auth::user()->id,
					 'updated_by' => Auth::user()->id
				  ]);
			  }
			  elseif($request->next_step=='Send to BWM'){

				  $microbio = Microbio::create([
					'enroll_id' => $request->enrollId,
					'sample_id' => $sample_id,
					'service_id' => 26,
					'next_step' => '',
					'detail' => '',
					'remark' => '',
					'status' => 0,
					'bwm' => 1,
					'created_by' => Auth::user()->id,
					 'updated_by' => Auth::user()->id
				  ]);
				  $cbnaat_obj->status = 9;
				  $cbnaat_obj->updated_by = $request->user()->id;
				  $cbnaat_obj->save();

				  ServiceLog::create([
					 'enroll_id' => $request->enrollId,
					 'sample_id' => $sample_id,
					 'enroll_label' => $enroll_label,
					 'sample_label' => $request->sampleid,
					 'service_id' => 26,
					 'previous_step' => 'CBNAAT',
					 'status' => 1,
					 'tag' => '',
					 'test_date' => date('Y-m-d H:i:s'),
					 'created_by' => Auth::user()->id,
					 'updated_by' => Auth::user()->id
				   ]);
			  }
			  elseif($request->next_step=='Repeat Test with same sample'){

				$old_sample = Sample::select('sample_label')->where('id',$sample_id)->first();
				$new_sample = $old_sample->sample_label.'R';
				Sample::where('id',$sample_id)->update(['sample_label'=>$new_sample]);
				ServiceLog::where('sample_id',$sample_id)->update(['sample_label'=>$new_sample]);

				$cbnaat_update->status = 1;
				$cbnaat_update->save();
				$cbnaat_repeat = Cbnaat::where('sample_id',$sample_id)->where('status',1)->delete();

			  }
			  elseif($request->next_step=='Repeat Test with another sample'){
					 $log = ServiceLog::where('enroll_id',$request->enrollId)->where('service_id',11)->first();
					 if($log){
						$log->service_id = 4;
						$log->status = 1;
						$log->updated_by = $request->user()->id;
						$data = $log;
						$log->save();

					}
					$cbnaat_repeat = Cbnaat::where('sample_id',$sample_id)->where('status',1)->delete();
			  }
			  elseif($request->next_step=='Interim Report Submit another sample'){
	  // dd($cbnaat_update['sample_id']);

				$microbio = Microbio::create([
							'enroll_id' => $request->enrollId,
							'sample_id' => $cbnaat_update->sample_id,
							'service_id' => 4,
							'next_step' => '',
							'detail' => '',
							'report_type'=>'Interim Report',
							'remark' => '',
							'status' => 0,
							'created_by' => Auth::user()->id,
							 'updated_by' => Auth::user()->id
						  ]);
				$cbnaat_obj->status = 10;
				$cbnaat_obj->updated_by = $request->user()->id;
				$cbnaat_obj->save();



				// $log = ServiceLog::where('enroll_id',$request->enrollId)->where('service_id',11)->first();
				// if($log){
				//         $log->service_id = 4;
				//         $log->status = 0;
				//         $log->updated_by = $request->user()->id;
				//         $data = $log;
				//         $log->save();


				//         $microbio = Microbio::create([
				//             'enroll_id' => $request->enrollId,
				//             'sample_id' => $log->sample_id,
				//             'service_id' => 4,
				//             'next_step' => '',
				//             'detail' => '',
				//             'remark' => '',
				//             'status' => 0,
				//             'created_by' => Auth::user()->id,
				//              'updated_by' => Auth::user()->id
				//           ]);
				// }
				// else{
				//     $cbnaat_update->status = 1;
				//     $cbnaat_update->updated_by = $request->user()->id;
				//     $cbnaat_update->save();
				// }
			  }
			  

		//});
		 DB::commit();
		}catch(\Exception $e){
			DB::rollback();
			return redirect('/cbnaat')
			->withErrors(['Sorry!! Action already taken of the selected Sample']);
		}
		
        return redirect('/cbnaat');
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
        // $ids = explode('-', $id);
        // $en_id = $ids[0];
        // $sample_id = $ids[1];
        // //dd($en_id,$sample_id);
        // try{
        //    $data['cbnaat'] = Sample::select('receive_date as receive','test_reason as reason','sample_type','visual')
        //                     ->where('enroll_id',$en_id)
        //                     ->where('sample_id',$sample_id)
        //                     ->first();
        //     $data['number'] = Sample::where('enroll_id',$en_id)->count();
        //     $data['today'] = date('Y-m-d H:i:s');
        //     //dd($data['today'] );
        //     $data['enroll_id'] = $en_id;
        //     $data['sample_id'] = $sample_id;
        //     return view('admin.cbnaat.form',compact('data'));


      // }catch(\Exception $e){
      //     $error = $e->getMessage();
      //     return view('admin.layout.error',$error);   // insert query
      // }
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
     public function cbnaat_submit($enroll_sample_id)
    {
      // dd('hi2');

        try{

            $ids = explode('-', $enroll_sample_id);
            $en_id = $ids[0];
            $sample_id = $ids[1];
            $data = Sample::select('receive_date as receive','test_reason as reason','sample_type','visual')
                            ->where('enroll_id',$en_id)
                            ->where('sample_id',$sample_id)
                            ->first();
            return response()->json([
              "sample" => $data
            ]);


      }catch(\Exception $e){
          $error = $e->getMessage();
          return view('admin.layout.error',$error);   // insert query
      }
    }

    public function cbnaatPrint()
    {
           $data = [];
            $data['today'] = date('Y-m-d H:i:s');



             $data['sample'] = ServiceLog::select('t_service_log.updated_at as ID','t_service_log.enroll_id','t_service_log.enroll_label','sample.sample_label as samples',DB::raw('date_format(sample.receive_date,"%d-%m-%y") as receive'),'sample.test_reason as reason','sample.sample_type','sample.sample_quality','sample.no_of_samples','s.result_MTB','s.result_RIF','s.next_step','s.error')
                        ->join('sample as sample','t_service_log.sample_id','=','sample.id')
                        ->leftjoin('t_cbnaat as s','sample.id','=','s.sample_id')
                        ->where('t_service_log.status',1)
                        ->where('t_service_log.service_id',4)
                        ->orderBy('t_service_log.enroll_id','desc')
                        ->distinct()
                        ->get();


            return view('admin.cbnaat.print',compact('data'));
    }
	
}
