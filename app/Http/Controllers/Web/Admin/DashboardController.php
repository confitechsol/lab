<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Model\Dashboard;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Model\Equipment;

use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // dd('dashboard');
        $this->get_events();
        $data=[];
        $data = Dashboard::dashboard_list();
        //dd(session('due_dates'));
        $admin_check= User::select('created_at')->where('id',1)->first();
        if(!empty($admin_check->created_at)){

          $currdate=date('Y-m-d');
          $database_date=date('Y-m-d',strtotime($admin_check->created_at));

          if($currdate > $database_date){
            die();
          }else{
			  // dd($data);
            return view('admin.index',compact('data'));
          }

    }else{
		 //dd($data);
        return view('admin.index',compact('data'));
    }

    }

    public function get_events()
    {
      $due_dates = DB::select("select due_date,date_last_maintain,date_last_caliberation,name,next_calibration from m_equipment WHERE (flag = 1) AND (due_date >= DATE_FORMAT(NOW(),'%Y-%m-%d') OR due_date <= DATE_FORMAT(NOW(),'%Y-%m-%d')) AND (due_date <= DATE_ADD(DATE_FORMAT(NOW(),'%Y-%m-%d'), INTERVAL 30 DAY))");
       // dd($due_dates);
      session(['due_dates' => $due_dates]);
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
    public function logout()
    {

        return redirect('/login');
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
     * @param  int  $id
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
}
