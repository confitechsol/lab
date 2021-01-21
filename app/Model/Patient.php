<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;

/**
 * @property string $firstname
 * @property string $surname
 * @property string $full_name
 */
class Patient extends Model
{
    protected $table = 'patient';
    //$occupation = [1=>'',2=>'',3=>'',];
    protected $fillable = ['name', 'mobile_number','nikshay_id', 'firstname','surname','father_or_husband_name','gender','age','reg_by','mobile_number','state','district',
    'tb','phi','adhar_no','bank_name','account_no','ifsc_code','house_no','street','ward','city','taluka',
    'landmark','landmark_state','landmark_district','landmark_tu_id','pincode','area','marital_state','occupation','socioeconomy_status',
    'cp_name','cp_phn_no','cp_address','key_population','hiv_test','regr_date','collection_date','collection_time','population_other',
    'bankname_other','maritalstatus_other','health_establish_id','sector_radio','secondary_no_1','secondary_no_2','secondary_no_3'];
    public static function patient_list(){
        try{
        	$name = User::select('name as name')->first();
	        $user = $name->name;
	        $data['user'] = $user;
        	$patient = Patient::select('id','name','mobile_number','nikshay id','created_at')->get();

      		$data['patient'] = $patient;


      		return view('admin.patient.list',compact('data'));

        }catch(\Exception $e){

            return (['ret'=>[],'err'=>['code'=>1, 'msg'=>$e->getMessage()]]);
        }

    }

     public static function patient_form(){
        try{
        	$name = User::select('name as name')->first();
	        $user = $name->name;
	        $data['user'] = $user;
          return $data;

        }catch(\Exception $e){

            return (['ret'=>[],'err'=>['code'=>1, 'msg'=>$e->getMessage()]]);
        }

    }

    public static function patient_add(){
        try{
              $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'mobile_number' => 'required|max:7',
            'pincode' => 'max:6|min:6',
            ]);
            if ($validator->fails()) {
                return redirect('/admin/patient/create')
                            ->withErrors($validator)
                            ->withInput();
            }

            // dd($request->all());

            $patient = Patient::create([
              'name' => $request->name,

            ]);

            return;


        }catch(\Exception $e){

            return (['ret'=>[],'err'=>['code'=>1, 'msg'=>$e->getMessage()]]);
        }

    }



    // Attributes ==============
    public function getFullNameAttribute(){
        return trim( $this->firstname . ' ' . $this->surname );
    }

}
