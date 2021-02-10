<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\BioWaste;
use App\Model\Config;
use Illuminate\Support\Facades\DB;

class BioWasteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


      $data['lab_details']=Config::select('lab_name as labname','city as labcity')->where('status',1)->first();
      // dd($data['lab_details']->labname);

      $data['labname']='unknown';
      $data['labcity']='unknown';
      if(!empty($data['lab_details']->labname)){

      $data['labname']=$data['lab_details']->labname;
      }

      if(!empty($data['lab_details']->labcity)){
      $data['labcity']=$data['lab_details']->labcity;

      }
                   // $data['today'] = date('Y-m-d H:i:s');
            $data['today_date']=DB::select('select date_format(now(),"%d-%m-%y %H:%i:%s") as date');
            $data['today']=$data['today_date'][0]->date;
            $data['sample'] = BioWaste::orderBy('id','desc')
                        ->distinct()
                        ->get();
            // foreach($data['sample'] as $key=>$value){
            //   if($value->quantity_status==1){
            //     collected_date
            //   }
            //   else{
            //     $value->today_end='';
            //   }
            // }

            return view('admin.biowaste.list',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $data['today_date']=DB::select('select date_format(now(),"%d-%m-%y %H:%i:%s") as date');
      $data['today']=$data['today_date'][0]->date;
        $cbnaat = BioWaste::create([
            'generated_date' =>   $data['today'],


          ]);
        return redirect('/bioWaste');
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
      $waste = BioWaste::find($request->waste_id);
      if($request->option_value == 'quantity_option'){
        $waste->packets = 1;
        $waste->quantity = 1;
      }
      if($request->option_value == 'packets_option'){
        $waste->quantity = null;
        $waste->packets = 2;
      } 

      $waste->yellow = $request->yellow;
      $waste->red = $request->red;
      $waste->white = $request->white;
      $waste->blue = $request->blue;
      $waste->collected_date = $request->collected_date;
      $waste->save();
            
        return redirect('/bioWaste');
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
        // dd($id);

        $waste = BioWaste::find($id);



        $data['today_date']=DB::select('select date_format(now(),"%d-%m-%y %H:%i:%s") as date');
        $data['today_end']=$data['today_date'][0]->date;

        //dd($data['today_end']);
        //$waste->collected_date = $data['today_end'];
        $waste->quantity_status=1;
        $waste->status=1;
        $waste->save();
        return redirect('/bioWaste');

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

    public function biowasteprint()
    {

        $data['waste'] = BioWaste::all();
        return view('admin.biowaste.print',compact('data'));

    }



    public function viewSamples(){

      $query=DB::select(DB::RAW("SELECT `t_service_log`.`enroll_id`, `t_service_log`.`sample_id`,  `t_service_log`.`id` as `log_id`, `sample`.`sample_label`,`enrolls`.`label` as enroll_label, CONCAT (`patient`.`firstname`,' ',`patient`.`surname`) as `patient_name`,`t_service_log`.`previous_step`, DATE_FORMAT(`t_service_log`.`created_at`,'%d-%m-%Y') as `date` FROM `t_service_log` left join `enrolls` on `t_service_log`.`enroll_id`=`enrolls`.`id` left join `patient` on `enrolls`.`patient_id`=`patient`.`id` left join `sample` ON `sample`.`id`=`t_service_log`.`sample_id`  WHERE `t_service_log`.`service_id` = 26 AND `t_service_log`.`status`=1 GROUP BY `sample`.`id` ORDER BY `enrolls`.`label` desc"));
      if(!empty($query)){
        foreach ($query as $key => $sample) {
          $data[]=array("enroll_label"=>$sample->enroll_label,"sample_label"=>$sample->sample_label,"test_req"=>$sample->previous_step,"patient_name"=>$sample->patient_name,"date"=>$sample->date);
        }
        echo json_encode($data);
      }else{
          echo json_encode(false);
      }

    }



    public function search_samples(Request $request){

  // dd($request->search_val);
  $query=DB::select(DB::RAW("SELECT `t_service_log`.`enroll_id`, `t_service_log`.`sample_id`,  `t_service_log`.`id` as `log_id`, `sample`.`sample_label`,`enrolls`.`label` as enroll_label, CONCAT (`patient`.`firstname`,' ',`patient`.`surname`) as `patient_name`,`t_service_log`.`previous_step`, DATE_FORMAT(`t_service_log`.`created_at`,'%d-%m-%Y') as `date` FROM `t_service_log` left join `enrolls` on `t_service_log`.`enroll_id`=`enrolls`.`id` left join `patient` on `enrolls`.`patient_id`=`patient`.`id` left join `sample` ON `sample`.`id`=`t_service_log`.`sample_id`  WHERE (`t_service_log`.`service_id` = 26) AND (`t_service_log`.`status`= 1) AND (`sample`.`sample_label` LIKE '%$request->search_val%' OR `enrolls`.`label` LIKE '%$request->search_val%' OR `t_service_log`.`previous_step` LIKE '%$request->search_val%' OR DATE_FORMAT(`t_service_log`.`created_at`,'%d-%m-%Y') LIKE  '%$request->search_val%' OR `patient`.`firstname` LIKE '%$request->search_val%' OR `patient`.`surname` LIKE '%$request->search_val%')  GROUP BY `sample`.`id`"));



      if(!empty($query)){
        foreach ($query as $key => $sample) {
          $data[]=array("enroll_label"=>$sample->enroll_label,"sample_label"=>$sample->sample_label,"test_req"=>$sample->previous_step,"patient_name"=>$sample->patient_name,"date"=>$sample->date);
        }
        echo json_encode($data);
      }else{
          echo json_encode(false);
      }

    }
}
