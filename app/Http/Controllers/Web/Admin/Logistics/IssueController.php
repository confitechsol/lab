<?php

namespace App\Http\Controllers\Web\Admin\Logistics;


use App\Http\Controllers\Controller;
use App\Model\Logistics\Item;
use App\Model\Logistics\ItemCategory;
use App\Model\Logistics\SentTo;
use App\Model\Logistics\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IssueController extends Controller
{



    /**
     * List of all cart items.
     *
     * @return array
     */
    public function cartIndex(){
        $cart = session('logistics.issue.cart', []);

        if( \request()->ajax() ){
            return $cart;
        }

        $item_codes = array_keys( $cart );

        $query = Stock::scopes()

            ->with(['item', 'item.item_type', 'item.uom'])

            ->whereHas('item', function( $query ){
                $query->active();
            })

            ->whereIn('item_code', $item_codes);

        // This is not from state labs -----
        if( this_lab() ){
            $query->where( 'lab_id', this_lab()->id );
        }


        $stock = $query->get();

        return view('admin.logistics.issue.cart', compact( 'stock', 'cart' ));
    }


    /**
     * Add to issue Cart
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function cartAdd(Request $request ){

        $this->validate($request, [
            'code' => 'required',
            'quantity' => 'nullable|numeric|min:1'
        ]);


        /** @var Item $item */
        $item = Item::scopes()
            ->active()
            ->code( $request->code )
            ->firstOrFail();

        $quantity = intval( $request->quantity );
        if( $quantity <= 0 ) $quantity = 1;

        $cart = session('logistics.issue.cart', []);

        if( !isset( $cart[ $item->code ] ) ){
            $cart[ $item->code ] = 0;
        }

        $cart[ $item->code ] += $quantity;

        session([ 'logistics.issue.cart' => $cart ]);

        return $cart;

    }

    /**
     * Update issue Cart
     *
     * @param Request $request
     * @param Item $item
     * @return mixed
     * @throws \Exception
     */
    public function cartUpdate(Request $request, $code ){

        $this->validate($request, [
            'quantity' => 'nullable|numeric|min:1'
        ]);

        $item = Item::scopes()
            ->code( $code )
            ->active()
            ->firstOrFail();

        $quantity = intval( $request->quantity );
        if( $quantity <= 0 ) $quantity = 1;

        $cart = session('logistics.issue.cart', []);

        $cart[ $item->code ] = $quantity;

        session([ 'logistics.issue.cart' => $cart ]);

        return $cart;
    }


    /**
     * Remove item from cart.
     *
     * @param Request $request
     * @param Item $item
     * @return mixed
     */
    public function cartRemove( Request $request, $code ){

        $cart = session('logistics.issue.cart', []);

        if( isset( $cart[ $code ] ) ){
            unset( $cart[ $code ] );
        }

        session([ 'logistics.issue.cart' => $cart ]);

        return $cart;
    }


    public function cartClear(){
        session([ 'logistics.issue.cart' => [] ]);
        return back();
    }
    
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


//        return view('admin.logistics.issue');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


        return view('admin.logistics.issue.stock');

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


    public function stock(){


        $stock = Stock::scopes()

            // Relationships -------
            ->with(['item', 'item.item_type', 'item.uom', 'item.category'])

            // Item Conditions -------
            ->whereHas( 'item', function( $query ) {

                $query

                    // Filters -------
                    ->code( \request('code') )
                    ->itemType( \request('item_type_code') )
                    ->category( \request('category') )
                    ->packSize( \request('pack_size') )
                    ->description( \request('description') )

                    // Active Only -------
                    ->active();

            })

            // Order By
            ->orderBy(DB::raw('`current_stock` - `re_order`'))

            ->where( 'lab_id', this_lab()->id )


            // Pagination -------
            ->paginate()
            ->appends( \request()->all() );


        $cart = session('logistics.issue.cart', []);

        $item_categories = ItemCategory::all();

        return view('admin.logistics.issue.stock', compact('stock', 'cart', 'item_categories'));
    }



}
