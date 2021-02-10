<?php

namespace App\Http\Controllers\Web\Admin;

use App\Model\LJ;
use App\Model\Sample;
use App\Model\Service;
use App\Model\ServiceLog;
use App\Model\RequestServices;
use App\Model\LJWeekLog;
use App\Model\LJDetail;
use App\Model\Microscopy;
use App\Model\LCFlaggedMGIT;
use App\Model\Microbio;
use App\Model\CultureInoculation;
use App\Model\DNAextraction;
use App\Model\Hybridization;
use App\Model\Pcr;
use App\Model\FirstLineLpa;
use App\Model\SecondLineLpa;
use App\Model\FinalInterpretation;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;

class LJReviewController extends Controller
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
          $data['sample'] = ServiceLog::select('m.enroll_id','t_service_log.status as week_status','m.id as sample_id', 'm.receive_date as receive',
		  'm.test_reason as reason','is_accepted','s.result','t_service_log.sample_label as samples','t_service_log.enroll_label as enroll_label',
		  't_service_log.service_id','t_service_log.id as log_id', 't_service_log.status','m.no_of_samples', 'ci.mgit_id','ci.tube_id_lj','ci.tube_id_lc',
		  'ci.inoculation_date','m.sample_type','ljd.final_result','ljd.species','ljd.other_result','ljd.lj_result_date','lc.result as lc_result',
		  'lc.result_date as lc_result_date','w.week as week','m.fu_month', 'm.others_type','t_service_log.tag','t_service_log.enroll_id AS enrollID','t_service_log.sample_id AS sampleID',
		  't_service_log.rec_flag')
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
       // ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
        ->leftjoin('t_microscopy as s', function ($join) {
              $join->on('s.sample_id','=','t_service_log.sample_id')
                   ->where('s.status', 1);
          })
        ->leftjoin('t_lj_week_log as w', function ($join) {
                $join->on('w.sample_id','=','m.id')
                     ->where('w.status', 1);
            })
        ->leftjoin('t_lc_flagged_mgit_further as lc','lc.sample_id','=','t_service_log.sample_id')
        // ->leftjoin('t_lj_week_log as w','w.sample_id','=','m.id')
        ->leftjoin('t_culture_inoculation as ci','ci.sample_id','=','t_service_log.sample_id')
        ->leftjoin('t_lj_detail as ljd','ljd.sample_id','=','t_service_log.sample_id')
        ->where('t_service_log.service_id',20)
        //->where('w.status',1)
        ->whereIn('t_service_log.status',[-1]) //        ->whereIn('t_service_log.status',[0,-1])
        ->orderBy('enroll_id','desc')
        ->distinct('w.sample_id')
        ->get();
      //  dd($data['sample']);
        //dd($data['sample']);
        foreach ($data['sample'] as $key => $value) {
          // $lpa = ServiceLog::select('service_id')->where('enroll_id',$value->enroll_id)->where('sample_id',$value->sample_id)->first();
          // if($lpa->service_id==6){
          //   $value->culture_method = "Solid Culture";
          //   $value->lpa_type = "LPA 1st line";
          // }elseif($lpa->service_id==7){
          //   $value->culture_method = "Liquid Culture";
          //   $value->lpa_type = "LPA 2nd line";
          // }elseif($lpa->service_id==13){
          //   $value->culture_method = "Both";
          //   $value->lpa_type = "LPA Both Line";
          // }else{
          //   $value->culture_method = "NA";
          //   $value->lpa_type = "NA";
          // }

          $culture = ServiceLog::select('tag')->where('enroll_id',$value->enroll_id)->where('sample_id',$value->sample_id)->where('service_id',16)->first();
          $lpa = ServiceLog::select('service_id')->where('enroll_id',$value->enroll_id)->where('sample_id',$value->sample_id)->first();
          if($lpa->service_id==13){
            $value->lpa_type = "Both";
          }elseif($lpa->service_id==7){
            $value->lpa_type = "LPA 2nd line";
          }elseif($lpa->service_id==6){
            $value->lpa_type = "LPA 1st line";
          }
          // else{
          //   $value->lpa_type = "NA";
          // }

          if($culture->tag=='LC & LJ Both'){
            $value->culture_method = "Both";
          }else{
            $value->culture_method = "LJ";
          }
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
		
        return view('admin.ljreview.list',compact('data'));
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

        if($request->service_id == 1 || $request->service_id == 2 || $request->service_id == 3){
          if($request->service_log_id > 0){
            $service = ServiceLog::find($request->service_log_id);
            $service->comments=$request->comments;
            $service->tested_by=$request->user()->name;
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
			//Update LPA series if exist
			ServiceLog::where('enroll_id', $service->enroll_id)->where('sample_id',$service->sample_id)->where('service_id', 8)->where('tag',$tag)->update(['status'=>99]);
			ServiceLog::where('enroll_id', $service->enroll_id)->where('sample_id',$service->sample_id)->where('service_id', 12)->where('tag',$tag)->update(['status'=>99]);
			ServiceLog::where('enroll_id', $service->enroll_id)->where('sample_id',$service->sample_id)->where('service_id', 14)->where('tag',$tag)->update(['status'=>99]);
			ServiceLog::where('enroll_id', $service->enroll_id)->where('sample_id',$service->sample_id)->where('service_id', 15)->where('tag',$tag)->update(['status'=>99]);
			
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
			   'service_id' => 20,
			   'next_step' => '',
			   'detail' => '',
			   'remark' => '',
			   'status' => 0,
			   'report_type'=>'End Of Report',
			   'result_date' => $request->hid_result_date,
			   'created_by' => $request->user()->id,
			   'updated_by' => $request->user()->id
			 ]);
			 
			//Delete from LPA Series if exist
			DNAextraction::where('enroll_id',$service->enroll_id)->delete();
			Pcr::where('enroll_id',$service->enroll_id)->where('tag','like',$tag)->delete();
			Hybridization::where('enroll_id',$service->enroll_id)->where('tag','like',$tag)->delete(); 
			FinalInterpretation::where('enroll_id',$service->enroll_id)->where('tag','like',$tag)->delete();
			FirstLineLpa::where('enroll_id',$service->enroll_id)->where('tag','like',$tag)->delete();
			SecondLineLpa::where('enroll_id',$service->enroll_id)->where('tag','like',$tag)->delete();
			Microbio::where('enroll_id',$service->enroll_id)->where('tag','like',$tag)->delete();
        }
      }elseif($request->service_id == 4 || $request->service_id == 5){
        $service = ServiceLog::find($request->service_log_id);
        $service->comments=$request->comments;
        $service->tested_by=$request->user()->name;
        $service->released_dt=date('Y-m-d');
        $service->status = 0;
        $service->updated_by = $request->user()->id;
        $service->save();
        if($request->service_id == 4){
          $s_id = 22;
		  $tag = $request->tagId;
        }else{
          $s_id = 23;
		  $tag = $request->tagId;
        }
        $new_service = [
          'enroll_id' => $service->enroll_id,
          'sample_id' => $service->sample_id,
          'service_id' => $s_id,
          'status' => 1,
          'tag' => $tag,
          'reported_dt'=>date('Y-m-d'),
          'created_by' => $request->user()->id,
          'updated_by' => $request->user()->id,
          'enroll_label' => $service->enroll_label,
          'sample_label' => $service->sample_label,
        ];

        $nwService = ServiceLog::create($new_service);
        //return $nwService;
		//Insert into microbiologist
		if($request->service_id == 4){
		 $microbio = Microbio::create([
            'enroll_id' => $service->enroll_id,
            'sample_id' => $service->sample_id,
            'service_id' => 20,
            'next_step' => '',
            'detail' => '',
            'remark' => '',
            'status' => 0,
            'created_by' => $request->user()->id,
             'updated_by' => $request->user()->id
          ]);
		}  
      }
	  elseif($request->service_id == 7){
        $service = ServiceLog::find($request->service_log_id);
        $service->comments=$request->comments;
        $service->tested_by=$request->user()->name;
        $service->released_dt=date('Y-m-d');
        $service->status = 0;
        $service->updated_by = $request->user()->id;
        $service->save();
        
        $new_service = [
          'enroll_id' => $service->enroll_id,
          'sample_id' => $service->sample_id,
          'service_id' => 22,
          'status' => 1,
          'tag' => '',
          'reported_dt'=>date('Y-m-d'),
          'created_by' => $request->user()->id,
          'updated_by' => $request->user()->id,
          'enroll_label' => $service->enroll_label,
          'sample_label' => $service->sample_label,
        ];

        $nwService = ServiceLog::create($new_service);
		
        $new_service = [
          'enroll_id' => $service->enroll_id,
          'sample_id' => $service->sample_id,
          'service_id' => 23,
          'status' => 1,
          'tag' => '',
          'reported_dt'=>date('Y-m-d'),
          'created_by' => $request->user()->id,
          'updated_by' => $request->user()->id,
          'enroll_label' => $service->enroll_label,
          'sample_label' => $service->sample_label,
        ];

        $nwService = ServiceLog::create($new_service);
		
		
        //return $nwService;
      }
      elseif($request->service_id == 6 || $request->service_id == 19){
        $service = ServiceLog::find($request->service_log_id);
        $service->comments=$request->comments;
        $service->tested_by=$request->user()->name;
        $service->released_dt=date('Y-m-d');
        $service->status = 0;
        $service->updated_by = $request->user()->id;
        $service->save();
        $microbio = Microbio::create([
            'enroll_id' => $service->enroll_id,
            'sample_id' => $service->sample_id,
            'service_id' => 20,
            'next_step' => '',
            'detail' => '',
            'remark' => '',
            'status' => 0,
            'created_by' => $request->user()->id,
             'updated_by' => $request->user()->id
          ]);

        //return $microbio;
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
			 return redirect("/reviewlj");
		}else{
			 return redirect("/reviewlj")->withErrors(['Sorry!! Action already taken of the selected Sample']);
		}
      //return redirect('/reviewlj');

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

    public function ljreviewprint()
    {

        $data = [];
          $data['sample'] = ServiceLog::select('m.enroll_id','t_service_log.status as week_status','m.id as sample_id', 'm.receive_date as receive','m.test_reason as reason','is_accepted','s.result','t_service_log.sample_label as samples','t_service_log.enroll_label as enroll_label','t_service_log.service_id','t_service_log.id as log_id', 't_service_log.status','m.no_of_samples', 'ci.mgit_id','ci.tube_id_lj','ci.tube_id_lc','ci.inoculation_date','m.sample_type','ljd.final_result','ljd.lj_result_date','lc.result as lc_result','lc.result_date as lc_result_date','w.week as week','m.fu_month', 'm.others_type')
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
       // ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
        ->leftjoin('t_microscopy as s', function ($join) {
              $join->on('s.sample_id','=','t_service_log.sample_id')
                   ->where('s.status', 1);
          })
        ->leftjoin('t_lj_week_log as w', function ($join) {
                $join->on('w.sample_id','=','m.id')
                     ->where('w.status', 1);
            })
        ->leftjoin('t_lc_flagged_mgit_further as lc','lc.sample_id','=','t_service_log.sample_id')
        // ->leftjoin('t_lj_week_log as w','w.sample_id','=','m.id')
        ->leftjoin('t_culture_inoculation as ci','ci.sample_id','=','t_service_log.sample_id')
        ->leftjoin('t_lj_detail as ljd','ljd.sample_id','=','t_service_log.sample_id')
        ->where('t_service_log.service_id',20)
        //->where('w.status',1)
        ->whereIn('t_service_log.status',[-1]) //        ->whereIn('t_service_log.status',[0,-1])
        ->orderBy('enroll_id','desc')
        ->distinct('w.sample_id')
        ->get();
          foreach ($data['sample'] as $key => $value) {
        
          $culture = ServiceLog::select('tag')->where('enroll_id',$value->enroll_id)->where('sample_id',$value->sample_id)->where('service_id',16)->first();
          $lpa = ServiceLog::select('service_id')->where('enroll_id',$value->enroll_id)->where('sample_id',$value->sample_id)->first();
          if($lpa->service_id==13){
            $value->lpa_type = "Both";
          }elseif($lpa->service_id==7){
            $value->lpa_type = "LPA 2nd line";
          }elseif($lpa->service_id==6){
            $value->lpa_type = "LPA 1st line";
          }
         
          if($culture->tag=='LC & LJ Both'){
            $value->culture_method = "Both";
          }else{
            $value->culture_method = "LJ";
          }
        }
		
		
      //  dd($data['sample']);
        //dd($data['sample']);
      
        return view('admin.ljreview.print',compact('data'));

    }
    /**
     *
     * Bulk send to Microscopy Review.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function bulkStore(Request $request){
       // Validate User Inputs ===========================================
        $this->validate( $request, [
          'sample_ids' => 'required'            
        ] );
        DB::beginTransaction();
        try{
          $sample_ids = trim( $request->input('sample_ids') );
          $sample_ids = explode(',', $sample_ids);
          $data = array();
          foreach($sample_ids as $sample_id){             

            if($request->service_id == 1 || $request->service_id == 2 || $request->service_id == 3){
              if(isset( $sample_id )){
                $service = ServiceLog::find( $sample_id);
                $service->comments=$request->comments;
                $service->tested_by=$request->user()->name;
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
                //Update LPA series if exist
                ServiceLog::where('enroll_id', $service->enroll_id)->where('sample_id',$service->sample_id)->where('service_id', 8)->where('tag',$tag)->update(['status'=>99]);
                ServiceLog::where('enroll_id', $service->enroll_id)->where('sample_id',$service->sample_id)->where('service_id', 12)->where('tag',$tag)->update(['status'=>99]);
                ServiceLog::where('enroll_id', $service->enroll_id)->where('sample_id',$service->sample_id)->where('service_id', 14)->where('tag',$tag)->update(['status'=>99]);
                ServiceLog::where('enroll_id', $service->enroll_id)->where('sample_id',$service->sample_id)->where('service_id', 15)->where('tag',$tag)->update(['status'=>99]);
          
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
                   'service_id' => 20,
                   'next_step' => '',
                   'detail' => '',
                   'remark' => '',
                   'status' => 0,
                   'report_type'=>'End Of Report',
                   'result_date' => $request->hid_result_date,
                   'created_by' => $request->user()->id,
                   'updated_by' => $request->user()->id
                 ]);           
                //Delete from LPA Series if exist
                DNAextraction::where('enroll_id',$service->enroll_id)->delete();
                Pcr::where('enroll_id',$service->enroll_id)->where('tag','like',$tag)->delete();
                Hybridization::where('enroll_id',$service->enroll_id)->where('tag','like',$tag)->delete(); 
                FinalInterpretation::where('enroll_id',$service->enroll_id)->where('tag','like',$tag)->delete();
                FirstLineLpa::where('enroll_id',$service->enroll_id)->where('tag','like',$tag)->delete();
                SecondLineLpa::where('enroll_id',$service->enroll_id)->where('tag','like',$tag)->delete();
                Microbio::where('enroll_id',$service->enroll_id)->where('tag','like',$tag)->delete();
            }
          }elseif($request->service_id == 4 || $request->service_id == 5){
            $service = ServiceLog::find( $sample_id);
            $service->comments=$request->comments;
            $service->tested_by=$request->user()->name;
            $service->released_dt=date('Y-m-d');
            $service->status = 0;
            $service->updated_by = $request->user()->id;
            $service->save();
            if($request->service_id == 4){
              $s_id = 22;
              $tag = $request->tagId;
                }else{
                  $s_id = 23;
              $tag = $request->tagId;
                }
            $new_service = [
              'enroll_id' => $service->enroll_id,
              'sample_id' => $service->sample_id,
              'service_id' => $s_id,
              'status' => 1,
              'tag' => $tag,
              'reported_dt'=>date('Y-m-d'),
              'created_by' => $request->user()->id,
              'updated_by' => $request->user()->id,
              'enroll_label' => $service->enroll_label,
              'sample_label' => $service->sample_label,
            ];

            $nwService = ServiceLog::create($new_service);
            //return $nwService;
        //Insert into microbiologist
        if($request->service_id == 4){
         $microbio = Microbio::create([
                'enroll_id' => $service->enroll_id,
                'sample_id' => $service->sample_id,
                'service_id' => 20,
                'next_step' => '',
                'detail' => '',
                'remark' => '',
                'status' => 0,
                'created_by' => $request->user()->id,
                 'updated_by' => $request->user()->id
              ]);
        }  
          }
        elseif($request->service_id == 7){
            $service = ServiceLog::find( $sample_id);
            $service->comments=$request->comments;
            $service->tested_by=$request->user()->name;
            $service->released_dt=date('Y-m-d');
            $service->status = 0;
            $service->updated_by = $request->user()->id;
            $service->save();
            
            $new_service = [
              'enroll_id' => $service->enroll_id,
              'sample_id' => $service->sample_id,
              'service_id' => 22,
              'status' => 1,
              'tag' => '',
              'reported_dt'=>date('Y-m-d'),
              'created_by' => $request->user()->id,
              'updated_by' => $request->user()->id,
              'enroll_label' => $service->enroll_label,
              'sample_label' => $service->sample_label,
            ];

            $nwService = ServiceLog::create($new_service);
        
            $new_service = [
              'enroll_id' => $service->enroll_id,
              'sample_id' => $service->sample_id,
              'service_id' => 23,
              'status' => 1,
              'tag' => '',
              'reported_dt'=>date('Y-m-d'),
              'created_by' => $request->user()->id,
              'updated_by' => $request->user()->id,
              'enroll_label' => $service->enroll_label,
              'sample_label' => $service->sample_label,
            ];

            $nwService = ServiceLog::create($new_service);
        
        
            //return $nwService;
          }
          elseif($request->service_id == 6 || $request->service_id == 19){
            $service = ServiceLog::find($sample_id);
            $service->comments=$request->comments;
            $service->tested_by=$request->user()->name;
            $service->released_dt=date('Y-m-d');
            $service->status = 0;
            $service->updated_by = $request->user()->id;
            $service->save();
            $microbio = Microbio::create([
                'enroll_id' => $service->enroll_id,
                'sample_id' => $service->sample_id,
                'service_id' => 20,
                'next_step' => '',
                'detail' => '',
                'remark' => '',
                'status' => 0,
                'created_by' => $request->user()->id,
                 'updated_by' => $request->user()->id
              ]);

            //return $microbio;
          }
          DB::commit();     
          }
          

        }catch(\Exception $e){

         DB::rollback();
         
        return back(); // Return back from where the request has come.
      }  
     return back(); // Return back from where the request has come.
  }
}
