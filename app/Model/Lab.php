<?php

namespace App\Model;

use App\Model\Logistics\Requisition;
use App\Model\Logistics\Stock;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\User;

/**
 * @property int $id
 * @property string $name
 * @property string $location
 * @property string $state
 * @property string $name_and_location
 * @property Collection $stock
 * @property Collection $requisitions
 */
class Lab extends Model
{
	protected $table = 'm_lab';
    protected $fillable = ['name', 'lab_code','location'];



    public function stock(){
        return $this->hasMany( Stock::class, 'lab_id', 'id' );
    }

    public function requisitions(){
        return $this->hasMany( Requisition::class, 'lab_id', 'id' );
    }



    // Scopes =================

    public function scopeLab( Builder $query, $value = NULL ){
        if( !$value ) return $query;
        return $query->where( 'id', $value );
    }

    
    public static function lab_list(){
        try{
        	$name = User::select('name as name')->first();
	        $user = $name->name;
	        $data['user'] = $user;
        	$lab = Lab::select('id','name','lab_code','location')->get();    
      		$data['lab'] = $lab;
      		return view('admin.lab.list',compact('data'));
            
        }catch(\Exception $e){

            return (['ret'=>[],'err'=>['code'=>1, 'msg'=>$e->getMessage()]]);
        }

    }


    public function getNameAndLocationAttribute(){
        return "$this->name ($this->location)";
    }

}
