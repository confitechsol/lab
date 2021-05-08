<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cbnaat extends Model
{
	protected $table = 't_cbnaat';
    protected $fillable = ['enroll_id','sample_id','nikshay_id','user_id','result_MTB','result_RIF',
		'next_step','status','test_date','created_by','updated_by','error','reason_edit','edit_microbiologist','cbnaat_equipment_name', 'lab_code', 'sample_label', 'comments', 'final_interpretation'];

    // public static function cbnaat_list(){
    //     try{
    //     	$name = Cbnaat::select('name as name')->first();
	   //      $user = $name->name;
	   //      $data['user'] = $user;
    //     	$cbnaat = Cbnaat::all();
    //   		$data['cbnaat'] = $cbnaat;


    //   		return view('admin.cbnaat.list',compact('data'));

    //     }catch(\Exception $e){

    //         return (['ret'=>[],'err'=>['code'=>1, 'msg'=>$e->getMessage()]]);
    //     }

    // }
	public static function cbnaatsrch( Request $request = NULL ){
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
	 public function scopeMonthlySelect( Builder $query, $name ){
        return $query->select(
            DB::raw('sum(MONTH(t_cbnaat.test_date)="01") as '. $name .'_01'),
            DB::raw('sum(MONTH(t_cbnaat.test_date)="02") as '. $name .'_02'),
            DB::raw('sum(MONTH(t_cbnaat.test_date)="03") as '. $name .'_03'),
            DB::raw('sum(MONTH(t_cbnaat.test_date)="04") as '. $name .'_04'),
            DB::raw('sum(MONTH(t_cbnaat.test_date)="05") as '. $name .'_05'),
            DB::raw('sum(MONTH(t_cbnaat.test_date)="06") as '. $name .'_06'),
            DB::raw('sum(MONTH(t_cbnaat.test_date)="07") as '. $name .'_07'),
            DB::raw('sum(MONTH(t_cbnaat.test_date)="08") as '. $name .'_08'),
            DB::raw('sum(MONTH(t_cbnaat.test_date)="09") as '. $name .'_09'),
            DB::raw('sum(MONTH(t_cbnaat.test_date)="10") as '. $name .'_10'),
            DB::raw('sum(MONTH(t_cbnaat.test_date)="11") as '. $name .'_11'),
            DB::raw('sum(MONTH(t_cbnaat.test_date)="12") as '. $name .'_12')
        );
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

}
