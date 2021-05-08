<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Decontamination;
use App\Model\Sample;
use App\Model\Service;
use App\Model\Enroll;
use App\Model\Pcr;
use App\Model\ServiceLog;
use App\Model\FirstLineLpa;
use App\Model\SecondLineLpa;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;

class PCRController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
            $data['today'] = date('Y-m-d H:i:s');
            $data['services'] = Service::select('name')->get();

            //DB::enableQueryLog();
              /* $data['sample'] = ServiceLog::select('t_service_log.updated_at as ID','t_service_log.enroll_id',
                        't_service_log.enroll_label','t_service_log.sample_label as samples','sample.receive_date as receive',
                        'sample.test_reason as reason','sample.sample_type','sample.sample_quality','sample.no_of_samples',
                        'd.test_date','m.result', 'e.dna_extraction_date as created_extraction', 'sn.dna_extraction_date as created_extraction_2nd', 't_service_log.tag',
                        't_service_log.status as STATUS','t_service_log.sample_id','t_service_log.service_id','t_service_log.rec_flag')
                        ->leftjoin('sample as sample','t_service_log.sample_id','=','sample.id')
                        
                        ->leftjoin('t_1stlinelpa as s','t_service_log.sample_id','=','s.sample_id')
                        ->leftjoin('t_2stlinelpa as sn','t_service_log.sample_id','=','sn.sample_id')
                        ->leftjoin('t_decontamination as d',function($join)
                        {

                              $join->on('d.sample_id','=','t_service_log.sample_id')
                                    ->where('d.status',1);
                        })

                        ->leftjoin('t_microscopy as m',function($join)
                        {

                              $join->on('m.sample_id','=','t_service_log.sample_id')
                                    ->where('m.status',1);
                        })                       

                        ->leftjoin('t_1stlinelpa as e',function($join)
                        {
                              $join->on('e.sample_id','=','t_service_log.sample_id')
                                    ->where('e.status',1);
                        })

                        ->leftjoin('t_2stlinelpa as en',function($join)
                        {
                              $join->on('en.sample_id','=','t_service_log.sample_id')
                                    ->where('en.status',1);
                        })

                        ->whereIn('t_service_log.status',[1]) //      ->whereIn('t_service_log.status',[0,1])
                        ->where('t_service_log.service_id',12)
                        ->orderBy('t_service_log.enroll_id','desc')
                        ->distinct('t_service_log.sample_id')
                       ->groupBy('samples') // made changes for multiple records displaying in PCR
                        ->groupBy('t_service_log.STATUS')
						 ->groupBy('t_service_log.tag')
                        ->get();
 */
						//->toSql();
              // dd($data['sample']);
              //dd(DB::getQueryLog());



            // dd($data['sample']);
            return view('admin.PCR.list',compact('data'));
    }

    public function lpaMethod_count($searchValue, $req_tag)
    {
        $data = [];
        $tags = [];       

        if( $req_tag == '1st line LPA' )
        {
            $tags = array('LPA1', 'LPA 1st Line', '1st line LPA'); 
            
            if(  $searchValue != "" )
            {
                        $data = ServiceLog::select('t_service_log.updated_at as ID','t_service_log.enroll_id',
                        't_service_log.enroll_label','t_service_log.sample_label as samples','sample.receive_date as receive',
                        'sample.test_reason as reason','sample.sample_type','sample.sample_quality','sample.no_of_samples',
                        'd.test_date','m.result', 'e.dna_extraction_date as created_extraction', 't_service_log.tag',
                        't_service_log.status as STATUS','t_service_log.sample_id','t_service_log.service_id','t_service_log.rec_flag')
                        ->leftjoin('sample as sample','t_service_log.sample_id','=','sample.id')
                        /* ->leftjoin('t_pcr as s','t_service_log.sample_id','=','s.sample_id') */
                        ->leftjoin('t_1stlinelpa as s','t_service_log.sample_id','=','s.sample_id')
                        /* ->leftjoin('t_2stlinelpa as sn','t_service_log.sample_id','=','sn.sample_id') */
                        ->leftjoin('t_decontamination as d',function($join)
                        {
                              $join->on('d.sample_id','=','t_service_log.sample_id')
                                    ->where('d.status',1);
                        })
                        ->leftjoin('t_microscopy as m',function($join)
                        {

                              $join->on('m.sample_id','=','t_service_log.sample_id')
                                    ->where('m.status',1);
                        })
                        /* ->leftjoin('t_dnaextraction as e',function($join)
                        {
                              $join->on('e.sample_id','=','t_service_log.sample_id')
                                    ->where('e.status',1);
                        }) */

                        ->leftjoin('t_1stlinelpa as e',function($join)
                        {
                              $join->on('e.sample_id','=','t_service_log.sample_id')
                                    ->where('e.status',1);
                        })

                       /*  ->leftjoin('t_2stlinelpa as en',function($join)
                        {
                              $join->on('en.sample_id','=','t_service_log.sample_id')
                                    ->where('en.status',1);
                        }) */

                        ->whereIn('t_service_log.status',[1]) //      ->whereIn('t_service_log.status',[0,1])
                        ->where('t_service_log.service_id',12)
                        ->whereIn('t_service_log.tag', $tags)
                        ->Where('t_service_log.enroll_label', 'LIKE', '%'.$searchValue.'%')
                        ->orWhere('t_service_log.sample_label', 'LIKE', '%'.$searchValue.'%')
                        ->orderBy('t_service_log.enroll_id','desc')
                        ->distinct('t_service_log.sample_id')
                       ->groupBy('samples') // made changes for multiple records displaying in PCR
                        ->groupBy('t_service_log.STATUS')
						 ->groupBy('t_service_log.tag')                        
                        ->get();


            } else {

                        $data = ServiceLog::select('t_service_log.updated_at as ID','t_service_log.enroll_id',
                        't_service_log.enroll_label','t_service_log.sample_label as samples','sample.receive_date as receive',
                        'sample.test_reason as reason','sample.sample_type','sample.sample_quality','sample.no_of_samples',
                        'd.test_date','m.result', 'e.dna_extraction_date as created_extraction', 't_service_log.tag',
                        't_service_log.status as STATUS','t_service_log.sample_id','t_service_log.service_id','t_service_log.rec_flag')
                        ->leftjoin('sample as sample','t_service_log.sample_id','=','sample.id')
                        /* ->leftjoin('t_pcr as s','t_service_log.sample_id','=','s.sample_id') */
                        ->leftjoin('t_1stlinelpa as s','t_service_log.sample_id','=','s.sample_id')
                        /* ->leftjoin('t_2stlinelpa as sn','t_service_log.sample_id','=','sn.sample_id') */
                        ->leftjoin('t_decontamination as d',function($join)
                        {
                              $join->on('d.sample_id','=','t_service_log.sample_id')
                                    ->where('d.status',1);
                        })
                        ->leftjoin('t_microscopy as m',function($join)
                        {

                              $join->on('m.sample_id','=','t_service_log.sample_id')
                                    ->where('m.status',1);
                        })
                        /* ->leftjoin('t_dnaextraction as e',function($join)
                        {
                              $join->on('e.sample_id','=','t_service_log.sample_id')
                                    ->where('e.status',1);
                        }) */

                        ->leftjoin('t_1stlinelpa as e',function($join)
                        {
                              $join->on('e.sample_id','=','t_service_log.sample_id')
                                    ->where('e.status',1);
                        })

                       /*  ->leftjoin('t_2stlinelpa as en',function($join)
                        {
                              $join->on('en.sample_id','=','t_service_log.sample_id')
                                    ->where('en.status',1);
                        }) */

                        ->whereIn('t_service_log.status',[1]) //      ->whereIn('t_service_log.status',[0,1])
                        ->where('t_service_log.service_id',12)
                        ->whereIn('t_service_log.tag', $tags)                        
                        ->orderBy('t_service_log.enroll_id','desc')
                        ->distinct('t_service_log.sample_id')
                       ->groupBy('samples') // made changes for multiple records displaying in PCR
                        ->groupBy('t_service_log.STATUS')
						 ->groupBy('t_service_log.tag')                        
                        ->get();

            }
                        

        } elseif( $req_tag == '2nd line LPA' )
        {
            $tags = array('LPA2', 'LPA 2nd Line', '2nd line LPA');
            $table_name = 't_2stlinelpa';

            if(  $searchValue != "" )
            {
                        $data = ServiceLog::select('t_service_log.updated_at as ID','t_service_log.enroll_id',
                        't_service_log.enroll_label','t_service_log.sample_label as samples','sample.receive_date as receive',
                        'sample.test_reason as reason','sample.sample_type','sample.sample_quality','sample.no_of_samples',
                        'd.test_date','m.result', 'en.dna_extraction_date as created_extraction', 't_service_log.tag',
                        't_service_log.status as STATUS','t_service_log.sample_id','t_service_log.service_id','t_service_log.rec_flag')
                        ->leftjoin('sample as sample','t_service_log.sample_id','=','sample.id')
                        /* ->leftjoin('t_pcr as s','t_service_log.sample_id','=','s.sample_id') */
                        //->leftjoin('t_1stlinelpa as s','t_service_log.sample_id','=','s.sample_id')
                       ->leftjoin('t_2stlinelpa as sn','t_service_log.sample_id','=','sn.sample_id')
                        ->leftjoin('t_decontamination as d',function($join)
                        {
                              $join->on('d.sample_id','=','t_service_log.sample_id')
                                    ->where('d.status',1);
                        })
                        ->leftjoin('t_microscopy as m',function($join)
                        {

                              $join->on('m.sample_id','=','t_service_log.sample_id')
                                    ->where('m.status',1);
                        })
                        /* ->leftjoin('t_dnaextraction as e',function($join)
                        {
                              $join->on('e.sample_id','=','t_service_log.sample_id')
                                    ->where('e.status',1);
                        }) */

                       /*  ->leftjoin('t_1stlinelpa as e',function($join)
                        {
                              $join->on('e.sample_id','=','t_service_log.sample_id')
                                    ->where('e.status',1);
                        }) */

                      ->leftjoin('t_2stlinelpa as en',function($join)
                        {
                              $join->on('en.sample_id','=','t_service_log.sample_id')
                                    ->where('en.status',1);
                        })

                        ->whereIn('t_service_log.status',[1]) //      ->whereIn('t_service_log.status',[0,1])
                        ->where('t_service_log.service_id',12)
                        ->whereIn('t_service_log.tag', $tags)
                        ->Where('t_service_log.enroll_label', 'LIKE', '%'.$searchValue.'%')
                        ->orWhere('t_service_log.sample_label', 'LIKE', '%'.$searchValue.'%')
                        ->orderBy('t_service_log.enroll_id','desc')
                        ->distinct('t_service_log.sample_id')
                       ->groupBy('samples') // made changes for multiple records displaying in PCR
                        ->groupBy('t_service_log.STATUS')
						 ->groupBy('t_service_log.tag')                         
                        ->get();

            } else {

                        $data = ServiceLog::select('t_service_log.updated_at as ID','t_service_log.enroll_id',
                        't_service_log.enroll_label','t_service_log.sample_label as samples','sample.receive_date as receive',
                        'sample.test_reason as reason','sample.sample_type','sample.sample_quality','sample.no_of_samples',
                        'd.test_date','m.result', 'en.dna_extraction_date as created_extraction', 't_service_log.tag',
                        't_service_log.status as STATUS','t_service_log.sample_id','t_service_log.service_id','t_service_log.rec_flag')
                        ->leftjoin('sample as sample','t_service_log.sample_id','=','sample.id')
                        /* ->leftjoin('t_pcr as s','t_service_log.sample_id','=','s.sample_id') */
                        //->leftjoin('t_1stlinelpa as s','t_service_log.sample_id','=','s.sample_id')
                        ->leftjoin('t_2stlinelpa as sn','t_service_log.sample_id','=','sn.sample_id')
                        ->leftjoin('t_decontamination as d',function($join)
                        {
                              $join->on('d.sample_id','=','t_service_log.sample_id')
                                    ->where('d.status',1);
                        })
                        ->leftjoin('t_microscopy as m',function($join)
                        {

                              $join->on('m.sample_id','=','t_service_log.sample_id')
                                    ->where('m.status',1);
                        })
                        /* ->leftjoin('t_dnaextraction as e',function($join)
                        {
                              $join->on('e.sample_id','=','t_service_log.sample_id')
                                    ->where('e.status',1);
                        }) */

                        /* ->leftjoin('t_1stlinelpa as e',function($join)
                        {
                              $join->on('e.sample_id','=','t_service_log.sample_id')
                                    ->where('e.status',1);
                        }) */

                       ->leftjoin('t_2stlinelpa as en',function($join)
                        {
                              $join->on('en.sample_id','=','t_service_log.sample_id')
                                    ->where('en.status',1);
                        })

                        ->whereIn('t_service_log.status',[1]) //      ->whereIn('t_service_log.status',[0,1])
                        ->where('t_service_log.service_id',12)
                        ->whereIn('t_service_log.tag', $tags)                        
                        ->orderBy('t_service_log.enroll_id','desc')
                        ->distinct('t_service_log.sample_id')
                       ->groupBy('samples') // made changes for multiple records displaying in PCR
                        ->groupBy('t_service_log.STATUS')
						 ->groupBy('t_service_log.tag')                         
                        ->get();
            }
        }

        $response = array('rec_count' => count($data));
        return $response;

    }

    public function lpaMethod($searchValue, $row, $rowperpage, $req_tag)
    {
        $data = [];
        $tags = [];       

        if( $req_tag == '1st line LPA' )
        {

            //dd($req_tag);

            $tags = array('LPA1', 'LPA 1st Line', '1st line LPA'); 
            
            if(  $searchValue != "" )
            {
                        $data = ServiceLog::select('t_service_log.updated_at as ID','t_service_log.enroll_id',
                        't_service_log.enroll_label','t_service_log.sample_label as samples','sample.receive_date as receive',
                        'sample.test_reason as reason','sample.sample_type','sample.sample_quality','sample.no_of_samples',
                        'd.test_date','m.result', 'e.dna_extraction_date as created_extraction', 't_service_log.tag',
                        't_service_log.status as STATUS','t_service_log.sample_id','t_service_log.service_id','t_service_log.rec_flag')
                        ->leftjoin('sample as sample','t_service_log.sample_id','=','sample.id')
                        /* ->leftjoin('t_pcr as s','t_service_log.sample_id','=','s.sample_id') */
                        ->leftjoin('t_1stlinelpa as s','t_service_log.sample_id','=','s.sample_id')
                        /* ->leftjoin('t_2stlinelpa as sn','t_service_log.sample_id','=','sn.sample_id') */
                        ->leftjoin('t_decontamination as d',function($join)
                        {
                              $join->on('d.sample_id','=','t_service_log.sample_id')
                                    ->where('d.status',1);
                        })
                        ->leftjoin('t_microscopy as m',function($join)
                        {

                              $join->on('m.sample_id','=','t_service_log.sample_id')
                                    ->where('m.status',1);
                        })
                        /* ->leftjoin('t_dnaextraction as e',function($join)
                        {
                              $join->on('e.sample_id','=','t_service_log.sample_id')
                                    ->where('e.status',1);
                        }) */

                        ->leftjoin('t_1stlinelpa as e',function($join)
                        {
                              $join->on('e.sample_id','=','t_service_log.sample_id')
                                    ->where('e.status',1);
                        })

                       /*  ->leftjoin('t_2stlinelpa as en',function($join)
                        {
                              $join->on('en.sample_id','=','t_service_log.sample_id')
                                    ->where('en.status',1);
                        }) */

                        ->whereIn('t_service_log.status',[1]) //      ->whereIn('t_service_log.status',[0,1])
                        ->where('t_service_log.service_id',12)
                        ->whereIn('t_service_log.tag', $tags)
                        ->Where('t_service_log.enroll_label', 'LIKE', '%'.$searchValue.'%')
                        ->orWhere('t_service_log.sample_label', 'LIKE', '%'.$searchValue.'%')
                        ->orderBy('t_service_log.enroll_id','desc')
                        ->distinct('t_service_log.sample_id')
                       ->groupBy('samples') // made changes for multiple records displaying in PCR
                        ->groupBy('t_service_log.STATUS')
						 ->groupBy('t_service_log.tag')
                         ->skip($row)
                        ->take($rowperpage)
                        ->get();


            } else {

                        $data = ServiceLog::select('t_service_log.updated_at as ID','t_service_log.enroll_id',
                        't_service_log.enroll_label','t_service_log.sample_label as samples','sample.receive_date as receive',
                        'sample.test_reason as reason','sample.sample_type','sample.sample_quality','sample.no_of_samples',
                        'd.test_date','m.result', 'e.dna_extraction_date as created_extraction', 't_service_log.tag',
                        't_service_log.status as STATUS','t_service_log.sample_id','t_service_log.service_id','t_service_log.rec_flag')
                        ->leftjoin('sample as sample','t_service_log.sample_id','=','sample.id')
                        /* ->leftjoin('t_pcr as s','t_service_log.sample_id','=','s.sample_id') */
                        ->leftjoin('t_1stlinelpa as s','t_service_log.sample_id','=','s.sample_id')
                        /* ->leftjoin('t_2stlinelpa as sn','t_service_log.sample_id','=','sn.sample_id') */
                        ->leftjoin('t_decontamination as d',function($join)
                        {
                              $join->on('d.sample_id','=','t_service_log.sample_id')
                                    ->where('d.status',1);
                        })
                        ->leftjoin('t_microscopy as m',function($join)
                        {

                              $join->on('m.sample_id','=','t_service_log.sample_id')
                                    ->where('m.status',1);
                        })
                        /* ->leftjoin('t_dnaextraction as e',function($join)
                        {
                              $join->on('e.sample_id','=','t_service_log.sample_id')
                                    ->where('e.status',1);
                        }) */

                        ->leftjoin('t_1stlinelpa as e',function($join)
                        {
                              $join->on('e.sample_id','=','t_service_log.sample_id')
                                    ->where('e.status',1);
                        })

                       /*  ->leftjoin('t_2stlinelpa as en',function($join)
                        {
                              $join->on('en.sample_id','=','t_service_log.sample_id')
                                    ->where('en.status',1);
                        }) */

                        ->whereIn('t_service_log.status',[1]) //      ->whereIn('t_service_log.status',[0,1])
                        ->where('t_service_log.service_id',12)
                        ->whereIn('t_service_log.tag', $tags)                        
                        ->orderBy('t_service_log.enroll_id','desc')
                        ->distinct('t_service_log.sample_id')
                       ->groupBy('samples') // made changes for multiple records displaying in PCR
                        ->groupBy('t_service_log.STATUS')
						 ->groupBy('t_service_log.tag')
                         ->skip($row)
                        ->take($rowperpage)
                        ->get();

            }

                        

        } elseif( $req_tag == '2nd line LPA' )
        {
            $tags = array('LPA2', 'LPA 2nd Line', '2nd line LPA');
            $table_name = 't_2stlinelpa';

            if(  $searchValue != "" )
            {
                        $data = ServiceLog::select('t_service_log.updated_at as ID','t_service_log.enroll_id',
                        't_service_log.enroll_label','t_service_log.sample_label as samples','sample.receive_date as receive',
                        'sample.test_reason as reason','sample.sample_type','sample.sample_quality','sample.no_of_samples',
                        'd.test_date','m.result', 'en.dna_extraction_date as created_extraction', 't_service_log.tag',
                        't_service_log.status as STATUS','t_service_log.sample_id','t_service_log.service_id','t_service_log.rec_flag')
                        ->leftjoin('sample as sample','t_service_log.sample_id','=','sample.id')
                        /* ->leftjoin('t_pcr as s','t_service_log.sample_id','=','s.sample_id') */
                        //->leftjoin('t_1stlinelpa as s','t_service_log.sample_id','=','s.sample_id')
                       ->leftjoin('t_2stlinelpa as sn','t_service_log.sample_id','=','sn.sample_id')
                        ->leftjoin('t_decontamination as d',function($join)
                        {
                              $join->on('d.sample_id','=','t_service_log.sample_id')
                                    ->where('d.status',1);
                        })
                        ->leftjoin('t_microscopy as m',function($join)
                        {

                              $join->on('m.sample_id','=','t_service_log.sample_id')
                                    ->where('m.status',1);
                        })
                        /* ->leftjoin('t_dnaextraction as e',function($join)
                        {
                              $join->on('e.sample_id','=','t_service_log.sample_id')
                                    ->where('e.status',1);
                        }) */

                       /*  ->leftjoin('t_1stlinelpa as e',function($join)
                        {
                              $join->on('e.sample_id','=','t_service_log.sample_id')
                                    ->where('e.status',1);
                        }) */

                      ->leftjoin('t_2stlinelpa as en',function($join)
                        {
                              $join->on('en.sample_id','=','t_service_log.sample_id')
                                    ->where('en.status',1);
                        })

                        ->whereIn('t_service_log.status',[1]) //      ->whereIn('t_service_log.status',[0,1])
                        ->where('t_service_log.service_id',12)
                        ->whereIn('t_service_log.tag', $tags)
                        ->Where('t_service_log.enroll_label', 'LIKE', '%'.$searchValue.'%')
                        ->orWhere('t_service_log.sample_label', 'LIKE', '%'.$searchValue.'%')
                        ->orderBy('t_service_log.enroll_id','desc')
                        ->distinct('t_service_log.sample_id')
                       ->groupBy('samples') // made changes for multiple records displaying in PCR
                        ->groupBy('t_service_log.STATUS')
						 ->groupBy('t_service_log.tag')
                         ->skip($row)
                        ->take($rowperpage)
                        ->get();

            } else {

                        $data = ServiceLog::select('t_service_log.updated_at as ID','t_service_log.enroll_id',
                        't_service_log.enroll_label','t_service_log.sample_label as samples','sample.receive_date as receive',
                        'sample.test_reason as reason','sample.sample_type','sample.sample_quality','sample.no_of_samples',
                        'd.test_date','m.result', 'en.dna_extraction_date as created_extraction', 't_service_log.tag',
                        't_service_log.status as STATUS','t_service_log.sample_id','t_service_log.service_id','t_service_log.rec_flag')
                        ->leftjoin('sample as sample','t_service_log.sample_id','=','sample.id')
                        /* ->leftjoin('t_pcr as s','t_service_log.sample_id','=','s.sample_id') */
                        //->leftjoin('t_1stlinelpa as s','t_service_log.sample_id','=','s.sample_id')
                        ->leftjoin('t_2stlinelpa as sn','t_service_log.sample_id','=','sn.sample_id')
                        ->leftjoin('t_decontamination as d',function($join)
                        {
                              $join->on('d.sample_id','=','t_service_log.sample_id')
                                    ->where('d.status',1);
                        })
                        ->leftjoin('t_microscopy as m',function($join)
                        {

                              $join->on('m.sample_id','=','t_service_log.sample_id')
                                    ->where('m.status',1);
                        })
                        /* ->leftjoin('t_dnaextraction as e',function($join)
                        {
                              $join->on('e.sample_id','=','t_service_log.sample_id')
                                    ->where('e.status',1);
                        }) */

                        /* ->leftjoin('t_1stlinelpa as e',function($join)
                        {
                              $join->on('e.sample_id','=','t_service_log.sample_id')
                                    ->where('e.status',1);
                        }) */

                       ->leftjoin('t_2stlinelpa as en',function($join)
                        {
                              $join->on('en.sample_id','=','t_service_log.sample_id')
                                    ->where('en.status',1);
                        })

                        ->whereIn('t_service_log.status',[1]) //      ->whereIn('t_service_log.status',[0,1])
                        ->where('t_service_log.service_id',12)
                        ->whereIn('t_service_log.tag', $tags)                        
                        ->orderBy('t_service_log.enroll_id','desc')
                        ->distinct('t_service_log.sample_id')
                       ->groupBy('samples') // made changes for multiple records displaying in PCR
                        ->groupBy('t_service_log.STATUS')
						 ->groupBy('t_service_log.tag')
                         ->skip($row)
                        ->take($rowperpage)
                        ->get();
            }
        }
        
        $response = array('data' => $data);

      return $response;
        

    }

    public function ajaxPCRList(Request $request)
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
        $enroll_label = "";
        $sample_label = "";
        $sample_test_date = "";
        $action = "";
        $sample_result = "";
        $created_extraction = "";
        $sample_tag = "";
        $is_completed = "";
        $PCR_data = [];

        //dd( $data['sample'] );

        foreach($data['sample'] as $key => $samples)
        {
            if($samples->STATUS != 0)
            {
                $input = '<input class="bulk-selected" type="checkbox" id="sample_id_'.$samples->sample_id.'" value="'.$samples->sample_id.'" />';   
                $input .= '<input type="hidden" name="enroll_id_'.$samples->sample_id.'" id="enroll_id_'.$samples->sample_id.'" value="'.$samples->enroll_id.'" />';
                $input .= '<input type="hidden" name="samples_'.$samples->sample_id.'" id="samples_'.$samples->sample_id.'" value="'.$samples->samples.'" />';
                $input .= '<input type="hidden" name="tag_'.$samples->sample_id.'" id="tag_'.$samples->sample_id.'" value="'.$samples->tag.'" />';
                $input .= '<input type="hidden" name="service_id_'.$samples->sample_id.'" id="service_id_'.$samples->sample_id.'" value="'.$samples->service_id.'" />';
                $input .= '<input type="hidden" name="rec_flag_'.$samples->sample_id.'" id="rec_flag_'.$samples->sample_id.'" value="'.$samples->rec_flag.'" />';
            }

            $hide = $samples->ID;
            $enroll_label = $samples->enroll_label;
            $sample_label = $samples->samples;
            $sample_test_date = !empty($samples->test_date) ? date('d-m-Y', strtotime($samples->test_date)) : "";
            $action = $samples->STATUS==0 ? 'DONE' : '<button type="button" onclick="openCbnaatForm('.$samples->sample_id.')" class="btn btn-info btn-sm resultbtn" >Submit</button>';
            $sample_result = $samples->result;
            $created_extraction = date('d-m-Y', strtotime($samples->created_extraction));
            $sample_tag = $samples->tag;
            $is_completed = $samples->completed==1 ? 'Yes' : 'No';

            $PCR_data[] = array(

                "DT_RowId"=> $key,
                "DT_RowClass"=>'sel',
                "ID"=>$hide,
                "inputs" => $input,
                "enroll_label" => $enroll_label,          
                "sample_label" => $sample_label, 
                "sample_test_date" => $sample_test_date,                       
                "tag" => $sample_tag,
                "sample_result" => $sample_result,
                "action" => $action,
                "created_extraction" => $created_extraction,
                "is_completed" => $is_completed,                
     
              ); 
        }

        $PCR_data = array_values(array_filter($PCR_data));

        //dd($dna_extraction_data);
   
        $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $count,
          "iTotalDisplayRecords" => $count,
          "aaData" => $PCR_data,
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

        $sample_arr = array();
        $sample_arr = $request->sampleID;
        $data_arr = $request->all();

		DB::beginTransaction();
        try {
                foreach($sample_arr as $sampleID)
                {
                      //dd($data_arr);
                    $en_label = Enroll::select('label')->where('id', $data_arr['enrollId'.$sampleID])->first();
                    $s_id = Sample::select('id')->where('sample_label','like', $data_arr['sample_ids'.$sampleID].'%')->first();
                //dd($s_id);
                    $enroll_label=$en_label->label;
                    $sample_id=$s_id->id;

                    //dd($sample_id);

                    //Pcr::where('enroll_id', $request->enrollId)->where('sample_id', $sample_id)->delete();
                    /* Pcr::where('enroll_id', $data_arr['enrollId'.$sampleID])->where('tag',$data_arr['tag'.$sampleID])->delete(); */

                    if($request->completed == 1)
                    {

                        /* Updated on 11-03-2021 */

                        if( $data_arr['tag'.$sampleID] == '1st line LPA')
                        {   
                            $find_lpa1st_data = FirstLineLpa::where('sample_id', $sample_id)
                                                ->where('enroll_id', $data_arr['enrollId'.$sampleID])
                                                ->where('tag', '1st line LPA')
                                                ->count();


                            //dd($find_lpa1st_data);
              
                            if($find_lpa1st_data >= 1)
                            {
                                
                                $updated = FirstLineLpa::where('sample_id', $sample_id)
                                ->where('enroll_id', $data_arr['enrollId'.$sampleID])
                                ->where('tag', '1st line LPA')
                                ->update(['pcr_test_date' => date('Y-m-d')]);   
                                
                                //dd($updated);

                            } else {

                              //dd($data_arr['sampleID'.$sampleID]);

                                $new_1st_lpa = FirstLineLpa::create([
                                    'enroll_id'             => $data_arr['enrollId'.$sampleID],
                                    'sample_id'             => $sample_id,
                                    'created_by'            => Auth::user()->id,
                                    'updated_by'            => Auth::user()->id,
                                    'tag'                   => '1st line LPA',
                                    'pcr_test_date'         => date('Y-m-d'),
                                    ]);



                            } 

                            ServiceLog::where('sample_id', $sample_id)
                                        ->where('enroll_id', $data_arr['enrollId'.$sampleID]) 
                                        ->where('service_id', '12')          
                                        ->where('tag', '1st line LPA')
                                        ->delete();
                        }

                        if( $data_arr['tag'.$sampleID] == '2nd line LPA')
                        {   
                            $find_lpa2st_data = SecondLineLpa::where('sample_id', $sample_id)
                                                ->where('enroll_id', $data_arr['enrollId'.$sampleID])
                                                ->where('tag', '2nd line LPA')
                                                ->count();


                            //dd($find_lpa1st_data);
              
                            if($find_lpa2st_data >= 1)
                            {
                                
                                SecondLineLpa::where('sample_id', $sample_id)
                                ->where('enroll_id', $data_arr['enrollId'.$sampleID])
                                ->where('tag', '2nd line LPA')
                                ->update(['pcr_test_date' => date('Y-m-d')]);                                

                            } else {

                                $new_1st_lpa = SecondLineLpa::create([
                                    'enroll_id'           => $data_arr['enrollId'.$sampleID],
                                    'sample_id'           => $sample_id,
                                    'tag'                 => '2nd line LPA',
                                    'pcr_test_date' => date('Y-m-d'),
                                    ]);

                            } 

                            ServiceLog::where('sample_id', $sample_id)
                                        ->where('enroll_id', $data_arr['enrollId'.$sampleID]) 
                                        ->where('service_id', '12')          
                                        ->where('tag', '2nd line LPA')
                                        ->delete();
                        }                       


                    /* $pcr = Pcr::create([
                        'enroll_id' => $data_arr['enrollId'.$sampleID],
                        'sample_id' => $sample_id,
                        'completed' => $request->completed,
                        'status' => 1,
                        'tag' => $data_arr['tag'.$sampleID],
                        'test_date' => date('Y-m-d H:i:s'),
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id
                    ]); */

                    
                        ServiceLog::create([
                                'enroll_id' => $data_arr['enrollId'.$sampleID],
                                'sample_id' => $sample_id,
                                'enroll_label' => $enroll_label,
                                'sample_label' => $data_arr['sample_ids'.$sampleID],
                                'service_id' => 14,
                                'status' => 1,
                                'reported_dt'=>date('Y-m-d'),
                                'tag' => $data_arr['tag'.$sampleID],
                                'rec_flag' => $data_arr['rec_flag'.$sampleID],
                                'test_date' => date('Y-m-d H:i:s'),
                                'created_by' => Auth::user()->id,
                                'updated_by' => Auth::user()->id
                            ]);

                        


                        /* ServiceLog::where('enroll_id', $data_arr['enrollId'.$sampleID])
                        ->where('sample_id', $sample_id)
                        ->where('service_id',12)
                        ->where('tag',$data_arr['tag'.$sampleID])
                        ->update(['status' => 0 ,'released_dt'=>date('Y-m-d'),'tested_by'=>Auth::user()->name,'comments'=>$request->comments,'created_by' => Auth::user()->id,'updated_by' => Auth::user()->id]); */

                    }else{
                    $old_sample = Sample::select('sample_label')->where('id',$sample_id)->first();
                    $new_sample = $old_sample->sample_label.'R';
                    Sample::where('id',$sample_id)->update(['sample_label'=>$new_sample]);
                    ServiceLog::where('sample_id',$sample_id)->where('status','!=',0)->update(['sample_label'=>$new_sample,'rec_flag' => $data_arr['rec_flag'.$sampleID]]);
                    }
                }

       //  $data = Cbnaat::create($request->all());
     // return $data;
       }catch(\Exception $e){
            $error = $e->getMessage();
            //dd($error);
			DB::rollback();
			return redirect('/PCR')
			->withErrors(['Sorry!! Action already taken of the selected Sample']);
		}
		DB::commit();

        return redirect('/PCR');
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
    public function PCRprint()
    {
         $data = [];
            $data['today'] = date('Y-m-d H:i:s');
            $data['services'] = Service::select('name')->get();


              $data['sample'] = ServiceLog::select('t_service_log.updated_at as ID','t_service_log.enroll_id',
                        't_service_log.enroll_label','t_service_log.sample_label as samples','sample.receive_date as receive',
                        'sample.test_reason as reason','sample.sample_type','sample.sample_quality','sample.no_of_samples',
                        'd.test_date','m.result','s.completed','e.created_at as created_extraction','t_service_log.tag',
                        't_service_log.status as STATUS')
                        ->join('sample as sample','t_service_log.sample_id','=','sample.id')
                        ->leftjoin('t_pcr as s','t_service_log.sample_id','=','s.sample_id')
                        ->leftjoin('t_decontamination as d',function($join)
                        {

                              $join->on('d.sample_id','=','t_service_log.sample_id')
                                    ->where('d.status',1);
                        })
                        ->leftjoin('t_microscopy as m',function($join)
                        {

                              $join->on('m.sample_id','=','t_service_log.sample_id')
                                    ->where('m.status',1);
                        })
                        ->leftjoin('t_dnaextraction as e',function($join)
                        {

                              $join->on('e.sample_id','=','t_service_log.sample_id')
                                    ->where('e.status',1);
                        })
                        ->whereIn('t_service_log.status',[0,1])
                        ->where('t_service_log.service_id',12)
                        ->orderBy('t_service_log.enroll_id','desc')
                        ->get();
            return view('admin.PCR.print',compact('data'));
    }
}
