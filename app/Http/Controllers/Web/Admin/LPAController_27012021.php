<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Decontamination;
use App\Model\Sample;
use App\Model\Service;
use App\Model\Enroll;
use App\Model\Microbio;
use App\Model\FirstLineLpa;
use App\Model\SecondLineLpa;
use App\Model\FinalInterpretation;
use App\Model\Pcr;
use App\Model\ServiceLog;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Model\ResultEdit;
use App\Model\Lpa_nikshey_final_interpretation;

class LPAController extends Controller
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
            $data['user'] = Auth::user()->name;
            $data['services'] = Service::select('name')->get();


              $data['sample'] = ServiceLog::select('t_service_log.updated_at as ID','t_service_log.enroll_id','t_service_log.enroll_label','sample.sample_label as samples','t_service_log.service_id','services.name as service', 't_service_log.tag','t_service_log.status','t_service_log.sample_id','t_service_log.rec_flag')
                        ->join('sample as sample','t_service_log.sample_id','=','sample.id')
                         ->join('m_services as services','t_service_log.service_id','=','services.id')
                        ->leftjoin('t_1stlinelpa as e',function($join)
                        {

                              $join->on('t_service_log.sample_id','=','e.sample_id')
                                    ->where('t_service_log.enroll_id','=','e.enroll_id');
                        })
                        ->whereIn('t_service_log.status',[1]) //    ->whereIn('t_service_log.status',[0,1])
                        ->whereIn('t_service_log.service_id',[6,7,13,15])
                        ->orderBy('t_service_log.enroll_id','desc')
                      ->groupBy('samples')
                       ->groupBy('status')
					    ->groupBy('tag')
                       ->get();
               

            return view('admin.LPA_Interpretation.list',compact('data'));
    }
    public function getFinalInterpretation( Request $request ){
		    $linetype = $request->linetype;
            //echo $linetype; die;
		    $query = Lpa_nikshey_final_interpretation::query();			
			if($linetype==1){//1 st line lpa
			$query->whereIn('lpa_line',[1,3]);
			}
			if($linetype==2){//2nd line lpa
			$query->whereIn('lpa_line',[2,3]);
			}
			if($linetype==3){//both 1st and 2nd line lpa
			$query->whereIn('lpa_line',[1,2,3]);
			}
            
			//dd($query->toSql()); die;
            $data = $query->get();
			
			//echo "<pre>"; print_r( $data); die;
			$html='<option value="">select</option>';
			foreach ($data as $key=> $bdata)
			{
			 $html.='<option value="'.$bdata->nikshey_final_interpretation.'">'.$bdata->nikshey_final_interpretation.'</option>';
			}
		
			return $html;
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
        // dd($request->sampleid);
        $s_id = Sample::select('id')->where('sample_label',$request->sampleid)->first();
        // dd($s_id);
        $enroll_label=$en_label->label;
        $sample_id=$s_id->id;
   // dd($sample_id);
        // $data['sample'] = ServiceLog::select('t_service_log.service_id as s_id')
        //                 ->where('t_service_log.enroll_id',$request->enrollId)
        //                 ->where('t_service_log.sample_id',$sample_id)
        //                 ->whereIn('t_service_log.service_id',[6,7,13])
        //                 ->first();

        if(!$request->type_indirect)
        {
          $request->request->add(['type_indirect' => NULL]);
        }
        else if(!$request->type_direct) {
          $request->request->add(['type_direct' => NULL]);
        }


        if($request->tag=='1st line LPA' || $request->tag=='1st Line LPA'){

            FirstLineLpa::where('enroll_id', $request->enrollId)->where('sample_id', $sample_id)->delete();

            $FirstLineLpa = FirstLineLpa::create([
                'enroll_id' => $request->enrollId,
                'sample_id' => $sample_id,
                'RpoB' => $request->tbu_band==1?$request->RpoB:"",
                'wt1' => $request->tbu_band==1?$request->wt1:"",
                'wt2' => $request->tbu_band==1?$request->wt2:"",
                'wt3' => $request->tbu_band==1?$request->wt3:"",
                'wt4' => $request->tbu_band==1?$request->wt4:"",
                'wt5' => $request->tbu_band==1?$request->wt5:"",
                'wt6' => $request->tbu_band==1?$request->wt6:"",
                'wt7' => $request->tbu_band==1?$request->wt7:"",
                'wt8' => $request->tbu_band==1?$request->wt8:"",
                'mut1DS16V' => $request->tbu_band==1?$request->mut1DS16V:"",
                'mut2aH526Y' => $request->tbu_band==1?$request->mut2aH526Y:"",
                'mut2bH526D' => $request->tbu_band==1?$request->mut2bH526D:"",
                'mut3S531L' => $request->tbu_band==1?$request->mut3S531L:"",
                'katg' => $request->tbu_band==1?$request->katg:"",
                'wt1315' => $request->tbu_band==1?$request->wt1315:"",
                'mut1S315T1' => $request->tbu_band==1?$request->mut1S315T1:"",
                'mut2S315T2' => $request->tbu_band==1?$request->mut2S315T2:"",
                'inha' => $request->tbu_band==1?$request->inha:"",
                'wt1516' => $request->tbu_band==1?$request->wt1516:"",
                'wt28' => $request->tbu_band==1?$request->wt28:"",
                'mut1C15T' => $request->tbu_band==1?$request->mut1C15T:"",
                'mut2A16G' => $request->tbu_band==1?$request->mut2A16G:"",
                'mut3aT8C' => $request->tbu_band==1?$request->mut3aT8C:"",
                'mut3bT8A' => $request->tbu_band==1?$request->mut3bT8A:"",
                'status' => 1,
                'test_date' => date('Y-m-d H:i:s'),
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
				'tub_band'=>$request->tbu_band,
                'tag'=>$request->tag
              ]);
            }
        if($request->tag=='2nd line LPA'|| $request->tag=='2nd Line LPA' ){
            SecondLineLpa::where('enroll_id', $request->enrollId)->where('sample_id', $sample_id)->delete();
            $SecondLineLpa = SecondLineLpa::create([
                'enroll_id' => $request->enrollId,
                'sample_id' => $sample_id,
                'gyra' => $request->tbu_band==1?$request->gyra:"",
                'wt18590' => $request->tbu_band==1?$request->wt18590:"",
                'wt28993' => $request->tbu_band==1?$request->wt28993:"",
                'wt39297' => $request->tbu_band==1?$request->wt39297:"",
                'mut1A90V' => $request->tbu_band==1?$request->mut1A90V:"",
                'mut2S91P' => $request->tbu_band==1?$request->mut2S91P:"",
                'mut3aD94A' => $request->tbu_band==1?$request->mut3aD94A:"",
                'mut3bD94N' => $request->tbu_band==1?$request->mut3bD94N:"",
                'mut3cD94G' => $request->tbu_band==1?$request->mut3cD94G:"",
                'mut3dD94H' => $request->tbu_band==1?$request->mut3dD94H:"",
                'gyrb' => $request->tbu_band==1?$request->gyrb:"",
                'wt1536541' => $request->tbu_band==1?$request->wt1536541:"",
                'mut1N538D' => $request->tbu_band==1?$request->mut1N538D:"",
                'mut2E540V' => $request->tbu_band==1?$request->mut2E540V:"",
                'rrs' => $request->tbu_band==1?$request->rrs:"",
                'wt1140102' => $request->tbu_band==1?$request->wt1140102:"",
                'wt21484' => $request->tbu_band==1?$request->wt21484:"",
                'mut1A1401G' => $request->tbu_band==1?$request->mut1A1401G:"",
                'mut2G1484T' => $request->tbu_band==1?$request->mut2G1484T:"",
                'eis' => $request->tbu_band==1?$request->eis:"",
                'wt137' => $request->tbu_band==1?$request->wt137:"",
                'wt2141210' => $request->tbu_band==1?$request->wt2141210:"",
                'wt32' => $request->tbu_band==1?$request->wt32:"",
                'mut1c14t' => $request->tbu_band==1?$request->mut1c14t:"",
                'status' => 1,
                'test_date' => date('Y-m-d H:i:s'),
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
				'tub_band'=>$request->tbu_band,
                'tag'=>$request->tag
              ]);
            }elseif($request->tag=='1st line LPA  and for 2nd line LPA'){
              FirstLineLpa::where('enroll_id', $request->enrollId)->where('sample_id', $sample_id)->delete();

              $FirstLineLpa = FirstLineLpa::create([
                  'enroll_id' => $request->enrollId,
                  'sample_id' => $sample_id,
                  'RpoB' => $request->tbu_band==1?$request->RpoB:"",
                  'wt1' => $request->tbu_band==1?$request->wt1:"",
                  'wt2' => $request->tbu_band==1?$request->wt2:"",
                  'wt3' => $request->tbu_band==1?$request->wt3:"",
                  'wt4' => $request->tbu_band==1?$request->wt4:"",
                  'wt5' => $request->tbu_band==1?$request->wt5:"",
                  'wt6' => $request->tbu_band==1?$request->wt6:"",
                  'wt7' => $request->tbu_band==1?$request->wt7:"",
                  'wt8' => $request->tbu_band==1?$request->wt8:"",
                  'mut1DS16V' => $request->tbu_band==1?$request->mut1DS16V:"",
                  'mut2aH526Y' => $request->tbu_band==1?$request->mut2aH526Y:"",
                  'mut2bH526D' => $request->tbu_band==1?$request->mut2bH526D:"",
                  'mut3S531L' => $request->tbu_band==1?$request->mut3S531L:"",
                  'katg' => $request->tbu_band==1?$request->katg:"",
                  'wt1315' => $request->tbu_band==1?$request->wt1315:"",
                  'mut1S315T1' => $request->tbu_band==1?$request->mut1S315T1:"",
                  'mut2S315T2' => $request->tbu_band==1?$request->mut2S315T2:"",
                  'inha' => $request->tbu_band==1?$request->inha:"",
                  'wt1516' => $request->tbu_band==1?$request->wt1516:"",
                  'wt28' => $request->tbu_band==1?$request->wt28:"",
                  'mut1C15T' => $request->tbu_band==1?$request->mut1C15T:"",
                  'mut2A16G' => $request->tbu_band==1?$request->mut2A16G:"",
                  'mut3aT8C' => $request->tbu_band==1?$request->mut3aT8C:"",
                  'mut3bT8A' => $request->tbu_band==1?$request->mut3bT8A:"",
                  'status' => 1,
                  'test_date' => date('Y-m-d H:i:s'),
                  'created_by' => Auth::user()->id,
                  'updated_by' => Auth::user()->id,
				  'tub_band'=>$request->tbu_band,
                  'tag'=>$request->tag
                ]);

              SecondLineLpa::where('enroll_id', $request->enrollId)->where('sample_id', $sample_id)->delete();
              $SecondLineLpa = SecondLineLpa::create([
                  'enroll_id' => $request->enrollId,
                  'sample_id' => $sample_id,
                  'gyra' => $request->tbu_band==1?$request->gyra:"",
                  'wt18590' => $request->tbu_band==1?$request->wt18590:"",
                  'wt28993' => $request->tbu_band==1?$request->wt28993:"",
                  'wt39297' => $request->tbu_band==1?$request->wt39297:"",
                  'mut1A90V' => $request->tbu_band==1?$request->mut1A90V:"",
                  'mut2S91P' => $request->tbu_band==1?$request->mut2S91P:"",
                  'mut3aD94A' => $request->tbu_band==1?$request->mut3aD94A:"",
                  'mut3bD94N' => $request->tbu_band==1?$request->mut3bD94N:"",
                  'mut3cD94G' => $request->tbu_band==1?$request->mut3cD94G:"",
                  'mut3dD94H' => $request->tbu_band==1?$request->mut3dD94H:"",
                  'gyrb' => $request->tbu_band==1?$request->gyrb:"",
                  'wt1536541' => $request->tbu_band==1?$request->wt1536541:"",
                  'mut1N538D' => $request->tbu_band==1?$request->mut1N538D:"",
                  'mut2E540V' => $request->tbu_band==1?$request->mut2E540V:"",
                  'rrs' => $request->tbu_band==1?$request->rrs:"",
                  'wt1140102' => $request->tbu_band==1?$request->wt1140102:"",
                  'wt21484' => $request->tbu_band==1?$request->wt21484:"",
                  'mut1A1401G' => $request->tbu_band==1?$request->mut1A1401G:"",
                  'mut2G1484T' => $request->tbu_band==1?$request->mut2G1484T:"",
                  'eis' => $request->tbu_band==1?$request->eis:"",
                  'wt137' => $request->tbu_band==1?$request->wt137:"",
                  'wt2141210' => $request->tbu_band==1?$request->wt2141210:"",
                  'wt32' => $request->tbu_band==1?$request->wt32:"",
                  'mut1c14t' => $request->tbu_band==1?$request->mut1c14t:"",
                  'status' => 1,
                  'test_date' => date('Y-m-d H:i:s'),
                  'created_by' => Auth::user()->id,
                  'updated_by' => Auth::user()->id,
				  'tub_band'=>$request->tbu_band,
                  'tag'=>$request->tag
                ]);

            }

            if($request->editresult){ //Edit from microbiologist
              //dd($request->all());
              $lpaobj=FinalInterpretation::select('id')->where('enroll_id', $request->enrollId)->where('sample_id', $sample_id)->where('tag',$request->tag)->first();
              //dd($lpaobj);
			  if($lpaobj){
                $lpa = FinalInterpretation::find($lpaobj->id);
                if($lpa){
                  //dd($lpa); die;
				  ResultEdit::where('enroll_id', $request->enrollId)->where('service_id',15)->delete();
                  $edit = ResultEdit::create([
                    'enroll_id' => $request->enrollId,
                    'sample_id' => $lpa->sample_id,
                    'service_id' => 15,
                    'previous_result' => 'MTB: '.$lpa->mtb_result.', RIF: '.$lpa->rif.', INH: '.$lpa->inh.', QUINOLONE: '.$lpa->quinolone.', SLID: '.$lpa->slid,
                    'updated_result' => 'MTB: '.$request->mtb_result.', RIF: '.$request->rif.', INH: '.$request->inh.', QUINOLONE: '.$request->quinolone.', SLID: '.$request->slid,
                    'updated_by' => Auth::user()->id,
                    'status' => 1,
                    'reason' => $request->reason_edit,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => ''
                  ]);

                  if(!empty($request->mtb_result)){
                    $lpa->mtb_result=$request->mtb_result;
                  }
                  if(!empty($request->type)){
                    $lpa->type=$request->type;
                  }else{
                    $lpa->type='';
                  }

                  if(!empty($request->rif)){
                    $lpa->rif=$request->rif;
                  }
                  if(!empty($request->inh)){
                      $lpa->inh=$request->inh;
                  }
                  if(!empty($request->quinolone)){
                      $lpa->quinolone=$request->quinolone;
                  }
                  if(!empty($request->slid)){
                      $lpa->slid=$request->slid;
                  }
				  
				  if(!empty($request->final_interpretation)){
				       $lpa->nikshey_final_interpretation=$request->final_interpretation;
				  }
				  $lpa->tub_band=$request->tbu_band;
                  $lpa->reason_edit=$request->reason_edit;
				  
                  $lpa->is_moved = 0;
                  $lpa->save();
                }
             }
			  DB::commit();
              return redirect('/microbiologist');
            }


        //$fi=FinalInterpretation::where('enroll_id', $request->enrollId)->where('sample_id', $sample_id)->delete();
		//echo "<pre>"; print_r($request->all());
		//echo $fi; die;
		//Atfirst update final result and then make insertion
		$finalinterpreationexist=FinalInterpretation::select('id')->where('enroll_id', $request->enrollId)->where('sample_id', $sample_id)->where('tag',$request->tag)->first();
		if($finalinterpreationexist){		 
			FinalInterpretation::where('enroll_id', $request->enrollId)
					->where('sample_id', $sample_id)                
					->where('tag',$request->tag)
					->update(['status' =>0]);
		}	
		
        $FinalInterpretation = FinalInterpretation::create([
            'enroll_id' => $request->enrollId,
            'sample_id' => $sample_id,
            'type' => $request->type,
            'type_direct' => $request->type_direct,
            'type_indirect' => $request->type_indirect,
            'mtb_result' => $request->mtb_result,
            'rif' => $request->rif,
            'inh' => $request->inh,
            'quinolone' => $request->quinolone,
            'slid' => $request->slid,
            'tub_band' => $request->tbu_band,
		    'nikshey_final_interpretation' => $request->final_interpretation,
            'status' => 1,
            'test_date' => date('Y-m-d H:i:s'),
            'report_date' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
            'tag'=>$request->tag
          ]);
          //echo "<pre>"; print_r($FinalInterpretation); die;

        // $FirstLineLpa = new FirstLineLpa;
        // $request->request->add(['enroll_id' => $request->enrollId]);
        // $request->request->add(['sample_id' => $sample_id]);
        // $request->request->add(['status' => 1]);
        // $request->request->add(['test_date' => date('Y-m-d H:i:s')]);
        // $FirstLineLpa->fill($request->all());
        // $FirstLineLpa->save();

        //update service log
        ServiceLog::where('enroll_id', $request->enrollId)
            ->where('sample_id', $sample_id)
            ->where('service_id',15)
			->where('tag',$request->tag)
			->where('rec_flag',$request->rec_flag)
            ->update(['status' => 0 ,'released_dt'=>date('Y-m-d') ,'tested_by'=>$request->user()->name,'comments' =>$request->comments ,'created_by' => Auth::user()->id,'updated_by' => Auth::user()->id]);

            // Sample::where('enroll_id', $request->enrollId)
            //     ->where('id', $sample_id)
            //     ->update(['service_id' => 6]);
			
            $microbioobj=Microbio::select('id')->where('enroll_id',$request->enrollId)->where('sample_id',$sample_id)->where('service_id',14)->where('next_step','')->first();
            if($microbioobj){
              Microbio::where('id',$microbioobj->id)->delete();
			}  
            $microbio = Microbio::create([
                'enroll_id' => $request->enrollId,
                'sample_id' => $sample_id,
                'service_id' => 15,
                'next_step' => '',
                'detail' => '',
                'remark' => '',
                'status' => 0,
                'tag' => $request->tag,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id
              ]);
         DB::commit();
        }catch(\Exception $e){
			DB::rollback();
			return redirect('/lpa_interpretation')
			->withErrors(['Sorry!! Action already taken of the selected Sample']);
		}
		

          return redirect('/lpa_interpretation');
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

    public function Lpaprint()
    {
        $data = [];
            $data['today'] = date('Y-m-d H:i:s');
            $data['user'] = Auth::user()->name;
            $data['services'] = Service::select('name')->get();


              $data['sample'] = ServiceLog::select('t_service_log.updated_at as ID','t_service_log.enroll_id','t_service_log.enroll_label','sample.sample_label as samples','t_service_log.service_id','services.name as service', 't_service_log.tag')
                        ->join('sample as sample','t_service_log.sample_id','=','sample.id')
                        ->join('m_services as services','t_service_log.service_id','=','services.id')
                        ->leftjoin('t_1stlinelpa as e',function($join)
                        {

                              $join->on('t_service_log.sample_id','=','e.sample_id')
                                    ->where('t_service_log.enroll_id','=','e.enroll_id');
                        })
                        ->where('t_service_log.status',1)
                        ->whereIn('t_service_log.service_id',[6,7,13,15])
                        ->orderBy('t_service_log.enroll_id','desc')
                        ->get();


            return view('admin.LPA_Interpretation.print',compact('data'));
    }
}
