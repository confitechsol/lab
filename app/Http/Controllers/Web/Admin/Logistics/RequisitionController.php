<?php

namespace App\Http\Controllers\Web\Admin\Logistics;

use App\Http\Controllers\Controller;
use App\Model\Logistics\CentralItem;
use App\Model\Logistics\Config;
use App\Model\Logistics\Item;
use App\Model\Logistics\Requisition;
use App\Model\Logistics\RequisitionItem;
use App\Model\Logistics\SentTo;
use App\Model\Logistics\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequisitionController extends Controller
{


    /**
     * List of all cart items.
     *
     * @return array
     */
    public function cartIndex(){
        $cart = session('logistics.requisition.cart', []);

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
        $sent_tos = SentTo::all();

        return view('admin.logistics.requisition.cart', compact( 'stock', 'cart', 'sent_tos' ));
    }


    /**
     * Add to Requisition Cart
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

        $cart = session('logistics.requisition.cart', []);

        if( !isset( $cart[ $item->code ] ) ){
            $cart[ $item->code ] = 0;
        }

        $cart[ $item->code ] += $quantity;

        session([ 'logistics.requisition.cart' => $cart ]);

        return $cart;

    }

    /**
     * Update Requisition Cart
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

        $cart = session('logistics.requisition.cart', []);

        $cart[ $item->code ] = $quantity;

        session([ 'logistics.requisition.cart' => $cart ]);

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

        $cart = session('logistics.requisition.cart', []);

        if( isset( $cart[ $code ] ) ){
            unset( $cart[ $code ] );
        }

        session([ 'logistics.requisition.cart' => $cart ]);

        return $cart;
    }


    public function cartClear(){
        session([ 'logistics.requisition.cart' => [] ]);
        return back();
    }



    public function generate( Request $request ){

//        dd( $request->all() );

        $this->validate( $request, [
            'item.*' => 'required|numeric',
            'sent_to' => 'required|numeric',
        ]);

        $lab = this_lab();
        $requisition = NULL;

        DB::transaction(function() use ( &$requisition, $lab ){

            $requisition = new Requisition();
            $requisition->requisition_no = Config::nextNumber( Requisition::NUMBER_PREFIX, $lab->name );
            $requisition->lab_id = $lab->id;
            $requisition->status = 'pending';
            $requisition->user_id = auth()->user()->id;
            $requisition->sent_to = \request('sent_to');

            $requisition->saveOrFail();

            $req_items = \request('item');
            $items = Item::with('stock')
                ->whereIn( 'code', array_keys( $req_items ) )
                ->get();

            foreach ( $items as $item ){


                /** @var Item $item */
                $req_item = new RequisitionItem([
                    'requisition_id' => $requisition->id,
                    'item_type_code' => $item->item_type_code,
                    'item_code' => $item->code,
                    'current_stock' => $item->stock->current_stock ?? 0,
                    'required_qty' => $req_items[ $item->code ],
                ]);

                $req_item->user_id = auth()->user()->id;
                $req_item->saveOrFail();

            }


            session()->flash('logistics.requisition.new', $requisition);

        });


        session([ 'logistics.requisition.cart' => [] ]);

        if( $requisition ){
            return redirect( route('logistics.requisition.index') );
        }

        return back();

    }



    public function index(){

        $query = Requisition::scopes()

            // Filters --------------

            ->lab( \request('lab') )

            ->requisitionNumber( \request('requisition_no') )

            ->status( \request('status') )

            ->sentTo( \request('sent_to') );

        // This is not from state labs -----
        if( this_lab() ){
            $query->where( 'lab_id', this_lab()->id );
        }

        $query->orderBy('requisition_no', 'DESC');

        $requisitions = $query->paginate();

        return view('admin.logistics.requisition.index', compact( 'requisitions' ));
    }


    public function show( Requisition $requisition ){
        return view('admin.logistics.requisition.show', compact( 'requisition' ));
    }



    public function centralItems( Request $request ){

        $this->validate($request, [
            'code' => 'required',
            'lab_id' => 'required',
        ]);

        $stock = Stock::scopes()
            ->where( 'lab_id', '!=', $request->lab_id )
            ->where( 'item_code', $request->code )
            ->get();

        $items = $stock->map(function( $stock_item ){
            $item = $stock_item->item;
            $item->current_stock = $stock_item->current_stock;
            $item->effective_stock = $stock_item->current_stock;
            $item->lab = $stock_item->lab;
            return $item;
        });

        return $items;

    }


}