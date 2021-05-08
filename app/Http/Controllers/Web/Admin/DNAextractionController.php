<?php

namespace App\Http\Controllers\Web\Admin;

use App\Model\Sample;
use App\Model\Service;
use App\Model\ServiceLog;
use App\Model\Microscopy;
use App\Model\DNAextraction;
use App\Model\Decontamination;
use App\Model\FirstLineLpa;
use App\Model\SecondLineLpa;
use App\Model\RequestServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;

class DNAextractionController extends Controller
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
        $data['today'] = date('d-m-Y H:i:s');

		//DB::enableQueryLog();
        /* $data['sample'] = ServiceLog::select('t_service_log.updated_at as ID','m.enroll_id', 'm.receive_date as receive',
                    'm.test_reason as reason','is_accepted','s.result','t_service_log.sample_label as samples',
                    't_service_log.service_id','t_service_log.id as log_id', 't_service_log.status','m.no_of_samples',
                    't.status as dna_status','t_service_log.tag',DB::raw('date_format(d.test_date,"%d-%m-%y") as decontamination_date'),
                    't.created_at as extraction_date','t_service_log.status as STATUS','t_service_log.rec_flag','t_service_log.sample_id')
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        ->leftjoin('t_dnaextraction as t', function ($join) {
              $join->on('t.sample_id','=','t_service_log.sample_id')
                   ->where('t.status', 1);
          })
        ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
        ->leftjoin('t_decontamination as d', function ($join) {
              $join->on('d.sample_id','=','t_service_log.sample_id')
                   ->where('d.status', 1);
          })
        ->where('t_service_log.service_id',8)
        ->whereIn('t_service_log.status',[1]) //  ->whereIn('t_service_log.status',[0,1,2])
        ->orderBy('enroll_id','desc')
        ->distinct()
        ->groupBy('log_id') //made changes for multiple records displaying in DNA-EXTRACTION
        ->get(); */
        //dd($data['sample'] );
         //dd(DB::getQueryLog());

        /* foreach ($data['sample'] as $key => $value) {
            $value->no_sample = ServiceLog::where('enroll_id',$value->enroll_id)->where('service_id',11)->count();
			
		    //Test Request
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
        } */
		//dd($data['sample']);
		//dd($data['sample'][0]['no_sample']);
        $data['summaryTotal'] = ServiceLog::whereIn('status',[1,2])
                    ->whereIn('service_id',[1,2])
                    ->count();
        $data['summaryDone'] = ServiceLog::where('status',1)
                    ->whereIn('service_id',[1,2])
                    ->count();
        $data['summarySent'] = ServiceLog::where('status',2)
                    ->whereIn('service_id',[1,2])
                    ->count();
        $data['services'] = Service::select('id','name')->where('record_status',1)->get();
		//dd($data['sample']);

        return view('admin.DNAextraction.list',compact('data'));
      }catch(\Exception $e){
          $error = $e->getMessage();
          return view('admin.layout.error',$error);   // insert query
      }
    }

    public function lpa1st_count($searchValue)
    {
      $data = [];

      //dd($searchValue);

      if( $searchValue != "")
      {        

        $data = ServiceLog::select('t_service_log.updated_at as ID','m.enroll_id', 'm.receive_date as receive', 'm.test_reason as reason','is_accepted','s.result','t_service_log.sample_label as samples',
      't_service_log.service_id','t_service_log.id as log_id', 't_service_log.status','m.no_of_samples', 't.status as dna_status','t_service_log.tag', DB::raw('date_format(d.test_date,"%d-%m-%y") as decontamination_date'), 't.created_at as extraction_date', 't_service_log.status as STATUS','t_service_log.rec_flag','t_service_log.sample_id')
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        ->leftjoin('t_1stlinelpa as t', function ($join) {
              $join->on('t.sample_id','=','t_service_log.sample_id')
                    ->on('t.enroll_id', '=', 't_service_log.enroll_id')
                  ->where('t.status', 1);
          })
        ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')        
        ->where('t_service_log.service_id',8)
        ->whereIn('t_service_log.tag', array('LPA1', 'LPA 1st Line', '1st line LPA'))
        ->Where('t_service_log.sample_label', 'LIKE', '%'.$searchValue.'%')
        ->whereIn('t_service_log.status',[1]) //  ->whereIn('t_service_log.status',[0,1,2])
        ->orderBy('enroll_id','desc')
        ->distinct()
        ->groupBy('log_id') //made changes for multiple records displaying in DNA-EXTRACTION        
        ->get();

      } else {        

        //DB::enableQueryLog();
        $data = ServiceLog::select('t_service_log.updated_at as ID','m.enroll_id', 'm.receive_date as receive', 'm.test_reason as reason','is_accepted','s.result','t_service_log.sample_label as samples', 't_service_log.service_id','t_service_log.id as log_id', 't_service_log.status','m.no_of_samples', 't.status as dna_status','t_service_log.tag', DB::raw('date_format(d.test_date,"%d-%m-%y") as decontamination_date'), 't.created_at as extraction_date', 't_service_log.status as STATUS','t_service_log.rec_flag','t_service_log.sample_id')
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        ->leftjoin('t_1stlinelpa as t', function ($join) {
              $join->on('t.sample_id','=','t_service_log.sample_id')
                    ->on('t.enroll_id', '=', 't_service_log.enroll_id')
                  ->where('t.status', 1);
          })
        ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
        ->leftjoin('t_decontamination as d', function ($join) {
          $join->on('d.sample_id','=','t_service_log.sample_id')
              ->where('d.status', 1);
          })        
        ->where('t_service_log.service_id',8) 
        ->whereIn('t_service_log.tag', array('LPA1', 'LPA 1st Line', '1st line LPA'))         
        ->whereIn('t_service_log.status',[1]) //  ->whereIn('t_service_log.status',[0,1,2])
        ->orderBy('enroll_id','desc')
        ->distinct()
        ->groupBy('log_id') //made changes for multiple records displaying in DNA-EXTRACTION        
        ->get();
        //dd(DB::getQueryLog());
        //dd($data);
      }

      $response = array('rec_count' => count($data));

      return $response;     

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
      //dd($searchValue);

      /* Sql for 1st line or 2nd line */

      if( $searchValue != "")
      {        

      $data = ServiceLog::select('t_service_log.updated_at as ID','m.enroll_id', 'm.receive_date as receive', 'm.test_reason as reason','is_accepted','s.result','t_service_log.sample_label as samples',
      't_service_log.service_id','t_service_log.id as log_id', 't_service_log.status','m.no_of_samples', 't.status as dna_status','t_service_log.tag', DB::raw('date_format(d.test_date,"%d-%m-%y") as decontamination_date'), 't.created_at as extraction_date', 't_service_log.status as STATUS','t_service_log.rec_flag','t_service_log.sample_id')
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        ->leftjoin($table_name.' as t', function ($join) {
              $join->on('t.sample_id','=','t_service_log.sample_id')
                    ->on('t.enroll_id', '=', 't_service_log.enroll_id')
                  ->where('t.status', 1);
          })
        ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')        
        ->where('t_service_log.service_id',8)
        ->whereIn('t_service_log.tag', $tags)
        ->Where('t_service_log.sample_label', 'LIKE', '%'.$searchValue.'%')
        ->whereIn('t_service_log.status',[1]) //  ->whereIn('t_service_log.status',[0,1,2])
        ->orderBy('enroll_id','desc')
        ->distinct()
        ->groupBy('log_id') //made changes for multiple records displaying in DNA-EXTRACTION                
        ->get();

      } else {        

        //DB::enableQueryLog();
        $data = ServiceLog::select('t_service_log.updated_at as ID','m.enroll_id', 'm.receive_date as receive', 'm.test_reason as reason','is_accepted','s.result','t_service_log.sample_label as samples', 't_service_log.service_id','t_service_log.id as log_id', 't_service_log.status','m.no_of_samples', 't.status as dna_status','t_service_log.tag', DB::raw('date_format(d.test_date,"%d-%m-%y") as decontamination_date'), 't.created_at as extraction_date', 't_service_log.status as STATUS','t_service_log.rec_flag','t_service_log.sample_id')
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        ->leftjoin($table_name.' as t', function ($join) {
              $join->on('t.sample_id','=','t_service_log.sample_id')
                    ->on('t.enroll_id', '=', 't_service_log.enroll_id')
                  ->where('t.status', 1);
          })
        ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
        ->leftjoin('t_decontamination as d', function ($join) {
          $join->on('d.sample_id','=','t_service_log.sample_id')
              ->where('d.status', 1);
          })        
        ->where('t_service_log.service_id',8) 
        ->whereIn('t_service_log.tag', $tags)         
        ->whereIn('t_service_log.status',[1]) //  ->whereIn('t_service_log.status',[0,1,2])
        ->orderBy('enroll_id','desc')
        ->distinct()
        ->groupBy('log_id') //made changes for multiple records displaying in DNA-EXTRACTION        
        ->get();
        //dd(DB::getQueryLog());
        //dd($data);
      }      

      //dd($data);

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
      //dd($searchValue);

      /* Sql for 1st line or 2nd line */

      if( $searchValue != "")
      {        

      $data = ServiceLog::select('t_service_log.updated_at as ID','m.enroll_id', 'm.receive_date as receive', 'm.test_reason as reason','is_accepted','s.result','t_service_log.sample_label as samples',
      't_service_log.service_id','t_service_log.id as log_id', 't_service_log.status','m.no_of_samples', 't.status as dna_status','t_service_log.tag', DB::raw('date_format(d.test_date,"%d-%m-%y") as decontamination_date'), 't.created_at as extraction_date', 't_service_log.status as STATUS','t_service_log.rec_flag','t_service_log.sample_id')
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        ->leftjoin($table_name.' as t', function ($join) {
              $join->on('t.sample_id','=','t_service_log.sample_id')
                    ->on('t.enroll_id', '=', 't_service_log.enroll_id')
                  ->where('t.status', 1);
          })
        ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')        
        ->where('t_service_log.service_id',8)
        ->whereIn('t_service_log.tag', $tags)
        ->Where('t_service_log.sample_label', 'LIKE', '%'.$searchValue.'%')
        ->whereIn('t_service_log.status',[1]) //  ->whereIn('t_service_log.status',[0,1,2])
        ->orderBy('enroll_id','desc')
        ->distinct()
        ->groupBy('log_id') //made changes for multiple records displaying in DNA-EXTRACTION        
        ->skip($row)
        ->take($rowperpage)
        ->get();

      } else {        

        //DB::enableQueryLog();
        $data = ServiceLog::select('t_service_log.updated_at as ID','m.enroll_id', 'm.receive_date as receive', 'm.test_reason as reason','is_accepted','s.result','t_service_log.sample_label as samples', 't_service_log.service_id','t_service_log.id as log_id', 't_service_log.status','m.no_of_samples', 't.status as dna_status','t_service_log.tag', DB::raw('date_format(d.test_date,"%d-%m-%y") as decontamination_date'), 't.created_at as extraction_date', 't_service_log.status as STATUS','t_service_log.rec_flag','t_service_log.sample_id')
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        ->leftjoin($table_name.' as t', function ($join) {
              $join->on('t.sample_id','=','t_service_log.sample_id')
                    ->on('t.enroll_id', '=', 't_service_log.enroll_id')
                  ->where('t.status', 1);
          })
        ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
        ->leftjoin('t_decontamination as d', function ($join) {
          $join->on('d.sample_id','=','t_service_log.sample_id')
              ->where('d.status', 1);
          })        
        ->where('t_service_log.service_id',8) 
        ->whereIn('t_service_log.tag', $tags)         
        ->whereIn('t_service_log.status',[1]) //  ->whereIn('t_service_log.status',[0,1,2])
        ->orderBy('enroll_id','desc')
        ->distinct()
        ->groupBy('log_id') //made changes for multiple records displaying in DNA-EXTRACTION
        ->skip($row)
        ->take($rowperpage)
        ->get();
        //dd(DB::getQueryLog());
        //dd($data);
      }      

      //dd($data);

      $response = array('data' => $data);

      return $response;     

    }    

    public function lpa1stand2nd($searchValue, $row, $rowperpage)
    {
      $data = [];

      if( $searchValue != "")
      {

        $data = ServiceLog::select('t_service_log.updated_at as ID','m.enroll_id', 'm.receive_date as receive',
        'm.test_reason as reason','is_accepted','s.result','t_service_log.sample_label as samples',
        't_service_log.service_id','t_service_log.id as log_id', 't_service_log.status','m.no_of_samples',
        't.status as dna_status','t_service_log.tag',DB::raw('date_format(d.test_date,"%d-%m-%y") as decontamination_date'),
        't.created_at as extraction_date','t_service_log.status as STATUS','t_service_log.rec_flag','t_service_log.sample_id')
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        ->leftjoin('t_dnaextraction as t', function ($join) {
        $join->on('t.sample_id','=','t_service_log.sample_id')
            ->where('t.status', 1);
        })
        ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
        ->leftjoin('t_decontamination as d', function ($join) {
        $join->on('d.sample_id','=','t_service_log.sample_id')
            ->where('d.status', 1);
        })
        ->where('t_service_log.service_id',8)
        ->whereIn('t_service_log.tag', array('Both LPA 1st & 2nd Line'))
        ->Where('t_service_log.sample_label', 'LIKE', '%'.$searchValue.'%')
        ->whereIn('t_service_log.status',[1]) //  ->whereIn('t_service_log.status',[0,1,2])
        ->orderBy('enroll_id','desc')
        ->distinct()
        ->groupBy('log_id') //made changes for multiple records displaying in DNA-EXTRACTION
        ->skip($row)
        ->take($rowperpage)
        ->get();

      }
      else {

        $data = ServiceLog::select('t_service_log.updated_at as ID','m.enroll_id', 'm.receive_date as receive',
        'm.test_reason as reason','is_accepted','s.result','t_service_log.sample_label as samples',
        't_service_log.service_id','t_service_log.id as log_id', 't_service_log.status','m.no_of_samples',
        't.status as dna_status','t_service_log.tag',DB::raw('date_format(d.test_date,"%d-%m-%y") as decontamination_date'),
        't.created_at as extraction_date','t_service_log.status as STATUS','t_service_log.rec_flag','t_service_log.sample_id')
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        ->leftjoin('t_dnaextraction as t', function ($join) {
        $join->on('t.sample_id','=','t_service_log.sample_id')
            ->where('t.status', 1);
        })
        ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
        ->leftjoin('t_decontamination as d', function ($join) {
        $join->on('d.sample_id','=','t_service_log.sample_id')
            ->where('d.status', 1);
        })
        ->where('t_service_log.service_id',8)
        ->whereIn('t_service_log.tag', array('Both LPA 1st & 2nd Line'))        
        ->whereIn('t_service_log.status',[1]) //  ->whereIn('t_service_log.status',[0,1,2])
        ->orderBy('enroll_id','desc')
        ->distinct()
        ->groupBy('log_id') //made changes for multiple records displaying in DNA-EXTRACTION
        ->skip($row)
        ->take($rowperpage)
        ->get();

      }      

      $response = array('data' => $data);

      return $response;

    }

    public function lpa1stand2nd_count($searchValue)
    {
      $data = [];

      if( $searchValue != "")
      {

        $data = ServiceLog::select('t_service_log.updated_at as ID','m.enroll_id', 'm.receive_date as receive',
        'm.test_reason as reason','is_accepted','s.result','t_service_log.sample_label as samples',
        't_service_log.service_id','t_service_log.id as log_id', 't_service_log.status','m.no_of_samples',
        't.status as dna_status','t_service_log.tag',DB::raw('date_format(d.test_date,"%d-%m-%y") as decontamination_date'),
        't.created_at as extraction_date','t_service_log.status as STATUS','t_service_log.rec_flag','t_service_log.sample_id')
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        ->leftjoin('t_dnaextraction as t', function ($join) {
        $join->on('t.sample_id','=','t_service_log.sample_id')
            ->where('t.status', 1);
        })
        ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
        ->leftjoin('t_decontamination as d', function ($join) {
        $join->on('d.sample_id','=','t_service_log.sample_id')
            ->where('d.status', 1);
        })
        ->where('t_service_log.service_id',8)
        ->whereIn('t_service_log.tag', array('Both LPA 1st & 2nd Line'))
        ->Where('t_service_log.sample_label', 'LIKE', '%'.$searchValue.'%')
        ->whereIn('t_service_log.status',[1]) //  ->whereIn('t_service_log.status',[0,1,2])
        ->orderBy('enroll_id','desc')
        ->distinct()
        ->groupBy('log_id') //made changes for multiple records displaying in DNA-EXTRACTION        
        ->get();

      }
      else {

        $data = ServiceLog::select('t_service_log.updated_at as ID','m.enroll_id', 'm.receive_date as receive',
        'm.test_reason as reason','is_accepted','s.result','t_service_log.sample_label as samples',
        't_service_log.service_id','t_service_log.id as log_id', 't_service_log.status','m.no_of_samples',
        't.status as dna_status','t_service_log.tag',DB::raw('date_format(d.test_date,"%d-%m-%y") as decontamination_date'),
        't.created_at as extraction_date','t_service_log.status as STATUS','t_service_log.rec_flag','t_service_log.sample_id')
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        ->leftjoin('t_dnaextraction as t', function ($join) {
        $join->on('t.sample_id','=','t_service_log.sample_id')
            ->where('t.status', 1);
        })
        ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
        ->leftjoin('t_decontamination as d', function ($join) {
        $join->on('d.sample_id','=','t_service_log.sample_id')
            ->where('d.status', 1);
        })
        ->where('t_service_log.service_id',8)
        ->whereIn('t_service_log.tag', array('Both LPA 1st & 2nd Line'))        
        ->whereIn('t_service_log.status',[1]) //  ->whereIn('t_service_log.status',[0,1,2])
        ->orderBy('enroll_id','desc')
        ->distinct()
        ->groupBy('log_id') //made changes for multiple records displaying in DNA-EXTRACTION       
        ->get();

      }      

      $response = array('rec_count' => count($data));

      return $response;

    }

    public function ajaxDNAList(Request $request)
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

       } else {

        $result = $this->lpa1stand2nd($searchValue, $row, $rowperpage);
        $data['sample'] = $result['data'];          

       }     

    //dd($req_tag);     

     $result_count_1st = $this->lpaMethod_count($searchValue, '1st line LPA');
     $lpa1stline =  $result_count_1st['rec_count'];
     $count = $lpa1stline;  
     
     $result_count_1st = $this->lpaMethod_count($searchValue, '2nd line LPA');
     $lpa2stline =  $result_count_1st['rec_count'];
     $count = $lpa2stline;

     $result_count_1st_2st = $this->lpa1stand2nd_count($searchValue);
     $lpa1st2stline = $result_count_1st_2st['rec_count'];

     if($req_tag == '1st line LPA')
     {

      $result_count_1st = $this->lpaMethod_count($searchValue, '1st line LPA');
      $count =  $result_count_1st['rec_count'];    
      

     } elseif( $req_tag == '2nd line LPA' ) {

      $result_count_1st = $this->lpaMethod_count($searchValue, '2nd line LPA');
      $count =  $result_count_1st['rec_count'];

     } else {

      $result_count_1st_2st = $this->lpa1stand2nd_count($searchValue);
      $count = $result_count_1st_2st['rec_count'];

     }   


     $dna_extraction_data[] = array();

     $input = "";
     $hide = "";
     $sample_label = "";
     $tag = "";
     $sample_submitted = "";
     $action = "";
     $test_requested = "";
     $deconta_date = "";
     $microscopy_result = "";
     $extraction_date = "";

     foreach ($data['sample'] as $key => $value) {

       $value->no_sample = ServiceLog::where('enroll_id', $value->enroll_id)->where('service_id',11)->count();
 
         //Test Request
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

       if( $value->status != 0)
       {

         $input = '<input class="bulk-selected" type="checkbox" id="smpl_log_id_'.$value->sample_id.'" value="'.$value->sample_id.'" />';          
         $input .= '<input type="hidden" name="samples_'.$value->sample_id.'" id="samples_'.$value->sample_id.'" value="'.$value->samples.'" />';
         $input .= '<input type="hidden" name="sample_log_id_'.$value->sample_id.'" id="sample_log_id_'.$value->sample_id.'" value="'.$value->log_id.'" />';
         $input .= '<input type="hidden" name="sample_enroll_id_'.$value->sample_id.'" id="sample_enroll_id_'.$value->sample_id.'" value="'.$value->enroll_id.'" />';
         $input .= '<input type="hidden" name="sample_tag_'.$value->sample_id.'" id="sample_tag_'.$value->sample_id.'" value="'.$value->tag.'" />';
         $input .= '<input type="hidden" name="sample_no_sample_'.$value->sample_id.'" id="sample_no_sample_'.$value->sample_id.'" value="'.$value->no_sample.'" />';
         $input .= '<input type="hidden" name="sample_id_'.$value->sample_id.'" id="sample_id_'.$value->sample_id.'" value="'.$value->sample_id.'" />';
         $input .= '<input type="hidden" name="sample_service_id_'.$value->sample_id.'" id="sample_service_id_'.$value->sample_id.'" value="'.$value->service_id.'" />';
         $input .= '<input type="hidden" name="sample_status_'.$value->sample_id.'" id="sample_status_'.$value->sample_id.'" value="'.$value->STATUS.'" />';
         $input .= '<input type="hidden" name="sample_rec_flag_'.$value->sample_id.'" id="sample_rec_flag_'.$value->sample_id.'" value="'.$value->rec_flag.'" />';       
         
       } 

         $hide = $value->ID;  
         $sample_label = $value->samples;
         $tag = $value->tag;
         $sample_submitted = $value->no_of_samples;
         $action = "<button onclick=\"openNextForm('".$value->sample_id."')\" type='button' class = 'btn btn-info btn-sm resultbtn'>Submit</button>";
         $test_requested = $data['test_requested['.$value->enroll_id.']'];
         $deconta_date = $value->decontamination_date != "" ? $value->decontamination_date : "";
         $microscopy_result = $value->result;
         $extraction_date = $value->extraction_date != "" ? date('d-m-Y', strtotime($value->extraction_date)) : "Pending";
     
         $dna_extraction_data[] = array(

           "DT_RowId"=> $key,
           "DT_RowClass"=>'sel',
           "ID"=>$hide,
           "inputs" => $input,           
           "sample_label" => $sample_label,                        
           "tag" => $tag,
           "sample_submitted" => $sample_submitted,
           "action" => $action,
           "test_requested" => $test_requested,
           "deconta_date" => $deconta_date,
           "microscopy_result" => $microscopy_result,
           "extraction_date" => $extraction_date

         ); 
     }

     $dna_extraction_data = array_values(array_filter($dna_extraction_data));

     //dd($dna_extraction_data);

     $response = array(
       "draw" => intval($draw),
       "iTotalRecords" => $count,
       "iTotalDisplayRecords" => $count,
       "aaData" => $dna_extraction_data,
       "no_1st_lpa" => $lpa1stline,
       "no_2st_lpa" => $lpa2stline,
       "both_1st_2st" => $lpa1st2stline                    
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


        $log = ServiceLog::find($request->log_id);

        $data = DNAextraction::create([
          'enroll_id' => $log->enroll_id,
          'sample_id' => $log->sample_id,
          'created_by' => $request->user()->id,
          'updated_by' => $request->user()->id,
          'status' => 1
        ]);
        $log->status = 2;
        $log->save();
        return redirect('/DNAextraction');
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
    /*store datqa from dnaextraction popup*/
    public function DNANext(Request $request)
    {
     //dd($request->all());

     $sample_arr = array();
        $sample_arr = $request->logID;
        $data_arr = $request->all();

	 DB::beginTransaction();
     try { 

      foreach($sample_arr as $sampleID)
      {

          $log = ServiceLog::find($data_arr['service_log_id'.$sampleID]);

          /* updated on 11-03-2021 */

          if($request->service_id==4)
          {
              $find_lpa1st_data = FirstLineLpa::select('dna_extraction_date')
                                                ->where('sample_id', $data_arr['sampleID'.$sampleID])
                                                ->where('enroll_id', $data_arr['enroll_id'.$sampleID])
                                                ->where('tag', '1st line LPA')
                                                ->first();
              
              if(empty($find_lpa1st_data))
              {
                $new_1st_lpa = FirstLineLpa::create([
                  'enroll_id'           => $data_arr['enroll_id'.$sampleID],
                  'sample_id'           => $data_arr['sampleID'.$sampleID],
                  'tag'                 => '1st line LPA',
                  'dna_extraction_date' => date('Y-m-d', strtotime($request->date_ext)),
                ]);
              }

          }
          if($request->service_id== 5)
          {
            $find_lpa2st_data = SecondLineLpa::select('dna_extraction_date')
                                                ->where('sample_id', $data_arr['sampleID'.$sampleID])
                                                ->where('enroll_id', $data_arr['enroll_id'.$sampleID])
                                                ->where('tag', '2nd line LPA')
                                                ->first();
              
              if(empty($find_lpa2st_data))
              {
                $new_2st_lpa = SecondLineLpa::create([
                  'enroll_id'           => $data_arr['enroll_id'.$sampleID],
                  'sample_id'           => $data_arr['sampleID'.$sampleID],
                  'tag'                 => '2nd line LPA',
                  'dna_extraction_date' => date('Y-m-d', strtotime($request->date_ext)),
                ]);
              }

          }
          if($request->service_id ==6){


            $find_lpa1st_data = FirstLineLpa::select('dna_extraction_date')
                                                ->where('sample_id', $data_arr['sampleID'.$sampleID])
                                                ->where('enroll_id', $data_arr['enroll_id'.$sampleID])
                                                ->where('tag', '1st line LPA')
                                                ->first();
              
              if(empty($find_lpa1st_data))
              {
                $new_1st_lpa = FirstLineLpa::create([
                  'enroll_id'           => $data_arr['enroll_id'.$sampleID],
                  'sample_id'           => $data_arr['sampleID'.$sampleID],
                  'tag'                 => '1st line LPA',
                  'dna_extraction_date' => date('Y-m-d', strtotime($request->date_ext)),
                ]);
              }

              $find_lpa2st_data = SecondLineLpa::select('dna_extraction_date')
                                                ->where('sample_id', $data_arr['sampleID'.$sampleID])
                                                ->where('enroll_id', $data_arr['enroll_id'.$sampleID])
                                                ->where('tag', '2nd line LPA')
                                                ->first();
              
              if(empty($find_lpa2st_data))
              {
                $new_2st_lpa = SecondLineLpa::create([
                  'enroll_id'           => $data_arr['enroll_id'.$sampleID],
                  'sample_id'           => $data_arr['sampleID'.$sampleID],
                  'tag'                 => '2nd line LPA',
                  'dna_extraction_date' => date('Y-m-d', strtotime($request->date_ext)),
                ]);
              }


        }
          //dd('ddd');
            if($request->service_id == 1){
          $storagelog = ServiceLog::where('enroll_id',$data_arr['enroll_id'.$sampleID])->where('service_id',11)->first();     
              
              if($storagelog){
            $log = ServiceLog::find($data_arr['service_log_id'.$sampleID]);
            $log->status =99;
            $log->updated_by = $request->user()->id;			 
            $log->save();
                
          $new_service = [
              'enroll_id' => $log->enroll_id,
              'sample_id' => $storagelog->sample_id,
              'service_id' => $request->service_id == 1?3:8,
              'status' => 1,
              'tag' => $log->tag,
              'rec_flag' => $log->rec_flag,
              'reported_dt'=>date('Y-m-d'),
              'created_by' => $request->user()->id,
              'updated_by' => $request->user()->id,
              'enroll_label' => $storagelog->enroll_label,
              'sample_label' => $storagelog->sample_label,
            ];

            $nwService = ServiceLog::create($new_service);
            
            //Update storage sample
            $storagelog->updated_by = $request->user()->id;
              $storagelog->status = 0;           
                    $storagelog->save();

              }
              //return redirect('/DNAextraction');
            }elseif($request->service_id == 2){//Extraction with stand by sample
              
              $storagelog = ServiceLog::where('enroll_id',$data_arr['enroll_id'.$sampleID])->where('service_id',11)->first();
              if($storagelog){
            $log = ServiceLog::find($data_arr['service_log_id'.$sampleID]);
            //$log->status = 0;
            $log->status = 99;
            $log->updated_by = $request->user()->id;
            //$data = $log;
            $log->save();
            
                /*$log->service_id = $request->service_id == 2?8:3;
                $log->updated_by = $request->user()->id;
          $log->rec_flag = $request->rec_flag;
                //$data = $log;
                $log->save();*/
          $new_service = [
              'enroll_id' => $log->enroll_id,
              'sample_id' => $storagelog->sample_id,
              'service_id' => $request->service_id == 2?8:3,
              'status' => 1,
              'tag' => $log->tag,
              'rec_flag' => $log->rec_flag,
              'reported_dt'=>date('Y-m-d'),
              'created_by' => $request->user()->id,
              'updated_by' => $request->user()->id,
              'enroll_label' => $storagelog->enroll_label,
              'sample_label' => $storagelog->sample_label,
            ];

            $nwService = ServiceLog::create($new_service);
            
            //Update storage sample
            $storagelog->updated_by = $request->user()->id;
              $storagelog->status = 0;           
                    $storagelog->save();
              }
              //return redirect('/DNAextraction');
            }elseif($request->service_id == 3){
              $old_sample = Sample::select('sample_label')->where('id',$log->sample_id)->first();
              $new_sample = $old_sample->sample_label.'R';
              Sample::where('id',$log->sample_id)->update(['sample_label'=>$new_sample]);
              ServiceLog::where('sample_id',$log->sample_id)->where('status','!=',0)->update(['sample_label'=>$new_sample]);
              $log = ServiceLog::find($data_arr['service_log_id'.$sampleID]);
              $log->status = 1;
          $log->rec_flag = $data_arr['rec_flag'.$sampleID];
              $log->sample_label = $new_sample;
              $log->updated_by = $request->user()->id;
              //$data = $log;
              $log->save();
          
              /*DNAextraction::where('sample_id', $log->sample_id)
              ->where('enroll_id', $request->enroll_id)
              ->where('status',1)
              ->update(['status' => 0]);*/
              //return redirect('/DNAextraction');

              /* Updated on 11-03-2021 */

            }elseif($request->service_id == 4)
            {
              if($data_arr['service_log_id'.$sampleID] > 0){

                $service = ServiceLog::find($data_arr['service_log_id'.$sampleID]);

                ServiceLog::where('id', $data_arr['service_log_id'.$sampleID])                           
                            ->firstorfail()
                            ->delete();

                            $new_service = [
                              'enroll_id' => $data_arr['enroll_id'.$sampleID],
                              'sample_id' => $data_arr['sampleID'.$sampleID],
                              'service_id' => 12,
                              'status' => 1,
                              'tag' => '1st line LPA',
                              'rec_flag' => $data_arr['rec_flag'.$sampleID],
                              'reported_dt'=>date('Y-m-d'),
                              'created_by' => $request->user()->id,
                              'updated_by' => $request->user()->id,
                              'enroll_label' => $service->enroll_label,
                              'sample_label' => $service->sample_label,
                            ];
                
                            $nwService = ServiceLog::create($new_service);
              }

            } elseif($request->service_id == 5)
            {
              if($data_arr['service_log_id'.$sampleID] > 0){
                $service = ServiceLog::find($data_arr['service_log_id'.$sampleID]);
                ServiceLog::where('id', $data_arr['service_log_id'.$sampleID])
                            ->firstorfail()
                            ->delete();

                            $new_service = [
                              'enroll_id' => $data_arr['enroll_id'.$sampleID],
                              'sample_id' => $data_arr['sampleID'.$sampleID],
                              'service_id' => 12,
                              'status' => 1,
                              'tag' => '2nd line LPA',
                              'rec_flag' => $data_arr['rec_flag'.$sampleID],
                              'reported_dt'=>date('Y-m-d'),
                              'created_by' => $request->user()->id,
                              'updated_by' => $request->user()->id,
                              'enroll_label' => $service->enroll_label,
                              'sample_label' => $service->sample_label,
                            ];
                
                            $nwService = ServiceLog::create($new_service);
              }

            } elseif($request->service_id == 6){

              if($data_arr['service_log_id'.$sampleID] > 0){
                $service = ServiceLog::find($data_arr['service_log_id'.$sampleID]);
                //dd($service);
               /*  $service->released_dt=date('Y-m-d');
                $service->comments=$request->comments;
                $service->tested_by=$request->user()->name;
                $service->status = 0;
                $service->updated_by = $request->user()->id;
                $service->save(); */

                /* Updated on 11-03-2021 */

                ServiceLog::where('id', $service->id)                           
                            ->firstorfail()
                            ->delete();

                if($request->service_id == 4 ) {
                  $tag = '1st line LPA';
                }
          if($request->service_id == 5){
                  $tag = '2nd line LPA';
                }
          
          /*else{
                  $tag = '1st line LPA  and for 2nd line LPA';
                }*/
          if($request->service_id == 6){//1st line LPA  and for 2nd line LPA
            for($i=1;$i<=2;$i++){
              if($i==1){
                $tag = '1st line LPA';
              }else{
                $tag = '2nd line LPA';
              }
              $new_service = [
              'enroll_id' => $service->enroll_id,
              'sample_id' => $service->sample_id,
              'service_id' => 12,
              'status' => 1,
              'tag' => $tag,
              'rec_flag' => $data_arr['rec_flag'.$sampleID],
              'reported_dt'=>date('Y-m-d'),
              'created_by' => $request->user()->id,
              'updated_by' => $request->user()->id,
              'enroll_label' => $service->enroll_label,
              'sample_label' => $service->sample_label,
            ];

            $nwService = ServiceLog::create($new_service);
            }
          }else{	
            $new_service = [
              'enroll_id' => $service->enroll_id,
              'sample_id' => $service->sample_id,
              'service_id' => 12,
              'status' => 1,
              'tag' => $tag,
              'rec_flag' => $data_arr['rec_flag'.$sampleID],
              'reported_dt'=>date('Y-m-d'),
              'created_by' => $request->user()->id,
              'updated_by' => $request->user()->id,
              'enroll_label' => $service->enroll_label,
              'sample_label' => $service->sample_label,
            ];

            $nwService = ServiceLog::create($new_service);
          }
                //return $nwService;
                //return redirect('/DNAextraction');
            }
            }
      }

		 DB::commit();
       }catch(\Exception $e){
			DB::rollback();
			return redirect('/DNAextraction')
			->withErrors(['Sorry!! Action already taken of the selected Sample']);
	   }
	  
	   return redirect('/DNAextraction');
	}


    public function dnaextractprint()
    {

        $data = [];
        $data['today'] = date('d-m-Y H:i:s');
        $data['sample'] = ServiceLog::select('t_service_log.updated_at as ID','m.enroll_id', DB::raw('date_format(m.receive_date,"%d-%m-%y") as receive'),'m.test_reason as reason','is_accepted','s.result','t_service_log.sample_label as samples','t_service_log.service_id','t_service_log.id as log_id', 't_service_log.status','m.no_of_samples','t.status as dna_status','t_service_log.tag',DB::raw('date_format(d.test_date,"%d-%m-%y") as decontamination_date'),DB::raw('date_format(t.created_at,"%d-%m-%y") as extraction_date'))
        ->leftjoin('sample as m','m.id','=','t_service_log.sample_id')
        ->leftjoin('t_dnaextraction as t', function ($join) {
              $join->on('t.sample_id','=','t_service_log.sample_id')
                   ->where('t.status', 1);
          })
        ->leftjoin('t_microscopy as s','s.sample_id','=','t_service_log.sample_id')
        ->leftjoin('t_decontamination as d', function ($join) {
              $join->on('d.sample_id','=','t_service_log.sample_id')
                   ->where('d.status', 1);
          })
        ->where('t_service_log.service_id',8)
        ->whereIn('t_service_log.status',[1,2])
        ->orderBy('enroll_id','desc')
        ->distinct()
        ->get();
		

        return view('admin.DNAextraction.print',compact('data'));

    }
}
