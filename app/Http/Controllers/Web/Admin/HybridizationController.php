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
use App\Model\FirstLineLpa;
use App\Model\SecondLineLpa;
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
          /* $data['sample'] = ServiceLog::select('t_service_log.updated_at as ID','m.enroll_id','m.id as sample_id',
                  'm.receive_date as receive','m.test_reason as reason','is_accepted','s.result',
                  't_service_log.sample_label as samples','t_service_log.service_id','t_service_log.id as log_id',
                   't_service_log.status','m.no_of_samples','t.status as dna_status','t.created_at as date_of_extraction',
                   'p.completed as pcr_completed','t_service_log.tag','d.test_date as decontamination_date','t_service_log.status as STATUS','t_service_log.sample_id','t_service_log.service_id','t_service_log.rec_flag')
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')

        ->leftjoin('t_1stlinelpa as t', function ($join) {
          $join->on('t.sample_id','=','t_service_log.sample_id')
                ->on('t.enroll_id', '=', 't_service_log.enroll_id')
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
        } */
		//dd($data['sample']);
		//dd($data['sample'][1]['no_sample']);
        $data['services'] = ["Valid","Invalid","Repeat DNA Extraction from same sample","Repeat DNA Extraction from standby sample", "Repeat Hybridization from same DNA extract"];
        return view('admin.hybridization.list',compact('data'));
      }catch(\Exception $e){
          $error = $e->getMessage();
          return view('admin.layout.error',$error);   // insert query
      }
    }


    public function lpaMethod_count($searchValue, $req_tag)
    {

      $data = [];
      $tags = []; 
      $table_name = "";    
      
      if( $req_tag == '1st line LPA' )
      {
        $tags = array('LPA1', 'LPA 1st Line', '1st line LPA');
        $table_name = 't_1stlinelpa';

      } elseif( $req_tag == '2nd line LPA' )
      {
        $tags = array('LPA2', 'LPA 2nd Line', '2nd line LPA');
        $table_name = 't_2stlinelpa';

      } 
            
            if(  $searchValue != "" )
            {
              $data = ServiceLog::select('t_service_log.updated_at as ID','m.enroll_id','m.id as sample_id',
              'm.receive_date as receive','m.test_reason as reason','is_accepted','s.result',
              't_service_log.sample_label as samples','t_service_log.service_id','t_service_log.id as log_id',
               't_service_log.status','m.no_of_samples','t.status as dna_status','t.created_at as date_of_extraction',
               'p.completed as pcr_completed','t_service_log.tag','d.test_date as decontamination_date','t_service_log.status as STATUS','t_service_log.sample_id','t_service_log.service_id','t_service_log.rec_flag')
                ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')

                ->leftjoin($table_name.' as t', function ($join) {
                  $join->on('t.sample_id','=','t_service_log.sample_id')
                        ->on('t.enroll_id', '=', 't_service_log.enroll_id')
                      ->where('t.status', 1);
              })
              /*  ->leftjoin('t_dnaextraction as t', function ($join) {
                      $join->on('t.sample_id','=','t_service_log.sample_id')
                          ->where('t.status', 1);
                  }) */
                ->leftjoin('t_decontamination as d', function ($join) {
                      $join->on('d.sample_id','=','t_service_log.sample_id')
                          ->where('d.status', 1);
                  })
                ->leftjoin('t_pcr as p','p.sample_id','=','t_service_log.sample_id')
                ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
                ->where('t_service_log.service_id',14)
                ->whereIn('t_service_log.status',[1]) //  ->whereIn('t_service_log.status',[0,1,2])
                ->whereIn('t_service_log.tag', $tags)
                ->Where('t_service_log.enroll_label', 'LIKE', '%'.$searchValue.'%')
                ->orWhere('t_service_log.sample_label', 'LIKE', '%'.$searchValue.'%')
                ->orderBy('enroll_id','desc')
                ->groupBy('log_id') // made changes for multiple records displaying in Hybridisation
                ->groupBy('samples')                
                ->get();

            } else {

              $data = ServiceLog::select('t_service_log.updated_at as ID','m.enroll_id','m.id as sample_id',
              'm.receive_date as receive','m.test_reason as reason','is_accepted','s.result',
              't_service_log.sample_label as samples','t_service_log.service_id','t_service_log.id as log_id',
               't_service_log.status','m.no_of_samples','t.status as dna_status','t.created_at as date_of_extraction',
               'p.completed as pcr_completed','t_service_log.tag','d.test_date as decontamination_date','t_service_log.status as STATUS','t_service_log.sample_id','t_service_log.service_id','t_service_log.rec_flag')
                ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')

                ->leftjoin($table_name.' as t', function ($join) {
                  $join->on('t.sample_id','=','t_service_log.sample_id')
                        ->on('t.enroll_id', '=', 't_service_log.enroll_id')
                      ->where('t.status', 1);
              })
              /*  ->leftjoin('t_dnaextraction as t', function ($join) {
                      $join->on('t.sample_id','=','t_service_log.sample_id')
                          ->where('t.status', 1);
                  }) */
                ->leftjoin('t_decontamination as d', function ($join) {
                      $join->on('d.sample_id','=','t_service_log.sample_id')
                          ->where('d.status', 1);
                  })
                ->leftjoin('t_pcr as p','p.sample_id','=','t_service_log.sample_id')
                ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
                ->where('t_service_log.service_id',14)
                ->whereIn('t_service_log.status',[1]) //  ->whereIn('t_service_log.status',[0,1,2])
                ->whereIn('t_service_log.tag', $tags)                
                ->orderBy('enroll_id','desc')
                ->groupBy('log_id') // made changes for multiple records displaying in Hybridisation
                ->groupBy('samples')                
                ->get();
        }

        $response = array('rec_count' => count($data));
        return $response;

    }

    public function lpaMethod($searchValue, $row, $rowperpage, $req_tag)
    {

      $data = [];
      $tags = []; 
      $table_name = "";    
      
      if( $req_tag == '1st line LPA' )
      {
        $tags = array('LPA1', 'LPA 1st Line', '1st line LPA');
        $table_name = 't_1stlinelpa';

      } elseif( $req_tag == '2nd line LPA' )
      {
        $tags = array('LPA2', 'LPA 2nd Line', '2nd line LPA');
        $table_name = 't_2stlinelpa';

      } 
            
            if(  $searchValue != "" )
            {
              $data = ServiceLog::select('t_service_log.updated_at as ID','m.enroll_id','m.id as sample_id',
              'm.receive_date as receive','m.test_reason as reason','is_accepted','s.result',
              't_service_log.sample_label as samples','t_service_log.service_id','t_service_log.id as log_id',
               't_service_log.status','m.no_of_samples','t.status as dna_status','t.created_at as date_of_extraction',
               'p.completed as pcr_completed','t_service_log.tag','d.test_date as decontamination_date','t_service_log.status as STATUS','t_service_log.sample_id','t_service_log.service_id','t_service_log.rec_flag')
                ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')

                ->leftjoin($table_name.' as t', function ($join) {
                  $join->on('t.sample_id','=','t_service_log.sample_id')
                        ->on('t.enroll_id', '=', 't_service_log.enroll_id')
                      ->where('t.status', 1);
              })
              /*  ->leftjoin('t_dnaextraction as t', function ($join) {
                      $join->on('t.sample_id','=','t_service_log.sample_id')
                          ->where('t.status', 1);
                  }) */
                ->leftjoin('t_decontamination as d', function ($join) {
                      $join->on('d.sample_id','=','t_service_log.sample_id')
                          ->where('d.status', 1);
                  })
                ->leftjoin('t_pcr as p','p.sample_id','=','t_service_log.sample_id')
                ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
                ->where('t_service_log.service_id',14)
                ->whereIn('t_service_log.status',[1]) //  ->whereIn('t_service_log.status',[0,1,2])
                ->whereIn('t_service_log.tag', $tags)
                ->Where('t_service_log.enroll_label', 'LIKE', '%'.$searchValue.'%')
                ->orWhere('t_service_log.sample_label', 'LIKE', '%'.$searchValue.'%')
                ->orderBy('enroll_id','desc')
                ->groupBy('log_id') // made changes for multiple records displaying in Hybridisation
                ->groupBy('samples')
                ->skip($row)
                ->take($rowperpage)
                ->get();

            } else {

              $data = ServiceLog::select('t_service_log.updated_at as ID','m.enroll_id','m.id as sample_id',
              'm.receive_date as receive','m.test_reason as reason','is_accepted','s.result',
              't_service_log.sample_label as samples','t_service_log.service_id','t_service_log.id as log_id',
               't_service_log.status','m.no_of_samples','t.status as dna_status','t.created_at as date_of_extraction',
               'p.completed as pcr_completed','t_service_log.tag','d.test_date as decontamination_date','t_service_log.status as STATUS','t_service_log.sample_id','t_service_log.service_id','t_service_log.rec_flag')
                ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')

                ->leftjoin($table_name.' as t', function ($join) {
                  $join->on('t.sample_id','=','t_service_log.sample_id')
                        ->on('t.enroll_id', '=', 't_service_log.enroll_id')
                      ->where('t.status', 1);
              })
              /*  ->leftjoin('t_dnaextraction as t', function ($join) {
                      $join->on('t.sample_id','=','t_service_log.sample_id')
                          ->where('t.status', 1);
                  }) */
                ->leftjoin('t_decontamination as d', function ($join) {
                      $join->on('d.sample_id','=','t_service_log.sample_id')
                          ->where('d.status', 1);
                  })
                ->leftjoin('t_pcr as p','p.sample_id','=','t_service_log.sample_id')
                ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
                ->where('t_service_log.service_id',14)
                ->whereIn('t_service_log.status',[1]) //  ->whereIn('t_service_log.status',[0,1,2])
                ->whereIn('t_service_log.tag', $tags)                
                ->orderBy('enroll_id','desc')
                ->groupBy('log_id') // made changes for multiple records displaying in Hybridisation
                ->groupBy('samples')
                ->skip($row)
                ->take($rowperpage)
                ->get();
        } 
        
        $response = array('data' => $data);

      return $response;

    }


    public function ajaxHybridizationList(Request $request)
    {
      $searchValue = "";

      $draw = $_POST['draw'];
      $row = $_POST['start'];
      $rowperpage = $_POST['length']; // Rows display per page
      $columnIndex = $_POST['order'][0]['column']; // Column index
      $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
      $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
      $searchValue = $_POST['search']['value']; // Search value 

      //dd($searchValue);

      $lpa1stline = 0;
      $lpa2stline = 0;
      $lpa1st2stline = 0;
      $lpa1sor2ndtline = 0;
      $count = 0;

      $req_tag = $request->tag;      

      $data[] = array();   
      
      if($req_tag == '1st line LPA')
       {
           $result = $this->lpaMethod($searchValue, $row, $rowperpage, $req_tag);           
           $data['sample'] = $result['data'];          

       } elseif( $req_tag == '2nd line LPA' ) {

         $result = $this->lpaMethod($searchValue, $row, $rowperpage, $req_tag);
         $data['sample'] = $result['data'];         

       }

        $result_count_1st = $this->lpaMethod_count($searchValue, '1st line LPA');
        $lpa1stline =  $result_count_1st['rec_count'];
        $count = $lpa1stline;  
        
        $result_count_1st = $this->lpaMethod_count($searchValue, '2nd line LPA');
        $lpa2stline =  $result_count_1st['rec_count'];
        $count = $lpa2stline;

        if($req_tag == '1st line LPA')
        {

        $result_count_1st = $this->lpaMethod_count($searchValue, '1st line LPA');
        $count =  $result_count_1st['rec_count'];        

        } elseif( $req_tag == '2nd line LPA' ) {

        $result_count_1st = $this->lpaMethod_count($searchValue, '2nd line LPA');
        $count =  $result_count_1st['rec_count'];

        }

        $input = "";
        $hide = "";
        $sample_id = "";
        $sample_submitted = "";
        $date_of_deconta = "";
        $next_result = "";
        $action = "";
        $m_result = "";
        $date_of_extraction = "";
        $lpa_test = "";
        $pcr_completed = "";
        $hydra_data = [];

        foreach ($data['sample'] as $key => $samples) {
          //DB::enableQueryLog(); 		
          $samples->no_sample = ServiceLog::where('enroll_id',$samples->enroll_id)->where('service_id',11)->count();
      //dd(DB::getQueryLog());	
         $lpa = ServiceLog::select('service_id')->where('enroll_id',$samples->enroll_id)->where('sample_id',$samples->sample_id)->first();
         if($lpa->service_id==6){
           $samples->lpa_type = "LPA 1st line";
         }elseif($lpa->service_id==7){
           $samples->lpa_type = "LPA 2nd line";
         }elseif($lpa->service_id==13){
           $samples->lpa_type = "LPA Both Line";
         }else{
           $samples->lpa_type = "NA";
         }

         if($samples->status && $samples->status==1)
         {
          $input = '<input class="bulk-selected" type="checkbox" value="'.$samples->log_id.'">';
         }

         $hide = $samples->ID;
         $sample_id = $samples->samples;
         $sample_submitted = $samples->no_of_samples;
         $date_of_deconta = $samples->decontamination_date != "" ? date('d-m-Y', strtotime($samples->decontamination_date)) : "";
         $action = $samples->STATUS == 0 ? 'Done' : "<button onclick=\"openNextForm('".$samples->samples."', ".$samples->log_id.", ".$samples->enroll_id.",'".$samples->tag."','".$samples->no_sample."', ".$samples->sample_id.", ".$samples->service_id.", ".$samples->rec_flag.")\" type='button' class = 'btn btn-info btn-sm  nextbtn'>Submit</button>";
         $next_result = $samples->result;        
         $date_of_extraction = $samples->date_of_extraction != "" ? date('d-m-Y', strtotime($samples->date_of_extraction)) : "";
         $lpa_test = $samples->tag;
         $pcr_completed = $samples->pcr_completed==1 ? 'Yes' : 'No';

         $hydra_data[] = array(

          "DT_RowId"=> $key,
          "DT_RowClass"=>'sel',
          "ID"=>$hide,
          "inputs" => $input,
          "sample_id" => $sample_id,          
          "sample_submitted" => $sample_submitted, 
          "date_of_deconta" => $date_of_deconta,
          "action" => $action,                       
          "next_result" => $next_result,
          "date_of_extraction" => $date_of_extraction,          
          "lpa_test" => $lpa_test,
          "pcr_completed" => $pcr_completed,                

        ); 

       }

       $hydra_data = array_values(array_filter($hydra_data));

        //dd($dna_extraction_data);
   
        $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $count,
          "iTotalDisplayRecords" => $count,
          "aaData" => $hydra_data,
          "no_1st_lpa" => $lpa1stline,
          "no_2st_lpa" => $lpa2stline,
                            
        );
   
        //dd($response);
   
        echo json_encode($response);

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

      /* Updated on 11-03-2021 */

		    /* Hybridization::where('enroll_id', $log->enroll_id)->where('tag',$request->tag)->delete();

          $hybridization = Hybridization::create([
            'enroll_id' => $log->enroll_id,
            'sample_id' => $log->sample_id,
            'result' => $result,
            'status' => 1 ,
            'tag' => $request->tag		   
          ]); */

                       if( $request->tag == '1st line LPA')
                        {   
                            $find_lpa1st_data = FirstLineLpa::where('sample_id', $request->sampleID)
                                                ->where('enroll_id', $request->enroll_id)
                                                ->where('tag', '1st line LPA')
                                                ->count();
                            //dd($find_lpa1st_data);
              
                            if($find_lpa1st_data >= 1)
                            {
                                
                                $updated = FirstLineLpa::where('sample_id', $request->sampleID)
                                ->where('enroll_id', $request->enroll_id)
                                ->where('tag', '1st line LPA')
                                ->update(['hybridization_date' => date('Y-m-d'), 'hybridization_result'  => $result]);   
                                
                                //dd($updated);

                            } else {

                                $new_1st_lpa = FirstLineLpa::create([
                                    'enroll_id'             => $request->enroll_id,
                                    'sample_id'             => $request->sampleID,
                                    'tag'                   => '1st line LPA',
                                    'hybridization_date'    => date('Y-m-d'),
                                    'hybridization_result'  => $result,
                                    ]);
                            } 
                           
                        }

                        if( $request->tag == '2nd line LPA')
                        {   
                            $find_lpa2st_data = SecondLineLpa::where('sample_id', $request->sampleID)
                                                ->where('enroll_id', $request->enroll_id)
                                                ->where('tag', '2nd line LPA')
                                                ->count();

                            //dd($find_lpa1st_data);
              
                            if($find_lpa2st_data >= 1)
                            {                                
                                SecondLineLpa::where('sample_id', $request->sampleID)
                                ->where('enroll_id', $request->enroll_id)
                                ->where('tag', '2nd line LPA')
                                ->update(['hybridization_date' => date('Y-m-d'), 'hybridization_result'  => $result]);                                 

                            } else {

                              $new_1st_lpa = SecondLineLpa::create([
                                'enroll_id'             => $request->enroll_id,
                                'sample_id'             => $request->sampleID,
                                'tag'                   => '1st line LPA',
                                'hybridization_date'    => date('Y-m-d'),
                                'hybridization_result'  => $result,
                                ]);

                            }
                            
                        }
		}
		 //dd(DB::getQueryLog());
         //dd($hybridization);
        if($request->service_id == 0){//VALID
          $log = ServiceLog::find($request->service_log_id);

           /* Updated on 11-03-2021 */

           ServiceLog::where('id', $log->id)                           
           ->firstorfail()
           ->delete();

          /* $log->released_dt=date('Y-m-d');
          $log->comments=$request->comments;
          $log->tested_by=$request->user()->name;
          $log->status = 0;
          $log->updated_by = $request->user()->id;
          $log->save(); */
		  
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

          /* Updated on 11-03-2021 */

          $log = ServiceLog::find($request->service_log_id);

          /* $log->released_dt=date('Y-m-d');
          $log->comments=$request->comments;
          $log->tested_by=$request->user()->name;
          $log->status = 0;
          $log->updated_by = $request->user()->id;
          $log->save(); */

          ServiceLog::where('id', $log->id)                           
          ->firstorfail()
          ->delete();

          /*$microbio = Microbio::create([
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
		   DB::commit();	  */
       $new_service = [
              'enroll_id' =>  $log->enroll_id,
              'sample_id' =>  $log->sample_id,
              'service_id' => 15,
              'status' => 1,
              'reported_dt'=>date('Y-m-d'),
              'tag' => $request->tag,
              'rec_flag' =>$request->rec_flag,
              'created_by' => $request->user()->id,
              'updated_by' => $request->user()->id,
              'enroll_label' =>  $log->enroll_label,
              'sample_label' => $log->sample_label,
            ];
            $nwService = ServiceLog::create($new_service);
            DB::commit();
          //return $log;
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
    /**
     *
     * Bulk send to hybridization Review.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function bulkStore( Request $request ){ 
      // Validate User Inputs ===========================================
        $this->validate( $request, [
            'sample_ids' => 'required',
           // 'test_date'  => 'required|date_format:Y-m-d',
        ] );  
        DB::beginTransaction();
        try {
        $sample_ids = trim( $request->input('sample_ids') );
        $sample_ids = explode(',', $sample_ids);        
        $data = array();
         foreach($sample_ids as $sample_id){
              $data['sample'] = ServiceLog::select('t_service_log.updated_at as ID','m.enroll_id','m.id as sample_id',
                      'm.receive_date as receive','m.test_reason as reason','is_accepted','s.result',
                      't_service_log.sample_label as samples','t_service_log.service_id','t_service_log.id as log_id',
                       't_service_log.status','t_service_log.enroll_label','t_service_log.sample_label','m.no_of_samples','t.status as dna_status','t.created_at as date_of_extraction',
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
            ->where('t_service_log.id',$sample_id)
            ->whereIn('t_service_log.status',[1]) //  ->whereIn('t_service_log.status',[0,1,2])
            ->orderBy('enroll_id','desc')
            ->groupBy('log_id') // made changes for multiple records displaying in Hybridisation
            ->groupBy('samples')
            ->get();        

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


          if(($request->service_id == 0)||($request->service_id == 1)){//VALID & INVALID
             
            Hybridization::where('enroll_id', $data['sample'][0]->enroll_id)->where('tag',$data['sample'][0]->tag)->delete();
              $hybridization = Hybridization::create([
               'enroll_id' => $data['sample'][0]->enroll_id,
               'sample_id' => $data['sample'][0]->sample_id,
               'result' => $result,
               'status' => 1 ,
               'tag' => $data['sample'][0]->tag   
             ]);

                        if( $data['sample'][0]->tag == '1st line LPA')
                        {   
                            $find_lpa1st_data = FirstLineLpa::where('sample_id', $data['sample'][0]->sample_id)
                                                ->where('enroll_id', $data['sample'][0]->enroll_id)
                                                ->where('tag', '1st line LPA')
                                                ->count();
                            //dd($find_lpa1st_data);
              
                            if($find_lpa1st_data >= 1)
                            {
                                
                                $updated = FirstLineLpa::where('sample_id', $data['sample'][0]->sample_id)
                                ->where('enroll_id', $data['sample'][0]->enroll_id)
                                ->where('tag', '1st line LPA')
                                ->update(['hybridization_date' => date('Y-m-d'), 'hybridization_result'  => $result]);   
                                
                                //dd($updated);

                            } else {

                                $new_1st_lpa = FirstLineLpa::create([
                                    'enroll_id'             => $data['sample'][0]->enroll_id,
                                    'sample_id'             => $data['sample'][0]->sample_id,
                                    'tag'                   => '1st line LPA',
                                    'hybridization_date'    => date('Y-m-d'),
                                    'hybridization_result'  => $result,
                                    ]);
                            } 
                           
                        }

                        if( $data['sample'][0]->tag == '2nd line LPA')
                        {   
                            $find_lpa2st_data = SecondLineLpa::where('sample_id', $data['sample'][0]->sample_id)
                                                ->where('enroll_id', $data['sample'][0]->enroll_id)
                                                ->where('tag', '2nd line LPA')
                                                ->count();

                            //dd($find_lpa1st_data);
              
                            if($find_lpa2st_data >= 1)
                            {                                
                                SecondLineLpa::where('sample_id', $data['sample'][0]->sample_id)
                                ->where('enroll_id', $data['sample'][0]->enroll_id)
                                ->where('tag', '2nd line LPA')
                                ->update(['hybridization_date' => date('Y-m-d'), 'hybridization_result'  => $result]);                                 

                            } else {

                              $new_1st_lpa = SecondLineLpa::create([
                                'enroll_id'             => $data['sample'][0]->enroll_id,
                                'sample_id'             => $data['sample'][0]->sample_id,
                                'tag'                   => '1st line LPA',
                                'hybridization_date'    => date('Y-m-d'),
                                'hybridization_result'  => $result,
                                ]);

                            }
                            
                        }

          } 
          if($request->service_id == 0){//VALID

              /* $log = ServiceLog::find($data['sample'][0]->log_id);
              //dd($data['sample'][0]->id );
              $log->released_dt=date('Y-m-d');
              $log->comments=$request->comments;
              $log->tested_by=$request->user()->name;
              //$log->tested_by = 'Administrator';
              $log->status = 0;             
              $log->updated_by = $request->user()->id;
              $log->save(); */
              $log = ServiceLog::find($data['sample'][0]->log_id);
              ServiceLog::where('id', $log->id)                           
          ->firstorfail()
          ->delete();
      
            $new_service = [
              'enroll_id' => $data['sample'][0]->enroll_id,
              'sample_id' => $data['sample'][0]->sample_id,
              'service_id' => 15,
              'status' => 1,
              'reported_dt'=>date('Y-m-d'),
              'tag' => $data['sample'][0]->tag,
              'rec_flag' => $data['sample'][0]->rec_flag,
              'created_by' => $request->user()->id,
              'updated_by' => $request->user()->id,
              'enroll_label' => $data['sample'][0]->enroll_label,
              'sample_label' => $data['sample'][0]->sample_label,
            ];
            $nwService = ServiceLog::create($new_service);
             DB::commit();
            //return $nwService;          
          }elseif($request->service_id == 1){//INVALID

            /* $log = ServiceLog::find($data['sample'][0]->log_id);
            $log->released_dt=date('Y-m-d');
            $log->comments=$request->comments;
            $log->tested_by=$request->user()->name;
            $log->status = 0;
            $log->updated_by = $request->user()->id;
            $log->save(); */

            $log = ServiceLog::find($data['sample'][0]->log_id);
              ServiceLog::where('id', $log->id)                           
          ->firstorfail()
          ->delete();

            /*$microbio = Microbio::create([
              'enroll_id' => $data['sample'][0]->enroll_id,
              'sample_id' => $data['sample'][0]->sample_id,
                'service_id' => 14,
                //'rec_flag' => $request->rec_flag,
                'rec_flag' => $data['sample'][0]->rec_flag,
                'next_step' => '',
                'detail' => '',
                'remark' => '',
                'status' => 0,
                'created_by' => $request->user()->id,
                'updated_by' => $request->user()->id,
              ]);*/
            $new_service = [
              'enroll_id' => $data['sample'][0]->enroll_id,
              'sample_id' => $data['sample'][0]->sample_id,
              'service_id' => 15,
              'status' => 1,
              'reported_dt'=>date('Y-m-d'),
              'tag' => $data['sample'][0]->tag,
              'rec_flag' => $data['sample'][0]->rec_flag,
              'created_by' => $request->user()->id,
              'updated_by' => $request->user()->id,
              'enroll_label' => $data['sample'][0]->enroll_label,
              'sample_label' => $data['sample'][0]->sample_label,
            ];
            $nwService = ServiceLog::create($new_service);
            DB::commit();
           // return $nwService;
          }elseif($request->service_id == 3){//Repeat DNA Extraction from standby sample

            $storagelog = ServiceLog::where('enroll_id',$data['sample'][0]->enroll_id)->where('service_id',11)->first(); 
            if($storagelog){
              //UPDATE STATUS=0 SERVICE LOG WITH SERVICE_ID=14
                $log_data = ServiceLog::find($data['sample'][0]->log_id);          
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
              DNAextraction::where('enroll_id', $data['sample'][0]->enroll_id)->where('sample_id',$data['sample'][0]->sample_id)->delete();                                    
              Pcr::where('enroll_id',$data['sample'][0]->enroll_id)->where('sample_id',$data['sample'][0]->sample_id)->where('tag','like',$data['sample'][0]->tag)->delete();
              
            //INSERT IN TO SERVICE LOG   
            $new_service = [
              'enroll_id' => $data['sample'][0]->enroll_id,
              'sample_id' => $data['sample'][0]->sample_id,
             // 'sample_id' => $storagelog->sample_id,
              'service_id' => 8,
              'status' => 1,
              'tag' => $data['sample'][0]->tag,
              'rec_flag' =>  $data['sample'][0]->rec_flag,
              'reported_dt'=>date('Y-m-d'),
              'created_by' => $request->user()->id,
              'updated_by' => $request->user()->id,
              'enroll_label' => $data['sample'][0]->enroll_label,
              'sample_label' => $data['sample'][0]->sample_label,
             ];   
              $nwService = ServiceLog::create($new_service);
              //UPDATE SERVICE LOG AGAIN with old service id=8
              ServiceLog::where('sample_id',$data['sample'][0]->sample_id)->where('enroll_id',$data['sample'][0]->enroll_id)->where('service_id',8)->update(['status'=>99]);
              DB::commit();
             //return $nwService;
            }
          }elseif($request->service_id == 4){
            $log = ServiceLog::find($data['sample'][0]->log_id);
            $old_sample = Sample::select('sample_label')->where('id',$data['sample'][0]->sample_id)->first();
            $new_sample = $old_sample->sample_label.'R';

            Sample::where('id',$data['sample'][0]->sample_id)->update(['sample_label'=>$new_sample]);

                           
            Pcr::where('enroll_id',$data['sample'][0]->enroll_id)->where('sample_id',$data['sample'][0]->sample_id)->where('tag','like',$data['sample'][0]->tag)->delete();

            //ServiceLog::where('sample_id',$log->sample_id)->where('status','!=',0)->update(['sample_label'=>$new_sample]);

            //INSERT IN TO SERVICE LOG   
            $new_service = [
            'enroll_id' => $data['sample'][0]->enroll_id,
            'sample_id' => $data['sample'][0]->sample_id,
            'service_id' => 12,
            'status' => 1,
            'tag' => $log->tag,
            'rec_flag' => $data['sample'][0]->rec_flag + 1,
            'reported_dt'=>date('Y-m-d'),
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id,
            'enroll_label' => $data['sample'][0]->enroll_label,
            'sample_label' => $new_sample,
            ];

            $nwService = ServiceLog::create($new_service);

            //update service log with 99          
            $log->status = 99;      
            $log->updated_by = $request->user()->id;          
            $log->save();
            //dd($data);
            DB::commit();
           // return $nwService;
          }
         }
        DB::commit();
        }catch(\Exception $e){
        //dd($e->getMessage()); 
         DB::rollback();
       // return redirect('/dash_decontamination')->withErrors(['Sorry!! Action already taken of the selected Sample']);
       return back();
      }
      return back(); 
    }
}
