<?php

namespace App\Http\Controllers\Web\Admin;


use App\Http\Controllers\Controller;
use App\Model\ServiceLog;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Facades\Excel;

class BioWasteSampleController extends Controller
{



    public function index(){

        $status = request('status', ServiceLog::STATUS_ACTIVE);

        $query = ServiceLog::scopes()
            ->with(['service', 'enroll', 'sample'])

            ->where('service_id', ServiceLog::TYPE_BWM)
            ->where('status', $status);


        $service_logs = ( $status === ServiceLog::STATUS_ACTIVE ) ? $query->get() : $query->paginate();

        if (\request('download')){

            return Excel::create('BWM Samples', function( $excel ) use ( $service_logs ) {

                $excel

                    ->setTitle( 'BWM Samples' )
                    ->setCreator('LIMS')
                    ->setCompany('UFLIX DESIGN')

                    ->sheet('BWM Samples', function( LaravelExcelWorksheet $sheet ) use( $service_logs ) {

                        $sheet->setAllBorders();

                        // Headings ==================
                        $sheet->appendRow([ 'Enrollment ID', 'Sample ID', 'Patient Name', 'Sent From', 'Comments']);

                        // Rows ==================

                        foreach ( $service_logs as $service_log ){

                            $row = [
                                $service_log->enroll->label, // Enrollment ID
                                $service_log->sample->sample_label, // Sample ID
                                $service_log->patient_name, // Patient Name
                                $service_log->previous_step ?? 'From Sample Opening', // Sent From
                                ( $service_log->previous_step ?? NULL ) ? $service_log->previous_log->comments : $service_log->sample->rejection
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


        return view('admin.biowaste-sample.index', compact( 'status', 'service_logs' ));

    }


    public function store(){

        $selected = \request('selected', []);

        ServiceLog::query()
            ->whereIn('id', $selected)
            ->where('status', ServiceLog::STATUS_ACTIVE)
            ->update(['status' => ServiceLog::STATUS_COMPLETE]);

        return back();

    }

}