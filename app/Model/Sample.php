<?php
namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Http\Responce;
use Illuminate\Database\Eloquent\Model;
use App\Model\Barcodes;
use DateTime;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $enroll_id
 * @property int $user_id
 * @property string $sample_label
 * @property string $name
 * @property mixed $receive_date
 * @property string $sample_quality
 * @property string $other_samplequality
 * @property string $sample_type
 * @property int $service_id
 * @property string is_accepted
 */
class Sample extends Model
{
    protected $table = 'sample';
    protected $fillable = ['enroll_id', 'sample_label', 'nikshay_id', 'user_id', 'name','receive_date',
    'sample_quality','other_samplequality' ,'is_accepted', 'test_reason', 'sample_type', 'fu_month', 'no_of_samples',
    'visual','service_id','others_type'];

    public static function add(){
        try{
          $enroll_id = Enroll::create([]);
          $data['enroll_id'] = $enroll_id->id;
          return $data;

        }catch(\Exception $e){

            return (['ret'=>[],'err'=>['code'=>1, 'msg'=>$e->getMessage()]]);
        }

    }

    public static function store(Request $request){
  
		// $time=date('H:i:s');
		 // dd();
		 // dd($request->actualtime);
		$custom_dt=$request->actualtime;
		// dd($custom_dt);
		if(!empty($custom_dt)){
		$time_exploded=explode(" " , $custom_dt);
		// dd($time_exploded);
		$custom_dt=$time_exploded[0];
		}else{
		  $custom_dt='';
		}

		// dd($custom_dt);
		// dd($submitted_date);
		 // $labcode=Config::select('barcode_offset')->where('status',1)->get();
		 // $labcode=$labcode[0]->barcode_offset;
		 // $labcode=date('y').substr($labcode,2,3);

          $count = count($request->sample_id);
          if($count){
          /*$enroll = Enroll::find($request->enroll_id);
            $enroll->label = substr_replace($request->sample_id[0] ,"",-1);       
            $enroll->save();*/
			 
			 //Create one record in enroll table
			   $enroll_id = Enroll::insertGetId([
				'label' => $request->enroll_label
			   ]);
			   
			   //Patient table pk id=enroll table id
			   $patient_id = Patient::insert([
				'id' => $enroll_id
			   ]);
			   
			   //Update enroll table with patient id  
				$update_enroll = Enroll::find($enroll_id);
                $update_enroll->patient_id = $enroll_id;       
                $update_enroll->save();
          }


          for ($i=0; $i < $count; $i++) {

  // dd($request->receive_date[$i].' '.$custom_dt);
// print_r($i);
            if($request->sample_type[$i]=="Other"){
              $sample_type = $request->other_sample_type[$i];
            }else{
              $sample_type = $request->sample_type[$i];
            }
			
			
			 if($request->rejection=='Other reason'){
                $request->rejection = $request->reason_reject;
              }

			  
             $request->name =  ucfirst ($request->name);
             //dd($request->receive_date[$i]);
             if($request->fu_month[$i]=='Other'){
               $month=$request->followup_other[$i];
             }
             else {
               $month=$request->fu_month[$i];
             }

             if($request->service_id[$i] == '8F' || $request->service_id[$i] == '8S' ){
               $request->service_id[$i].set('8');
             }
             //dd($request->sample_id);

             foreach ($request->sample_id as $key => $value) {
			  $scan_code=strtoupper($value);
			  $last_index=substr($scan_code,-1);
			  if($last_index == 'A'){
				Barcodes::where('codeA',$scan_code)->update(['barcode_status_A'=>'Y','barcode_status_B'=>'Y']);

			  }
			  if($last_index == 'B'){
				Barcodes::where('codeB',$scan_code)->update(['barcode_status_B'=>'Y','barcode_status_A'=>'Y']);
			  }

			}
// print_r($request->sample_id);
// $check=Sample::where('sample_label',$request->sample_id[$i])->count();
// echo $check;
// if($check < 1){

// dd($request->receive_date[$i].$custom_dt);

             $data = Sample::insertGetId([
              'name' => $request->name,
              'nikshay_id' => $request->nikshay_id,
              'sample_label' => $request->sample_id[$i],
              'receive_date' => $request->receive_date[$i].' '.$custom_dt,
              'sample_quality' => $request->sample_quality[$i],
              'other_samplequality'=>$request->othersample_quality,
              'sample_type' => $sample_type,
              'is_accepted' => $request->is_accepted[$i],
              'rejection'  => $request->rejection,
              'test_reason' => $request->test_reason[$i],
              'fu_month' => $month,
              'enroll_id' => $enroll_id,			 
              'user_id' => $request->user()->id,
              'no_of_samples' => $request->no_of_samples,
              'service_id' => $request->service_id[$i],
              'others_type' => $request->others_type[$i],
              'created_at' => date('Y-m-d H:i:s'),
            ]);


            $status = ServiceLog::STATUS_ACTIVE;
            if( $request->service_id[ $i ] == ServiceLog::TYPE_STORAGE ){
                $status = ServiceLog::STATUS_STORAGE;
            }


            $type = '';
            if($request->service_id[$i] == '8F'){
              $type = 'LPA1';
              $request->service_id[$i].set('8');
            }else if($request->service_id[$i] == '8S'){
              $type = 'LPA2';
              $request->service_id[$i].set('8');
            }else if($request->service_id[$i] == 1){
              $type = 'ZN Microscopy';             
            }else if($request->service_id[$i] == 2){
              $type = 'FM Microscopy';             
            }else if($request->service_id[$i] == 3){
              $type = 'Decontamination';             
            }else if($request->service_id[$i] == 4){
              $type = 'CBNAAT';             
            }else if($request->service_id[$i] == 16){
              $type = '';              
            }else if($request->service_id[$i] == 11){
              $type = 'STORAGE';              
            }

            ServiceLog::create([
              'enroll_id' => $enroll_id,
              'sample_id' => $data,
              'service_id' => $request->service_id[$i],
              'enroll_label' => substr_replace($request->sample_id[0] ,"",-1),
              'created_by' => $request->user()->id,
              'updated_by' => $request->user()->id,
              'sample_label' => $request->sample_id[$i],
              'reported_dt'=>date('Y-m-d'),
              'tag' => $type,
              'status' => $status
            ]);


          }
		 
			
			
			
            return true;
          }




     public static function edit($id){
        try{

          return $data;


        }catch(\Exception $e){

            return (['ret'=>[],'err'=>['code'=>1, 'msg'=>$e->getMessage()]]);
        }

    }

}
