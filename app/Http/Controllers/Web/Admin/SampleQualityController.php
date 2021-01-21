<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\SampleQuality;
use App\Model\Sample;
use App\Model\State;
use App\Model\District;
use App\Model\Facility;
use App\User;

class SampleQualityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      try{
        $data = [];
        $data['sample'] = Sample::select('sample.*','e.patient_id')
                          ->leftjoin('enrolls as e','e.id','=','sample.enroll_id')
                        ->get();
        return view('admin.sample_quality.list',compact('data'));

      }catch(\Exception $e){

          return (['ret'=>[],'err'=>['code'=>1, 'msg'=>$e->getMessage()]]);
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sample_quality.form1');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        SampleQuality::updateOrCreate(['enroll_id'=>$request->enroll_id],$request->all());
        return redirect('/req_test');
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
        $data['enroll_id'] = $id;
        $state = State::all();
        $district = District::all();
        $facility = Facility::all();
        //dd($data['patient']);
        $data['state'] = $state;
        $data['district'] = $district;
        $data['facility'] = $facility;
        // return SampleQuality::sample_quality_edit($id);
        return view('admin.sample_quality.form1',compact('data'));
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
