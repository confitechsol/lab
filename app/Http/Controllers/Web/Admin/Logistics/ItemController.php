<?php

namespace App\Http\Controllers\Web\Admin\Logistics;

use App\Model\Logistics\Item;
use App\Model\Logistics\ItemCategory;
use App\Model\Logistics\Stock;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Lab;
use App\User;
use Illuminate\Support\Facades\DB;


class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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


        $cart = session('logistics.requisition.cart', []);

        $item_categories = ItemCategory::all();

        $new_requisition = \request('new_requisition') === 'yes';

        return view('admin.logistics.stock.index', compact('stock', 'cart', 'item_categories', 'new_requisition'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.logistics.item-issue.create');
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


}