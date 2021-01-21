<?php

namespace App\Http\Controllers\Web\Admin;

use App\Model\RequestServices;
use Excel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Dashboard;
use App\User;
use App\Model\Service;
use App\Model\Sample;
use App\Model\ServiceLog;
use App\Model\LCDST;
use App\Model\LjDstReading;
use App\Model\TestRequest;
use App\Model\Equipment;
use DateTime;
use Illuminate\Support\Facades\DB;
use App\Model\ResultEdit;
use App\Model\Cbnaat_lab_details;
use App\Model\Cbnaat;
use Illuminate\Support\Facades\Event;
use PDF;
use App\Model\Config;
use Carbon\Carbon;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	 // Change done by Vidhi
    public function index()
    {

        $data = Service::select('id', 'workloadReportName')->whereIn('id', [1, 2, 4, 17, 20, 21, 22, 4, 15])->get();

        //dd($data);
        $diagnosis_sum = 0;
        $follow_up_sum = 0;
        foreach ($data as $key => $value) {

            if ($value->id == 15) {


                $lpa1 = ServiceLog::leftjoin('sample as s', 't_service_log.sample_id', '=', 's.id')
                    ->where('t_service_log.service_id', 15)->where('s.test_reason', 'DX')->where('t_service_log.tag', '1st line LPA')->count();
                $lpa1fu = ServiceLog::leftjoin('sample as s', 't_service_log.sample_id', '=', 's.id')
                    ->where('t_service_log.service_id', 15)->where('s.test_reason', 'FU')->where('t_service_log.tag', '1st line LPA')->count();

                $lpa2 = ServiceLog::leftjoin('sample as s', 't_service_log.sample_id', '=', 's.id')
                    ->where('t_service_log.service_id', 15)->where('s.test_reason', 'DX')->where('t_service_log.tag', '2nd line LPA')->count();
                $lpa2fu = ServiceLog::leftjoin('sample as s', 't_service_log.sample_id', '=', 's.id')
                    ->where('t_service_log.service_id', 15)->where('s.test_reason', 'FU')->where('t_service_log.tag', '2nd line LPA')->count();
            }
            
            $value->diagnosis = ServiceLog::leftjoin('sample as s', 't_service_log.sample_id', '=', 's.id')
                ->where('t_service_log.service_id', $value->id)
                ->where('s.test_reason', 'DX')
                ->count();


            $value->follow_up = ServiceLog::leftjoin('sample as s', 't_service_log.sample_id', '=', 's.id')
                ->where('t_service_log.service_id', $value->id)
                ->where('s.test_reason', 'FU')
                ->count();


            $diagnosis_sum += $value->diagnosis;
            $follow_up_sum += $value->follow_up;
        }
        // dd($diagnosis_sum);

        $data->diagnosis_sum = $diagnosis_sum;
        $data->follow_up_sum = $follow_up_sum;
        $data->lpa1 = $lpa1;
        $data->lpa2 = $lpa2;
        $data->lpa1fu = $lpa1fu;
        $data->lpa2fu = $lpa2fu;
        $to_date = '';
        $from_date = '';
// dd($data);
//dd($data);
        return view('admin.report.dashboard', compact('data', 'to_date', 'from_date'));
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
// dd($request->all());
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $data = Service::select('id', 'workloadReportName')->whereIn('id', [1, 2, 4, 17, 20, 21, 22, 4, 15])->get();
        $diagnosis_sum = 0;
        $follow_up_sum = 0;
        foreach ($data as $key => $value) {


            if ($value->id == 15) {


                $lpa1 = DB::select(DB::raw("select count(*) as count from `t_service_log`
              left join `sample` as `s` on `t_service_log`.`sample_id` = `s`.`id`
              where `t_service_log`.`service_id` = 15 and `t_service_log`.`tag`='1st line LPA'
              and `s`.`test_reason` = 'DX'
              and (date(`t_service_log`.`created_at`) between '$from_date' and '$to_date')"));

                $lpa1 = $lpa1[0]->count;


                $lpa1fu = DB::select(DB::raw("select count(*) as count from `t_service_log`
              left join `sample` as `s` on `t_service_log`.`sample_id` = `s`.`id`
              where `t_service_log`.`service_id` = 15 and `t_service_log`.`tag`='1st line LPA'
              and `s`.`test_reason` = 'FU'
              and (date(`t_service_log`.`created_at`) between '$from_date' and '$to_date')"));
                $lpa1fu = $lpa1fu[0]->count;

                $lpa2 = DB::select(DB::raw("select count(*) as count from `t_service_log`
              left join `sample` as `s` on `t_service_log`.`sample_id` = `s`.`id`
              where `t_service_log`.`service_id` = 15 and `t_service_log`.`tag`='2nd line LPA'
              and `s`.`test_reason` = 'DX'
              and (date(`t_service_log`.`created_at`) between '$from_date' and '$to_date')"));
                $lpa2 = $lpa2[0]->count;

                $lpa2fu = DB::select(DB::raw("select count(*) as count from `t_service_log`
              left join `sample` as `s` on `t_service_log`.`sample_id` = `s`.`id`
              where `t_service_log`.`service_id` = 15 and `t_service_log`.`tag`='2nd line LPA'
              and `s`.`test_reason` = 'FU'
              and (date(`t_service_log`.`created_at`) between '$from_date' and '$to_date')"));
                $lpa2fu = $lpa2fu[0]->count;
            }


// echo "select count(*) as count from `t_service_log`
// left join `sample` as `s` on `t_service_log`.`sample_id` = `s`.`id`
// where `t_service_log`.`service_id` = $value->id
// and `t_service_log`.`status` = 1
// and `s`.`test_reason` = 'DX'
// and (date(`t_service_log`.`created_at`) between '$from_date' and '$to_date')"; die;


            $value->diagnosis = DB::select(DB::raw("select count(*) as count from `t_service_log`
          left join `sample` as `s` on `t_service_log`.`sample_id` = `s`.`id`
          where `t_service_log`.`service_id` = $value->id
          and `s`.`test_reason` = 'DX'
          and (date(`t_service_log`.`created_at`) between '$from_date' and '$to_date')"));

            $value->diagnosis = $value->diagnosis[0]->count;


            $value->follow_up = DB::select(DB::raw("select count(*) as count from `t_service_log`
          left join `sample` as `s` on `t_service_log`.`sample_id` = `s`.`id`
          where `t_service_log`.`service_id` = $value->id
          and `s`.`test_reason` = 'FU'
          and (date(`t_service_log`.`created_at`) between '$from_date' and '$to_date')"));
            $value->follow_up = $value->follow_up[0]->count;

            $diagnosis_sum += $value->diagnosis;
            $follow_up_sum += $value->follow_up;
        }

        $data->diagnosis_sum = $diagnosis_sum;
        $data->follow_up_sum = $follow_up_sum;
        $data->lpa1 = $lpa1;
        $data->lpa2 = $lpa2;
        $data->lpa1fu = $lpa1fu;
        $data->lpa2fu = $lpa2fu;


        $to_date = $request->to_date;
        $from_date = $request->from_date;
        //dd($data);
        return view('admin.report.dashboard', compact('data', 'to_date', 'from_date'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    // Change by Vidhi
    public function lqc_indicator(Request $request)
    {
        $from_date=!empty($request->from_date)?date('Y-m-d', strtotime($request->from_date)):date("Y-m-d");
        $to_date=!empty($request->to_date)?date('Y-m-d', strtotime($request->to_date)):date("Y-m-d");
        $data['lq_indicator'] = DB::select('call lab_qc_indicator_report (?,?)',array($from_date,$to_date));
        $data['to_date'] = $request->to_date;
        $data['from_date'] = $request->from_date;
        return view('admin.report.lqc_indicator', compact('data'));
    }
	//Change by amrita
	public function lqc_indicator_tat(Request $request)
    {
    $data['to_date'] = $request->to_date;
        $data['from_date'] = $request->from_date;
        if ($request->has('from_date') && $request->has('to_date')) {
			$from_date=date("Y-m-d",strtotime($request->from_date));
			$to_date=date("Y-m-d",strtotime($request->to_date));
			//echo $from_date."--".$to_date; die;
			$data['qc_indicator_tat_data']= DB::select('call usp_qc_indicator_tat_lab(?, ?)',array($from_date,$to_date));
			$data['to_date'] = $request->to_date;
            $data['from_date'] = $request->from_date;
        } else {			
			$todaydate=Carbon::today()->format("Y-m-d");// will get you the current date
		    $fromdate=Carbon::today()->subDays(5)->format("Y-m-d");//30 days before today			
            $data['qc_indicator_tat_data']= DB::select('call usp_qc_indicator_tat_lab(?, ?)',array($fromdate, $todaydate));
            $data['to_date'] = Carbon::today()->format("d-m-Y");
            $data['from_date'] = Carbon::today()->subDays(5)->format("d-m-Y");
        }	
		return view('admin.report.lqc_indicator_tat', compact('data'));
    }
  // Change by Vidhi
/*  public function lqc_indicator_tat(Request $request)
  {
      $data['lpa1_in_tat'] = 0;
      $data['lpa2_in_tat'] = 0;
      $data['lpa1_in_tat_dna'] = 0;
      $data['lpa2_in_tat_dna'] = 0;
      $data['lc_in_tat'] = 0;
      $data['lj_in_tat'] = 0;
      $data['lc_dst_in_tat'] = 0;
      $data['lc_dstz_in_tat'] = 0;
      $data['lj_dst_in_tat'] = 0;
    //   $data['lj1_in_tat'] = 0;
    //   $data['lj1_out_tat'] = 0;
    //   $data['lj2_in_tat'] = 0;
    //   $data['lj2_out_tat'] = 0;
      $data['cbnaat_in_tat'] = 0;
      $data['cbnaat_out_tat'] = 0;
      $data['p_culture_in_tat'] = 0;
    //   $data['p_culture_out_tat'] = 0;
      $data['p_lj_in_tat'] = 0;
      $data['p_lj_out_tat'] = 0;

      $from_date = date('Y-m-d', strtotime($request->from_date));
      $to_date = date('Y-m-d', strtotime($request->to_date));

      if ($request->has('from_date') && $request->has('to_date')) {
          $con = "DATE(t_service_log.created_at) BETWEEN '" . date('Y-m-d', strtotime($request->from_date)) . "' and '" . date('Y-m-d', strtotime($request->to_date)) . "'";
      } else {
          $con = "t_service_log.id != ''";
      }

      $data['lpa1'] = ServiceLog::select('s.receive_date as date_receive', 't_service_log.sent_to_nikshay_date as result_submitted')
          ->where('t_service_log.service_id', 15)
          ->where('t_service_log.tag', '1st line LPA')
          ->where('t_service_log.sent_to_nikshay',1)
          ->leftjoin('sample as s', 't_service_log.sample_id', '=', 's.id')
          ->whereRaw(DB::raw($con))
          ->get();

          foreach ($data['lpa1'] as $key => $value) {
          $day = new DateTime(date($value->result_submitted));
          $dayAfter5 = (new DateTime($value->date_receive))->format('Y-m-d h:i:s');
          $dayA5 = new DateTime(date($dayAfter5));
          $interval = $dayA5->diff($day);
          $days = $interval->format('%a');
         
          if ($interval->d <= 5) {
              $data['lpa1_in_tat'] += 1;
          } 
      }

      $data['lpa1_total'] = DB::select(DB::raw("select COUNT(lc.sample_id) AS count FROM t_1stlinelpa lc, t_service_log sl where lc.sample_id = sl.sample_id and sl.service_id = 15 and date(sl.created_at) between '$from_date' and '$to_date'"));
      $data['lpa1_total'] = $data['lpa1_total'][0]->count;


      $data['lpa1_dna'] = ServiceLog::select('dna.created_at as date_receive', 't_service_log.sent_to_nikshay_date as result_submitted')
          ->where('t_service_log.service_id', 15)
          ->where('t_service_log.tag', '1st line LPA')
          ->where('t_service_log.sent_to_nikshay',1)
          ->leftjoin('t_dnaextraction as dna', 't_service_log.sample_id', '=', 'dna.sample_id')
          ->whereRaw(DB::raw($con))
          ->get();

      foreach ($data['lpa1_dna'] as $key => $value) {
          $day = new DateTime(date($value->result_submitted));
          $dayAfter5 = (new DateTime($value->date_receive))->format('Y-m-d h:i:s');
          $dayA5 = new DateTime(date($dayAfter5));
          $interval = $dayA5->diff($day);
          $days = $interval->format('%a');
          
          if ($interval->d <= 5) {
              $data['lpa1_in_tat_dna'] += 1;
          } 
      }


      $data['lpa2'] = ServiceLog::select('s.receive_date as date_receive', 't_service_log.sent_to_nikshay_date as result_submitted')
      ->where('t_service_log.service_id', 15)
      ->where('t_service_log.tag', '2nd line LPA')
      ->where('t_service_log.sent_to_nikshay',1)
      ->leftjoin('sample as s', 't_service_log.sample_id', '=', 's.id')
      ->whereRaw(DB::raw($con))
      ->get();

      foreach ($data['lpa2'] as $key => $value) {
          $day = new DateTime(date($value->result_submitted));
          $dayAfter5 = (new DateTime($value->date_receive))->format('Y-m-d h:i:s');
          $dayA5 = new DateTime(date($dayAfter5));
          $interval = $dayA5->diff($day);
          $days = $interval->format('%a');
          
          if ($interval->d <= 5) {
              $data['lpa2_in_tat'] += 1;
          }
      }

      $data['lpa2_total'] = DB::select(DB::raw("select COUNT(lc.sample_id) AS count FROM t_2stlinelpa lc, t_service_log sl where lc.sample_id = sl.sample_id and sl.service_id = 15 and date(sl.created_at) between '$from_date' and '$to_date'"));
      $data['lpa2_total'] = $data['lpa2_total'][0]->count;


      $data['lpa2_dna'] = ServiceLog::select('dna.created_at as date_receive', 't_service_log.sent_to_nikshay_date as result_submitted')
      ->where('t_service_log.service_id', 15)
      ->where('t_service_log.tag', '2nd line LPA')
      ->where('t_service_log.sent_to_nikshay',1)
      ->leftjoin('t_dnaextraction as dna', 't_service_log.sample_id', '=', 'dna.sample_id')
      ->whereRaw(DB::raw($con))
      ->get();

  foreach ($data['lpa2_dna'] as $key => $value) {
      $day = new DateTime(date($value->result_submitted));
      $dayAfter5 = (new DateTime($value->date_receive))->format('Y-m-d h:i:s');
      $dayA5 = new DateTime(date($dayAfter5));
      $interval = $dayA5->diff($day);
      $days = $interval->format('%a');
      
      if ($interval->d <= 5) {
          $data['lpa2_in_tat_dna'] += 1;
      } 
  }

  
  $data['lc'] = ServiceLog::select('cul.created_at as date_receive', 't_service_log.sent_to_nikshay_date as result_submitted')
  ->where('t_service_log.service_id', 17)
  ->where('t_service_log.sent_to_nikshay',1)
  ->leftjoin('t_lc_flagged_mgit as mg', 't_service_log.sample_id', '=', 'mg.sample_id')
  ->leftjoin('t_culture_inoculation as cul', 'mg.sample_id', '=', 'cul.sample_id')
  ->whereRaw(DB::raw($con))
  ->get();

  foreach ($data['lc'] as $key => $value) {
      $day = new DateTime(date($value->result_submitted));
      $dayAfter42 = (new DateTime($value->date_receive))->format('Y-m-d h:i:s');
      $dayA42 = new DateTime(date($dayAfter42));
      $interval = $dayA42->diff($day);
      $days = $interval->format('%a');
      if ($interval->d <= 42) {
          $data['lc_in_tat'] += 1;
      }
  }

  $data['lc_total'] = DB::select(DB::raw("select COUNT(lc.sample_id) AS count FROM t_lc_flagged_mgit lc, t_service_log sl where lc.sample_id = sl.sample_id and sl.service_id = 17 and date(sl.created_at) between '$from_date' and '$to_date'" ));
  $data['lc_total'] = $data['lc_total'][0]->count;


  $data['lj'] = ServiceLog::select('cul.created_at as date_receive', 't_service_log.sent_to_nikshay_date as result_submitted')
  ->where('t_service_log.service_id', 20)
  ->where('t_service_log.sent_to_nikshay',1)
  ->leftjoin('t_culture_inoculation as cul', 't_service_log.sample_id', '=', 'cul.sample_id')
  ->whereRaw(DB::raw($con))
  ->get();

  foreach ($data['lj'] as $key => $value) {
      $day = new DateTime(date($value->result_submitted));
      $dayAfter56 = (new DateTime($value->date_receive))->format('Y-m-d h:i:s');
      $dayA56 = new DateTime(date($dayAfter56));
      $interval = $dayA56->diff($day);
      $days = $interval->format('%a');
      if ($interval->d <= 56) {
          $data['lj_in_tat'] += 1;
      }
  }

  $data['lj_total'] = DB::select(DB::raw("select COUNT(lc.sample_id) AS count FROM t_lj_detail lc, t_service_log sl where lc.sample_id = sl.sample_id and sl.service_id = 20 and date(sl.created_at) between '$from_date' and '$to_date'"));
  $data['lj_total'] = $data['lj_total'][0]->count;



  $data['lc_dst'] = ServiceLog::select(DB::raw('cul.created_at as date_receive'),DB::raw('t_service_log.sent_to_nikshay_date as result_submitted'),DB::raw('COUNT(DISTINCT lc.sample_id) AS countDST'))
  ->where('t_service_log.service_id', 21)
  ->where('t_service_log.sent_to_nikshay',1)
  ->leftjoin('t_lc_dst_inoculation as cul', 't_service_log.sample_id', '=', 'cul.sample_id')
  ->leftjoin('t_lc_dst as lc', 'cul.sample_id', '=', 'lc.sample_id')
  ->whereRaw(DB::raw('lc.sample_id != (SELECT sample_id from t_lc_dst where drug_name="Z")'))
  ->whereRaw(DB::raw($con))
  ->get();

  foreach ($data['lc_dst'] as $key => $value) {
      if(!empty($value->date_receive && $value->result_submitted)){
      $day = new DateTime(date($value->date_receive));
      $dayAfter14 = (new DateTime($value->result_submitted))->format('Y-m-d h:i:s');
      $dayA14 = new DateTime(date($dayAfter14));
      $interval = $dayA14->diff($day);
      $days = $interval->format('%a');
      if ($interval->d <= 14) {
          $data['lc_dst_in_tat'] += 1;
      }
      }
  }



  $data['lc_dstz'] = ServiceLog::select(DB::raw('cul.created_at as date_receive'),DB::raw('t_service_log.sent_to_nikshay_date as result_submitted'),DB::raw('COUNT(DISTINCT lc.sample_id) AS countDST'))
  ->where('t_service_log.service_id', 21)
  ->where('t_service_log.sent_to_nikshay',1)
  ->leftjoin('t_lc_dst_inoculation as cul', 't_service_log.sample_id', '=', 'cul.sample_id')
  ->leftjoin('t_lc_dst as lc', 'cul.sample_id', '=', 'lc.sample_id')
  ->whereRaw(DB::raw('lc.sample_id = (SELECT sample_id from t_lc_dst where drug_name="Z")'))
  ->whereRaw(DB::raw($con))
  ->get();

  foreach ($data['lc_dstz'] as $key => $value) {
      if(!empty($value->date_receive && $value->result_submitted)){
      $day = new DateTime(date($value->date_receive));
      $dayAfter23 = (new DateTime($value->result_submitted))->format('Y-m-d h:i:s');
      $dayA23 = new DateTime(date($dayAfter23));
      $interval = $dayA23->diff($day);
      $days = $interval->format('%a');
      if ($interval->d <= 23) {
          $data['lc_dstz_in_tat'] += 1;
      }
      }
  }

  $data['lc_dst_total'] = DB::select(DB::raw("select COUNT(lc.sample_id) AS count FROM t_lc_dst_inoculation lc, t_service_log sl where lc.sample_id = sl.sample_id and sl.service_id = 21 and sl.sent_to_nikshay = 1 and date(sl.created_at) between '$from_date' and '$to_date'"));
  $data['lc_dst_total'] = $data['lc_dst_total'][0]->count;



  $data['lj_dst'] = ServiceLog::select('cul.created_at as date_receive','t_service_log.sent_to_nikshay_date as result_submitted')
  ->where('t_service_log.service_id', 22)
  ->where('t_service_log.sent_to_nikshay',1)
  ->leftjoin('t_lj_dst_inoculation as cul', 't_service_log.sample_id', '=', 'cul.sample_id')
  ->whereRaw(DB::raw($con))
  ->get();

  foreach ($data['lj_dst'] as $key => $value) {
      $day = new DateTime(date($value->date_receive));
      $dayAfter42 = (new DateTime($value->result_submitted))->format('Y-m-d h:i:s');
      $dayA42 = new DateTime(date($dayAfter42));
      $interval = $dayA42->diff($day);
      $days = $interval->format('%a');
      if ($interval->d <= 42) {
          $data['lj_dst_in_tat'] += 1;
      }
  }

  $data['lj_dst_total'] = DB::select(DB::raw("select COUNT(lc.sample_id) AS count FROM t_lj_dst_inoculation lc, t_service_log sl where lc.sample_id = sl.sample_id and sl.service_id = 22 and sl.sent_to_nikshay = 1 and date(sl.created_at) between '$from_date' and '$to_date'"));
  $data['lj_dst_total'] = $data['lj_dst_total'][0]->count;


      $data['cbnaat'] = ServiceLog::select('s.receive_date as date_receive', 't_service_log.sent_to_nikshay_date as result_submitted')
          ->where('t_service_log.service_id', 4)
          ->where('t_service_log.sent_to_nikshay',1)
          ->leftjoin('sample as s', 't_service_log.sample_id', '=', 's.id')
          ->whereRaw(DB::raw($con))
          ->get();


      foreach ($data['cbnaat'] as $key => $value) {
          $day = new DateTime(date($value->date_receive));
          $dayAfter1 = (new DateTime($value->result_submitted))->format('Y-m-d h:i:s');
          $dayA1 = new DateTime(date($dayAfter1));
          $interval = $dayA1->diff($day);
          $days = $interval->format('%a');
          if ($interval->d <= 1) {
              $data['cbnaat_in_tat'] += 1;
          } else {
              $data['cbnaat_out_tat'] += 1;
          }
      }

      $data['cbnaat_total'] = $data['cbnaat_in_tat'] + $data['cbnaat_out_tat'];

     
      $data['p_lc'] = ServiceLog::select('t_service_log.sent_to_nikshay_date as result_submitted', 't_service_log.released_dt as print_15')
      ->where('t_service_log.service_id', 17)
      ->where('t_service_log.sent_to_nikshay',1)
      ->whereRaw(DB::raw($con))
      ->get();
    
      $data['p_lc_in_tat'] = 0;
      foreach ($data['p_lc'] as $key => $value) {
          $day = new DateTime(date($value->result_submitted));
          $dayAfter1 = new DateTime(date($value->print_15));
          $interval = $dayAfter1->diff($day);
          $days = $interval->format('%a');
          if ($interval->d <= 1) {
              $data['p_lc_in_tat'] += 1;
          }
      }
    
    
      $data['p_lj'] = ServiceLog::select('t_service_log.sent_to_nikshay_date as result_submitted', 't_service_log.released_dt as print_15')
      ->where('t_service_log.service_id', 20)
      ->where('t_service_log.sent_to_nikshay',1)
      ->whereRaw(DB::raw($con))
      ->get();
    
      $data['p_lj_in_tat'] = 0;
      foreach ($data['p_lj'] as $key => $value) {
        $day = new DateTime(date($value->result_submitted));
        $dayAfter1 = new DateTime(date($value->print_15));
        $interval = $dayAfter1->diff($day);
        $days = $interval->format('%a');
        if ($interval->d <= 1) {
            $data['p_lj_in_tat'] += 1;
        }
    }
    
   $data['p_culture_in_tat'] = $data['p_lc_in_tat'] + $data['p_lj_in_tat'];
   $data['p_culture_total'] = $data['lc_total'] + $data['lj_total'];


   $data['p_lc_dst'] = ServiceLog::select('t_service_log.sent_to_nikshay_date as result_submitted', 't_service_log.released_dt as print_15')
  ->where('t_service_log.service_id', 21)
  ->where('t_service_log.sent_to_nikshay',1)
  ->whereRaw(DB::raw($con))
  ->get();

  $data['p_lc_dst_in_tat'] = 0;
  foreach ($data['p_lc_dst'] as $key => $value) {
        $day = new DateTime(date($value->result_submitted));
        $dayAfter1 = new DateTime(date($value->print_15));
        $interval = $dayAfter1->diff($day);
        $days = $interval->format('%a');
        if ($interval->d <= 1) {
            $data['p_lc_dst_in_tat'] += 1;
        }
    }



  $data['p_lj_dst'] = ServiceLog::select('t_service_log.sent_to_nikshay_date as result_submitted', 't_service_log.released_dt as print_15')
  ->where('t_service_log.service_id', 22)
  ->where('t_service_log.sent_to_nikshay',1)
  ->whereRaw(DB::raw($con))
  ->get();

  $data['p_lj_dst_in_tat'] = 0;
  foreach ($data['p_lj_dst'] as $key => $value) {
        $day = new DateTime(date($value->result_submitted));
        $dayAfter1 = new DateTime(date($value->print_15));
        $interval = $dayAfter1->diff($day);
        $days = $interval->format('%a');
        if ($interval->d <= 1) {
            $data['p_lj_dst_in_tat'] += 1;
        }
    }

  $data['p_dst_in_tat'] = $data['p_lj_dst_in_tat'] + $data['p_lc_dst_in_tat'];
  $data['p_dst_total'] = $data['lc_dst_total'] + $data['lj_dst_total'];
  

     $data['p_cbnaat'] = ServiceLog::select('t_service_log.sent_to_nikshay_date as result_submitted', 't_service_log.released_dt as print_15')
          ->where('t_service_log.service_id', 4)
          ->where('t_service_log.sent_to_nikshay',1)
          ->whereRaw(DB::raw($con))
          ->get();


      $data['p_cbnaat_in_tat'] = 0;
      $data['p_cbnaat_out_tat'] = 0;
      foreach ($data['p_cbnaat'] as $key => $value) {
            $day = new DateTime(date($value->result_submitted));
            $dayAfter1 = new DateTime(date($value->print_15));
            $interval = $dayAfter1->diff($day);
            $days = $interval->format('%a');
            if ($interval->d <= 1) {
                $data['p_cbnaat_in_tat'] += 1;
            }
            else{
                $data['p_cbnaat_out_tat'] += 1;
            }
        }

      $data['p_cbnaat_total'] = $data['p_cbnaat_in_tat'] + $data['p_cbnaat_out_tat'];
  

        $data['specimen'] = ServiceLog::select('s.receive_date as date_receive', 't_service_log.sent_to_nikshay_date as result_submitted')
            ->where('t_service_log.sent_to_nikshay',1)
            ->leftjoin('sample as s', 't_service_log.sample_id', '=', 's.id')
            ->whereRaw(DB::raw($con))
            ->get();

        $data['specimen_in_tat'] = 0;
        $data['specimen_out_tat'] = 0;
        foreach ($data['p_cbnaat'] as $key => $value) {
            $day = new DateTime(date($value->date_receive));
            $dayAfter1 = new DateTime(date($value->result_submitted));
            $interval = $dayAfter1->diff($day);
            $days = $interval->format('%a');
            if ($interval->d <= 1) {
                $data['specimen_in_tat'] += 1;
            }
            else{
                $data['specimen_out_tat'] += 1;
            }
        }
    
      $data['specimen_total'] = $data['specimen_in_tat'] + $data['specimen_out_tat'];    
      $data['to_date'] = $request->to_date;
      $data['from_date'] = $request->from_date;
      return view('admin.report.lqc_indicator_tat', compact('data'));
  }*/

    public function quality_indicator(Request $request)
    {
        
		//echo $request->from_date."-----".$request->to_date; die;
		$data['to_date'] = $request->to_date;
        $data['from_date'] = $request->from_date;
        if ($request->has('from_date') && $request->has('to_date')) {
			$from_date=date("Y-m-d",strtotime($request->from_date));
			$to_date=date("Y-m-d",strtotime($request->to_date));
			//echo $from_date."--".$to_date; die;
			$data['lc_result']= DB::select('call quality_indicator_test_liquid_culture_report (?, ?)',array($from_date,$to_date));
			$data['lj_result']= DB::select('call quality_indicator_test_solid_culture_report (?, ?)',array($from_date,$to_date));
			$data['lpafld_result']= DB::select('call quality_indicator_test_1stline_lpa_report (?, ?)',array($from_date,$to_date));
			$data['lpasld_result']= DB::select('call quality_indicator_test_2ndline_lpa_report (?, ?)',array($from_date,$to_date));
			$data['lcdst_result']= DB::select('call quality_indicator_test_lcdst_report (?, ?)',array($from_date,$to_date));
			$data['cbnaat_indicator_result']= DB::select('call quality_indicator_test_cbnaat_report (?, ?)',array($from_date,$to_date));
			$data['to_date'] = $request->to_date;
            $data['from_date'] = $request->from_date;
			
        } else {
			$date = Carbon::now();// will get you the current date, time 
		    $todaydate=$date->format("Y-m-d");
            $data['lc_result']= DB::select('call quality_indicator_test_liquid_culture_report (?, ?)',array($todaydate, $todaydate));
			$data['lj_result']= DB::select('call quality_indicator_test_solid_culture_report (?, ?)',array($todaydate, $todaydate));
			$data['lpafld_result']= DB::select('call quality_indicator_test_1stline_lpa_report (?, ?)',array($todaydate,$todaydate));
			$data['lpasld_result']= DB::select('call quality_indicator_test_2ndline_lpa_report (?, ?)',array($todaydate,$todaydate));
			$data['lcdst_result']= DB::select('call quality_indicator_test_lcdst_report (?, ?)',array($todaydate,$todaydate));
			$data['cbnaat_indicator_result']= DB::select('call quality_indicator_test_cbnaat_report (?, ?)',array($todaydate,$todaydate));
			$data['to_date'] = $date->format("d-m-Y");
            $data['from_date'] = $date->format("d-m-Y");
            
        }	
		//dd($data['lc_result']);
        //dd($data['lj_result']);
		//dd($data['lpafld_result']);
		//dd($data['lpasld_result']);
		//dd($data['lcdst_result']);
		//dd($data['cbnaat_indicator_result']);
        		
		
		
        return view('admin.report.quality_indicator', compact('data'));
    }

     // Change done by Deepak and Vidhi
    public function referral_indicator(Request $request)
    {
        if ($request->has('from_date') && $request->has('to_date')) {
            $con = "DATE(req_test.created_at) BETWEEN '" . date('Y-m-d', strtotime($request->from_date)) . "' and  '" . date('Y-m-d', strtotime($request->to_date)) . "'";
        } else {
          $con = "req_test.id != ''";
              
        }
        $data = TestRequest::select('abc.name', 'dpr.DMC_PHI_Name','xyz.TBUnitName', DB::raw('sum(mb.print_15a = 1) declared'), DB::raw('COUNT(DISTINCT mb.enroll_id) as received'))   
        ->leftjoin('m_dmcs_phi_relation as dpr', 'dpr.id', '=', 'req_test.facility_id')
        ->leftjoin('district as abc', 'abc.DTOCode', '=', 'req_test.district')
        ->leftjoin('m_tbunits_relation as xyz', 'xyz.DTOCode', '=', 'req_test.district')
        ->leftjoin('t_microbiologist as mb', 'mb.enroll_id', '=', 'req_test.enroll_id')
        ->whereRaw("xyz.TBUnitCode = req_test.tbu")
        ->groupBy('facility_id')
        ->whereRaw(DB::raw($con))
        //->toSql();
        ->get();
        // dd($data);
        $to_date = $request->to_date;
        $from_date = $request->from_date;

        return view('admin.report.referral_indicator', compact('data', 'to_date', 'from_date'));
    }


    public function cbnaat_indicator(Request $request)
    {
        if ($request->has('from_date') && $request->has('to_date')) {
            $con = "DATE(req_test.created_at) BETWEEN '" . date('Y-m-d', strtotime($request->from_date)) . "' and  '" . date('Y-m-d', strtotime($request->to_date)) . "'";
        } else {
            $con = "req_test.id != ''";
        }
        $data['cbn_sputum'] = ServiceLog::select(DB::raw('sum(cbn.result_MTB = "MTB Detected" AND cbn.result_RIF ="RIF Detected") mtb_ref_det'), DB::raw('sum(cbn.result_MTB = "MTB Detected" AND cbn.result_RIF ="RIF Not Detected") mtb_det_ref_ndet'), DB::raw('sum(cbn.result_MTB = "MTB Not Detected") mtb_ndet'), DB::raw('sum(cbn.result_MTB = "Invalid") mtb_invalid'), DB::raw('sum(cbn.result_MTB = "RIF Indeterminate") rif_indeterminate'), DB::raw('COUNT(cbn.id) as total'))
            ->where('t_service_log.service_id', 4)
            ->leftjoin('sample as s', 't_service_log.sample_id', '=', 's.id')
            ->leftjoin('t_cbnaat as cbn', 't_service_log.sample_id', '=', 'cbn.sample_id')
            ->where('s.sample_type', 'Sputum')
            ->first();
        $data['cbn_csf'] = ServiceLog::select(DB::raw('count(cbn.result_MTB = "MTB Detected" AND cbn.result_RIF ="RIF Detected") mtb_ref_det'), DB::raw('sum(cbn.result_MTB = "MTB Detected" AND cbn.result_RIF ="RIF Not Detected") mtb_det_ref_ndet'), DB::raw('sum(cbn.result_MTB = "MTB Not Detected") mtb_ndet'), DB::raw('sum(cbn.result_MTB = "Invalid") mtb_invalid'), DB::raw('sum(cbn.result_MTB = "RIF Indeterminate") rif_indeterminate'), DB::raw('COUNT(cbn.id) as total'))
            ->where('t_service_log.service_id', 4)
            ->leftjoin('sample as s', 't_service_log.sample_id', '=', 's.id')
            ->leftjoin('t_cbnaat as cbn', 't_service_log.sample_id', '=', 'cbn.sample_id')
            ->where('s.sample_type', 'CSF')
            ->first();
        $data['cbn_ga'] = ServiceLog::select(DB::raw('sum(cbn.result_MTB = "MTB Detected" AND cbn.result_RIF ="RIF Detected") mtb_ref_det'), DB::raw('sum(cbn.result_MTB = "MTB Detected" AND cbn.result_RIF ="RIF Not Detected") mtb_det_ref_ndet'), DB::raw('sum(cbn.result_MTB = "MTB Not Detected") mtb_ndet'), DB::raw('sum(cbn.result_MTB = "Invalid") mtb_invalid'), DB::raw('sum(cbn.result_MTB = "RIF Indeterminate") rif_indeterminate'), DB::raw('COUNT(cbn.id) as total'))
            ->where('t_service_log.service_id', 4)
            ->leftjoin('sample as s', 't_service_log.sample_id', '=', 's.id')
            ->leftjoin('t_cbnaat as cbn', 't_service_log.sample_id', '=', 'cbn.sample_id')
            ->where('s.sample_type', 'GA')
            ->first();
        $data['cbn_pus'] = ServiceLog::select(DB::raw('sum(cbn.result_MTB = "MTB Detected" AND cbn.result_RIF ="RIF Detected") mtb_ref_det'), DB::raw('sum(cbn.result_MTB = "MTB Detected" AND cbn.result_RIF ="RIF Not Detected") mtb_det_ref_ndet'), DB::raw('sum(cbn.result_MTB = "MTB Not Detected") mtb_ndet'), DB::raw('sum(cbn.result_MTB = "Invalid") mtb_invalid'), DB::raw('sum(cbn.result_MTB = "RIF Indeterminate") rif_indeterminate'), DB::raw('COUNT(cbn.id) as total'))
            ->where('t_service_log.service_id', 4)
            ->leftjoin('sample as s', 't_service_log.sample_id', '=', 's.id')
            ->leftjoin('t_cbnaat as cbn', 't_service_log.sample_id', '=', 'cbn.sample_id')
            ->where('s.sample_type', 'PUS')
            ->first();
        $data['cbn_bal'] = ServiceLog::select(DB::raw('sum(cbn.result_MTB = "MTB Detected" AND cbn.result_RIF ="RIF Detected") mtb_ref_det'), DB::raw('sum(cbn.result_MTB = "MTB Detected" AND cbn.result_RIF ="RIF Not Detected") mtb_det_ref_ndet'), DB::raw('sum(cbn.result_MTB = "MTB Not Detected") mtb_ndet'), DB::raw('sum(cbn.result_MTB = "Invalid") mtb_invalid'), DB::raw('sum(cbn.result_MTB = "RIF Indeterminate") rif_indeterminate'), DB::raw('COUNT(cbn.id) as total'))
            ->where('t_service_log.service_id', 4)
            ->leftjoin('sample as s', 't_service_log.sample_id', '=', 's.id')
            ->leftjoin('t_cbnaat as cbn', 't_service_log.sample_id', '=', 'cbn.sample_id')
            ->where('s.sample_type', 'BAL')
            ->first();
        $data['cbn_pf'] = ServiceLog::select(DB::raw('sum(cbn.result_MTB = "MTB Detected" AND cbn.result_RIF ="RIF Detected") mtb_ref_det'), DB::raw('sum(cbn.result_MTB = "MTB Detected" AND cbn.result_RIF ="RIF Not Detected") mtb_det_ref_ndet'), DB::raw('sum(cbn.result_MTB = "MTB Not Detected") mtb_ndet'), DB::raw('sum(cbn.result_MTB = "Invalid") mtb_invalid'), DB::raw('sum(cbn.result_MTB = "RIF Indeterminate") rif_indeterminate'), DB::raw('COUNT(cbn.id) as total'))
            ->where('t_service_log.service_id', 4)
            ->leftjoin('sample as s', 't_service_log.sample_id', '=', 's.id')
            ->leftjoin('t_cbnaat as cbn', 't_service_log.sample_id', '=', 'cbn.sample_id')
            ->where('s.sample_type', 'PF')
            ->first();

        $data['cbn_hiv'] = ServiceLog::select(DB::raw('sum(cbn.result_MTB = "MTB Detected" AND cbn.result_RIF ="RIF Detected") mtb_ref_det'), DB::raw('sum(cbn.result_MTB = "MTB Detected" AND cbn.result_RIF ="RIF Not Detected") mtb_det_ref_ndet'), DB::raw('sum(cbn.result_MTB = "MTB Not Detected") mtb_ndet'), DB::raw('sum(cbn.result_MTB = "Invalid") mtb_invalid'), DB::raw('sum(cbn.result_MTB = "RIF Indeterminate") rif_indeterminate'), DB::raw('COUNT(cbn.id) as total'))
            ->where('t_service_log.service_id', 4)
            ->leftjoin('sample as s', 't_service_log.sample_id', '=', 's.id')
            ->leftjoin('t_cbnaat as cbn', 't_service_log.sample_id', '=', 'cbn.sample_id')
            ->where('s.sample_type', 'HIV positive (All sample type)')
            ->first();
        $data['cbn_others'] = ServiceLog::select(DB::raw('sum(cbn.result_MTB = "MTB Detected" AND cbn.result_RIF ="RIF Detected") mtb_ref_det'), DB::raw('sum(cbn.result_MTB = "MTB Detected" AND cbn.result_RIF ="RIF Not Detected") mtb_det_ref_ndet'), DB::raw('sum(cbn.result_MTB = "MTB Not Detected") mtb_ndet'), DB::raw('sum(cbn.result_MTB = "Invalid") mtb_invalid'), DB::raw('sum(cbn.result_MTB = "RIF Indeterminate") rif_indeterminate'), DB::raw('COUNT(cbn.id) as total'))
            ->where('t_service_log.service_id', 4)
            ->leftjoin('sample as s', 't_service_log.sample_id', '=', 's.id')
            ->leftjoin('t_cbnaat as cbn', 't_service_log.sample_id', '=', 'cbn.sample_id')
            ->where('s.sample_type', 'Others')
            ->first();
        return view('admin.report.cbnaat_indicator', compact('data'));
    }

    public function performance_indicator(Request $request)
    {
		//echo $request->from_date."-----".$request->to_date; die;
		$data['to_date'] = $request->to_date;
        $data['from_date'] = $request->from_date;
        if ($request->has('from_date') && $request->has('to_date')) {
			$from_date=date("Y-m-d",strtotime($request->from_date));
			$to_date=date("Y-m-d",strtotime($request->to_date));
			//echo $from_date."--".$to_date; die;
			$data['performance_data']= DB::select('call rpt_performance_indicator (?, ?)',array($from_date,$to_date));
			$data['to_date'] = $request->to_date;
            $data['from_date'] = $request->from_date;
        } else {
			$date = Carbon::now();// will get you the current date, time 
		    $todaydate=$date->format("Y-m-d");
            $data['performance_data']= DB::select('call rpt_performance_indicator (?, ?)',array($todaydate, $todaydate));
            $data['to_date'] = $date->format("d-m-Y");
            $data['from_date'] = $date->format("d-m-Y");
        }		
        //dd($data['performance_data']);
        return view('admin.report.performance_indicator', compact('data'));
    }

    public function cbnaat_monthly_report_submit(Request $request)
    {


        $id = Cbnaat_lab_details::select('id as ID')->where('status', 1)->first();
        //dd($id);
        if (!empty($id->ID)):
            Cbnaat_lab_details::whereId($id->ID)->update(['status' => 0]);
        endif;
        Cbnaat_lab_details::create([
            'lab_name' => $request->lab_name,
            'lab_addr' => $request->lab_addr,
            'contact_name' => $request->contact_name,
            'contact_no' => $request->contact_no,
            'contact_email' => $request->contact_email,
            'sr_no' => $request->sr_no,
            'date_caliberation' => $request->date_caliberation,
            'reporting_year' => $request->reporting_year,
            'status' => 1,
        ]);
        return redirect("/report/cbnaat_monthly_report");

    }


    /**
     * Generates the report displayed in /report/cbnaat_monthly_report.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	 //Change by Amrita on 31/10/2019
    public function cbnaat_monthly_report(Request $request)
    {
        //dd($request->all());
        $date = Carbon::now();// will get you the current date, time 
		$currentyear=!empty(\request('reporting_year'))?\request('reporting_year'):$date->format("Y");
		$serial_no=!empty(\request('serial_no'))?\request('serial_no'):0;
		//dd($currentyear);
		$cbnaat_mnth_rpt_data= DB::select('call cbnaat_monthly_report (?,?)',array($currentyear,$serial_no));
		//dd($cbnaat_mnth_rpt_data);
		$serial_no_drp = Equipment::select('serial_no')->where('name_cat','GeneXpert/ CBNAAT')->get();
		//dd($serial_no_drp);
		$lab_details=Config::select('*')->where('status',1)->first();
        return view('admin.report.cbnaat_monthly_new', compact('cbnaat_mnth_rpt_data','currentyear','serial_no_drp','lab_details'));
    }
    public function annexure15L(Request $request)
    {
		//echo $request->from_date."-----".$request->to_date; die;
		$data['to_date'] = $request->to_date;
        $data['from_date'] = $request->from_date;
        if ($request->has('from_date') && $request->has('to_date')) {
			$from_date=date("Y-m-d",strtotime($request->from_date));
			$to_date=date("Y-m-d",strtotime($request->to_date));
			//echo $from_date."--".$to_date; die;
			$data['annexure_data']= DB::select('call rpt_annexture15l(?, ?)',array($from_date,$to_date));
			$data['to_date'] = $request->to_date;
            $data['from_date'] = $request->from_date;
        } else {			
			$todaydate=Carbon::today()->format("Y-m-d");// will get you the current date
		    $fromdate=Carbon::today()->subDays(5)->format("Y-m-d");//30 days before today			
            $data['annexure_data']= DB::select('call rpt_annexture15l(?, ?)',array($fromdate, $todaydate));
            $data['to_date'] = Carbon::today()->format("d-m-Y");
            $data['from_date'] = Carbon::today()->subDays(5)->format("d-m-Y");
        }		
        //dd($data['annexure_data']);
        return view('admin.report.annexure_15l', compact('data'));
    }
    public function result_edit(Request $request)
    {
        $data['sample'] = ResultEdit::select('s.sample_label as sample', 't_result_edit.id',
            DB::raw('DATE_FORMAT(t_result_edit.created_at, "%d-%m-%Y") as created'), 't_result_edit.previous_result', 't_result_edit.updated_result',
            't_result_edit.reason', 'service.name as service', 'u.name as updatedBy')
            ->leftjoin('sample as s', 't_result_edit.sample_id', '=', 's.id')
            ->leftjoin('users as u', 'u.id', '=', 't_result_edit.updated_by')
            ->leftjoin('m_services as service', 'service.id', '=', 't_result_edit.service_id')
            ->get();
        if ($request->from_date || $request->to_date) {
            $data['sample'] = ResultEdit::select('s.sample_label as sample', 't_result_edit.id',
                DB::raw('DATE_FORMAT(t_result_edit.created_at, "%d-%m-%Y") as created'), 't_result_edit.previous_result', 't_result_edit.updated_result',
                't_result_edit.reason', 'service.name as service', 'u.name as updatedBy')
                ->leftjoin('sample as s', 't_result_edit.sample_id', '=', 's.id')
                ->leftjoin('users as u', 'u.id', '=', 't_result_edit.updated_by')
                ->leftjoin('m_services as service', 'service.id', '=', 't_result_edit.service_id')
                ->where(DB::raw('DATE_FORMAT(t_result_edit.created_at, "%d-%m-%Y")'), '>', $request->from_date)
                ->where(DB::raw('DATE_FORMAT(t_result_edit.created_at, "%d-%m-%Y")'), '<=', $request->to_date)
                ->get();
        }
        $data['from_date'] = $request->from_date;
        $data['to_date'] = $request->to_date;


        return view('admin.report.result_edit', compact('data'));
    }
	//Created by Rajarshi
	public function lpa_conta_event()
    {
		$users = DB::table('lpa_cont_rep')->get();

        return view('admin.report.lpa_conta_event',  ['users' => $users]);
		
	}	
    public function lpa_conta_event_submit(Request $request)
    {
       /*$new=$request->validate([
		     'date'=>'required',
			 'batch'=>'required',
			 'type'=>'required',
			 'reason'=>'required',
			 'action'=>'required',
			 'date_after'=>'required',
		]);
		echo "<pre>";
		print_r($new);
		die;*/
         $data=$request->all();
         // echo "<pre>";
         // print_r($data);
         // die;
            if (!empty($data)) {
            	try{
             DB::table('lpa_cont_rep')->insert([
             	'date_of_event'=>$data['date'],
             	'no_samples'=>$data['batch'],
             	'type'=>$data['type'],
                'contam_reason'=>$data['reason'],
                'action_taken'=>$data['action'],
                'restart_date'=>$data['date_after']
                 ]);
         }catch(\Exception $e){
             $request->session()->flash('alert-danger','registration failed');
         	return redirect()->back();
         }
         $request->session()->flash('alert-success','users added successfully');
         return redirect()->back();
            }else{
            	return redirect()->back();
            }

    }
	public function testResultStatusNikshay(Request $request)
    {
		//echo $request->from_date."-----".$request->to_date; die;
		$data['to_date'] = $request->to_date;
        $data['from_date'] = $request->from_date;
        if ($request->has('from_date') && $request->has('to_date')) {
			$from_date=date("Y-m-d",strtotime($request->from_date));
			$to_date=date("Y-m-d",strtotime($request->to_date));
			//echo $from_date."--".$to_date; die;
			$data['status_data']= DB::select('call test_result_status_nikshay  (?, ?)',array($from_date,$to_date));
			$data['to_date'] = $request->to_date;
            $data['from_date'] = $request->from_date;
        } else {
			$date = Carbon::now();// will get you the current date, time 
		    $todaydate=$date->format("Y-m-d");
            $data['status_data']= DB::select('call test_result_status_nikshay  (?, ?)',array($todaydate, $todaydate));
            $data['to_date'] = $date->format("d-m-Y");
            $data['from_date'] = $date->format("d-m-Y");
        }		
        //dd($data['status_data']);
        return view('admin.report.test_result_status_nikshay', compact('data'));
    }

}
