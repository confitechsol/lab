<?php

namespace App\Http\Controllers\Web\Admin;

use App\Model\Sample;
use App\Model\Service;
use App\Model\ServiceLog;
use App\Model\RequestServices;
use App\Model\Microscopy;
use App\Model\CultureInoculation;
use App\Model\Microbio;
use App\Model\Barcodes;
use App\Model\Enroll;
use Illuminate\Support\Facades\Auth;
use \Milon\Barcode\DNS1D;
use PDF;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;

class CultureInoculationController extends Controller
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
          $year = Barcodes::distinct()->get(['year'])->last();

          //DB::enableQueryLog();
          $data['sample'] = ServiceLog::select('t_service_log.updated_at as ID','m.enroll_id','m.id as sample_id', 'm.receive_date as receive',
		  'm.test_reason as reason','is_accepted','s.result','t_service_log.sample_label as samples','t_service_log.enroll_label as enroll_label',
		  't_service_log.service_id','t_service_log.id as log_id', 't_service_log.status','m.no_of_samples','t.status as dna_status',
		  't.created_at as date_of_extraction','t_service_log.mgit','t_service_log.tube_id_lj','t_service_log.tube_id_lc','ci.inoculation_date',
		  't_service_log.tag', 't_service_log.tag as lpa_type','m.fu_month','t_service_log.enroll_id AS enrollID','t_service_log.sample_id AS sampleID',
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
        ->where('t_service_log.service_id',16)
        ->whereIn('t_service_log.status',[1]) //        ->whereIn('t_service_log.status',[0,1,2])
        ->orderBy('enroll_id','desc')
		->distinct()
		->get();
		//dd(DB::getQueryLog());
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
         //dd($data['sample']);
        //dd($data['sample']);
        // foreach ($data['sample'] as $key => $value) {
        //   $lpa = ServiceLog::select('service_id')->where('enroll_id',$value->enroll_id)->where('sample_id',$value->sample_id)->first();
        //   if($lpa->service_id==6){
        //     $value->lpa_type = "LJ";
        //   }elseif($lpa->service_id==7){
        //     $value->lpa_type = "LC";
        //   }elseif($lpa->service_id==13){
        //     $value->lpa_type = "Both";
        //   }else{
        //     $value->lpa_type = "NA";
        //   }
        // }
        //dd($data['sample']);
        return view('admin.culture_inoculation.list',compact('data','year'));
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
	  //dd($request->all());	 
      $logdata = ServiceLog::find($request->log_id);

      //CultureInoculation::where('sample_id',$logdata->sample_id)->where('enroll_id',$logdata->enroll_id)->delete();
      CultureInoculation::where('enroll_id',$logdata->enroll_id)->delete();
       //DB::enableQueryLog();
      $data = CultureInoculation::create([
        'sample_id' => $logdata->sample_id,
        'enroll_id' => $logdata->enroll_id,
        'mgit_id' => $request->mgit_id,
        'tube_id_lj' => $request->tube_id_lj,
        'tube_id_lc' => $request->tube_id_lc,
        'inoculation_date' => $request->inoculation_date,
        'created_by' => $request->user()->id,
        'updated_by' => $request->user()->id
      ]);
	  //dd(DB::getQueryLog());
	  //dd($data);
      $logdata->comments=!empty($request->comments)?$request->comments:"";
      $logdata->tested_by=$request->user()->name;
      $logdata->released_dt=date('Y-m-d');
      $logdata->status = 0;
      if(!empty($request->mgit_id)){
        $logdata->mgit = $request->mgit_id;
      }
      if(!empty($request->tube_id_lj)){
        $logdata->tube_id_lj = $request->tube_id_lj;
      }
      if(!empty($request->tube_id_lc)){
        $logdata->tube_id_lc = $request->tube_id_lc;
      }

      $logdata->save();
      if($request->service_id == 1 || $request->service_id == 2){
        if($request->service_id == 1){
          $serviceId = 17;
		  $tag="LC";
        }else{
          $serviceId = 20;
		  $tag="LJ";
        }
        $user=$request->user()->id;
         //echo "INSERT INTO `t_service_log` (enroll_id,sample_id,service_id,status,mgit,tube_id_lc,tube_id_lj,created_by,updated_by,enroll_label,sample_label) VALUES ($logdata->enroll_id,$logdata->sample_id,$serviceId,1,'$request->mgit_id','$request->tube_id_lc','$request->tube_id_lj',$user,$user,'$logdata->enroll_label','$logdata->sample_label')"; die;
        $reprted_dt=date('Y-m-d');
		
           //DB::enableQueryLog();
        $new_service=DB::insert(DB::raw("INSERT INTO `t_service_log` (enroll_id,sample_id,service_id,status,mgit,tube_id_lc,tube_id_lj,created_by,updated_by,enroll_label,sample_label,reported_dt,mtb,rifs,gu,week_log,stage,tested_by,comments,tag,rec_flag) VALUES ($logdata->enroll_id,$logdata->sample_id,$serviceId,1,'$request->mgit_id','$request->tube_id_lc','$request->tube_id_lj',$user,$user,'$logdata->enroll_label','$logdata->sample_label','$reprted_dt','','','',0,'','','','$tag',$request->rec_flag)"));
          
		   //dd(DB::getQueryLog());
    //    $nwService = ServiceLog::create($new_service);
      }else{
        if($request->service_id == 3){
          $reprted_dt=date('Y-m-d');
          // dd($request->mgit_id);
         $user=$request->user()->id;
        $new_service=DB::insert(DB::raw("INSERT INTO `t_service_log` (enroll_id,sample_id,service_id,status,mgit,tube_id_lc,tube_id_lj,created_by,updated_by,enroll_label,sample_label,reported_dt,mtb,rifs,gu,week_log,stage,tested_by,comments,tag,rec_flag) VALUES ($logdata->enroll_id,$logdata->sample_id,17,1,'$request->mgit_id','$request->tube_id_lc','$request->tube_id_lj',$user,$user,'$logdata->enroll_label','$logdata->sample_label','$reprted_dt','','','',0,'','','','LC',$request->rec_flag)"));

        $new_service1=DB::insert(DB::raw("INSERT INTO `t_service_log` (enroll_id,sample_id,service_id,status,mgit,tube_id_lc,tube_id_lj,created_by,updated_by,enroll_label,sample_label,reported_dt,mtb,rifs,gu,week_log,stage,tested_by,comments,tag,rec_flag) VALUES ($logdata->enroll_id,$logdata->sample_id,20,1,'$request->mgit_id','$request->tube_id_lc','$request->tube_id_lj',$user,$user,'$logdata->enroll_label','$logdata->sample_label','$reprted_dt','','','',0,'','','','LJ',$request->rec_flag)"));


          // // dd($new_service);
          // $new_service1 = [
          //   'enroll_id' => $logdata->enroll_id,
          //   'sample_id' => $logdata->sample_id,
          //   'service_id' => 20,
          //   'status' => 1,
          //   'created_by' => $request->user()->id,
          //   'updated_by' => $request->user()->id,
          //   'enroll_label' => $logdata->enroll_label,
          //   'sample_label' => $logdata->sample_label,
          // ];
          // $nwService = ServiceLog::create($new_service);
          // $nwService1 = ServiceLog::create($new_service1);
        }
      }

      if($request->service_id=='Send to BWM'){
        // dd("hi");
        $culture = CultureInoculation::select('id')->where('sample_id',$logdata->sample_id)->where('enroll_id',$logdata->enroll_id)->first();
        $culture_obj = CultureInoculation::find($culture->id);
          $microbio = Microbio::create([
            'enroll_id' => $logdata->enroll_id,
            'sample_id' => $logdata->sample_id,
            'service_id' => 26,
            'next_step' => '',
            'detail' => '',
            'remark' => '',
            'bwm' => 1,
            'status' => 0,
            'created_by' => Auth::user()->id,
             'updated_by' => Auth::user()->id
          ]);
          $culture_obj->status = 9;
          $culture_obj->updated_by = $request->user()->id;
          $culture_obj->save();

          ServiceLog::create([
             'enroll_id' => $logdata->enroll_id,
             'sample_id' => $logdata->sample_id,
             'enroll_label' => $logdata->enroll_label,
             'sample_label' => $logdata->sample_label,
             'service_id' => 26,
             'previous_step' => 'AFB Culture Inoculation',
             'status' => 1,
             'tag' => '',
			 'rec_flag' => $request->rec_flag,
             'test_date' => date('Y-m-d H:i:s'),
             'created_by' => Auth::user()->id,
             'updated_by' => Auth::user()->id
           ]);
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
		 return redirect('/culture_inoculation');
    }else{
         return redirect('/culture_inoculation')->withErrors(['Sorry!! Action already taken of the selected Sample']);
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

    public function cultureInnoprint()
    {

        $data = [];
          $data['sample'] = ServiceLog::select('t_service_log.updated_at as ID','m.enroll_id','m.id as sample_id', 'm.receive_date as receive','m.test_reason as reason','is_accepted','s.result','t_service_log.sample_label as samples','t_service_log.enroll_label as enroll_label','t_service_log.service_id','t_service_log.id as log_id', 't_service_log.status','m.no_of_samples','t.status as dna_status','t.created_at as date_of_extraction','ci.mgit_id','ci.tube_id_lj','ci.tube_id_lc','ci.inoculation_date', 't_service_log.tag')
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        ->leftjoin('t_dnaextraction as t', function ($join) {
              $join->on('t.sample_id','=','t_service_log.sample_id')
                   ->where('t.status', 1);
          })
        ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
        ->leftjoin('t_culture_inoculation as ci','ci.sample_id','=','t_service_log.sample_id')
        ->where('t_service_log.service_id',16)
        //->where('s.status',1)
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
        return view('admin.culture_inoculation.print',compact('data'));

    }
    public function getMgitId($enroll_id){
        
        $getmgit=CultureInoculation::select('mgit_id')->where('enroll_id',$enroll_id)->get();
        //dd($getmgit);
		$json_data['json_data_item']=(array) null;
        if(!empty($getmgit)) {
            foreach ($getmgit as $itm_data) {
                $json_data['json_data_item'][]=array("mgit_id"=>$itm_data->mgit_id);
            }
        }


        echo json_encode($json_data);
        exit;
    }
        public function printBarcode(Request $request)
        {

        //  dd($request->all());
            echo "<style>
                @media print {
                  @page {
                  margin-top:8px;
                  size: 100mm 25mm;
                  #size: 100mm 25mm;
                  }

                             img {
                    margin-top: 7%;
                        margin-left:3%;

                    }

                }


                </style>";
                // dd($request->print[0]);
          //   echo "<a href='".url('/culture_inoculation')."' class='btn btn-default btn-sm resultbtn' style='float:left;'>Go Back</a>";
            $sample_string = $request->print;
            foreach ($sample_string as $key => $value) {
              $enroll_ids=Sample::select('enroll_id')->where('sample_label',$value)->first();

    //           $getenroll_sticker=Enroll::select('label')->where('id',$enroll_ids->enroll_id)->first();
    // dd($getenroll_sticker->label);
              // Barcodes::where('')->update(['enroll_no' => $enroll_ids])
    $value=substr($value,0,11);
    $last_index=substr($value,-1);
    if($last_index == 'A'){
      $barcodes = Barcodes::where('codeA',$value)
      ->get(['barcodeA','codeA']);

    }elseif($last_index == 'B'){
      $barcodes = Barcodes::where('codeB',$value)
      ->get(['barcodeB','codeB']);
    }

    // dd($barcodes[0]->barcodeA);
          //     $lc_count=ServiceLog::where('enroll_id',$enroll_ids->enroll_id)->where('service_id',17)->count();
          //
          // $lj_count=ServiceLog::where('enroll_id',$enroll_ids->enroll_id)->where('service_id',20)->count();

    // if($lc_count > 0){
    //   echo "lc is there";
    // }
              if(!empty($barcodes)):
              $counter=$request->no_of_copy[$key];
              for($i=1;$i<=$counter;$i++){

              echo "<div style='float:left; margin-left:9px;'>";
              echo "<img src='".url("/printcode",["text"=>$barcodes[0]->barcodeA,"ptext"=>$barcodes[0]->codeA])."'/>";
              // return redirect()->route('/printcode', ["text"=>$barcodes[0]->barcodeA,"ptext"=>$barcodes[0]->codeA]);
          //    echo DNS1D::getBarcodeSVG($value,"C93",0.6,20); //C39
              // echo "<br/>".$value;
              echo "</div>";
              if($i % 4 == 0 || $i == $counter){
                echo "<div style='clear:both;height:20px;'></div>";
              }

              }
    endif;

            }
            // die;

        }
    }
