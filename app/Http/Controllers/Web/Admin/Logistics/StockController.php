<?php

namespace App\Http\Controllers\Web\Admin\Logistics;

use App\Model\Logistics\Advice;
use App\Model\Logistics\AdviceItem;
use App\Model\Logistics\Config;
use App\Model\Config as ConfigOutside;
use App\Model\Logistics\ItemType;
use App\Model\Logistics\ItemCategory;
use App\Model\Logistics\Item;
use App\Model\Logistics\Uom;
use App\Model\Logistics\Requisition;
use App\Model\Logistics\RequisitionItem;
use App\Model\Logistics\Stock;
use App\Model\Logistics\StockBatch;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Lab;
use App\User;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $cart_mode = \request('mode') ?? 'all';
        $is_grouped = $cart_mode == 'grouped';

        $query = Stock::with(['item', 'item.item_type', 'item.uom', 'item.category', 'lab'])


            // Filters
            ->whereHas('item', function( Builder $query ) use ( $is_grouped ){
                $query->where(DB::raw('1'), DB::raw('1'));
                $query->itemType( \request('type') );
                $query->description( \request('description') );
                $query->code( \request('code') );
                $query->category( \request('category') );
            })

            ->whereHas('lab', function( Builder $query ) use ( $is_grouped ){
                $query->where(DB::raw('1'), DB::raw('1'));

                if( \request('lab') AND !$is_grouped ){
                    $query->lab( \request('lab') );
                }

            });


        if( !$is_grouped ){
            $query->join('t_requisition_hdr', 'm_stock.lab_id', 't_requisition_hdr.lab_id')
                ->where('t_requisition_hdr.status', 'pending')
                ->join('t_requisition_item', 't_requisition_item.requisition_id', 't_requisition_hdr.id')
                ->whereRaw('t_requisition_item.item_code = m_stock.item_code');
        }


        if( $is_grouped ){

            $query

                ->groupBy( 'item_code' )

                ->select([
                    '*',
                    DB::raw('SUM(current_stock) as current_stock'),
                    DB::raw('1 as is_grouped'),
                ]);

        } else{
            $query->groupBy('m_stock.lab_id', 'm_stock.item_code');
        }


        // Get Stock with Pagination -------
        $stock = $query->paginate();

        $labs = Lab::all();
        $item_categories = ItemCategory::all();

        return view(
            'admin.logistics.po-requisition.index',
            compact('stock', 'labs', 'cart_mode', 'is_grouped', 'item_categories')
        );

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['itemtype'] = ItemType::pluck('name','code')->toArray();
        //dd($data['itemtype']);

        $data['lab_data'] = ConfigOutside::select('lab_id','lab_name')
            ->where('status',1)
            ->get();
        $data['lab_arr_data']=(array) null;
        if(!empty($data['lab_data'])) {
            foreach ($data['lab_data'] as $lab_datas) {
                $data['lab_arr_data']=array("lab_id"=>$lab_datas->lab_id,"lab_name"=>$lab_datas->lab_name);
            }
        }
        //dd($data['lab_arr_data']);
        return view('admin.logistics.opening-balance.create',compact('data'));
    }
    //Ajax call
    // Fetch records according to the itemtype code
    public function getItem($code=0){
        //echo $code; die;
        $data['item_data'] = Stock::select('m_stock.item_code','item.description')
            ->join('m_item as item','item.code','=','m_stock.item_code')
            ->where('item.item_type_code',$code)
            ->where('m_stock.lab_id',1001)
            ->get();

        $json_data['items']=(array) null;
        if(!empty($data['item_data'])) {
            foreach ($data['item_data'] as $item_datas) {
                $json_data['items'][]=array("item_code"=>$item_datas->item_code,"description"=>$item_datas->description);
            }
        }

        echo json_encode($json_data);
        exit;
    }
    //Ajax call
    // Fetch records  to get item category according as item code
    public function getItemCategory($code=0){
        $itemCategory = ItemCategory::select('name')
            ->where('code', $code)
            ->first();
        $item_cat_json_data='';
        if ($itemCategory) {
            $item_cat_json_data = $itemCategory->name;
        }


        echo json_encode($item_cat_json_data);
        exit;
    }
    //Ajax call
    // Fetch records  to get pack size according as item code
    public function getPackSize($itemcode=0){
        $packsize = Item::select('pack_size')
            ->where('code', $itemcode)
            ->first();
        $packsize_json_data=0;
        if ($packsize) {
            $packsize_json_data = $packsize->pack_size;
        }


        echo json_encode($packsize_json_data);
        exit;
    }

    //Ajax call
    // Fetch records  to get pack size according as item code
    public function getUOM($itemcode=0){
        $uom_data = Uom::select('m_uom.name')
            ->join('m_item as item','item.uom_id','=','m_uom.id')
            ->where('item.code',$itemcode)
            ->first();
        $uom_json_data=0;
        if ($uom_data) {
            $uom_json_data = $uom_data->name;
        }


        echo json_encode($uom_json_data);
        exit;
    }

    //Ajax call
    // Fetch records  to get batch details according as item code and labid
    public function getBatchDetails($labid=0,$itemcode=0){
        $data['batch_data'] = StockBatch::select('lot_no','expiry_on','lot_qty')
            ->where('lab_id', $labid)
            ->where('item_code', $itemcode)
            ->orderBy('expiry_on', 'ASC')
            ->get();
        $json_data['batch_data_item']=(array) null;
        if(!empty($data['batch_data'])) {
            foreach ($data['batch_data'] as $batch_datas) {
                $json_data['batch_data_item'][]=array("lot_no"=>$batch_datas->lot_no,"expiry_on"=>$batch_datas->expiry_on,"lot_qty"=>$batch_datas->lot_qty);
            }
        }


        echo json_encode($json_data);
        exit;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $stocks = Stock::updateOrCreate(array('lab_id' => $request->labid,'item_code' => $request->ItemCode),array('op_stock' => $request->opening_balance,'current_stock' => $request->opening_balance));
        if($request->itemtype=='C')
        {
            $hid_lot_no =  $request->hid_lot_no;
            $hid_lot_qty =  $request->hid_lot_qty;
            $hid_expiry_in =  $request->hid_expiry_in;
            if(count($hid_lot_no) > count($hid_lot_qty)){
                $count = count($hid_lot_qty);
            }else {
                $count = count($hid_lot_no);
            }

            for($i = 0; $i < $count; $i++){
                $stockbatchs = StockBatch::updateOrCreate(array('lab_id' => $request->labid,'item_code' => $request->ItemCode,'lot_no' => $hid_lot_no[$i]),array('lot_qty' => $hid_lot_qty[$i],'expiry_on' => $hid_expiry_in[$i]));

            }

        }
        return redirect('/logistics/item/opening-balance')->with('message', 'Success!');;
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




    public function requisitionIndex( Request $request ){

        $this->validate($request, [
            'lab' => 'nullable',
            'code' => 'required',
        ]);

        $lab = $request->lab;
        $code = $request->code;


        $query = RequisitionItem::scopes()
            ->with(['detail', 'requisition', 'requisition.lab']);

        $query->where('item_code', $code);

        $query->whereHas('requisition', function( $query ) use ( $lab ) {
            $query->where('status', Requisition::STATUS_PENDING);
            if( $lab ){
                $query->where('lab_id', $lab);
            }
        });


        return $query->get();

    }



    protected function cart( $data = NULL ){
        $mode = \request('mode') ?? 'all';
        $cart_key = "logistics.po-requisition.cart.$mode";
        if( $data !== NULL ) session( [ $cart_key => $data ] );
        return session($cart_key, []);
    }


    public function cartIndex(){

        $cart_mode = \request('mode') ?? 'all';
        $is_grouped = $cart_mode == 'grouped';

        $cart = $this->cart();

        if( \request()->ajax() ){
            return $cart;
        }

        foreach ( $cart as $key => $item ){

            $query = Stock::scopes()

                ->with(['item', 'item.item_type', 'item.uom', 'lab'])

                ->itemCode( $item['code'] );



            if( $item['lab'] ){ // Single Lab
                $query->where( 'lab_id', $item['lab'] );

            }else{ // Grouped

                $query->groupBy( 'item_code' )

                    ->select([
                        '*',
                        DB::raw('SUM(current_stock) as current_stock'),
                        DB::raw('AVG(re_order) as re_order_avg'),
                        DB::raw('AVG(op_stock) as op_stock'),
                        DB::raw('SUM(isu_for_lab) as isu_for_lab'),
                        DB::raw('SUM(isu_oth_site) as isu_oth_site'),
                        DB::raw('1 as is_grouped'),
                    ]);
            }

            $cart[ $key ]['stock_item'] = $query->first();

        }

        return view('admin.logistics.po-requisition.cart', compact('cart', 'cart_mode', 'is_grouped'));

    }


    public function cartAdd( Request $request ) {

        $this->validate( $request, [
            'code' => 'required',
            'lab' => 'nullable',
            'quantity' => 'required|min:0.01',
        ] );


        $quantity = floatval( $request->quantity ) ?? 0.0;

        $cart = $this->cart();

        $item = [
            'code' => $request->code,
            'lab' => $request->lab,
            'quantity' => $quantity
        ];

        if( $request->grouped ){
            $key = $request->code;
        }else{
            $key = $request->code . '-' . ($request->lab ?? 'grouped');
        }

        if( isset( $cart[ $key ] ) ){
            $item['quantity'] += $cart[$key]['quantity'];
        }

        $cart[ $key ] = $item;

        $this->cart( $cart );

        return $this->cart();
    }


    public function cartRemove( $index ) {

        $cart = $this->cart();

        if( isset( $cart[ $index ] ) ){
            unset( $cart[ $index ] );
        }

        $this->cart( $cart );

        return back();
    }


    public function cartClear(){
        $this->cart([]);
        return back();
    }


    /**
     * @param Request $request
     * @throws \Throwable
     */
    public function generatePO(Request $request ){

        $this->validate( $request, [
            'mode' => 'required',
            'quantity.*' => 'nullable|min:0.01'
        ]);


        DB::transaction(function() use ($request) {


            $mode = $request->mode;
            $cart = $this->cart();
            $quantities = collect( $request->quantity )->filter(function( $quantity ){ return $quantity > 0; });


            $purchase_advice = new Advice();
            $purchase_advice->advice_no = Config::nextNumber( Advice::PURCHASE_NUMBER_PREFIX, 'CENTRAL' );
            $purchase_advice->advice_type = Advice::TYPE_PURCHASE;
            $purchase_advice->user_id = auth()->user()->id;
            $purchase_advice->saveOrFail();

            foreach ( $cart as $key => $item ){
                $purchase_advice->items()->save(new AdviceItem([
                    'item_code'  => $item['code'],
                    'advice_qty' => $quantities[ $key ],
                    'to_lab_id'  => $mode == 'grouped' ? NULL : $item['lab'],
                ]));
            }


            session()->flash('logistics.advice.new', $purchase_advice);
            $this->cart([]);

        });

        return back();

    }

}
