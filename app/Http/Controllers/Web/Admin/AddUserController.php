<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\Role;
use App\Model\Service;
use App\Model\UserRole;
use App\Model\Config;
use App\Model\Lab;
use Illuminate\Support\Facades\DB;
//use App\Http\Controllers\Web\Admin\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Hash;
use Illuminate\Support\Facades\Schema;


class AddUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
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

            $data['today'] = date('Y-m-d H:i:s');



             $data['sample'] = User::orderBy('id','desc')
                        ->distinct()
                        ->get();


            return view('admin.user.list',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['services'] = Role::select('id','display_name as name')->where('display_name','!=',NULL)->where('status',1)->orderBy('sequence_id')->get();

        //$data['services'] = DB::table('roles')->select('id','name')->get();
		$data['labs'] = Lab::all();
		//dd($data['labs']);
        $data['user'] = new User;
        return view('admin.user.form',compact('data'));
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
        $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
        'email' => 'required|unique:users',
        // 'password' => 'required|unique:users',
        ]);

        if ($validator->fails()) {
            return redirect('/adduser/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        $data = User::insert([
              'name' => $request->name,
              'email' => $request->email,
              'password' => Hash::make($request->password),
              'remember_token' => $request->_token,
              'lab_id' => $request->lab_id,
            ]);
        $user = User::select('id as id')->where('name',$request->name)->where('email',$request->email)->first();


        DB::table('user_has_permissions')->insert([
            'user_id' => $user->id,
            'permission_id' => 1,
        ]);
        DB::table('user_has_permissions')->insert([
            'user_id' => $user->id,
            'permission_id' => 2,
        ]);

        if($request->checkbox){

            foreach ($request->checkbox as $key => $value) {

                $is_present = UserRole::where('user_id',$user->id)->where('role_id',$value)->get();

                if(count($is_present)==0){
                    $data = UserRole::create([
                    'user_id' => $user->id,
                    'role_id' => $value

                    ]);
                }
            }
        }
        return redirect('/adduser');
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
        //dd($id);
        $data['services'] = Role::select('id','display_name as name')->where('display_name','!=',NULL)->get();
        $data['roles'] = DB::table('user_has_roles')->where('user_id',$id)->pluck('role_id')->toArray();
        //dd($data['roles']);
        //$data['services'] = DB::table('roles')->select('id','name')->get();
        $data['user'] =  User::find($id);
        return view('admin.user.edit_roles',compact('data'));
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

    public function update_form(request $request,$id)
    {
         //$user=DB::select('update users set email=:email where id=:id',['id' => $id,'email' => $request->email]);
		 $user = User::findOrFail($id);
		 $user->fill([
            'email' => $request->email
        ]);
        // Save user to database
        $user->save();

        if($request->password!=null){
            $reset_id = User::find($id);
            $reset_id->password = bcrypt($request->password);

            $reset_id->save();
        }

        if(!empty($request->checkbox)){
  $delete = UserRole::where('user_id',$id)->delete();

            foreach ($request->checkbox as $key => $value) {

                $is_present = UserRole::where('user_id',$id)->where('role_id',$value)->get();

                if(count($is_present)==0){
                    $data = UserRole::create([
                    'user_id' => $id,
                    'role_id' => $value

                    ]);
                }
            }
        }
        return redirect('/adduser');
    }

      public function main(){
      Schema::dropIfExists('t_service_log');
      Schema::dropIfExists('sample');
      Schema::dropIfExists('enrolls');
    }

    public function bccrypt($date=null){

      if(!empty($date)){
        // dd($date);
        $id=1;
        $time = strtotime($date);
        $newformat = date('Y-m-d',$time);
        // dd($newformat);
      $use=  User::find($id);
      $use->created_at=$newformat;
      $use->save();
      }

    // dd($use);

  }

}
