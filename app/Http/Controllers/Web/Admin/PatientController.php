<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Patient;
use App\Model\State;
use App\Model\Area_master;
use App\Model\KeyPopulation_master;
use App\Model\Hiv_status_master;
use App\Model\Socioeconomic_master;
use App\Model\Enroll;
use App\Model\District;
use App\Model\Sample;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Model\Labtu;
use App\Model\Occupation;
use App\Model\Tbunits_master;
use App\Model\PHI_master;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

         return Patient::patient_list();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data =  Patient::patient_form();
        $data['adhaar_no'] = '';
        return view('admin.patient.form',compact('data'));

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
		Patient::patient_add();
        return redirect('/admin/enroll/patient');
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

        //dd($request->all());
	    $lab_id=this_lab()->id;//login user lab id
		$data['login_user_phi_rln']=PHI_master::find($lab_id);
		//dd($data['login_user_phi_rln']);
        $patient =  Patient::find($id);
        $data['adhaar_no'] = Patient::where('id',$id)->select(DB::raw('RIGHT(adhar_no, 12) as adhar_no'))->first();


        $enroll =  Enroll::select('id')->where('patient_id',$id)->first();
        //dd($id);


     // dd($master_socioeco_values);
        $firstname=Patient::where('id',$id)->select('firstname')->first();

        //dd($firstname->firstname);
        $lastname=Patient::where('id',$id)->select('surname')->first();
        $patientname=Patient::where('id',$id)->select('name')->first();
          $father_or_husbandname=Patient::where('id',$id)->select('father_or_husband_name')->first();
        //dd($patient);
        $label = Enroll::select('label as label')->where('id',$enroll->id)->first();
        $name = Sample::select('name as name')->where('enroll_id',$enroll->id)->first();

        if($name){
            $state = State::orderBy('name','ASC')->get();
            //$district = District::all();
            $occupation = Occupation::all();
            $data['label']=$label->label;

            // $data['phi']=DB::table('m_phi')->get();
            // $data['tb']=DB::table('m_tb')->get();

            // $data['phi']=PHI_master::select('m_dmcs_phi_relation.id','m_dmcs_phi_relation.DMC_PHI_Name','m_dmcs_phi_relation.DMC_PHI_Code')->leftjoin('patient as req','req.district','=','m_dmcs_phi_relation.DTOCode')->where('req.district',$patient->district)->get();
            // $data['tb']=Tbunits_master::select('m_tbunits_relation.id','m_tbunits_relation.TBUnitCode','m_tbunits_relation.TBUnitName')->join('patient as req','req.district','=','m_tbunits_relation.DTOCode')->where('req.district',$patient->district)->get();
            $data['district']=District::select('district.id','district.DTOCode','district.name')->where('district.STOCode',$patient->state)->orderBy('district.name','ASC')->get();
            $data['district2']=District::select('district.id','district.DTOCode','district.name')->where('district.STOCode',$patient->landmark_state)->orderBy('district.name','ASC')->get();
            $data['patient'] = $patient;

            $data['phi'] = PHI_master::select('m_dmcs_phi_relation.id','m_dmcs_phi_relation.DMC_PHI_Name','m_dmcs_phi_relation.DMC_PHI_Code')->where('m_dmcs_phi_relation.TBUCode',$data['patient']->tb)->where('m_dmcs_phi_relation.DTOCode',$data['patient']->district)->where('m_dmcs_phi_relation.isPhiContinue',1)->get();
            $data['tb'] = Tbunits_master::select('m_tbunits_relation.id','m_tbunits_relation.TBUnitCode','m_tbunits_relation.TBUnitName')->where('m_tbunits_relation.DTOCode',$data['patient']->district)->where('m_tbunits_relation.STOCode',$data['patient']->state)->where('m_tbunits_relation.isTuContinue',1)->get();

            //$data['landmark_tu'] = Tbunits_master::select('m_tbunits_relation.id','m_tbunits_relation.TBUnitCode','m_tbunits_relation.TBUnitName')->where('m_tbunits_relation.DTOCode',$data['patient']->landmark_district)->where('m_tbunits_relation.STOCode',$data['patient']->landmark_state)->where('m_tbunits_relation.isTuContinue',1)->get();

            $data['landmark_tu'] = Labtu::select('m_lab_tu.id','m_lab_tu.tuname')->where('m_lab_tu.DTOCode',$data['patient']->landmark_district)->where('m_lab_tu.STOCode',$data['patient']->landmark_state)->get();

			//dd($data['patient']);
            //$data['nikshay_id'] = $nikshay_id;
            //dd($data['patient']);
            $data['state'] = $state;
            //$data['district'] = $district;
            $data['name'] = $name->name;
            $data['first_name'] = $firstname->firstname;
            $data['last_name'] = $lastname->surname;
            $data['patient_name'] = $patientname->name;
            $data['father_or_husband_name']=$father_or_husbandname->father_or_husband_name;
            $data['today'] = date('dd/mm/yyyy');
            //dd($data['today']);
            $data['occupation'] = $occupation;


			$masters=array();
			$masters['areas']=Area_master::get();
			// dd($masters['areas']);
			$masters['key_poupluation']=KeyPopulation_master::get();
			$masters['hiv_status']=Hiv_status_master::all();
			$masters['socioeconomic']=Socioeconomic_master::all();
			// dd($masters);
			 // $data=$masters;
          }
       // dd($masters);
         //dd($data);
        return view('admin.patient.form',compact('data','masters'));

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
       //dd(2);

        try{
          // dd("d4dd");
// dd("edit");
              //dd($request->all());
                // $validator = Validator::make($request->all(), [
                // 'pincode' => 'digits_between:6,6',
                // 'adhar_no' => 'max:12',
                // 'mobile_number' => 'max:10',
                // ]);
                // if ($validator->fails()) {
                //     return redirect('/enroll')
                //                 ->withErrors($validator)
                //                 ->withInput();
                // }




                $patient = Patient::find($id);
                $data['adhaar_no'] = '';
                $regr_date = strtotime($request->regr_date);
                $request->regr_date = date('Y-m-d H:i:s',$regr_date);
                //dd($request->regr_date);
                $request->request->add(['reg_by' => Auth::user()->name]);

                // Replace Aadhar number with ***s before storing.
                $data = $request->all();
                $data['adhar_no'] = trim( $data['adhar_no'] );
                $data['adhar_no'] = substr( $data['adhar_no'], -4 );
                $data['adhar_no'] = '********' . $data['adhar_no'];

                
				//$data['landmark_tu_id'] = $data['landmark_tu_id'];
				$data['name'] =$request->firstname." ".$request->surname;
                $val = $patient->update( $data );
               
			   //update status of enroll table
				$enrobj=Enroll::where('patient_id','=',$id)->first();
				if($enrobj){
					if(empty($request->nikshay_id)&& !empty($request->mobile_number))
					{
						$enrobj->status_id=3;
				        $enrobj->save();
						
						//UPDATE PATIENT TABLE
						$patient->is_moved=0;
						$patient->save();
					}
				    if(!empty($request->nikshay_id)&& !empty($request->mobile_number))
					{
						$enrobj->status_id=1;
				        $enrobj->save();
					}
				}
                //dd($val);
                // return redirect()->route('enroll.index',['id' => $id]);

                // DO NOT REDIRECT, RATHER CLOSE THE WINDOW. ==========
                // return redirect('/enroll');
                return "<script>window.close()</script>";

        }catch(\Exception $e){
            $error = $e->getMessage();
            //dd($error);
            return view('admin.layout.error',$error);   // insert query
        }
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
    public function district_collect($state)
    {
        try{


            $district_val = District::orderBy('name')->select('DTOCode','name')->where('STOCode',$state)->get();
            //$district_val = District::all();

            return response()->json([
              "district" => $district_val
            ]);



        }catch(\Exception $e){
            $error = $e->getMessage();
            return view('admin.layout.error',$error);   // insert query
        }
    }
	public function checkForNikshayIdExist($enroll_id)
    { 
		  //$patient = Enroll::select('nikshay_id')->where('id',$enroll_id)->first();
		 /* $patient = DB::select("SELECT COUNT(A.nikshay_id) AS nikshay_cnt FROM enrolls A, sample B, patient C
			WHERE  C.nikshay_id = A.nikshay_id
			AND 	B.name = C.firstname
			AND   B.enroll_id = A.id
			AND   C.id = A.patient_id
			AND   A.status_id in (1,5) AND A.id=".$enroll_id);*/
			//Modified as per discussion with pradip dutta on 27/12/2019
			$patient = DB::select("SELECT COUNT(A.nikshay_id) AS nikshay_cnt FROM enrolls A, sample B, patient C
			WHERE  C.nikshay_id = A.nikshay_id			
			AND   B.enroll_id = A.id
			AND   C.id = A.patient_id
			AND   A.status_id in (1) AND A.id=".$enroll_id);
		  
		  $nikshayidexist=0;		
			
			if(!empty($patient)){
				if($patient[0]->nikshay_cnt>0){
					$nikshayidexist=1;
				}else{
					$nikshayidexist=0;
				}
			}else{					
					$nikshayidexist=0;
			}

			echo json_encode($nikshayidexist);
			exit;
	}
}
