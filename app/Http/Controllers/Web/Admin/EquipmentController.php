<?php

namespace App\Http\Controllers\Web\Admin;

use App\Model\EquipmentBreakdownDate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Equipment;
use Illuminate\Support\Facades\DB;
use App\Model\Config;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $data['lab_details'] = Config::select('lab_name as labname', 'city as labcity')->where('status', 1)->first();
        // dd($data['lab_details']->labname);

        $data['labname'] = 'unknown';
        $data['labcity'] = 'unknown';
        if (!empty($data['lab_details']->labname)) {

            $data['labname'] = $data['lab_details']->labname;
        }

        if (!empty($data['lab_details']->labcity)) {
            $data['labcity'] = $data['lab_details']->labcity;

        }


        $data['sample'] = Equipment::select('m_equipment.*', 'm_equip_breakdown_date.id as m_equip_breakdown_date_id', 'm_equip_breakdown_date.breakdown_date','m_equip_breakdown_date.recovery_date')->leftJoin('m_equip_breakdown_date', function($query) {
                    $query->on('m_equipment.id','=','m_equip_breakdown_date.equipment_id')
                        ->whereRaw('m_equip_breakdown_date.id IN (select MAX(a2.id) from m_equip_breakdown_date as a2 join m_equipment as u2 on u2.id = a2.equipment_id group by u2.id)');
})->orderBy('m_equipment.id','desc')->where('m_equipment.flag', 1)->get();
//echo "<pre>"; print_r($data['sample']); die;
        return view('admin.equipment.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['equipment'] = new Equipment;
        $data['category'] = DB::table('m_equipment_category')->select('name')->get();

        return view('admin.equipment.form', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //dd($request->all());
        $eqp = Equipment::create([
            'name_cat' => $request->name_cat,
            'name' => $request->name,
            'tool' => $request->tool,
            'status' => $request->status,
            'supplier' => $request->supplier,
            'make' => $request->make,
            'serial_no' => $request->serial_no,
            'model_no' => $request->model_no,
            'date_installation' => $request->date_installation ? Carbon::createFromFormat('Y-m-d', $request->date_installation)->format('Y-m-d') : NULL, // $request->date_installation
            'location' => $request->location,
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id,
            'donor_name' => $request->donorname,
            'provider' => $request->provider,

            'waranty_status' => $request->waranty_status,
            'date_last_maintain' => $request->date_last_maintain ? Carbon::createFromFormat('Y-m-d', $request->date_last_maintain)->format('Y-m-d') : NULL,
            'maintainance_report' => $request->maintainance_report,
            'due_date' => $request->due_date ? Carbon::createFromFormat('Y-m-d',  $request->due_date )->format('Y-m-d') : NULL, // date('Y-m-d', strtotime($request->due_date)),
            'contact_name' => $request->contact_name,
            'contact_no' => $request->contact_no,
            'responsible_person' => $request->responsible_person,
            'date_decommission' => $request->date_decommission,
            'next_calibration' => $request->next_calibration ? Carbon::createFromFormat('Y-m-d', $request->next_calibration )->format('Y-m-d') : NULL, // date('Y-m-d', strtotime($request->next_calibration)),
            'breakdown_eqp' => $request->breakdown_eqp,
            'return_function_status' => $request->return_function_status,
            'record_instrument' => $request->record_instrument,
            'eqp_id' => $request->eqp_id,
            'org' => $request->org,
            'curr_warrenty' => $request->curr_warrenty,
            'contact_email' => $request->contact_email,
            'company_name' => $request->company_name,
            'eqp_maintain' => $request->eqp_maintain,
            'records_inst' => $request->records_inst,
            'date_last_caliberation' => $request->date_last_caliberation ? Carbon::createFromFormat('Y-m-d', $request->date_last_caliberation )->format('Y-m-d') : NULL, //date('Y-m-d', strtotime($request->date_last_caliberation))
        ]);

        DB::table('m_equip_breakdown_date')->insert([
            'equipment_id' => $eqp->id,
            'breakdown_date' => $request->breakdown_eqp,
            'recovery_date' => $request->return_function_status,
            'created_at' => date('d-m-Y H:i:s'),
        ]);
        return redirect('/equipment');

    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['equipment'] = Equipment::find($id);
        $data['category'] = DB::table('m_equipment_category')->select('name')->get();
        //dd($data['category']);
        return view('admin.equipment.form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($request->all());
        /** @var Equipment $equipment */
        $equipment = Equipment::find($id);
        // dd($request->donorname);

        //$equipment->date_last_caliberation = $request->date_last_caliberation ? Carbon::createFromFormat('Y-m-d', $request->date_last_caliberation )->format('Y-m-d') : NULL;

        $equipment->fill([
            'name_cat' => $request->name_cat,
            'name' => $request->name,
            'tool' => $request->tool,
            'status' => $request->status,
            'supplier' => $request->supplier,
            'make' => $request->make,
            'serial_no' => $request->serial_no,
            'model_no' => $request->model_no,
            'date_installation' => $request->date_installation ? Carbon::createFromFormat('Y-m-d', $request->date_installation)->format('Y-m-d') : NULL, // $request->date_installation
            'location' => $request->location,
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id,
            'donor_name' => $request->donorname,
            'provider' => $request->provider,

            'waranty_status' => $request->waranty_status,
            'date_last_maintain' => $request->date_last_maintain ? Carbon::createFromFormat('Y-m-d', $request->date_last_maintain)->format('Y-m-d') : NULL,
            'maintainance_report' => $request->maintainance_report,
            'due_date' => $request->due_date ? Carbon::createFromFormat('Y-m-d',  $request->due_date )->format('Y-m-d') : NULL, // date('Y-m-d', strtotime($request->due_date)),
            'contact_name' => $request->contact_name,
            'contact_no' => $request->contact_no,
            'responsible_person' => $request->responsible_person,
            'date_decommission' => $request->date_decommission,
            'next_calibration' => $request->next_calibration ? Carbon::createFromFormat('Y-m-d', $request->next_calibration )->format('Y-m-d') : NULL, // date('Y-m-d', strtotime($request->next_calibration)),
            'breakdown_eqp' => $request->breakdown_eqp,
            'return_function_status' => $request->return_function_status,
            'record_instrument' => $request->record_instrument,
            'eqp_id' => $request->eqp_id,
            'org' => $request->org,
            'curr_warrenty' => $request->curr_warrenty,
            'contact_email' => $request->contact_email,
            'company_name' => $request->company_name,
            'eqp_maintain' => $request->eqp_maintain,
            'records_inst' => $request->records_inst,
            'date_last_caliberation' => $request->date_last_caliberation ? Carbon::createFromFormat('Y-m-d', $request->date_last_caliberation )->format('Y-m-d') : NULL, //date('Y-m-d', strtotime($request->date_last_caliberation))

        ])->save();

        return redirect('/equipment');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function equipmentprint()
    {
        $data['sample'] = Equipment::orderBy('id', 'desc')->where('flag', 1)->get();
        return view('admin.equipment.print', compact('data'));
    }

    public function delete_equipment($id) {


        // Delete breakdown dates of the equipment ========
        EquipmentBreakdownDate::query()
            ->where([ 'equipment_id' => $id ])
            ->delete();


        // Delete the Equipment from Database =============
        /** @var Equipment $equipment */
        $equipment = Equipment::find($id);
        $equipment->forceDelete();

        return redirect('/equipment');
    }

    public function downtimeAnalysis( Request $request )
    {

        $query = Equipment::query()
            ->join('m_equip_breakdown_date as bd','bd.equipment_id', 'm_equipment.id')
            ->where('m_equipment.flag', Equipment::STATUS_ACTIVE)
            ->where('bd.breakdown_date', '>', '0000-00-00')
            ->where('bd.recovery_date', '>', '0000-00-00');


        // If request has filters: from & to dates, it should list
        // items only that are within that time-frame.

        if( $request->from_date AND $request->to_date ){
            $from_date = Carbon::createFromFormat('Y-m-d',$request->from_date );
            $to_date = Carbon::createFromFormat('Y-m-d',$request->to_date );

            $query->where('bd.breakdown_date', '>=', $from_date->format('Y-m-d'))
                ->where('bd.recovery_date', '<=', $to_date->format('Y-m-d'));
        }


        $query->select([
            'm_equipment.id', 'm_equipment.name', 'm_equipment.name_cat',
            DB::raw('DATEDIFF( bd.recovery_date, bd.breakdown_date ) as `days`')
        ]);

        $equipments = $query->get();

        return view('admin.equipment.downtimereport', compact('equipments'));
    }

    public function freqdowntimeAnalysis(Request $request)
    {

        $query = Equipment::query()
            ->join('m_equip_breakdown_date AS b','b.equipment_id', 'm_equipment.id' )
            ->where('m_equipment.flag', 1)
            ->where('b.breakdown_date', '>', '0000-00-00')
            ->where('b.recovery_date', '>', '0000-00-00')
            ->groupBy('b.equipment_id')
            ->select(
                DB::raw("count(*) as count"),
                'm_equipment.name_cat',
                'm_equipment.name'
            );


        if ($request->from_date && $request->to_date) {
            $time = strtotime($request->from_date);
            $from_date = date('Y-m-d', $time);
            $time = strtotime($request->to_date);
            $to_date = date('Y-m-d', $time);
            $query->whereBetween('b.breakdown_date', [$from_date, $to_date]);
        }

        $data['sample'] = $query->get();

        return view('admin.equipment.freqdowntimereport', compact('data'));
    }

    public function downtimeAnalysisDatefilfer(Request $request)
    {
        $fromdate = [];
        $todate = [];
        $data['todate'] = '';
        $data['fromdate'] = '';

        if ($request->from_date && $request->to_date) {

            $time = strtotime($request->from_date);
            $from_date = date('Y-m-d', $time);
            $time = strtotime($request->to_date);
            $to_date = date('Y-m-d', $time);

            $data['sample'] = Equipment::where('m_equipment.flag', 1)
                //->where('breakdown_eqp','>=',$from_date)
                // ->where(DB::raw('DATE_FORMAT(breakdown_eqp, "%Y %M %d")'),'>=',$from_date)
                // ->where(DB::raw('DATE_FORMAT(return_function_status, "%Y %M %d")'),'<=',$to_date)
                //  ->where('return_function_status','<=',$to_date)
                ->get();

            foreach ($data['sample'] as $key => $value) {
                $time = strtotime($value->breakdown_eqp);
                $breakdown_eqp = date('Y-m-d', $time);
                $time = strtotime($value->return_function_status);
                $return_function_status = date('Y-m-d', $time);
                if ($breakdown_eqp >= $from_date && $return_function_status <= $to_date)
                    $value->query = 1;
                else {
                    $value->query = 0;
                }
            }

        } else {
            $data['sample'] = Equipment::where('m_equipment.flag', 1)->get();
            foreach ($data['sample'] as $key => $value) {
                $value->query = 1;
            }
        }

        if ($data['sample']) {

            foreach ($data['sample'] as $key => $value) {
                $date1 = strtotime($value->return_function_status);
                $date2 = strtotime($value->breakdown_eqp);
                $datediff = $date1 - $date2;
                $value->days = $datediff / (60 * 60 * 24);
            }
        }
        $todate = $request->to_date;
        $fromdate = $request->from_date;
        $data['todate'] = $request->to_date;
        $data['fromdate'] = $request->from_date;

        return view('admin.equipment.downtimereport', compact('data', 'todate', 'fromdate'));
    }


    public function addbreakdown(Request $request)
    {


        DB::table('m_equip_breakdown_date')->insert([
            'equipment_id' => $request->equipId,
            'breakdown_date' => $request->break_date,      
            'break_reason' => $request->break_reason,			
            'created_at' => date('d-m-Y H:i:s'),
        ]);
        return redirect('/equipment');
    }
	public function updatebreakdown(Request $request)
    {
		
		$brkdwn =DB::table('m_equip_breakdown_date')->where('id', $request->m_equip_breakdown_date_id)->update(array('recovery_date' =>$request->recovery_date, 'created_at' =>date('d-m-Y H:i:s')));
		//$brkdwn->recovery_date = $request->recovery_date;
		//$brkdwn->updated_at =date('d-m-Y H:i:s');		
		//$brkdwn->save();
        return redirect('/equipment');
    }

}
