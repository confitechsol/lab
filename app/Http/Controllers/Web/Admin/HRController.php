<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Model\HR;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\Config;

class HRController extends Controller
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
      $data['designation'] = DB::table('m_hr_designation')->get();
        $data['sample'] = HR::orderBy('id','desc')->where('flag',1)->get();
        return view('admin.hr.list',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data['hr'] = new HR;
        $data['designation'] = DB::table('m_hr_designation')->get();
        //dd($data['designation']);
         return view('admin.hr.form',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd($request->all());
        HR::create([
          'name' => $request->name,
          'designation' => $request->designation,
          'other_designation' => $request->other_designation,
          'qualification' => $request->qualification,
          'mode' => $request->mode,
          'date_joining' => $request->date_joining,
          'date_reliving' => $request->date_reliving,
          'health_check' => $request->health_check,
          'vaccination' => $request->vaccination,
          'training_subject' => $request->training_subject,
          'training_date' => $request->train_start,
          'created_by' => $request->user()->id,
          'updated_by' => $request->user()->id,
          'adhaar' => $request->adhaar,

          'type_qualification' => $request->type_qualification,
          'org_source' => $request->org_source,
          'org_source_other' => $request->org_source_other,
          'lc' => $request->lc,
          'microscopy' => $request->microscopy,
          'dst' => $request->dst,
          'lpa' => $request->lpa,

          'geneXpert' => $request->geneXpert,
          'bio_safe_t' => $request->bio_safe_t,
          'fire_safe_t' => $request->fire_safe_t,
          'bio_waste_man' => $request->bio_waste_man,
          'date_reliving_curr' => $request->date_reliving_curr,

          'date_orientation' => $request->date_orientation,
          'date_biosafty' => $request->date_biosafty,
          'date_firesafty' => $request->date_firesafty,
          'date_qms' => $request->date_qms,
          'date_biowaste' => $request->date_biowaste,

          'date_microscopy' => $request->date_microscopy,
          'date_lpa' => $request->date_lpa,
          'date_dst' => $request->date_dst,
          'date_GeneXpert' => $request->date_GeneXpert,
          'date_lc' => $request->date_lc,

          'lpa_2' => $request->lpa_2,
          'date_lpa_2' => $request->date_lpa_2,
          'dst_lc_2' => $request->dst_lc_2,
          'date_dst_lc_2' => $request->date_dst_lc_2,
          'date_dst_lj_1' => $request->date_dst_lj_1,

          'dst_lj_1' => $request->dst_lj_1,
          'dst_lj_2' => $request->dst_lj_2,
          'date_dst_lj_2' => $request->date_dst_lj_2,
          'lj' => $request->lj,
          'date_lj' => $request->date_lj,

          'other' => $request->other,
          'name_other' => $request->name_other,
          'date_other' => $request->date_other,
          'refresher_training_name'=>$request->refresher_training_name,
          'refresher_training_date'=>$request->refresher_training_date,

        ]);
        return redirect('/hr');

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
      // dd("hi");
        $data['hr'] = HR::find($id);
        $data['designation'] = DB::table('m_hr_designation')->get();

        return view('admin.hr.form',compact('data'));
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
      //dd($request->all());
        $hr=HR::find($id);
        $hr->update([
          'name' => $request->name,
          'designation' => $request->designation,
          'other_designation' => $request->other_designation,
          'qualification' => $request->qualification,
          'mode' => $request->mode,
          'date_joining' => $request->date_joining,
          'date_reliving' => $request->date_reliving,
          'health_check' => $request->health_check,
          'vaccination' => $request->vaccination,
          'training_subject' => $request->training_subject,
          'training_date' => $request->train_start,
          'created_by' => $request->user()->id,
          'updated_by' => $request->user()->id,
          'adhaar' => $request->adhaar,

          'type_qualification' => $request->type_qualification,
          'org_source' => $request->org_source,
          'org_source_other' => $request->org_source_other,
          'lc' => $request->lc,
          'microscopy' => $request->microscopy,
          'dst' => $request->dst,
          'lpa' => $request->lpa,
          'qms' => $request->qms,
          'health_check' => $request->health_check,
          'org_source' => $request->org_source,
          'orientation_training' => $request->orientation_training,

          'geneXpert' => $request->geneXpert,
          'bio_safe_t' => $request->bio_safe_t,
          'fire_safe_t' => $request->fire_safe_t,
          'bio_waste_man' => $request->bio_waste_man,
          'date_reliving_curr' => $request->date_reliving_curr,

          'date_orientation' => $request->date_orientation,
          'date_biosafty' => $request->date_biosafty,
          'date_firesafty' => $request->date_firesafty,
          'date_qms' => $request->date_qms,
          'date_biowaste' => $request->date_biowaste,

          'date_microscopy' => $request->date_microscopy,
          'date_lpa' => $request->date_lpa,
          'date_dst' => $request->date_dst,
          'date_GeneXpert' => $request->date_GeneXpert,
          'date_lc' => $request->date_lc,

          'lpa_2' => $request->lpa_2,
          'date_lpa_2' => $request->date_lpa_2,
          'dst_lc_2' => $request->dst_lc_2,
          'date_dst_lc_2' => $request->date_dst_lc_2,
          'date_dst_lj_1' => $request->date_dst_lj_1,

          'dst_lj_1' => $request->dst_lj_1,
          'dst_lj_2' => $request->dst_lj_2,
          'date_dst_lj_2' => $request->date_dst_lj_2,
          'lj' => $request->lj,
          'date_lj' => $request->date_lj,

          'other' => $request->other,
          'name_other' => $request->name_other,
          'date_other' => $request->date_other,
          'refresher_training_name'=>$request->refresher_training_name,
          'refresher_training_date'=>$request->refresher_training_date,
        ]);
        return redirect('/hr');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
     public function hrprint()
    {
        $data['sample'] = HR::orderBy('id','desc')->where('flag',1)->get();
        return view('admin.hr.print',compact('data'));
    }
    public function yearFilter(Request $request)
     {


         $data['sample'] = HR::orderBy('id','desc')->where('flag',1)->where('designation',$request->desig)
         ->get();


         $filer['training']=array();
         $training=[];
         $ret=[];

         foreach($data['sample'] as $key => $value){

            $string_training = "";
            $other_training = "";
            if($value->date_orientation){
              $check = substr($value->date_orientation, 0,4);
              if($check==$request->year){
                $string_training = $string_training . ', Orientation subject';
              }
              else{
                $other_training = $other_training . ', Orientation subject';
              }
            }


            if($value->date_biosafty){
              $check = substr($value->date_biosafty, 0,4);

              if($check==$request->year){
                $string_training = $string_training . ', Biosafety training';
              }
              else{
                $other_training = $other_training . ', Biosafety training';
              }
            }

            if($value->date_firesafty){
              $check = substr($value->date_firesafty, 0,4);
              if($check==$request->year){
                $string_training = $string_training . ', Fire Safety training';
              }
              else{
                $other_training = $other_training . ', Fire Safety training';
              }
            }

            if($value->date_qms){
              $check = substr($value->date_qms, 0,4);
              if($check==$request->year){
                $string_training = $string_training . ', QMS training';
              }
              else{
                $other_training = $other_training . ', QMS training';
              }
            }

            if($value->date_lc){
              $check = substr($value->date_lc, 0,4);
              if($check==$request->year){
                $string_training = $string_training . ', LC training';
              }
              else{
                $other_training = $other_training . ', LC training';
              }
            }

            if($value->date_GeneXpert){
              $check = substr($value->date_GeneXpert, 0,4);
              if($check==$request->year){
                $string_training = $string_training . ', GeneXpert training';
              }
              else{
                $other_training = $other_training . ', GeneXpert training';
              }
            }

            if($value->date_dst){
              $check = substr($value->date_dst, 0,4);
              if($check==$request->year){
                $string_training = $string_training . ', LC DST FirstLine training';
              }
              else{
                $other_training = $other_training . ', LC DST FirstLine training';
              }
            }

            if($value->date_lpa){
              $check = substr($value->date_lpa, 0,4);
              if($check==$request->year){
                $string_training = $string_training . ', LPA FirstLine training';
              }
              else{
                $other_training = $other_training . ', LPA FirstLine training';
              }
            }

            if($value->date_microscopy){
              $check = substr($value->date_microscopy, 0,4);
              if($check==$request->year){
                $string_training = $string_training . ', Microscopy training';
              }
              else{
                $other_training = $other_training . ', Microscopy training';
              }
            }

            if($value->date_lpa_2){
              $check = substr($value->date_lpa_2, 0,4);
              if($check==$request->year){
                $string_training = $string_training . ', LPA SecondLine training';
              }
              else{
                $other_training = $other_training . ', LPA SecondLine training';
              }
            }

            if($value->date_dst_lc_2){
              $check = substr($value->date_dst_lc_2, 0,4);
              if($check==$request->year){
                $string_training = $string_training . ', LC DST SecondLine training';
              }
              else{
                $other_training = $other_training . ', LC DST SecondLine training';
              }
            }

            if($value->date_dst_lj_1){
              $check = substr($value->date_dst_lj_1, 0,4);
              if($check==$request->year){
                $string_training = $string_training . ', LJ DST FirstLine training';
              }
              else{
                $other_training = $other_training . ', LJ DST FirstLine training';
              }
            }

            if($value->date_dst_lj_2){
              $check = substr($value->date_dst_lj_2, 0,4);
              if($check==$request->year){
                $string_training = $string_training . ', LJ DST SecondLine training';
              }
              else{
                $other_training = $other_training . ', LJ DST SecondLine training';
              }
            }

            if($value->date_lj){
              $check = substr($value->date_lj, 0,4);
              if($check==$request->year){
                $string_training = $string_training . ', LJ training';
              }
              else{
                $other_training = $other_training . ', LJ training';
              }
            }

            if($value->date_other){
              $check = substr($value->date_other, 0,4);
              if($check==$request->year){
                $string_training = $string_training . ', Other training';
              }
              else{
                $other_training = $other_training . ', Other training';
              }
            }
            $string_training = ltrim($string_training, ',');
            $other_training = ltrim($other_training, ',');

            $ret[] = [
                 'name'=>$value->name,
                 'designation'=>$value->designation,
                 'qualification'=>$value->qualification,
                 'training'=> $string_training,
                 'other' => $other_training
             ];
         }
         $data['year'] = $request->year;
         $data['ret'] = $ret;
        //   dd( $data);
         return view('admin.hr.yearFilter',compact('data'));
     }

     public function yearOrganizationFilter(Request $request)
     {
       $hr=HR::where('org_source',$request->org)->where('flag',1)->where(DB::raw('SUBSTRING(date_joining, 7, 4)'),$request->year_org)->get();
       $data['hr'] = $hr;
       return view('admin.hr.yearorgFilter',compact('data'));
     }
     public function yearTypeFilter(Request $request)
     {
       $hr=HR::where('type_qualification',$request->type)->where('flag',1)->where(DB::raw('SUBSTRING(date_joining, 7, 4)'),$request->year_type)->get();
       $data['hr'] = $hr;
       return view('admin.hr.yeartypeFilter',compact('data'));
     }

    public function delete_hr($id)
    {
      $hr=HR::find($id);
      $hr->update([
        'flag' => 0,
      ]);
      return redirect('/hr');
    }
}
