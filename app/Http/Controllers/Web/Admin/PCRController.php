<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Decontamination;
use App\Model\Sample;
use App\Model\Service;
use App\Model\Enroll;
use App\Model\Pcr;
use App\Model\ServiceLog;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;

class PCRController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
            $data['today'] = date('Y-m-d H:i:s');
            $data['services'] = Service::select('name')->get();


              $data['sample'] = ServiceLog::select('t_service_log.updated_at as ID','t_service_log.enroll_id',
                        't_service_log.enroll_label','t_service_log.sample_label as samples','sample.receive_date as receive',
                        'sample.test_reason as reason','sample.sample_type','sample.sample_quality','sample.no_of_samples',
                        'd.test_date','m.result','s.completed','e.created_at as created_extraction','t_service_log.tag',
                        't_service_log.status as STATUS','t_service_log.sample_id','t_service_log.service_id','t_service_log.rec_flag')
                        ->leftjoin('sample as sample','t_service_log.sample_id','=','sample.id')
                        ->leftjoin('t_pcr as s','t_service_log.sample_id','=','s.sample_id')
                        ->leftjoin('t_decontamination as d',function($join)
                        {

                              $join->on('d.sample_id','=','t_service_log.sample_id')
                                    ->where('d.status',1);
                        })
                        ->leftjoin('t_microscopy as m',function($join)
                        {

                              $join->on('m.sample_id','=','t_service_log.sample_id')
                                    ->where('m.status',1);
                        })
                        ->leftjoin('t_dnaextraction as e',function($join)
                        {

                              $join->on('e.sample_id','=','t_service_log.sample_id')
                                    ->where('e.status',1);
                        })
                        ->whereIn('t_service_log.status',[1]) //      ->whereIn('t_service_log.status',[0,1])
                        ->where('t_service_log.service_id',12)
                        ->orderBy('t_service_log.enroll_id','desc')
                        ->distinct('sample_id')
                       ->groupBy('samples') // made changes for multiple records displaying in PCR
                        ->groupBy('STATUS')
						 ->groupBy('tag')
                        ->get();
						//->toSql();
              // dd($data['sample']);




            // dd($data['sample']);
            return view('admin.PCR.list',compact('data'));
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
        //dd($request->all());
		DB::beginTransaction();
        try {
        $en_label = Enroll::select('label')->where('id',$request->enrollId)->first();
        $s_id = Sample::select('id')->where('sample_label','like',$request->sampleid.'%')->first();
      //dd($s_id);
        $enroll_label=$en_label->label;
        $sample_id=$s_id->id;

        //Pcr::where('enroll_id', $request->enrollId)->where('sample_id', $sample_id)->delete();
		Pcr::where('enroll_id', $request->enrollId)->where('tag',$request->tag)->delete();
		if($request->completed == 1)
        {
        $pcr = Pcr::create([
            'enroll_id' => $request->enrollId,
            'sample_id' => $sample_id,
            'completed' => $request->completed,
            'status' => 1,
			'tag' => $request->tag,
            'test_date' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id
          ]);

        
            ServiceLog::create([
                    'enroll_id' => $request->enrollId,
                    'sample_id' => $sample_id,
                    'enroll_label' => $enroll_label,
                    'sample_label' => $request->sampleid,
                    'service_id' => 14,
                    'status' => 1,
                    'reported_dt'=>date('Y-m-d'),
                    'tag' => $request->tag,
					'rec_flag' => $request->rec_flag,
                    'test_date' => date('Y-m-d H:i:s'),
                    'created_by' => Auth::user()->id,
                     'updated_by' => Auth::user()->id
                  ]);
            ServiceLog::where('enroll_id', $request->enrollId)
            ->where('sample_id', $sample_id)
            ->where('service_id',12)
			->where('tag',$request->tag)
            ->update(['status' => 0 ,'released_dt'=>date('Y-m-d'),'tested_by'=>Auth::user()->name,'comments'=>$request->comments,'created_by' => Auth::user()->id,'updated_by' => Auth::user()->id]);
        }else{
          $old_sample = Sample::select('sample_label')->where('id',$sample_id)->first();
          $new_sample = $old_sample->sample_label.'R';
          Sample::where('id',$sample_id)->update(['sample_label'=>$new_sample]);
          ServiceLog::where('sample_id',$sample_id)->where('status','!=',0)->update(['sample_label'=>$new_sample,'rec_flag' => $request->rec_flag]);
        }

       //  $data = Cbnaat::create($request->all());
     // return $data;
       }catch(\Exception $e){
			DB::rollback();
			return redirect('/PCR')
			->withErrors(['Sorry!! Action already taken of the selected Sample']);
		}
		DB::commit();

        return redirect('/PCR');
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
    public function PCRprint()
    {
         $data = [];
            $data['today'] = date('Y-m-d H:i:s');
            $data['services'] = Service::select('name')->get();


              $data['sample'] = ServiceLog::select('t_service_log.updated_at as ID','t_service_log.enroll_id',
                        't_service_log.enroll_label','t_service_log.sample_label as samples','sample.receive_date as receive',
                        'sample.test_reason as reason','sample.sample_type','sample.sample_quality','sample.no_of_samples',
                        'd.test_date','m.result','s.completed','e.created_at as created_extraction','t_service_log.tag',
                        't_service_log.status as STATUS')
                        ->join('sample as sample','t_service_log.sample_id','=','sample.id')
                        ->leftjoin('t_pcr as s','t_service_log.sample_id','=','s.sample_id')
                        ->leftjoin('t_decontamination as d',function($join)
                        {

                              $join->on('d.sample_id','=','t_service_log.sample_id')
                                    ->where('d.status',1);
                        })
                        ->leftjoin('t_microscopy as m',function($join)
                        {

                              $join->on('m.sample_id','=','t_service_log.sample_id')
                                    ->where('m.status',1);
                        })
                        ->leftjoin('t_dnaextraction as e',function($join)
                        {

                              $join->on('e.sample_id','=','t_service_log.sample_id')
                                    ->where('e.status',1);
                        })
                        ->whereIn('t_service_log.status',[0,1])
                        ->where('t_service_log.service_id',12)
                        ->orderBy('t_service_log.enroll_id','desc')
                        ->get();
            return view('admin.PCR.print',compact('data'));
    }
}
