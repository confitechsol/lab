<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Sample;
use App\Model\Enroll;
use App\Model\Patient;
use App\Model\Config;
use Illuminate\Support\Facades\DB;
use \Milon\Barcode\DNS1D;

class SearchformController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $services = ['1' => 'ZN Microscopy', '2' => 'FM Microscopy', '3' => 'Liquid Culture', '4' => 'Solid Culture', '5' => 'Solid and Liquid Culture', '8' => 'DNA Extraction', '7' => 'For storage','9'=>'Cbnaat'];
        return view('admin.search1.searchpage')->with( compact('services') );
    }

    public function getenquiry(Request $request) {

        $search_param = escape_like( $request->search_val );

        $query = Sample::query()
            ->leftJoin('enrolls', 'sample.enroll_id', 'enrolls.id')
            ->leftJoin('patient', 'enrolls.patient_id', 'patient.id')
            ->where(function( $query ) use ( $search_param ){
                /** @var Builder $query */
                $query->where('sample.sample_label',    'LIKE', $search_param)
                    ->orWhere('patient.firstname',      'LIKE', $search_param)
                    ->orWhere('patient.nikshay_id',      'LIKE', $search_param)
                    ->orWhere('patient.mobile_number',  'LIKE', $search_param);
            })->orderBy('sample.sample_label', 'DESC')->select([
                'sample.sample_label',
                'patient.nikshay_id',
                'patient.firstname',
                'patient.mobile_number',
                DB::raw('enrolls.id as enroll_id'),
                DB::raw('enrolls.label as label'),
                DB::raw('sample.id as sample_id'),
            ]);

        $result = $query->get();

        $data = [];
        foreach ($result as $key => $value) {
            if (empty($value->mobile_number)) {
                $value->mobile_number = '';
            }
            if (empty($value->nikshay_id)) {
                $value->nikshay_id = '';
            }
            if (empty($value->firstname)) {
                $value->firstname = '';
            }

            $data[] = [
                'sampleid'      => $value->sample_id,
                'sample_label'  => $value->sample_label,
                'label'         => $value->label,
                'firstname'     => $value->firstname,
                'nikshay_id'    => $value->nikshay_id,
                'mobile_number' => $value->mobile_number,
                'enroll_id'     => $value->enroll_id,
            ];
        }

		
        return $data;
		

    }


    public function getstatus(Request $request) {

        $sample_id = $request->sample_id;
        $enroll_id = $request->enroll_id;
        $sample_label = $request->label;
        // echo "SELECT `tsl`.enroll_id,`tsl`.sample_id, `ms`.name as service_name,tsl.`reported_dt`,tsl.`released_dt`,`tsl`.service_id, `tsl`.status,`s`.name,`s`.receive_date,`s`.sample_quality, `s`.sample_label,p.`mobile_number`,`p`.firstname,`p`.surname FROM `t_service_log` tsl LEFT JOIN `sample` s ON `tsl`.sample_id=s.id and tsl.enroll_id=s.enroll_id LEFT join enrolls e ON tsl.enroll_id=e.id LEFT JOIN patient p ON tsl.enroll_id=e.id AND e.patient_id=p.id LEFT JOIN `m_services` ms ON tsl.service_id=ms.id where tsl.enroll_id=$enroll_id and tsl.sample_id=$sample_id and tsl.sample_label=$sample_label and tsl.service_id > 0";
        // DB::enableQueryLog();
        $result = DB::select(DB::raw("SELECT `tsl`.`id`, `tsl`.enroll_id,`tsl`.sample_id, `tsl`.tested_by,`tsl`.comments,`ms`.name as service_name,IFNULL(tsl.tag,'') as tag, (CASE`tsl`.`reported_dt` WHEN NULL THEN '' WHEN '0000-00-00' THEN '' ELSE DATE_FORMAT(`tsl`.`reported_dt`,'%d-%m-%Y') END) AS reported_dt, (CASE`tsl`.`released_dt` WHEN NULL THEN '' WHEN '0000-00-00' THEN '' ELSE DATE_FORMAT(`tsl`.`released_dt`,'%d-%m-%Y') END) AS released_dt, `tsl`.service_id, `tsl`.status,`tsl`.rec_flag,`s`.name,`s`.receive_date,`s`.sample_quality, `s`.sample_label,s.is_accepted,p.`mobile_number`,`p`.firstname,`p`.surname FROM `t_service_log` tsl LEFT JOIN `sample` s ON `tsl`.sample_id=s.id and tsl.enroll_id=s.enroll_id LEFT join enrolls e ON tsl.enroll_id=e.id LEFT JOIN patient p ON tsl.enroll_id=e.id AND e.patient_id=p.id LEFT JOIN `m_services` ms ON tsl.service_id=ms.id where tsl.enroll_id=$enroll_id and tsl.sample_id=$sample_id  and  tsl.service_id > 0 and tsl.status != 9 ORDER BY `tsl`.`reported_dt`"));
		//dd(DB::getQueryLog());
//and tsl.sample_id=$sample_id and tsl.sample_label='$sample_label'
        return $result;

    }

}
