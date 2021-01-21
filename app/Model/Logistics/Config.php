<?php

namespace App\Model\Logistics;


use App\Model\Lab;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $fin_code
 * @property string $fin_long
 * @property string $prefix
 * @property int $last_no
 * @property \Carbon\Carbon $start_date
 * @property \Carbon\Carbon $end_date
 */
class Config extends Model
{


    protected $table = 'm_logistic_config';

    public $timestamps = false;


    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];


    /**
     * @param $prefix
     * @return string
     */
    public static function nextNumber( $prefix, $lab ){

        $today = Carbon::now();

        /** @var static $config */
        $config = static::query()
            ->where('prefix', $prefix)
            ->where( 'start_date', '<=', $today->format('Y-m-d') )
            ->where( 'end_date', '>=', $today->format('Y-m-d') )
            ->first();

        $config->last_no++;
        $config->save();

        return "$config->prefix/$lab/$config->fin_code/$config->last_no";
    }

}