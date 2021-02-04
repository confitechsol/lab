<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Decontamination;
use App\Model\Sample;
use App\Model\Enroll;
use App\Model\Service;
use App\Model\ServiceLog;
use App\Model\RequestServices;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class DashboardDecontaminationController extends Controller
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
            $data['today'] = date('Y-m-d H:i:s');
            $data['services'] = Service::select('name')->get();

           
             $data['sample'] = ServiceLog::select('s.id as sample_id', 't_service_log.updated_at as ID','t_service_log.enroll_label',
			 't_service_log.enroll_id','t_service_log.sample_label as samples','t_service_log.status',
			 DB::raw('date_format(d.test_date,"%d-%m-%y") as date'), 's.sample_type as sample_type', 's.others_type as others_type', 's.test_reason','m.result','s.fu_month','t_service_log.tag',
                        't_service_log.status as STATUS','t_service_log.sample_id','t_service_log.service_id','t_service_log.rec_flag','d.sent_for AS Deconta_sent_for')
                        ->leftjoin('t_microscopy as m','m.sample_id','=','t_service_log.sample_id')
                        ->leftjoin('t_decontamination as d','d.sample_id','t_service_log.sample_id')
                        ->leftjoin('sample as s','s.id','t_service_log.sample_id')
                       ->whereIn('t_service_log.status',[1]) // ->whereIn('t_service_log.status',[1,2,0])
                       ->where('t_service_log.service_id',3)
                       ->orderBy('t_service_log.enroll_label','desc')
                       ->distinct()
                       ->get();


             //dd($data['sample']);
			 
			 //dd(Config::get('m_services_array.tests'));			
			 foreach($data['sample'] as $sampledata){
				//echo $sampledata->enroll_id; die;
				
				$services=RequestServices::select('service_id','enroll_id')->where('enroll_id',$sampledata->enroll_id)->get();
				//dd($services);
				$data['test_requested['.$sampledata->enroll_id.']']='';
				$data['services_col_color['.$sampledata->enroll_id.']']='N';
				if(!$services->isEmpty()){ 					
					unset($result);//reinitialize array
					foreach($services as $serv){
						$result[] = Config::get('m_services_array.tests')[$serv->service_id] ?? null;						
					}
					//dd($result);
					//dd(count($result));
					// comma in the array 
                    $data['test_requested['.$sampledata->enroll_id.']'] = implode(', ', $result); 
					//dd($data);
					//For display green colour for more than 1 services
					if(count($result)>1)
					{
						$data['services_col_color['.$sampledata->enroll_id.']']='Y';
					}				
					
				}
			 }
          

           $data['decontamination_test'] = ServiceLog::select('id')->whereIn('status',[0,1,2])->where('service_id',3)->count();

           $data['decontamination_tested'] = ServiceLog::select('id')->where('status',1)->where('service_id',3)->count();


            $data['decontamination_review'] = ServiceLog::select('id')->where('status',2)->where('service_id',3)
                        ->count();




            return view('admin.decontamination.dashboard_list',compact('data'));
        }catch(\Exception $e){
              $error = $e->getMessage();
              return view('admin.layout.error',$error);   // insert query
        }
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
     *
     * Bulk send to Decontamination Review.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function bulkStore( Request $request ){

        // Validate User Inputs ===========================================
        $this->validate( $request, [
            'sample_ids' => 'required',
            'test_date'  => 'required|date_format:Y-m-d',
        ] );

       DB::beginTransaction();
        try {
			// User Inputs ====================================================
			$sample_ids = trim( $request->input('sample_ids') );
			$sample_ids = explode(',', $sample_ids);
			$test_date  = $request->input('test_date');


			// Get Samples from $sample_ids ===================================
			$samples = Sample::query()->findMany( $sample_ids);


			// Go through each of the sample to update values =================
			foreach ( $samples as $sample ){


				// Update if exists or create new if not, in Decontamination ==
				/** @var Sample $sample */
				Decontamination::create([
					'enroll_id' => $sample->enroll_id,
					'sample_id' => $sample->id,
					'status'    => Decontamination::STATUS_ACTIVE,				
					'test_date' => $test_date,
					'created_by' => Auth::user()->id,
					'updated_by' => Auth::user()->id
				]);


				// Log this change to ServiceLog ==============================
				ServiceLog::where([
					'enroll_id'     => $sample->enroll_id,
					'sample_label'  => $sample->sample_label,
					'service_id'    => ServiceLog::TYPE_DECONTAMINATION,
				])->update([
					'status' => Decontamination::SERVICE_STATUS_ACTIVE,
					'created_by' => Auth::user()->id,
					'updated_by' => Auth::user()->id,
				]);
			}
			DB::commit();
         }catch(\Exception $e){
			//dd($e->getMessage()); 
			DB::rollback();
			/*return redirect('/dash_decontamination')->withErrors(['Sorry!! Action already taken of the selected Sample']);*/
			 return back(); // Return back from where the request has come.
		}
		

        return back(); // Return back from where the request has come.

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
       
        // Validate requests ========================
        $this->validate( $request, [
            'enrollId'   => 'required',
            'sample_ids' => 'required',
            'test_date'  => 'required|date_format:Y-m-d'
        ] );
		
        DB::beginTransaction();
        try {
        $enroll_id      = $request->enrollId;
		$service_id     = $request->serviceId;
        $sample_label   = $request->sample_ids;
        $test_date      = $request->test_date;
        $rec_flag       = $request->rec_flag;
       
//        $enroll_label = Enroll::query()->findOrFail( $enroll_id )->label;
        $sample_id    = Sample::query()->where( 'sample_label', $sample_label )->firstOrFail()->id;


        // Find any duplicate Decontamination Item & Delete ====
        Decontamination::where([
            'enroll_id' => $enroll_id,
            'sample_id' => $sample_id, // TODO: This should possibly be $sample_id not $sample_label. Recheck to finalize.
            'status' => Decontamination::STATUS_ACTIVE
        ])->delete();


        // Create new Decontamination ==========================
        Decontamination::create([
            'enroll_id' => $enroll_id,
            'sample_id' => $sample_id,
            'status'    => Decontamination::STATUS_ACTIVE,
            'test_date' => $test_date,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id
        ]);



        // Log this change to ServiceLog =======================
		 $decontamin = ServiceLog::where('enroll_id',$enroll_id)->where('service_id',$service_id)->where('sample_label',$sample_label)->first();
		//dd($decontamin);
		if($decontamin){ //if old decontamination exist update it with 9
			$decontamin->status=9;
			$decontamin->save();
		}
        ServiceLog::where([
            'enroll_id'     => $enroll_id,
            'sample_label'  => $sample_label,
            'service_id'    => ServiceLog::TYPE_DECONTAMINATION,
			'rec_flag'      => $rec_flag,
        ])->update([
            'status' => Decontamination::SERVICE_STATUS_ACTIVE,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ]);
		DB::commit();
        }catch(\Exception $e){
			//dd($e->getMessage()); 
			DB::rollback();
			return redirect('/dash_decontamination')
			->withErrors(['Sorry!! Action already taken of the selected Sample']);
		}
		
        return redirect('/dash_decontamination');
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

        $ids = explode(',', $id);
        $enroll_id = $ids[0];
        $sample_label = $ids[1];
        $en_label = Enroll::select('label as l')->where('id',$enroll_id)->first();
        $s_id = Sample::select('id as l')->where('sample_label',$sample_label)->first();

        $enroll_label=$en_label->l;
        $sample_id=$s_id->l;
       // dd($en_id,$sample_id);
        try{
             Decontamination::where('enroll_id', $enroll_id)->where('sample_id', $sample_label)->where('status',1)->delete();
            $decontamination = Decontamination::create([
            'enroll_id' => $enroll_id,
            'sample_id' => $sample_id,
            'status' => 1,
            'test_date' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
             'updated_by' => Auth::user()->id
          ]);



            ServiceLog::where('enroll_id', $enroll_id)
            ->where('sample_id', $sample_id)
            ->where('service_id',3)
            ->update(['status' => 2 ,'created_by' => Auth::user()->id,'updated_by' => Auth::user()->id]);
        // dd($s_id->l);
          //   $decontamination = ServiceLog::create([
          //   'enroll_id' => $enroll_id,
          //   'sample_id' => $sample_id,
          //   'enroll_label' => $enroll_label,
          //   'sample_label' => $sample_label,
          //   'service_id' => 3,
          //   'status' => 2,
          //   'test_date' => date('Y-m-d H:i:s'),
          //   'created_by' => Auth::user()->id,
          //    'updated_by' => Auth::user()->id
          // ]);
        return redirect('/dash_decontamination');


      }catch(\Exception $e){
          $error = $e->getMessage();
          return view('admin.layout.error',$error);   // insert query
      }
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
    public function dashdecontPrint()
    {
        $data = [];
            $data['today'] = date('Y-m-d H:i:s');
            $data['services'] = Service::select('name')->get();


             $data['sample'] = ServiceLog::select('t_service_log.updated_at as ID','t_service_log.enroll_label','t_service_log.enroll_id','t_service_log.sample_label as samples','t_service_log.status',DB::raw('date_format(d.test_date,"%d-%m-%y") as date'),'s.test_reason','m.result')
                        ->leftjoin('t_microscopy as m','m.sample_id','=','t_service_log.sample_id')
                        ->leftjoin('t_decontamination as d','d.sample_id','t_service_log.sample_id')
                        ->leftjoin('sample as s','s.id','t_service_log.sample_id')
                       ->whereIn('t_service_log.status',[1,2,0])
                       ->where('t_service_log.service_id',3)
                       ->orderBy('t_service_log.enroll_id','desc')
                       ->distinct()
                       ->get();


                       //dd($data['sample']);


           $data['decontamination_test'] = ServiceLog::select('id')->where('status',1)->where('service_id',3)->count();

            $data['decontamination_tested'] = ServiceLog::select('id')->where('status',2)->where('service_id',3)->count();


            $data['decontamination_review'] = ServiceLog::select('id')->where('status',2)->where('service_id',3)
                        ->count();




            return view('admin.decontamination.dashprint',compact('data'));
    }
}
