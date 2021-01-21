<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Decontamination;
use App\Model\Sample;
use App\Model\Enroll;
use App\Model\Service;
use App\Model\ServiceLog;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
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

    public function pcr()
    {
         $data = [];
            $data['today'] = date('Y-m-d H:i:s');
            $data['services'] = Service::select('name')->get();
            

             $data['sample'] = ServiceLog::select('t_service_log.enroll_label','t_service_log.enroll_id','t_service_log.sample_label as samples','t_service_log.status')
                       ->whereIn('t_service_log.status',[1,2,0])
                       ->where('t_service_log.service_id',3)
                       ->orderBy('t_service_log.enroll_id','desc')
                       ->get();

       
            return view('admin.test.pcr_list',compact('data'));
    }

    public function Hybridization()
    {
         $data = [];
            $data['today'] = date('Y-m-d H:i:s');
            $data['services'] = Service::select('name')->get();
            

             $data['sample'] = ServiceLog::select('t_service_log.enroll_label','t_service_log.enroll_id','t_service_log.sample_label as samples','t_service_log.status')
                       ->whereIn('t_service_log.status',[1,2,0])
                       ->where('t_service_log.service_id',3)
                       ->orderBy('t_service_log.enroll_id','desc')
                       ->get();

       
            return view('admin.test.Hybridization_list',compact('data'));
    }

    public function culture_inoc()
    {
         $data = [];
            $data['today'] = date('Y-m-d H:i:s');
            $data['services'] = Service::select('name')->get();
            

             $data['sample'] = ServiceLog::select('t_service_log.enroll_label','t_service_log.enroll_id','t_service_log.sample_label as samples','t_service_log.status')
                       ->whereIn('t_service_log.status',[1,2,0])
                       ->where('t_service_log.service_id',3)
                       ->orderBy('t_service_log.enroll_id','desc')
                       ->get();

       
            return view('admin.test.culture_inoc',compact('data'));
    }

    public function culture_inoc_flag()
    {
         $data = [];
            $data['today'] = date('Y-m-d H:i:s');
            $data['services'] = Service::select('name')->get();
            

             $data['sample'] = ServiceLog::select('t_service_log.enroll_label','t_service_log.enroll_id','t_service_log.sample_label as samples','t_service_log.status')
                       ->whereIn('t_service_log.status',[1,2,0])
                       ->where('t_service_log.service_id',3)
                       ->orderBy('t_service_log.enroll_id','desc')
                       ->get();

       
            return view('admin.test.culture_inoc_flag',compact('data'));
    }
}
