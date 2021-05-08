<?php

namespace App\Http\Controllers\Web\Admin;

use App\Model\Sample;
use App\Model\Service;
use App\Model\ServiceLog;
use App\Model\Microscopy;
use App\Model\LCFlaggedMGIT;
use App\Model\LCFlaggedMGITFurther;
use App\Model\CultureInoculation;
use App\Model\Microbio;
use App\Model\RequestServices;
use App\Model\DNAextraction;
use App\Model\Hybridization;
use App\Model\Pcr;
use App\Model\FirstLineLpa;
use App\Model\SecondLineLpa;
use App\Model\FinalInterpretation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;

class LCResultReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      try{
        // dd("hi");
          $data = [];
          $data['sample'] = ServiceLog::select('m.enroll_id','m.id as sample_id', 'm.receive_date as receive','m.test_reason as reason','is_accepted',
		  't_service_log.sample_label as samples','t_service_log.enroll_label as enroll_label','t_service_log.service_id','t_service_log.id as log_id',
		  't_service_log.status','t_service_log.tag as lpa_type','m.no_of_samples','t.status as dna_status','t.created_at as date_of_extraction','ci.mgit_id',
		  'ci.tube_id_lj','ci.tube_id_lc','ci.inoculation_date', 'lfm.gu','lfm.flagging_date','m.sample_type','lfmf.result', 'lfmf.species','lfmf.other_result',
		  'lfmf.result_date','m.fu_month','lfmf.status as lcstatus','t_service_log.enroll_id AS enrollID','t_service_log.sample_id AS sampleID',
		  't_service_log.rec_flag')
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        ->leftjoin('t_dnaextraction as t', function ($join) {
              $join->on('t.sample_id','=','t_service_log.sample_id');
			  $join->on('t.tag', '=','t_service_log.tag')
                   ->where('t.status', 1);
          })
        //->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
        ->leftjoin('t_microscopy as s', function ($join) {
              $join->on('s.sample_id','=','t_service_log.sample_id')
                   ->where('s.status', 1);
          })

		  ->leftjoin('t_culture_inoculation as ci', function ($join) {
			$join->on('ci.rec_flag','=','t_service_log.rec_flag')
				->on('ci.enroll_id','=','t_service_log.enroll_id');				 
		})

		->leftjoin('t_lc_flagged_mgit as lfm', function ($join) {
			$join->on('lfm.rec_flag','=','t_service_log.rec_flag')
			->on('lfm.enroll_id','=','t_service_log.enroll_id');				 
		})       

		->leftjoin('t_lc_flagged_mgit_further as lfmf', function ($join) {
			$join->on('lfmf.rec_flag','=','t_service_log.rec_flag')
			->on('lfmf.enroll_id','=','t_service_log.enroll_id');				 
		})        
        ->where('t_service_log.service_id',18)
        //->where('s.status',1)
        ->whereIn('t_service_log.status',[2]) //    ->whereIn('t_service_log.status',[0,2])
        ->orderBy('enroll_id','desc')
        ->distinct()
        ->get();
		//->toSql();

       //dd($data['sample']);
        // foreach ($data['sample'] as $key => $value) {
        //   $lpa = ServiceLog::select('service_id')->where('enroll_id',$value->enroll_id)->where('sample_id',$value->sample_id)->first();
        //   if($lpa->service_id==6){
        //     $value->lpa_type = "LPA 1st line";
        //     $value->lpa_method = "LC";
        //   }elseif($lpa->service_id==7){
        //     $value->lpa_type = "LPA 2nd line";
        //     $value->lpa_method = "LJ";
        //   }elseif($lpa->service_id==13){
        //     $value->lpa_type = "LPA Both Line";
        //     $value->lpa_method = "Both";
        //   }else{
        //     $value->lpa_type = "NA";
        //     $value->lpa_method = "NA";
        //   }
        // }

        foreach ($data['sample'] as $key => $value) {

          $value->no_sample = ServiceLog::where('enroll_id',$value->enroll_id)->where('service_id',11)->count();

         /* $lpa = ServiceLog::select('service_id')->where('enroll_id',$value->enroll_id)->where('sample_id',$value->sample_id)->first();
          if($lpa->service_id==13){
            $value->lpa_method = "Both";
          }elseif($lpa->service_id==7){
            $value->lpa_method = "LPA 2nd line";
          }elseif($lpa->service_id==6){
            $value->lpa_method = "LPA 1st line";
          }*/
		  
		  
		  $lpa = RequestServices::select('service_id')->where('enroll_id',$value->enroll_id)->whereIn('service_id',[4,5,6])->first();
          //dd($lpa);
		  if(!empty($lpa))
		  {	  
			  if($lpa->service_id==6){
				$value->lpa_method = "Both";
			  }elseif($lpa->service_id==5){
				$value->lpa_method = "LPA 2nd line";
			  }elseif($lpa->service_id==4){
				$value->lpa_method = "LPA 1st line";
			  }
          }else{
			  $value->lpa_method = "";
		  }
          // else{
          //   $value->lpa_type = "NA";
          // }
          $culture = ServiceLog::select('tag')->where('enroll_id',$value->enroll_id)->where('sample_id',$value->sample_id)->where('service_id',16)->first();
          if(isset($culture)):
        // echo "<pre>"; print_r($culture);  echo "</pre>";
          if($culture->tag=='LC & LJ Both'){
            $value->lpa_type = "LC & LJ Both";
            //$value->lpa_method = "Both";
          }else{
            $value->lpa_type = "LC";
            //$value->lpa_method = "LC";
          }
        endif;
//print_r($culture);
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

			 //dd($data['sample']);
        return view('admin.lc_result_review.dashboard',compact('data'));
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


	public function checkForSampleLcReview(Request $request)
	{
		//dd($request->all());

		$result = false;
		$response = [];

		$get_sample_id = Microbio::select('sample_id')
						->where('enroll_id', $request->enroll_id)
						->first();

		if( !empty($get_sample_id) )
		{
			if( $get_sample_id->sample_id != $request->sample_id )
			{
				$get_lpa_data = Microbio::select(DB::raw('COUNT(*) as tot_record'))
								->where('enroll_id', $request->enroll_id)
								->where('tag', $request->tag)
								->where('service_id', '15')
								->first();

				if( $get_lpa_data->tot_record != 0 )
				{
					$result = true;

				} else {

					$result = false;
				}
			}
		}

		$response = array( 'result'	=> $result);

		echo json_encode($response);
		
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

			$get_old_sample_id = Microbio::select('sample_id')
									->where('enroll_id', $request->enrollId)
									->first();

			//dd($get_old_sample_id);

			/* if( $get_old_sample_id->sample_id != $request->sample_id )
			{


			} else {


			} */
        
			if($request->service_id == 1 || $request->service_id == 2 || $request->service_id == 3){
			  if($request->service_log_id > 0){
				//DB::enableQueryLog();
				$service = ServiceLog::find($request->service_log_id); 
				$service->released_dt=date('Y-m-d');
				$service->status = 0;
				$service->updated_by = $request->user()->id;
				$service->save();				
				//dd(DB::getQueryLog());
				
				//dd($service);				
				
				if($request->service_id == 1){
				  $tag = '1st line LPA';
				}elseif($request->service_id == 2){
				  $tag = '2nd line LPA';
				}else{
				  $tag = '1st line LPA  and for 2nd line LPA';
				}
				
				//DB::enableQueryLog();
				//Update LPA series if exist
				ServiceLog::where('enroll_id', $service->enroll_id)->where('sample_id',$service->sample_id)->where('service_id', 8)->where('tag',$tag)->update(['status'=>99]);
				ServiceLog::where('enroll_id', $service->enroll_id)->where('sample_id',$service->sample_id)->where('service_id', 12)->where('tag',$tag)->update(['status'=>99]);
				ServiceLog::where('enroll_id', $service->enroll_id)->where('sample_id',$service->sample_id)->where('service_id', 14)->where('tag',$tag)->update(['status'=>99]);
				ServiceLog::where('enroll_id', $service->enroll_id)->where('sample_id',$service->sample_id)->where('service_id', 15)->where('tag',$tag)->update(['status'=>99]);
				//dd(DB::getQueryLog());
				
				$new_service = [
				  'enroll_id' => $service->enroll_id,
				  'sample_id' => $service->sample_id,
				  'service_id' => 8,
				  'status' => 1,
				  'tag' => $tag,
				  'rec_flag' =>$request->rec_flag+1,
				  'reported_dt'=>date('Y-m-d'),
				  'created_by' => $request->user()->id,
				  'updated_by' => $request->user()->id,
				  'enroll_label' => $service->enroll_label,
				  'sample_label' => $service->sample_label,
				];

				$nwService = ServiceLog::create($new_service);
				//return $nwService;
				
				//Incorporated by Amrito(Insert in to microbiologist)				

					$microbio = Microbio::create([
						'enroll_id' => $service->enroll_id,
						'sample_id' => $service->sample_id,
						'service_id' => 17,
						'next_step' => '',
						'detail' => '',
						'remark' => '',
						'status' => 0,
						'report_type'=>'End Of Report',
						'result_date' => $request->hid_result_date,
						'created_by' => $request->user()->id,
						'updated_by' => $request->user()->id,
						'tag' => $tag
					  ]);


					 
					//Update in sample table 
					$sample = Sample::find($service->sample_id);				
					$sample->sample_type ="AFB MTB positive culture (LJ or LC)";
					$sample->save(); 
					
					//Delete from LPA Series if exist
					DNAextraction::where('enroll_id',$service->enroll_id)->delete();
					Pcr::where('enroll_id',$service->enroll_id)->where('tag','like',$tag)->delete();
					Hybridization::where('enroll_id',$service->enroll_id)->where('tag','like',$tag)->delete(); 
					FinalInterpretation::where('enroll_id',$service->enroll_id)->where('tag','like',$tag)->delete();
					FirstLineLpa::where('enroll_id',$service->enroll_id)->where('tag','like',$tag)->delete();
					SecondLineLpa::where('enroll_id',$service->enroll_id)->where('tag','like',$tag)->delete();
					Microbio::where('enroll_id',$service->enroll_id)->where('tag','like',$tag)->delete();
					
			 }
			
		  }elseif($request->service_id == 4){
			
			$service = ServiceLog::find($request->service_log_id);
			$service->status = 0;
			$service->updated_by = $request->user()->id;
			$service->save();

			//dd($service);

			if( !empty($get_old_sample_id) )
			{

				if( $get_old_sample_id->sample_id == $request->sampleID )
				{
					$new_service = [
					'enroll_id' => $service->enroll_id,
					'sample_id' => $service->sample_id,
					'service_id' => 21,
					'status' => 1,
					'tag' => $request->tagId,
					'reported_dt'=>date('Y-m-d'),
					'created_by' => $request->user()->id,
					'updated_by' => $request->user()->id,
					'enroll_label' => $service->enroll_label,
					'sample_label' => $service->sample_label,
					'rec_flag' => $service->rec_flag
					];

					$nwService = ServiceLog::create($new_service);

					//return $nwService;
					//Incorporated by Amrito(Insert in to microbiologist)
			
				
					$microbio = Microbio::create([
						'enroll_id' => $service->enroll_id,
						'sample_id' => $service->sample_id,
						'service_id' => 17,
						'next_step' => '',
						'detail' => '',
						'remark' => '',
						'status' => 0,
						'report_type'=>'End Of Report',
						'result_date' => $request->hid_result_date,
						'created_by' => $request->user()->id,
						'updated_by' => $request->user()->id,
						'tag' => $request->tagId,
						'rec_flag' => $service->rec_flag
					  ]);

				} else {

					$get_enroll_record = Microbio::select(DB::raw('COUNT(*) AS tot_record'))
											->where('enroll_id', $request->enrollId)
											->where('service_id', '17')
											->where('tag', 'LC')											
											->first();

					if( $get_enroll_record->tot_record != 0 )
					{
						$new_service = [
							'enroll_id' => $service->enroll_id,
							'sample_id' => $service->sample_id,
							'service_id' => 21,
							'status' => 1,
							'tag' => $request->tagId,
							'reported_dt'=>date('Y-m-d'),
							'created_by' => $request->user()->id,
							'updated_by' => $request->user()->id,
							'enroll_label' => $service->enroll_label,
							'sample_label' => $service->sample_label,
							'rec_flag' => $service->rec_flag
							];
		
							$nwService = ServiceLog::create($new_service); 					

							$microbio = Microbio::create([
								'enroll_id' => $request->enrollId,
								'sample_id' => $request->sampleID,
								'service_id' => 17,
								'next_step' => '',
								'detail' => '',
								'remark' => '',
								'status' => 0,
								'report_type'=>'End Of Report',
								'result_date' => $request->hid_result_date,
								'created_by' => $request->user()->id,
								'updated_by' => $request->user()->id,
								'tag' => 'LC',
								'rec_flag' => $service->rec_flag,
								'bmw_flag'	=> 1
							  ]);

					} else {

						$new_service = [
							'enroll_id' => $service->enroll_id,
							'sample_id' => $service->sample_id,
							'service_id' => 21,
							'status' => 1,
							'tag' => $request->tagId,
							'reported_dt'=>date('Y-m-d'),
							'created_by' => $request->user()->id,
							'updated_by' => $request->user()->id,
							'enroll_label' => $service->enroll_label,
							'sample_label' => $service->sample_label,
							'rec_flag' => $service->rec_flag
							];
		
							$nwService = ServiceLog::create($new_service);							
							
							//return $nwService;
							//Incorporated by Amrito(Insert in to microbiologist)
					
						
							$microbio = Microbio::create([
								'enroll_id' => $service->enroll_id,
								'sample_id' => $service->sample_id,
								'service_id' => 17,
								'next_step' => '',
								'detail' => '',
								'remark' => '',
								'status' => 0,
								'report_type'=>'End Of Report',
								'result_date' => $request->hid_result_date,
								'created_by' => $request->user()->id,
								'updated_by' => $request->user()->id,
								'tag' => $request->tagId,
								'rec_flag' => $service->rec_flag
							  ]);
					}
				}


			} else {

				$new_service = [
					'enroll_id' => $service->enroll_id,
					'sample_id' => $service->sample_id,
					'service_id' => 21,
					'status' => 1,
					'tag' => $request->tagId,
					'reported_dt'=>date('Y-m-d'),
					'created_by' => $request->user()->id,
					'updated_by' => $request->user()->id,
					'enroll_label' => $service->enroll_label,
					'sample_label' => $service->sample_label,
					'rec_flag' => $service->rec_flag
					];

					$nwService = ServiceLog::create($new_service);

					//return $nwService;
					//Incorporated by Amrito(Insert in to microbiologist)
			
				
					$microbio = Microbio::create([
						'enroll_id' => $service->enroll_id,
						'sample_id' => $service->sample_id,
						'service_id' => 17,
						'next_step' => '',
						'detail' => '',
						'remark' => '',
						'status' => 0,
						'report_type'=>'End Of Report',
						'result_date' => $request->hid_result_date,
						'created_by' => $request->user()->id,
						'updated_by' => $request->user()->id,
						'tag' => $request->tagId,
						'rec_flag' => $service->rec_flag
					  ]);

			}			
		 

		  }elseif($request->service_id == 5 ){

				   $service = ServiceLog::find($request->service_log_id);
				   $service->released_dt=date('Y-m-d');
				  $service->status = 0;
				  $service->updated_by = $request->user()->id;
				  $service->save();

				 if( $get_old_sample_id->sample_id == $request->sampleID )
				 {

					$microbio = Microbio::create([
						'enroll_id' => $service->enroll_id,
						'sample_id' => $service->sample_id,
						'service_id' => 17,
						'next_step' => '',
						'detail' => '',
						'remark' => '',
						'status' => 0,
						'created_by' => $request->user()->id,
						'updated_by' => $request->user()->id,
						'tag' => $service->tag
					  ]);

				 }

				 
				  //return $microbio;
		  }elseif($request->service_id == 7){

			//dd( $request->service_id );

			$service = ServiceLog::find($request->service_log_id);
			$service->released_dt=date('Y-m-d');
			$service->status = 0;
			$service->updated_by = $request->user()->id;
			$service->save();

			//dd($get_old_sample_id);

			if( !empty($get_old_sample_id) )
			{
				if( $get_old_sample_id->sample_id == $request->sampleID )
				{				

						$microbio = Microbio::create([
							'enroll_id' => $service->enroll_id,
							'sample_id' => $service->sample_id,
							'service_id' => 17,
							'next_step' => '',
							'detail' => '',
							'remark' => '',
							'status' => 0,
							'report_type'=>'End Of Report',
							'result_date' => $request->hid_result_date,
							'created_by' => $request->user()->id,
							'updated_by' => $request->user()->id,
							'tag' => $service->tag,
							'rec_flag' => $service->rec_flag
						]);						

				} else {

						$get_enroll_record = Microbio::select(DB::raw('COUNT(*) AS tot_record'))
						->where('enroll_id', $request->enrollId)
						->where('service_id', '17')
						->where('tag', 'LC')
						->first();

						if( $get_enroll_record->tot_record != 0 )
						{							

							$microbio = Microbio::create([

								'enroll_id' => $request->enrollId,
								'sample_id' => $request->sampleID,
								'service_id' => 17,
								'next_step' => '',
								'detail' => '',
								'remark' => '',
								'status' => 0,
								'report_type'=>'End Of Report',
								'result_date' => $request->hid_result_date,
								'created_by' => $request->user()->id,
								'updated_by' => $request->user()->id,
								'tag' => $service->tag,
								'rec_flag' => $service->rec_flag,
								'bmw_flag'	=> 1
							]);

						}
				}


			} else {

				$microbio = Microbio::create([
					'enroll_id' => $service->enroll_id,
					'sample_id' => $service->sample_id,
					'service_id' => 17,
					'next_step' => '',
					'detail' => '',
					'remark' => '',
					'status' => 0,
					'report_type'=>'End Of Report',
					'result_date' => $request->hid_result_date,
					'created_by' => $request->user()->id,
					'updated_by' => $request->user()->id,
					'tag' => $service->tag,
					'rec_flag' => $service->rec_flag,
				]);

			}		  


		  }elseif($request->service_id == 6){

				  $service = ServiceLog::find($request->service_log_id);
				  $service->status = 0;
				  $service->updated_by = $request->user()->id;
				  $service->save();
				  
				  $another_sample = ServiceLog::select('sample_id','sample_label')->where('enroll_id',$service->enroll_id)->where('service_id',11)->first();
				  //dd($another_sample);
				  
				  if($another_sample){
					    $update_sample_obj = ServiceLog::where('enroll_id',$service->enroll_id)->where('service_id',11)->update(['status' => 0]);
						//$is_decontamin = ServiceLog::where('sample_id',$service->sample_id)->where('service_id',3)->first();
						//if($is_decontamin){
						  $new_service = [
							'enroll_id' => $service->enroll_id,
							'sample_id' => $another_sample->sample_id,
							'service_id' => 16,
							'status' => 1,
							'tag' => $request->tagId,
							'reported_dt'=>date('Y-m-d'),
							'created_by' => $request->user()->id,
							'updated_by' => $request->user()->id,
							'enroll_label' => $service->enroll_label,
							'sample_label' => $another_sample->sample_label,
						  ];
						  
						  //Delete from tables
							CultureInoculation::where('enroll_id',$request->enrollId)->where('sample_id',$request->sampleID)->delete();
							LCFlaggedMGIT::where('enroll_id',$request->enrollId)->where('sample_id',$request->sampleID)->delete();
							LCFlaggedMGITFurther::where('enroll_id',$request->enrollId)->where('sample_id',$request->sampleID)->delete();

						/*}
						else{
							$new_service = [
							'enroll_id' => $service->enroll_id,
							'sample_id' => $another_sample->sample_id,
							'service_id' => 3,
							'status' => 1,
							'tag' => $request->tagId,
							'reported_dt'=>date('Y-m-d'),
							'created_by' => $request->user()->id,
							'updated_by' => $request->user()->id,
							'enroll_label' => $service->enroll_label,
							'sample_label' => $another_sample->sample_label,
						  ];
						}*/
						$nwService = ServiceLog::create($new_service);
						//$another_sample_obj->service_id = 0;
						
						
				  }
				  else
				  {
					DB::commit();  
					return redirect('/lc_result_review');
				  }


		  }
	  
	       DB::commit();		
		}catch(\Exception $e){ 
		  
			  dd($e->getMessage());
			  $error = $e->getMessage();		  
			  DB::rollback(); 
			  $success = false;
			   
		}
		 if($success){
			// Return data for successful delete
			 return redirect("/lc_result_review");
		}else{
			 return redirect("/lc_result_review")->withErrors(['Sorry!! Action already taken of the selected Sample']);
		}
      //return redirect('/lc_result_review');

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
          $data['sample'] = ServiceLog::select('m.enroll_id','m.id as sample_id', 'm.receive_date as receive','m.test_reason as reason','is_accepted','t_service_log.sample_label as samples','t_service_log.enroll_label as enroll_label','t_service_log.service_id','t_service_log.id as log_id', 't_service_log.status','m.no_of_samples','t.status as dna_status','t.created_at as date_of_extraction','ci.mgit_id','ci.tube_id_lj','ci.tube_id_lc','ci.inoculation_date', 'lfm.gu','lfm.flagging_date','m.sample_type','lfmf.result', 'lfmf.result_date')
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        ->leftjoin('t_dnaextraction as t', function ($join) {
              $join->on('t.sample_id','=','t_service_log.sample_id')
                   ->where('t.status', 1);
          })
        ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
        ->leftjoin('t_culture_inoculation as ci','ci.sample_id','=','t_service_log.sample_id')
        ->leftjoin('t_lc_flagged_mgit as lfm','lfm.sample_id','=','t_service_log.sample_id')
        ->leftjoin('t_lc_flagged_mgit_further as lfmf','lfmf.sample_id','=','t_service_log.sample_id')
        ->where('t_service_log.service_id',18)
        ->where('s.status',1)
        ->whereIn('t_service_log.status',[1,2])
        ->orderBy('enroll_id','desc')
        ->distinct()
        ->get();
        foreach ($data['sample'] as $key => $value) {
          $lpa = ServiceLog::select('service_id')->where('enroll_id',$value->enroll_id)->where('sample_id',$value->sample_id)->first();
          if($lpa->service_id==6){
            $value->lpa_type = "LPA 1st line";
            $value->lpa_method = "LC";
          }elseif($lpa->service_id==7){
            $value->lpa_type = "LPA 2nd line";
            $value->lpa_method = "LJ";
          }elseif($lpa->service_id==13){
            $value->lpa_type = "LPA Both Line";
            $value->lpa_method = "Both";
          }else{
            $value->lpa_type = "NA";
            $value->lpa_method = "NA";
          }
        }
        return view('admin.lc_result_review.print',compact('data'));

    }
	public function checkForSampleExistInStorage($enroll_id)
    { 
	      //DB::enableQueryLog();			
			$servicelog = DB::select("SELECT IFNULL(count(*),0) AS v_count FROM t_service_log 
			WHERE enroll_id =".$enroll_id."
			AND service_id =11			
			AND status = 2");
			//dd(DB::getQueryLog());
			//dd($servicelog);
		    //dd($servicelog[0]->v_count);	   

			echo json_encode($servicelog[0]->v_count);
			exit;
	}


	/**
     *
     * Bulk send to LC Review Result.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function bulkStore( Request $request ){      

    	//$service_ids = trim( $request->input('sample_ids') );
    	//dd($service_ids);

        // Validate User Inputs ===========================================
        $this->validate( $request, [
            'sample_ids' => 'required',
            //'test_date'  => 'required|date_format:Y-m-d',
        ] );

       DB::beginTransaction();
        try {        	
            // User Inputs ====================================================
            $service_ids = trim( $request->input('sample_ids') );
            $service_log_ids = explode(',', $service_ids);  

            //$result  = $request->input('result');

            // Get Samples from $sample_ids ===================================
            // $samples = Sample::query()->findMany( $sample_ids);           
            $data = array();            
              if(count($service_log_ids) > 0){      

                foreach($service_log_ids as $key => $service_log_id){    

                $request->service_log_id = $service_log_id;

               	if($request->service_id == 1 || $request->service_id == 2 || $request->service_id == 3){               		
					  if($request->service_log_id > 0){
						$service = ServiceLog::find($request->service_log_id); 
						$service->released_dt=date('Y-m-d');
						$service->status = 0;
						$service->updated_by = $request->user()->id;
						$service->save();

						if($request->service_id == 1){
						  $tag = '1st line LPA';
						}elseif($request->service_id == 2){
						  $tag = '2nd line LPA';
						}else{
						  $tag = '1st line LPA  and for 2nd line LPA';
						}
						
						//DB::enableQueryLog();
						//Update LPA series if exist
						ServiceLog::where('enroll_id', $service->enroll_id)->where('sample_id',$service->sample_id)->where('service_id', 8)->where('tag',$tag)->update(['status'=>99]);
						ServiceLog::where('enroll_id', $service->enroll_id)->where('sample_id',$service->sample_id)->where('service_id', 12)->where('tag',$tag)->update(['status'=>99]);
						ServiceLog::where('enroll_id', $service->enroll_id)->where('sample_id',$service->sample_id)->where('service_id', 14)->where('tag',$tag)->update(['status'=>99]);
						ServiceLog::where('enroll_id', $service->enroll_id)->where('sample_id',$service->sample_id)->where('service_id', 15)->where('tag',$tag)->update(['status'=>99]);
						//dd(DB::getQueryLog());
						
						$new_service = [
						  'enroll_id' => $service->enroll_id,
						  'sample_id' => $service->sample_id,
						  'service_id' => 8,
						  'status' => 1,
						  'tag' => $tag,
						  'rec_flag' =>$request->rec_flag+1,
						  'reported_dt'=>date('Y-m-d'),
						  'created_by' => $request->user()->id,
						  'updated_by' => $request->user()->id,
						  'enroll_label' => $service->enroll_label,
						  'sample_label' => $service->sample_label,
						];

						$nwService = ServiceLog::create($new_service);				
						//Incorporated by Amrito(Insert in to microbiologist)		
						$microbio = Microbio::create([
							   'enroll_id' => $service->enroll_id,
							   'sample_id' => $service->sample_id,
							   'service_id' => 17,
							   'next_step' => '',
							   'detail' => '',
							   'remark' => '',
							   'status' => 0,
							   'report_type'=>'End Of Report',
							   'result_date' => $request->hid_result_date,
							   'created_by' => $request->user()->id,
							   'updated_by' => $request->user()->id,
							   'tag'		=> $service->tag
							 ]);
							 
							//Update in sample table 
							$sample = Sample::find($service->sample_id);				
							$sample->sample_type ="AFB MTB positive culture (LJ or LC)";
							$sample->save(); 
							
							//Delete from LPA Series if exist
							DNAextraction::where('enroll_id',$service->enroll_id)->delete();
							Pcr::where('enroll_id',$service->enroll_id)->where('tag','like',$tag)->delete();
							Hybridization::where('enroll_id',$service->enroll_id)->where('tag','like',$tag)->delete(); 
							FinalInterpretation::where('enroll_id',$service->enroll_id)->where('tag','like',$tag)->delete();
							FirstLineLpa::where('enroll_id',$service->enroll_id)->where('tag','like',$tag)->delete();
							SecondLineLpa::where('enroll_id',$service->enroll_id)->where('tag','like',$tag)->delete();
							Microbio::where('enroll_id',$service->enroll_id)->where('tag','like',$tag)->delete();
							
					    }
								
					}elseif($request->service_id == 4){

						$service = ServiceLog::find($request->service_log_id);
						$service->status = 0;
						$service->updated_by = $request->user()->id;
						$service->save();

						$new_service = [
						  'enroll_id' => $service->enroll_id,
						  'sample_id' => $service->sample_id,
						  'service_id' => 21,
						  'status' => 1,
						  'tag' => $request->tagId,
						  'reported_dt'=>date('Y-m-d'),
						  'created_by' => $request->user()->id,
						  'updated_by' => $request->user()->id,
						  'enroll_label' => $service->enroll_label,
						  'sample_label' => $service->sample_label,
						];
						
						$nwService = ServiceLog::create($new_service);
						//return $nwService;
						//Incorporated by Amrito(Insert in to microbiologist)

						$microbio = Microbio::create([
						   'enroll_id' => $service->enroll_id,
						   'sample_id' => $service->sample_id,
						   'service_id' => 17,
						   'next_step' => '',
						   'detail' => '',
						   'remark' => '',
						   'status' => 0,
						   'report_type'=>'End Of Report',
						   'result_date' => $request->hid_result_date,
						   'created_by' => $request->user()->id,
						   'updated_by' => $request->user()->id,
						   'tag'		=> $service->tag
						 ]);

					}elseif($request->service_id == 5 ){

							$service = ServiceLog::find($request->service_log_id);
							$service->released_dt=date('Y-m-d');
							$service->status = 0;
							$service->updated_by = $request->user()->id;
							$service->save();
							$microbio = Microbio::create([
							  'enroll_id' => $service->enroll_id,
							  'sample_id' => $service->sample_id,
							  'service_id' => 17,
							  'next_step' => '',
							  'detail' => '',
							  'remark' => '',
							  'status' => 0,
							  'created_by' => $request->user()->id,
							  'updated_by' => $request->user()->id,
							  'tag'		=> $service->tag
							]);
									  //return $microbio;
					}elseif($request->service_id == 7){						

							$service = ServiceLog::find($request->service_log_id);
							$service->released_dt=date('Y-m-d');
							$service->status = 0;
							$service->updated_by = $request->user()->id;
							$service->save();

							$get_old_sample_id = Microbio::select('sample_id')
												->where('enroll_id', $service->enroll_id)
												->first();
							
							if( !empty($get_old_sample_id) )
							{
								if( $get_old_sample_id->sample_id == $service->sample_id )
								{

									$microbio = Microbio::create([
										'enroll_id' => $service->enroll_id,
										'sample_id' => $service->sample_id,
										'service_id' => 17,
										'next_step' => '',
										'detail' => '',
										'remark' => '',
										'status' => 0,
										'report_type'=>'End Of Report',
										'result_date' => $request->hid_result_date,
										'created_by' => $request->user()->id,
										'updated_by' => $request->user()->id,
										'tag'		=> $service->tag
										]);

								} else {

									$get_enroll_record = Microbio::select(DB::raw('COUNT(*) AS tot_record'))
									->where('enroll_id', $service->enroll_id)
									->where('service_id', '17')
									->where('tag', 'LC')
									->first();

									if( !empty($get_enroll_record) )
									{				
											$microbio = Microbio::create([
												'enroll_id' => $service->enroll_id,
												'sample_id' => $service->sample_id,
												'service_id' => 17,
												'next_step' => '',
												'detail' => '',
												'remark' => '',
												'status' => 0,
												'report_type'=>'End Of Report',
												'result_date' => $request->hid_result_date,
												'created_by' => $request->user()->id,
												'updated_by' => $request->user()->id,
												'tag' => $service->tag,
												'rec_flag' => $service->rec_flag,
												'bmw_flag'	=> 1
											]);

									} else {

										$microbio = Microbio::create([
											'enroll_id' => $service->enroll_id,
											'sample_id' => $service->sample_id,
											'service_id' => 17,
											'next_step' => '',
											'detail' => '',
											'remark' => '',
											'status' => 0,
											'report_type'=>'End Of Report',
											'result_date' => $request->hid_result_date,
											'created_by' => $request->user()->id,
											'updated_by' => $request->user()->id,
											'tag'		=> $service->tag
											]);

									}
								}

							} else {

								$microbio = Microbio::create([
									'enroll_id' => $service->enroll_id,
									'sample_id' => $service->sample_id,
									'service_id' => 17,
									'next_step' => '',
									'detail' => '',
									'remark' => '',
									'status' => 0,
									'report_type'=>'End Of Report',
									'result_date' => $request->hid_result_date,
									'created_by' => $request->user()->id,
									'updated_by' => $request->user()->id,
									'tag'		=> $service->tag
									]);
							}											

					}elseif($request->service_id == 6){

						  $service = ServiceLog::find($request->service_log_id);
						  $service->status = 0;
						  $service->updated_by = $request->user()->id;
						  $service->save();
						  
						  $another_sample = ServiceLog::select('sample_id','sample_label')->where('enroll_id',$service->enroll_id)->where('service_id',11)->first();
						  //dd($another_sample);
						  
						  if($another_sample){
							    $update_sample_obj = ServiceLog::where('enroll_id',$service->enroll_id)->where('service_id',11)->update(['status' => 0]);
								//$is_decontamin = ServiceLog::where('sample_id',$service->sample_id)->where('service_id',3)->first();
								//if($is_decontamin){
								  $new_service = [
									'enroll_id' => $service->enroll_id,
									'sample_id' => $another_sample->sample_id,
									'service_id' => 16,
									'status' => 1,
									'tag' => $request->tagId,
									'reported_dt'=>date('Y-m-d'),
									'created_by' => $request->user()->id,
									'updated_by' => $request->user()->id,
									'enroll_label' => $service->enroll_label,
									'sample_label' => $another_sample->sample_label,
								  ];
								  
								  //Delete from tables
									CultureInoculation::where('enroll_id',$request->enrollId)->where('sample_id',$request->sampleID)->delete();
									LCFlaggedMGIT::where('enroll_id',$request->enrollId)->where('sample_id',$request->sampleID)->delete();
									LCFlaggedMGITFurther::where('enroll_id',$request->enrollId)->where('sample_id',$request->sampleID)->delete();

								/*}
								else{
									$new_service = [
									'enroll_id' => $service->enroll_id,
									'sample_id' => $another_sample->sample_id,
									'service_id' => 3,
									'status' => 1,
									'tag' => $request->tagId,
									'reported_dt'=>date('Y-m-d'),
									'created_by' => $request->user()->id,
									'updated_by' => $request->user()->id,
									'enroll_label' => $service->enroll_label,
									'sample_label' => $another_sample->sample_label,
								  ];
								}*/
								$nwService = ServiceLog::create($new_service);
								//$another_sample_obj->service_id = 0;
								
						}
					}
					                 
               }             
            }     
           DB::commit();
        }catch(\Exception $e){
        //dd($e->getMessage()); 
       DB::rollback();
        /*return redirect('/dash_decontamination')->withErrors(['Sorry!! Action already taken of the selected Sample']);*/
        return back(); // Return back from where the request has come.
    }  
   return back(); // Return back from where the request has come.

}
}
