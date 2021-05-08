<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Model\Labtu;
use App\Model\State;
use App\Model\District;

class TuController extends Controller
{
    //
    public function showList()
    {
        $get_state_data = DB::table('state')
                              ->select('STOCode', 'name')
                              ->orderBy('name')                              
                              ->get();
            //dd($get_state_data);

        return view('admin.tu.showlist',compact('get_state_data'));
    }

    public function showDistrict($state_code)
    {
        $get_district_data = DB::table('district')
                                  ->select('DTOCode', 'name')
                                  ->where('STOCode', $state_code)
                                  ->get();
        
        echo json_encode($get_district_data);
    }

    public function ajaxTUList(Request $request)
    {
        //dd($request->all());

        $draw = $_POST['draw'];
		$row = $_POST['start'];
		$rowperpage = $_POST['length']; // Rows display per page
		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = $_POST['search']['value']; // Search value

        $result = false;
        $data = [];
        $totalRecords = 0;
        $totalRecordwithFilter = 0;

        
           

            $get_tu_data = Labtu::select('id', 'STOCode', 'DTOCode', 'tuname')
                            ->where('STOCode', $request->state_code)
                            ->where('DTOCode', $request->district_code)
                            ->get();
            //dd($get_tu_data);           

            if(!empty( $get_tu_data))
            {
                foreach( $get_tu_data as $key => $value)
                {
                    $action = $bmwButton = "<button type='button'  onclick=\"updateTUData('".$value->id."','".$value->STOCode."','".$value->DTOCode."','".$value->tuname."')\" class='btn btn-info btn-sm resultbtn bmwButton'>Update</button>";

                    $data[] = array(

                        "DT_RowId"=> $key,                     
					    "DT_RowClass"=>'sel',                       
                        "tu_name"       => $value->tuname,
                        "action"        => $action
                    );

                    $action = "";

                }

                $totalRecords = count($get_tu_data);
                $totalRecordwithFilter = count($get_tu_data);
            }

        

        

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data,            
          );

          echo json_encode($response);
    }

    public function store(Request $request)
    {
       // dd( $request->all()); 
       DB::beginTransaction();
       try {

            if($request->edit_result == 'edit')
            {
                $tu = Labtu::find($request->tu_id);

                $tu->STOCode = $request->state;
                $tu->DTOCode = $request->district;
                $tu->tuname = $request->tuname;
                $tu->save();

            } else {

                $newtu = Labtu::create([
                    'STOCode'   => $request->state,
                    'DTOCode'   => $request->district,
                    'tuname'    => $request->tuname
                ]);

            }
               

                //dd($newtu);
             DB::commit();		
        }catch(\Exception $e){ 
         
             //dd($e->getMessage());
             $error = $e->getMessage();		  
             DB::rollback(); 	
             return redirect('/tu-update');	 
            
        }

        return redirect('/tu-update');
              
       }
        
    
}
