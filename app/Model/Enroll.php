<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * @property Patient $patient
 */
class Enroll extends Model
{

    protected $table = 'enrolls';
    //protected $fillable = ['patient_id', 'label', 'created_at', 'updated_at'];
	protected $fillable = ['patient_id', 'label'];

    // public static function enroll_list(){
    //     try{
    //     	$name = User::select('name as name')->first();
	   //      $user = $name->name;
	   //      $data['user'] = $user;
    //     	//$sample = Sample::select()->get();

    //   		//$data['sample'] = $sample;


    //   		return $data;

    //     }catch(\Exception $e){

    //         return (['ret'=>[],'err'=>['code'=>1, 'msg'=>$e->getMessage()]]);
    //     }

    // }
    public static function enroll_form(){
        try{
          $state = State::select('name')->get();
          $state = $state;
          $district = District::select('name')->get();
          $district = $district;
          $data['state'] = $state;
          $data['district'] = $district;
          $data['enroll'] = new Enroll;

          return $data;

        }catch(\Exception $e){

            return (['ret'=>[],'err'=>['code'=>1, 'msg'=>$e->getMessage()]]);
        }

    }

    // public static function enroll_add(){
    //     try{
    //           $validator = Validator::make($request->all(), [
    //         'name' => 'required|max:255',
    //         'mobile_number' => 'required|max:7',
    //         ]);
    //         if ($validator->fails()) {
    //             return redirect('/admin/patient/create')
    //                         ->withErrors($validator)
    //                         ->withInput();
    //         }

    //         //dd($request->all());

    //         $patient = new Enroll;
    //         $patient->fill($request->all());
    //         $patient->save();


    //         return;


    //     }catch(\Exception $e){

    //         return (['ret'=>[],'err'=>['code'=>1, 'msg'=>$e->getMessage()]]);
    //     }

    // }
    public static function enroll_edit($id){
        try{
          $state = State::orderBy('name')->select('name')->get();
          $state = $state;
          $district = District::select('name')->get();
          $district = $district;
          $data['state'] = $state;
          $data['district'] = $district;
          $enroll = Enroll::find($id);
          $data['enroll'] = $enroll;

          return $data;

          //dd($data);

        }catch(\Exception $e){

            return (['ret'=>[],'err'=>['code'=>1, 'msg'=>$e->getMessage()]]);
        }

    }


    // Relations ====================

    public function patient(){
        return $this->belongsTo( Patient::class, 'patient_id', 'id' );
    }

}
