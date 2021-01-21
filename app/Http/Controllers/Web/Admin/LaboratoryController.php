<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Config;
use App\Model\User;
use App\Model\Enroll;
use Illuminate\Http\UploadedFile;

class LaboratoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data=[];
        // $data['config'] = Config::where('status',1)->get();
        // return view('admin.laboratory.index',compact('data'));

        $data['config'] = Config::where('status',1)->first();
        $data['user'] = User::select('name')->get();
       // dd($data['config']);
        return view('admin.laboratory.view',compact('data'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=[];
        //$data['config'] = new Config;
        $data['config'] = Config::where('status',1)->first();
        $data['user'] = User::select('name')->get();
        return view('admin.laboratory.form',compact('data'));
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
        $offset = $request->barcode_offset;
        preg_match_all('!\d+!', $offset, $matches);
      //  print_r($matches);
        $year = $matches[0][0];
        $offset_val= $matches[0][1];
        if($offset_val > 0){
            $enroll = Enroll::create([
                'id' => $offset_val,
                'patient_id' => 0,

               ]);
         }

        // dd($request->all());
        $logofile = $request->file('lablogo');
		//dd($logofile);
		if(!empty($logofile)){			    
			$img_name = $logofile->getClientOriginalName();				
			$destinationPath = 'lab_logo';
			$logofile->storeAs('/', $img_name,$destinationPath);
			//$lablogourl=$destinationPath.'/'.$img_name;
			//echo $lablogourl; die;
			$request->request->add(['logo' => $img_name]);
				
		}
		
		$nabllogofile = $request->file('nabllogo');
		if(!empty($nabllogofile)){
				$nablimg_name = $nabllogofile->getClientOriginalName();
				$nabldestinationPath = 'nabl_logo';
				$nabllogofile->storeAs('/', $nablimg_name,$nabldestinationPath);				
			    //$nabllogourl=$nabldestinationPath.'/'.$nablimg_name;
				//echo $nabllogourl; die;
				$request->request->add(['nabl_logo' => $nablimg_name]);
				
		}
		
        $user_id = User::select('id as id')->where('email',$request->sink_user)->first();
        if($user_id){
            $request->request->add(['sink_user_id' => $user_id->id]);
        }
        //dd($request->all());
        $ispresent = Config::where('status',1)->get();
        if(count($ispresent)){
            Config::where('status', 1)
                     ->update(['status' => 0]);
        }
        $config = new Config;

        $config->fill($request->all());
        //dd($config);
        $dd=$config->save();
        // if(!empty($image)){
        //   $last_insert_id=$config->id;
        //   Config::where('id', $last_insert_id)->where('status',1)
        //            ->update(['logo' => $image]);
        // }
        
         return redirect('/laboratory');
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

        $data['config'] = Config::find($id);
        $data['user'] = User::select('name')->get();
        return view('admin.laboratory.view',compact('data'));
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

    public function view_form()
    {
        dd('ddd');
        $data['config'] = Config::where('status',1)->first();
        dd($data['config']);
        return view('admin.laboratory.view',compact('data'));
    }
}
