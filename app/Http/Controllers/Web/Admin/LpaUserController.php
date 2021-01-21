<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class LpaUserController extends Controller
{
    //
    public function index()
    {
        $users = DB::table('lpa_cont_rep')->get();

        return view('admin\LPA_cont_rep\form',  ['users' => $users]);
    }
    // public function index()
    // {
    //   return view('admin\LPA_cont_rep\form');
    // }
    // public function show()
    // {
    //     $test = DB::table('m_test_request')->whereBetween('id',[4, 6])->pluck('name');

    //     return view('admin\LPA_cont_rep\form',  ['test' => $test]);
    // }
    // public function show()
    // {
    //      $test = DB::table('m_test_request')->whereBetween('id', [4, 6])->pluck('name');
    //      return view('admin\LPA_cont_rep\form', ['test'=>$test]);
    // }

    public function userdata(Request $request)
    {
		/*$new=$request->validate([
		     'date'=>'required',
			 'batch'=>'required',
			 'type'=>'required',
			 'reason'=>'required',
			 'action'=>'required',
			 'date_after'=>'required',
		]);
		echo "<pre>";
		print_r($new);
		die;*/
         $data=$request->all();
         // echo "<pre>";
         // print_r($data);
         // die;
            if (!empty($data)) {
            	try{
             DB::table('lpa_cont_rep')->insert([
             	'date_of_event'=>$data['date'],
             	'no_samples'=>$data['batch'],
             	'type'=>$data['type'],
                'contam_reason'=>$data['reason'],
                'action_taken'=>$data['action'],
                'restart_date'=>$data['date_after']
                 ]);
         }catch(\Exception $e){
             $request->session()->flash('alert-danger','registration failed');
         	return redirect()->back();
         }
         $request->session()->flash('alert-success','users added successfully');
         return redirect()->back();
            }else{
            	return redirect()->back();
            }
    }
}
