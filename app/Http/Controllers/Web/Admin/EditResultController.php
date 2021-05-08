<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Microscopy;
use App\Model\Cbnaat;
use App\Model\LCFlaggedMGITFurther;
use App\Model\LJDetail;
use App\Model\LjDstReading;
use App\Model\Equipment;
use App\Model\LCDST;
use App\Model\FirstLineLpa;
use App\Model\SecondLineLpa;
use App\Model\FinalInterpretation;


class EditResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
     * @param  int  $id                    alert('dd');
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
    public function edit_result_micro($sample)
    {
        $microscopy = Microscopy::select('id','result', 'reason_edit')->where('sample_id',$sample)->first();
        $obj = Microscopy::find($microscopy->id);
        $obj->edit_microbiologist = $obj->edit_microbiologist+1;
        $obj->save();
        return($microscopy);
    }
    public function edit_result_cbnaat($sample)
    {
        $cbnaat = Cbnaat::select('id','result_MTB','error','result_RIF','cbnaat_equipment_name')->where('sample_id',$sample)->first();
        if($cbnaat){
            $obj = Cbnaat::find($cbnaat->id);
            $obj->edit_microbiologist = $obj->edit_microbiologist+1;
            $obj->save();
        }
        return($cbnaat);
    }
    public function edit_result_lc($sample)
    {
        $lc=LCFlaggedMGITFurther::select('id','ict','culture_smear','bhi','species','other_result','result', 'comments')->where('sample_id',$sample)->first();
        if($lc){
            $obj = LCFlaggedMGITFurther::find($lc->id);
            $obj->edit_microbiologist = $obj->edit_microbiologist+1;
            $obj->save();
        }
        return($lc);
    }
    public function edit_result_lj($sample)
    {
        $lj = LJDetail::select('id','test_id','culture_smear','species','other_result','final_result', 'comments')->where('sample_id',$sample)->first();
        if($lj){
            $obj = LJDetail::find($lj->id);
            $obj->edit_microbiologist = $obj->edit_microbiologist+1;
            $obj->save();
        }
        return($lj);
    }
    public function edit_result_lj_dst1($sample,$serviceid=0, $drug_list)
    {
		//$logid=$serviceid==22?4:5; 
		// ->where('service_log_id',$logid)

        $drug_list_arr = explode(',', $drug_list);

        //dd( $drug_list_arr );

        $ljdst1 = LjDstReading::select('id','drug_reading', 'drug_name', 'comments')
		          ->where('week_no',4)
				  ->where('status',1)
                  ->where('sample_id',$sample)	
                  ->whereIn('drug_name', $drug_list_arr)			 
				  ->orderBy('id','desc')
				  ->get();
				 // ->toSql();
                  // select * from `t_lj_dst_reading`
        //dd($ljdst1);
        return($ljdst1);
    }

    public function edit_result_lj_dst2($sample,$serviceid=0)
    {
		//$logid=$serviceid==23?5:4; 
		 // ->where('service_log_id',$logid)
        $ljdst2 = LjDstReading::select('id','drug_reading')->where('week_no',6)->where('status',1)
              ->where('sample_id',$sample)
			
			  ->orderBy('id','desc')
			  ->first();
    //dd($ljdst2);
        return($ljdst2);
    }

    public function edit_result_lc_dst($sample)
    {
        $lcdst = LCDST::select('id')->where('sample_id',$sample)->first();
        if($lcdst){
             $obj = LCDST::find($lcdst->id);
            // $obj->edit_microbiologist = $obj->edit_microbiologist+1;
            // $obj->save();
            $lcdstdata = LCDST::select('drug_name','result', 'comments')->where('sample_id',$sample)->get();
            LCDST::where('sample_id',$sample)->update(['edit_microbiologist' => $obj->edit_microbiologist+1]);
        }
		//echo "<pre>"; print_r($lcdstdata); //die();
        return($lcdstdata);
    }
    public function editResultLpa($sample,$tag)
    {
		//echo $tag; die;
		/*$lpa = FinalInterpretation::leftjoin('t_1stlinelpa as lpa1','lpa1.sample_id','t_lpa_final.sample_id')
		    ->leftjoin('t_2stlinelpa as lpa2','lpa2.sample_id','t_lpa_final.sample_id')
            ->where('t_lpa_final.sample_id',$sample)
			->where('t_lpa_final.tag',$tag)
			->first();
			//->toSql();
			//dd($lpa);*/
		if($tag=='1st line LPA')
		{	
       /*  $lpa = FinalInterpretation::leftjoin('t_1stlinelpa as lpa1','lpa1.sample_id','t_lpa_final.sample_id')           
            ->where('t_lpa_final.sample_id',$sample)
			->where('t_lpa_final.tag',$tag)
			->first(); */

            $lpa = FirstLineLpa::all()
                    ->where('sample_id', $sample)
                    ->where('tag', $tag)
                    ->first();
			
		}	
		if($tag=='2nd line LPA')
		{	
            $lpa = SecondLineLpa::all()
            ->where('sample_id', $sample)
            ->where('tag', $tag)
            ->first();
        }		
        if($lpa){
          /* $lpafinal = FinalInterpretation::select('id')->where('sample_id',$sample)->where('tag',$tag)->first();
         //dd($lpafinal);
		  $obj = FinalInterpretation::find($lpafinal->id);
          $obj->edit_microbiologist = $obj->edit_microbiologist+1;
          $obj->save(); */
        }
        return ($lpa);
		//echo json_encode($lpa);
        //exit;
    }

public function get_eq_list(Request $request){



$eqlist=Equipment::select('serial_no as eqipments')->where('name_cat','=','CBNAAT Machines')->get();
// $eq=array();

if(count($eqlist) > 0){
foreach ($eqlist as $key => $eqlists) {
  $eq[]=array("name"=>$eqlists->eqipments);
}
echo json_encode($eq);
}
}

}
