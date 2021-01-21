<?php

namespace App\Http\Controllers\Web\Admin\Logistics;


use App\Http\Controllers\Controller;
use App\Model\Logistics\Advice;
use App\Model\Logistics\Config;
use App\Model\Logistics\Receipt;
use App\Model\Logistics\ReceiptItem;
use App\Model\Logistics\ReceiptItemBatch;
use App\Model\Logistics\Requisition;
use App\Model\Logistics\Shipment;
use App\Model\Logistics\ShipmentItem;
use App\Model\Logistics\Stock;
use App\Model\Logistics\StockBatch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceiptController extends Controller
{


    public function index(){

        $shipments = Shipment::with('items', 'lab', 'requisition', 'requisition.items')

            ->where('lab_id', this_lab()->id)

            ->paginate();


        return view('admin.logistics.receipt.index', compact('shipments'));
    }


    public function show( Shipment $shipment ){
        return view('admin.logistics.receipt.show', compact('shipment'));
    }


    public function received( Request $request, Shipment $shipment ){

        // dd( $request->all(), $shipment->advice );


        $this->validate($request, [
            'received.*' => '',
        ]);


        DB::transaction(function() use ( $request, $shipment ){


            $receipt_request = $request->received;

            $receipt = new Receipt([
                'lab_id' => this_lab()->id,
                'receipt_date' => Carbon::today(),
            ]);

            $receipt->receipt_no    = Config::nextNumber( Receipt::NUMBER_PREFIX, $shipment->lab->name );
            $receipt->doc_type      = $shipment->advice->advice_type;
            $receipt->document_no   = $shipment->shipment_no;
            $receipt->document_date = $shipment->shipment_date;
            $receipt->user_id       = auth()->user()->id;

            $receipt->saveOrFail();


            $total_accepted_quantity = 0;

            /** @var ShipmentItem $shipment_item */
            foreach ( $shipment->items as $shipment_item ){


                $receipt_request_item = $receipt_request[ $shipment_item->item_code ];

                if( $shipment_item->detail->has_batches AND empty( $receipt_request_item['batches'] ) ) continue;
                else if( empty( $receipt_request_item['quantity'] ) ) continue;


                $requisition_item = $shipment_item->requisition_item;


                $receipt_item = new ReceiptItem();

                $receipt_item->receipt_id   = $receipt->id;
                $receipt_item->item_code    = $shipment_item->item_code;
                $receipt_item->shipment_qty = $shipment_item->shipment_qty;
                $receipt_item->lab_id       = this_lab()->id;

                $receipt_item->saveOrFail();


                /** @var Stock $stock_item */
                $stock_item = Stock::query()->firstOrCreate([
                    'item_code' => $shipment_item->item_code,
                ],[
                    'op_stock' => 0,
                    're_order' => 0,
                    'rcp_for_lab' => 0,
                    'rcp_oth_site' => 0,
                    'isu_for_lab' => 0,
                    'isu_oth_site' => 0,
                    'current_stock' => 0,
                    'user_id' => auth()->user()->id,
                    'lab_id' => this_lab()->id,
                ]);



                $accepted_quantity = 0;

                if( $shipment_item->detail->has_batches ){

                    $batches = json_decode( $receipt_request_item['batches'] );
                    if( !$batches ) continue;

                    foreach ( $batches as $key => $batch ){
                        if( $batch->received === 0 ) continue;
                        $accepted_quantity += $batch->received;

                        $receipt_batch_item = new ReceiptItemBatch();

                        $receipt_batch_item->receipt_item_id    = $receipt_item->id;
                        $receipt_batch_item->lot_no             = $batch->lot;
                        $receipt_batch_item->expiry_on          = $batch->date;
                        $receipt_batch_item->despatch_qty       = $batch->quantity;
                        $receipt_batch_item->accept_qty         = $batch->received;
                        $receipt_batch_item->reject_qty         = $batch->quantity - $batch->received;
                        $receipt_batch_item->user_id            = auth()->user()->id;
                        $receipt_batch_item->lab_id             = this_lab()->id;
                        $receipt_batch_item->remarks            = $batch->remarks;

                        $receipt_batch_item->saveOrFail();



                        // Item Stock Batch Item -------------------
                        $stock_batch_item = new StockBatch([
                            'lab_id'    => this_lab()->id,
                            'item_code' => $stock_item->item_code,
                            'lot_no'    => $batch->lot,
                            'lot_qty'   => $batch->received,
                            'expiry_on' => $batch->date,
                            'user_id'   => auth()->user()->id,
                        ]);

                        $stock_batch_item->saveOrFail();


                    }
                } else{
                    $accepted_quantity = $receipt_request_item['quantity'];
                }




                // Update accepted quantity based on type (batch-able or not) of item. =====
                $receipt_item->accepted_qty = $accepted_quantity;
                $receipt_item->rejected_qty = $receipt_item->shipment_qty - $accepted_quantity;
                $receipt_item->saveOrFail();



                // Update Stock --------------
                $stock_item->current_stock += $accepted_quantity;
                $stock_item->saveOrFail();



                if( $requisition_item ){
                    $requisition_item->received_qty = $accepted_quantity;
                    $requisition_item->saveOrFail();
                }

                $total_accepted_quantity += $accepted_quantity;

                // =========================================================================


            }


            // Update the status of requisition based on total accepted & requisition.
            $requisition = $shipment->requisition;

            if( $requisition ){

                if( $requisition->total_requested_quantity === $total_accepted_quantity ){
                    $requisition->status = Requisition::STATUS_COMPLETE;
                }else{
                    $requisition->status = Requisition::STATUS_PARTIAL;
                }

                $requisition->saveOrFail();
            }

            $shipment->status = Shipment::STATUS_RECEIVED;
            // $shipment->saveOrFail();


        });

        return redirect()->route('logistics.receipt.received.index');

    }


    public function receivedIndex(){

        $receipts = Receipt::query()

            ->where('lab_id', this_lab()->id)

            ->paginate();

        return view('admin.logistics.receipt.received-index', compact('receipts'));

    }

}