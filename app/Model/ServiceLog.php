<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Responce;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class ServiceLog
 * @package App\Model
 *
 * @property int $id
 * @property int service_id
 * @property int $sample_id
 * @property Service $service
 * @property Enroll $enroll
 * @property Sample $sample
 * @property \App\Model\ServiceLog $previous_log
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $enroll_id
 * @property string $patient_name
 */
class ServiceLog extends Model {

    protected $table = 't_service_log';
    protected $fillable = ['enroll_id', 'created_by', 'updated_by', 'sample_id', 'service_id', 'status', 'enroll_label', 'sample_label', 'tag', 'reported_dt', 'previous_step','rec_flag','sent_to'];


    // Type Constants ===========================
    const TYPE_DECONTAMINATION      = 3;
    const TYPE_CBNAAT               = 4;
    const TYPE_AFB_CULTURE          = 5;
    const TYPE_LPA_1ST_LINE         = 6;
    const TYPE_LPA_2ND_LINE         = 7;
    const TYPE_DNA_EXTRACTION       = 8;
    const TYPE_STORAGE              = 11;
    const TYPE_LPA_INTERPRETATION   = 15;
    const TYPE_CULTURE_INOCULATION  = 16;
    const TYPE_BWM                  = 26;

    // Status Constants ===========================
    const STATUS_COMPLETE       = 0;
    const STATUS_ACTIVE         = 1;
    const STATUS_STORAGE        = 2;
    const STATUS_INVALIDATE     = 9;


    public static function microscopyLog(Request $request) {
        $logdata = ServiceLog::find($request->service_log_id);
        $data = Microscopy::create([
            'sample_id' => $logdata->sample_id,
            'enroll_id' => $logdata->enroll_id,
            'result' => 'NA',
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id,
            'status' => 2
        ]);
        return $data;
    }

    public static function dnaExtractionLog(Request $request) {
        $logdata = ServiceLog::find($request->service_log_id);
        $data = DNAextraction::create([
            'sample_id' => $logdata->sample_id,
            'enroll_id' => $logdata->enroll_id,
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id,
            'status' => 2
        ]);
        return $data;
    }


    public static function cbnaat( Request $request = NULL ){
        $query = static::query()->where('t_service_log.service_id', ServiceLog::TYPE_CBNAAT);

        // Apply Filters =====================================
        if( $request ){

            // Serial Number.
            if( $request->input('sr_no') ){
                $query->ofCbnaat()->where('t_cbnaat.cbnaat_equipment_name', $request->input('sr_no'));
            }

//            // Contact Email.
//            if( $request->input('contact_email') ){
//                $query->ofCbnaatLab()->where('m_cbnaat_lab_details.contact_email', $request->input('contact_email'));
//            }
//
//            // Contact Number.
//            if( $request->input('contact_no') ){
//                $query->ofCbnaatLab()->where('m_cbnaat_lab_details.contact_no', $request->input('contact_no'));
//            }
//
//            // Contact Name.
//            if( $request->input('contact_name') ){
//                $query->ofCbnaatLab()->where('m_cbnaat_lab_details.contact_name', 'LIKE', like_param( $request->input('contact_name') ));
//            }
//
//            // Lab Address.
//            if( $request->input('lab_addr') ){
//                $query->ofCbnaatLab()->where('m_cbnaat_lab_details.lab_addr', 'LIKE', like_param( $request->input('lab_addr') ));
//            }
//
//            // Lab Name.
//            if( $request->input('lab_name') ){
//                $query->ofCbnaatLab()->where('m_cbnaat_lab_details.lab_name', 'LIKE', like_param( $request->input('lab_name') ));
//            }
//
//            // Date of last calibration.
//            if( $request->input('date_caliberation') ){
//                $query->ofCbnaatLab()->where('m_cbnaat_lab_details.date_caliberation', '>=', $request->input('reporting_year' ));
//            }
//
//            // Reporting Year.
//            if( $request->input('reporting_year') ){
//                $query->ofCbnaatLab()->where('m_cbnaat_lab_details.reporting_year', $request->input('reporting_year' ));
//            }

        }

        return $query;
    }

    protected $scopeHasCbnaat = false;
    public function scopeOfCbnaat( Builder $query ){
        if( $this->scopeHasCbnaat ) return $query;
        $this->scopeHasCbnaat = true;
        return $query->leftjoin('t_cbnaat', 't_cbnaat.enroll_id', 't_service_log.enroll_id');
    }

    protected $scopeHasCbnaatLab = false;
    public function scopeOfCbnaatLab( Builder $query ){
        if( $this->scopeHasCbnaatLab ) return $query;
        $this->scopeHasCbnaatLab = true;
        return $query->ofCbnaat()->leftjoin('m_cbnaat_lab_details', 't_cbnaat.cbnaat_equipment_name', 'm_cbnaat_lab_details.sr_no');
    }

    protected $scopeHasServiceRequest = false;
    public function scopeOfServiceRequest( Builder $query ){
        if( $this->scopeHasServiceRequest ) return $query;
        $this->scopeHasServiceRequest = true;
        return $query->leftJoin('t_request_services', 't_request_services.enroll_id', 't_service_log.enroll_id' );
    }

    protected $scopeHasEnroll = false;
    public function scopeOfEnroll( Builder $query ){
        if( $this->scopeHasEnroll ) return $query;
        $this->scopeHasEnroll = true;
        return $query->join('enrolls', 't_service_log.enroll_id', 'enrolls.id');
    }

    protected $scopeHasPatient = false;
    public function scopeOfPatient( Builder $query ){
        if( $this->scopeHasPatient ) return $query;
        $this->scopeHasPatient = true;
        return $query->ofEnroll()->join('patient', 'enrolls.patient_id', 'patient.id');
    }

    protected $scopeHasSample = false;
    public function scopeOfSample( Builder $query ){
        if( $this->scopeHasSample ) return $query;
        $this->scopeHasSample = true;
        return $query->join('sample', 't_service_log.enroll_id', 'sample.enroll_id');
    }

    protected $scopeHasReqTest = false;
    public function scopeOfReqTest( Builder $query ){
        if( $this->scopeHasReqTest ) return $query;
        $this->scopeHasReqTest = true;
        return $query->join('req_test', 't_service_log.enroll_id', 'req_test.enroll_id');
    }

    public function scopePresumptiveDxtb( Builder $query ){
        return $query->ofServiceRequest()->whereRaw( DB::raw('FIND_IN_SET( "' . RequestServices::TYPE_PRESUMPTIVE . '", t_request_services.diagnosis )') );
    }

    public function scopePresumptiveDrtb( Builder $query ){
        return $query->ofServiceRequest()->where(function( $query ){
            $query->where('t_request_services.type_of_prsmptv_drtb', '!=', '')
                ->orWhere('t_request_services.prsmptv_xdrtv', '!=', '');
        });
    }

    public function scopePaediatric( Builder $query ){
        return $query->ofPatient()->where('patient.age', '<', 15);
    }

    public function scopeNonPaediatric( Builder $query ){
        return $query->ofPatient()->where('patient.age', '>=', 15);
    }

    public function scopeMtbNegetive( Builder $query ){
        return $query->ofCbnaat()->where('t_cbnaat.result_MTB', 'MTB Not Detected');
    }

    public function scopeMtbPositive( Builder $query ){
        return $query->ofCbnaat()->where('t_cbnaat.result_MTB', 'MTB Detected');
    }

    public function scopeMtbInvalid( Builder $query ){
        return $query->ofCbnaat()->where('t_cbnaat.result_MTB', 'Invalid');
    }

    public function scopeMtbNoResult( Builder $query ){
        return $query->ofCbnaat()->where('t_cbnaat.result_MTB', 'No Result');
    }

    public function scopeMtbError( Builder $query ){
        return $query->ofCbnaat()->where('t_cbnaat.result_MTB', 'Error');
    }

    public function scopeRifNegetive( Builder $query ){
        return $query->ofCbnaat()->where('t_cbnaat.result_RIF', 'RIF Not Detected');
    }

    public function scopeRifPositive( Builder $query ){
        return $query->ofCbnaat()->where('t_cbnaat.result_RIF', 'RIF Detected');
    }

    public function scopeRifIndeterminate( Builder $query ){
        return $query->ofCbnaat()->where('t_cbnaat.result_RIF', 'RIF Indeterminate');
    }

    public function scopeHivNegetive( Builder $query ){
        return $query->ofPatient()->where('patient.hiv_test', 'Pos');
    }

    public function scopeHivPositive( Builder $query ){
        return $query->ofPatient()->where('patient.hiv_test', '!=', 'Pos');
    }

    public function scopeEptb( Builder $query ){
        return $query->ofSample()->whereNotIn('sample.sample_type', [ 'Sputum', 'AFB MTB positive culture (LJ or LC)', 'BAL' ]);
    }

    public function scopePublicSector( Builder $query ){
        return $query->ofPatient()->where('patient.sector_radio', 'public');
    }

    public function scopePrivateSector( Builder $query ){
        return $query->ofPatient()->where('patient.sector_radio', 'private');
    }

    public function scopeNewPatient( Builder $query ){
        return $query->ofServiceRequest()->where('t_request_services.regimen', 'New');
    }

    public function scopePresumptiveDrtbAtDiagnosis( Builder $query ){
        return $query->ofServiceRequest()->where('t_request_services.type_of_prsmptv_drtb', 'At Diagnosis');
    }

    public function scopePresumptiveDrtbOthers( Builder $query ){
        return $query->ofServiceRequest()->where('t_request_services.type_of_prsmptv_drtb', '!=', 'At Diagnosis');
    }

    public function scopePreviouslyTreated( Builder $query ){
        return $query->ofServiceRequest()->where('t_request_services.type_of_prsmptv_drtb', 'Previously Treated');
    }


    /**
     * @param Builder $query
     * @param $name
     * @return $this
     */
    public function scopeMonthlySelect( Builder $query, $name ){
        return $query->select(
            DB::raw('sum(MONTH(t_service_log.created_at)="01") as '. $name .'_01'),
            DB::raw('sum(MONTH(t_service_log.created_at)="02") as '. $name .'_02'),
            DB::raw('sum(MONTH(t_service_log.created_at)="03") as '. $name .'_03'),
            DB::raw('sum(MONTH(t_service_log.created_at)="04") as '. $name .'_04'),
            DB::raw('sum(MONTH(t_service_log.created_at)="05") as '. $name .'_05'),
            DB::raw('sum(MONTH(t_service_log.created_at)="06") as '. $name .'_06'),
            DB::raw('sum(MONTH(t_service_log.created_at)="07") as '. $name .'_07'),
            DB::raw('sum(MONTH(t_service_log.created_at)="08") as '. $name .'_08'),
            DB::raw('sum(MONTH(t_service_log.created_at)="09") as '. $name .'_09'),
            DB::raw('sum(MONTH(t_service_log.created_at)="10") as '. $name .'_10'),
            DB::raw('sum(MONTH(t_service_log.created_at)="11") as '. $name .'_11'),
            DB::raw('sum(MONTH(t_service_log.created_at)="12") as '. $name .'_12')
        );
    }


    // Attributes ==================================
    public function getPreviousLogAttribute(){
        /** @var static $previous_log */

        $previous_log = static::query()

            ->with('service')
            ->where( 'enroll_id', $this->enroll_id )
            ->where( 'sample_id', $this->sample_id )
            ->where( 'service_id', '!=', $this->service_id )
            ->where( 'id', '<=', $this->id )
            ->orderBy( 'id', 'desc' )
            ->first();

        return $previous_log;
    }


    public static function scopes(){
        return static::query()->where(DB::raw('1'), DB::raw('1'));
    }



    public function scopeFilters( Builder $query ){

        if( \request('q') ){

            $search = like_param( \request('q') );

            $query->where(function( Builder $query ) use ( $search ){

                $query->orWhereHas('enroll', function( Builder $query ) use ( $search ){
                    $query->where('label', 'LIKE', $search );
                });

                $query->orWhereHas('sample', function( Builder $query ) use ( $search ){
                    $query->where('sample_label', 'LIKE', $search );
                });

            });
        }

    }



    // Relations ===================================

    public function service(){
        return $this->belongsTo( Service::class, 'service_id', 'id' );
    }

    public function enroll(){
        return $this->belongsTo( Enroll::class, 'enroll_id', 'id' );
    }

    public function sample(){
        return $this->belongsTo( Sample::class, 'sample_id', 'id' );
    }



    // Attributes ==================================
    public function getPatientNameAttribute(){
        $name = '';
        if( !empty( $this->enroll->patient->firstname ?? NULL ) ){
            $name = trim( $this->enroll->patient->firstname . ' ' . $this->enroll->patient->surname );
        }

        if( empty( $name ) ){
            $name = $this->sample->name;
        }

        return $name;
    }

}
