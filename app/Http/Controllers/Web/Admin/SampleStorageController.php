<?php

namespace App\Http\Controllers\Web\Admin;


use App\Http\Controllers\Controller;
use App\Model\Service;
use App\Model\ServiceLog;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Facades\Excel;

class SampleStorageController extends Controller
{


    public function index(){

        $send_to_services = [
			'Send to BWM'=> 'Send to BWM',
            '1' => 'ZN Microscopy',
            '2' => 'FM Microscopy',
			'6'=> 'Decontamination',
            '3' => 'Liquid Culture',
            '4' => 'Solid Culture',
            '5' => 'Solid and Liquid Culture',
            '8' => 'LPA 1st line',
            '10' => 'LPA 2nd line',
            // '7' => 'For storage',
            '9'=>'Cbnaat'
            
			
        ];

        $service_log_query = ServiceLog::scopes()
            ->with(['service', 'enroll', 'sample'])
            ->filters()
            ->where('service_id', ServiceLog::TYPE_STORAGE)
            //->where('status', ServiceLog::STATUS_STORAGE)
			->whereIn('status', [ServiceLog::STATUS_ACTIVE,ServiceLog::STATUS_STORAGE])
			->whereNull('sent_to')
            ->orderBy('enroll_label', 'desc');


        if( request('download') ){

            $service_logs = $service_log_query->get();

            return Excel::create('Sample Storage', function( $excel ) use ( $service_logs ) {

                $excel

                    ->setTitle( 'Sample Storage' )
                    ->setCreator('LIMS')
                    ->setCompany('UFLIX DESIGN')

                    ->sheet('Sample Storage', function( LaravelExcelWorksheet $sheet ) use( $service_logs ) {

                        $sheet->setAllBorders();

                        // Headings ==================
                        $sheet->appendRow([ 'Enrollment ID', 'Sample ID', 'Patient Name', 'Date of Storage', 'Sample Sent From']);

                        // Rows ==================

                        foreach ( $service_logs as $service_log ){

                            $row = [
                                $service_log->enroll->label, // Enrollment ID
                                $service_log->sample->sample_label, // Sample ID
                                $service_log->patient_name, // Patient Name
                                $service_log->created_at->format('d/m/Y'), // Test Request
                                $service_log->previous_log->service->name ?? 'Sample Opening', // Comments
                            ];

                            $sheet->appendRow($row);

                        }

                        // Styling ===================
                        $sheet->row(1, function( $cells ){
                            $cells->setFontWeight('bold');
                            $cells->setBackground('cccccc');
                        });

                    });


            })->download('xlsx');
        }

       //$service_logs = $service_log_query->toSql();
	   //dd($service_logs);
       $service_logs = $service_log_query->paginate();

        return view('admin.sample-storage.index', compact('service_logs', 'send_to_services'));

    }


}