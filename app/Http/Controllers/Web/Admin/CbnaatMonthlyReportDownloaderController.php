<?php

namespace App\Http\Controllers\Web\Admin;
use Excel;
// use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Dashboard;
use App\User;
use App\Model\Service;
use App\Model\Sample;
use App\Model\ServiceLog;
use App\Model\LCDST;
use App\Model\LjDstReading;
use App\Model\TestRequest;
use DateTime;
use Illuminate\Support\Facades\DB;
use App\Model\ResultEdit;
use App\Model\Cbnaat_lab_details;
use Illuminate\Support\Facades\Event;
class CbnaatMonthlyReportDownloaderController extends Controller
{
    //

    public function excel(Request $request){
      // dd($request->all());
      if($request->excel == true){
        Excel::create('exportToExcel', function($excel1) {
          $excel1->sheet('exportToExcel', function($sheet1) {
              $sheet1->loadView('admin.report.cbnaat_monthly_report_table');
        });
       })->download('xls');

      }

    }
}
