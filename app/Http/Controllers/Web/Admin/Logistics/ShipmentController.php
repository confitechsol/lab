<?php

namespace App\Http\Controllers\Web\Admin\Logistics;


use App\Http\Controllers\Controller;
use App\Model\Logistics\Advice;
use App\Model\Logistics\AdviceItem;
use App\Model\Logistics\Config;
use App\Model\Logistics\Shipment;
use App\Model\Logistics\ShipmentItem;
use App\Model\Logistics\ShipmentItemBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Readers\Batch;

class ShipmentController extends Controller
{


    public function index(){



    }




    public function generate( Request $request, Advice $advice ){

        $this->validate($request, [
            'shipments.*' => 'required',
            'shipment_date' => 'required|date_format:Y-m-d',
            'tr_no' => 'required',
            'tr_date' => 'required|date_format:Y-m-d',
            'vendor_id' => 'required|numeric',
        ]);


        $advice->load('items', 'items.detail', 'requisition');

        DB::transaction(function() use( $request, $advice ) {

            $shipment = new Shipment([
                'shipment_date' => $request->shipment_date,
                'tr_no' => $request->tr_no,
                'tr_date' => $request->tr_date,
                'vendor_id' => $request->vendor_id,
            ]);

            // TODO: FIX CHANGES FOR SHIPMENT WHEN DONE DIRECTLY WITHOUT REQUISITION.
            $lab_name = $advice->requisition->lab->name ?? 'CENTRAL';

            $shipment->shipment_no = Config::nextNumber('SHP', $lab_name);
            $shipment->advice_id = $advice->id;
            $shipment->requisition_no = $advice->requisition_no;
            $shipment->lab_id = $advice->requisition->lab_id ?? NULL;

            $shipment->saveOrFail();

            /** @var AdviceItem $advice_item */
            foreach ( $advice->items as $advice_item ){

                // Shipment must be requested on adviced items.
                if( !isset( $request->shipments[ $advice_item->item_code ] ) ) continue;

                $shipment_request = $request->shipments[ $advice_item->item_code ];

                $shipment_request_quantity = $shipment_request['quantity'] ?? 0;
                if( $advice_item->detail->has_batches ){
                    if( !isset( $shipment_request['batches'] ) ) continue;
                    $shipment_request['batches'] = json_decode( $shipment_request['batches'] );
                    if( !$shipment_request['batches'] ) continue;
                    $shipment_request_quantity = 0;
                    foreach ( $shipment_request['batches'] as $batch ){
                        $shipment_request_quantity += $batch->quantity ?? 0;
                    }
                }


                // Do not proceed if $shipment_quantity is 0
                if( $shipment_request_quantity === 0 ) continue;


                $shipment_item = new ShipmentItem([
                    'item_code'     => $advice_item->item_code,
                    'adviced_qty'   => $advice_item->advice_qty,
                    'shipment_qty'  => $shipment_request_quantity,
                ]);

                $shipment_item->shipment_id = $shipment->id;
                $shipment_item->user_id = auth()->user()->id;

                $shipment_item->saveOrFail();

                $advice_item->requisition_item->shipment_qty = $shipment_request_quantity;
                $advice_item->requisition_item->saveOrFail();

                if( $advice_item->detail->has_batches AND !empty( $shipment_request['batches'] ) ){

                    foreach ( $shipment_request['batches'] as $batch){

                        $shipment_item_batch = new ShipmentItemBatch([
                            'lot_no'        => $batch->lot,
                            'expiry_on'     => $batch->date,
                            'shipment_qty'  => $batch->quantity,
                        ]);

                        $shipment_item_batch->shipment_dtl_id = $shipment_item->id;


                        $shipment_item_batch->saveOrFail();

                    }

                }
            }

            session()->flash('logistics.shipment.new', $shipment);


        });

        return redirect( route('logistics.advice.index', $advice->advice_type) );

    }


    public function show( Advice $advice ){

    }


}