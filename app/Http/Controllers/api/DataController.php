<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function getData($table_name, $lab_token){
      $labid = env('LAB_ID');
      $labToken = env('LAB_TOKEN');
      if($lab_token==$labToken){
        $data = DB::table($table_name)->select('*',DB::raw('"'.$labid.'" as labid'))->where('is_moved',0)->get();
        return $data;
      }else{
        return [];
      }

      if($data){
        return response()->json([
            'ret' => [
                'code' => 1,
                'data' => $data
            ],
            'err' => [
                'code'=>0,
                'msg'=>'',
                'time'=>microtime(true) - LARAVEL_START,
            ]
        ],Response::HTTP_OK);
      }
      return response()->json([
          'ret' => ['code' => 0, 'data' =>[]],
          'err' => [
              'code'=>0,
              'msg'=>'',
              'time'=>microtime(true) - LARAVEL_START,
          ]
      ],Response::HTTP_OK);

  }
  public function updateData(Request $request){
    $labToken = env('LAB_TOKEN');
    $data=[];
    if($request->lab_token==$labToken){
        $data = DB::table($request->table_name)->where('id',$request->id)->update(['is_moved' => 1]);
    }
    if($data){
      return response()->json([
          'ret' => [
              'code' => 1,
              'data' => $data
          ],
          'err' => [
              'code'=>0,
              'msg'=>'',
              'time'=>microtime(true) - LARAVEL_START,
          ]
      ],Response::HTTP_OK);
    }
    return response()->json([
        'ret' => ['code' => 0, 'data' =>[]],
        'err' => [
            'code'=>0,
            'msg'=>'',
            'time'=>microtime(true) - LARAVEL_START,
        ]
    ],Response::HTTP_OK);

  }

  public function transfer_15a_data(Request $request){
    $count = 0;
    $lab_details = DB::table('t_15aformdata')->select('sample_id','enroll_id','lab_id','15Aresult as data','patient_name','id')->where('flag',1)->get();
    if($lab_details){
      foreach($lab_details as $key=>$value){
          $data_inserted = DB::table('t_15aformdata_intermediate')->insert(
            [
              'sample_id' => $value->sample_id,
              'enroll_id' => $value->enroll_id,
              'lab_id' => $value->lab_id,
              'ismoved'=> 0,
              '15Aresult'=> $value->data,
              'patient_name' => $value->patient_name,
              'created_at' => date('Y-m-d'),
              'flag' => 0,
            ]
          );
          DB::table('t_15aformdata')->whereId($value->id)->update(['flag'=>0]);
          $count = $count + 1;
          if(!$data_inserted){
            return response()->json([
                'ret' => ['code' => 0, 'data' =>[]],
                'err' => [
                    'code'=>1,
                    'msg'=>'failed',
                    'time'=>microtime(true) - LARAVEL_START,
                ]
            ],Response::HTTP_OK);
          }
      }
      return response()->json([
          'ret' => ['code' => 1, 'msg' =>'Data inserted in intermediate table', 'count' => $count],
          'err' => [
              'code'=>0,
              'msg'=>'',
              'time'=>microtime(true) - LARAVEL_START,
          ]
      ],Response::HTTP_OK);
    }
    return response()->json([
        'ret' => ['code' => 0, 'data' =>[]],
        'err' => [
            'code'=>1,
            'msg'=>'failed',
            'time'=>microtime(true) - LARAVEL_START,
        ]
    ],Response::HTTP_OK);
  }
  public function transfer_15a_data_to_glabal(Request $request){
    $count = 0;
    $success = 0;
    $live_database = DB::connection('mysql');
    $global_database = DB::connection('mysql-staging');
    foreach($live_database->table('t_15aformdata_intermediate')->where('flag',0)->get() as $data){
       $global_database->table('t_15aformdata')->insert((array) $data);
       $live_database->table('t_15aformdata_intermediate')->whereId($data->id)->update(['flag'=>1]);
       $count = $count + 1;
       $success = 1;
    }
    if($success == 1){
      return response()->json([
          'ret' => ['code' => 1, 'msg' =>'Data inserted in global db', 'count' => $count],
          'err' => [
              'code'=>0,
              'msg'=>'',
              'time'=>microtime(true) - LARAVEL_START,
          ]
      ],Response::HTTP_OK);
    }
    return response()->json([
        'ret' => ['code' => 0, 'data' =>[]],
        'err' => [
            'code'=>1,
            'msg'=>'failed',
            'time'=>microtime(true) - LARAVEL_START,
        ]
    ],Response::HTTP_OK);
  }
}
