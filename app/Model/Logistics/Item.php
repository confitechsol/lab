<?php

namespace App\Model\Logistics;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id
 * @property string $code
 * @property string $description
 * @property string $item_type_code
 * @property ItemType $item_type
 * @property string $pack_size
 * @property integer $uom_id
 * @property Uom $uom
 * @property bool $is_active
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property bool $has_batches
 * @property Stock|Collection $stock
 * @property ItemCategory $category
 */
class Item extends Model
{

    protected $table = 'm_item';

    protected $casts = [
        'uom_id'    => 'integer',
        'is_active' => 'boolean',
        'user_id'   => 'integer',
    ];


    // Relations =========================

    public function item_type(){
        return $this->belongsTo( ItemType::class, 'item_type_code', 'code' );
    }


    public function uom(){
        return $this->belongsTo( Uom::class, 'uom_id' );
    }


    public function getHasBatchesAttribute(){
        return in_array( $this->item_type_code, ['C', 'X'] );
    }


    public function stock(){
        $lab = this_lab();
        if( $lab ){
            return $this->hasOne( Stock::class, 'item_code', 'code' )
                ->where( 'lab_id', $lab->id );
        }

        return $this->hasMany( Stock::class, 'item_code', 'code' );

    }


    public function category(){
        return $this->belongsTo( ItemCategory::class, 'item_category', 'code' );
    }



    // Scopes ============================

    public static function scopes(){
        return static::query()->where(DB::raw('1'), DB::raw('1'));
    }


    public function scopeItemType(Builder $query, $value = NULL ){
        if( !$value ) return $query;
        return $query->where( 'item_type_code', $value );
    }


    public function scopeCategory(Builder $query, $value = NULL ){
        if( !$value ) return $query;
        return $query->where( 'item_category', $value );
    }

    public function scopeDescription(Builder $query, $value = NULL ){
        if( !$value ) return $query;
        return $query->where( 'description', 'LIKE', like_param( $value ) );
    }


    public function scopePackSize(Builder $query, $value = NULL ){
        if( !$value ) return $query;
        return $query->where( 'pack_size', $value );
    }


    public function scopeCode(Builder $query, $value = NULL ){
        if( !$value ) return $query;
        return $query->where( 'code', 'LIKE', like_param( $value ) );
    }

    public function scopeActive(Builder $query){
        return $query->where( 'is_active', true );
    }

}