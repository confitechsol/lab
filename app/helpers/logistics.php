<?php


if( !function_exists('logistics_item_types') ){

    function logistics_item_types(){
        $types = config('logistics.item-types');
        if( !$types ){
            $types = \App\Model\Logistics\ItemType::all()->pluck('name', 'code');
            config([ 'logistics.item-types' => $types ]);
        }
        return $types;
    }

}

if( !function_exists('this_lab') ){

    /**
     * @return \App\Model\Lab|false|NULL
     */
    function this_lab(){

        // return false;
         //if( auth()->user()->id == 1 ) return false;


        $this_lab = config('logistics.cache.lab');
        if( $this_lab ) return $this_lab;

        /** @var \App\Model\Config $this_lab */
        $this_lab = \App\Model\Config::query()->where('status', 1)->first();
        $this_lab = \App\Model\Lab::find( $this_lab->lab_id );

        /** @var \App\Model\Lab $this_lab */
        config(['logistics.cache.lab' => $this_lab]);

        return $this_lab;
    }

}
if( !function_exists('central_lab') ){

    /**
     * @return \App\Model\Lab|false|NULL
     */
    function central_lab(){

        $central_lab = config('logistics.cache.central');
        if( $central_lab ) return $central_lab;

        /** @var \App\Model\Config $central_lab */
        $central_lab = \App\Model\Logistics\SentTo::find(2); // 2 => FIND (HARDCODED)

        /** @var \App\Model\Lab $central_lab */
        config(['logistics.cache.central' => $central_lab]);

        return $central_lab;
    }

}

if( !function_exists('logistics_vendors') ){

    /**
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function logistics_vendors( $type = 'V' ){
        /** \Illuminate\Database\Eloquent\Collection */
        return \App\Model\Logistics\Vendor::query()->where('vendor_type', $type)->get();
    }

}