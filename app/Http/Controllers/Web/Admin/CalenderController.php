<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Equipment;

class CalenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       //dd("hello");
      $events = [];


      $due_datesL1 = Equipment::select('id','date_last_maintain','flag','due_date','name')->get();
      $due_datesL2 = Equipment::select('id','date_last_caliberation','flag','name','next_calibration')->get();
    // dd($due_datesL1);

       foreach($due_datesL1 as $key=>$due_date){
        //dd($due_date);
      // echo "<pre>"; print_r($due_date);
         if($due_date->due_date){
          //dd($due_date->due_date,Date('Y-m-d'));
          if($due_date->date_last_maintain <= Date('Y-m-d') && Date('Y-m-d')<= $due_date->due_date && $due_date->flag == 1 ){
            $colour = '#d6c917';    //under pocess (yellow)
          }

          elseif($due_date->flag == 0) {
            $colour = '#42f442';    //completed(green)
          }
          elseif($due_date->due_date<Date('Y-m-d') && $due_date->flag == 1){
            $colour = '#e8041f';    //beyond without completion(red)
          }

              $events[] = \Calendar::event(
                  $due_date->id." ".$due_date->name, //event title
                  true, //full day event?
                  new \DateTime($due_date->due_date), //start time (you can also use Carbon instead of DateTime)
                  new \DateTime($due_date->due_date), //end time (you can also use Carbon instead of DateTime)
              	// 'stringEventId' //optionally, you can specify an event ID

                  $due_date->id,
                  [
                      'color' => $colour,
                      'url' => '#',
                      'description' => "Due date of Next Maintenance",
                      'textColor' => '#070707'
                  ]
              );
            }
        }

        foreach($due_datesL2 as $key=>$due_date){
          if($due_date->next_calibration){
          // dd($due_date->next_calibration);
               if($due_date->date_last_caliberation<Date('d-m-Y') && Date('Y-m-d')<=$due_date->next_calibration && $due_date->flag == 1){
                 $colour = '#d6c917';    //under pocess (yellow)
               }
               elseif( $due_date->flag == 0) {
                 $colour = '#42f442';    //completed(green)
               }
               elseif($due_date->next_calibration<Date('Y-m-d') && $due_date->flag == 1){
                 $colour = '#e8041f';    //beyond without completion(red)
               }
               $events[] = \Calendar::event(
                   $due_date->id." ".$due_date->name, //event title
                   true, //full day event?
                   new \DateTime($due_date->next_calibration), //start time (you can also use Carbon instead of DateTime)
                   new \DateTime($due_date->next_calibration), //end time (you can also use Carbon instead of DateTime)
                 // 'stringEventId', //optionally, you can specify an event ID
                   //optionally, you can specify an event ID
                   $due_date->id,
                   [
                       'color' => $colour,
                       'url' => '#',
                       'description' => "Due date of Next Calibration",
                       'textColor' => '#070707'
                   ]
               );
             }
         }

      // $eloquentEvent = EventModel::first(); //EventModel implements MaddHatter\LaravelFullcalendar\Event

      $calendar = \Calendar::addEvents($events) //add an array with addEvents
          ->setOptions([ //set fullcalendar options
      		'firstDay' => 1
      	])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)

          ]);

      return view('admin.calender', compact('calendar'));
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
}
