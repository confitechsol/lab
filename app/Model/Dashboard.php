<?php

namespace App\Model;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    public static function dashboard_list(){

        	$name = User::select('name as name')->first();
	        $user = $name->name;
            $data['today'] = date('Y');
            $date = $data['today'] . '-01-01 00:00:00';


	        $data['user'] = $user;
            //$total_samples = Sample::where('created_at','>',$date)->count();			
            // $total_samples = Enroll::where('created_at','>',$date)->count();
            // $tested_samples = ServiceLog::where('status',0)->where('created_at','>',$date)->count();
			$total_samples_sql = DB::select("SELECT count(distinct enroll_id) AS total_sample_count FROM `sample` where YEAR(`created_at`) = YEAR(CURDATE())");
			$total_samples=!empty($total_samples_sql)?$total_samples_sql[0]->total_sample_count:0;
            //$tested_sample = Microbio::where('print_15a',1)->groupBy('sample_id')->get();
            $tested_sample = ServiceLog::where('sent_to_nikshay',1)->groupBy('sample_id')->get();
            $tested_samples=count($tested_sample);
            // $non_tested_samples = ServiceLog::whereIN('status',[1,2])->where('created_at','>',$date)->count();
			$non_tested_samples = ServiceLog::whereIN('status',[1,2])->where('created_at','>',$date)->count();
            $rejected = Sample::where('is_accepted','Rejected')->count();
            //$non_tested_samples = $total_samples-$tested_samples-$rejected;
			$non_tested_samples = $total_samples-$tested_samples;
            $data['total_samples'] = $total_samples;
            $data['tested_samples'] = $tested_samples;
            $data['non_tested_samples'] = $non_tested_samples;
            $data['rejected'] = $rejected;
		
			//dd($rejected);
			
            //1,2,3,4,8,14,15,16,17,20,21,22   ,2,3,4,8,12,14,17,18,20,21
        
		    //$data['lj_innoculation_total']=DB::select('select "No record found" as name,ifnull(count(id),0) as cnt, 9090 as service_id from t_service_log where tag="LJ"');
			//$data['lj_innoculation_total']=DB::select('select "No record found" as name, " " as cnt, " " as service_id' ); 

            $data['lj_innoculation_tested']=DB::select('select "No record found" as name,ifnull(count(id),0) as cnt, 9090 as service_id from t_service_log where tag="LJ" and status=1');
            $data['lj_innoculation_review']=DB::select('select "No record found" as name,ifnull(count(id),0) as cnt, 9090 as service_id from t_service_log where tag="LJ" and status=2');
            $data['lj_innoculation_result']=DB::select('select "No record found" as name,ifnull(count(id),0) as cnt, 9090 as service_id from t_service_log where tag="LJ" and status=0');
            //dd($data['lj_innoculation_total'],$data['lj_innoculation_tested'],$data['lj_innoculation_review'],$data['lj_innoculation_result']);

            $data['service']['sample']=DB::select('select s.id as service_id, s.name, ifnull(count(m.id),0) as cnt from m_services s left join t_service_log as m on m.service_id = s.id where s.id in (1,2,3,4,8,12,14,17,18,20,21,22,23,25) and m.status in (0,1,2) group by m.service_id');

            $data['service']['sample_tested']=DB::select('select s.id as service_id, s.name, ifnull(count(m.id),0) as cnt from m_services s left join t_service_log as m on m.service_id = s.id where s.id in (1,2,3,4,8,12,14,17,18,20,21,22,23,25) and m.status = 1 group by m.service_id');

            $data['service']['sample_review']=DB::select('select s.id as service_id, s.name, ifnull(count(m.id),0) as cnt from m_services s left join t_service_log as m on m.service_id = s.id where s.id in (1,2,3,4,8,12,14,17,18,20,21,22,23,25) and m.status = 2 group by m.service_id');

            $data['service']['sample_result']=DB::select('select s.id as service_id, s.name, ifnull(count(m.id),0) as cnt from m_services s left join t_service_log as m on m.service_id = s.id where s.id in (1,2,3,4,8,12,14,17,18,20,21,22,23,25) and m.status = 0 group by m.service_id');



            //array_splice($data['service']['sample'],9,0,$data['lj_innoculation_total']);
            array_splice($data['service']['sample_tested'],9,0,$data['lj_innoculation_tested']);
            array_splice($data['service']['sample_review'],9,0,$data['lj_innoculation_review']);
            array_splice($data['service']['sample_result'],9,0,$data['lj_innoculation_result']);

            //dd($data['service']['sample']);


            $ret = [];
            foreach($data['service']['sample'] as $sample){
                $data1 = $sample;
                $data2 = [];
                $data3 = [];
                $data4 = [];

                foreach($data['service']['sample_tested'] as $test){
                    if($sample->service_id == $test->service_id){
                        $data2 = $test;
                        break;
                    }
                }
                foreach($data['service']['sample_review'] as $review){
                    if($sample->service_id == $review->service_id){
                        $data3 = $review;
                        break;
                    }
                }
                foreach($data['service']['sample_result'] as $result){
                    if($sample->service_id == $result->service_id){
                        $data4 = $result;
                        break;
                    }
                }

                $ret[] = [
                    'sample'=>$data1,
                    'test'=>$data2,
                    'review'=>$data3,
                    'result'=>$data4,
                ];
            }

            // dd($data);

            $data['ret']=$ret;

			return $data;


    }
}
