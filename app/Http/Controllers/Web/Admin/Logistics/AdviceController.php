<?php

namespace App\Http\Controllers\Web\Admin\Logistics;


use App\Http\Controllers\Controller;
use App\Model\Lab;
use App\Model\Logistics\Advice;
use App\Model\Logistics\AdviceItem;
use App\Model\Logistics\Config;
use App\Model\Logistics\Item;
use App\Model\Logistics\Requisition;
use App\Model\Logistics\Shipment;
use App\Model\Logistics\ShipmentItem;
use App\Model\Logistics\ShipmentItemBatch;
use App\Model\Logistics\Stock;
use App\Model\Logistics\StockBatch;
use App\Model\Logistics\StockTransfer;
use App\Model\Logistics\StockTransferBatch;
use App\Model\Logistics\StockTransferItem;
use App\Model\Logistics\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Readers\LaravelExcelReader;
use PhpParser\Node\Stmt\Return_;
use Ramsey\Uuid\Uuid;

class AdviceController extends Controller
{


    public function indexPurchase(){

        $type = Advice::TYPE_PURCHASE;

        $advices = Advice::scopes()

            // Relationships ================
            ->with(['requisition', 'requisition.lab', 'items', 'user'])

            ->adviceType( Advice::TYPE_PURCHASE )

            ->orderBy( 'advice_no', 'DESC' )

            // Pagination ================
            ->paginate();


        return view('admin.logistics.advice.index', compact('advices', 'type'));

    }


    public function indexTransfer(){

        $type = Advice::TYPE_TRANSFER;

        $advices = Advice::scopes()

            // Relationships ================
            ->with(['requisition', 'requisition.lab', 'items', 'user'])

            ->whereHas('items', function( $query ){
                $query->where('to_lab_id', this_lab()->id);
            })

            ->adviceType( Advice::TYPE_TRANSFER )

            ->orderBy( 'advice_no', 'DESC' )

            // Pagination ================
            ->paginate();


        return view('admin.logistics.advice.index', compact('advices', 'type'));

    }



    public function generate( Request $request ){
        $this->validate($request, [
            'requisition_no' => 'required',
            'advices.*.quantity' => 'nullable|numeric',
            'advices.*.lab' => 'nullable|numeric',
        ]);

        DB::transaction(function(){

            $purchases = [];
            $transfers = [];

            $advice_requests = \request('advices');
            foreach ( $advice_requests as $item_code => $advice_request ){

                if( $advice_request['quantity'] <= 0 ) continue;

                $advice_item = new AdviceItem([
                    'item_code' => $item_code,
                    'advice_qty' => $advice_request['quantity'],
                ]);

                if( !empty( $advice_request['lab'] ) ){
                    $advice_item->to_lab_id = $advice_request['lab'];
                    $transfers[] = $advice_item;
                }else{
                    $purchases[] = $advice_item;
                }

            }


            $advices = [];

            // Transfer Advice =============================
            if( !empty($transfers) ){

                $transfer_advice = new Advice(['requisition_no' => \request('requisition_no')]);

                $transfer_advice->advice_no = Config::nextNumber( Advice::TRANSFER_NUMBER_PREFIX, 'CENTRAL' );
                $transfer_advice->advice_type = Advice::TYPE_TRANSFER;
                $transfer_advice->user_id = auth()->user()->id;
                $transfer_advice->saveOrFail();

                /** @var AdviceItem $transfer */
                foreach ( $transfers as $transfer ){
                    $transfer->advice_id = $transfer_advice->id;
                    $transfer->saveOrFail();

                    $requisition_item = $transfer->requisition_item;
                    $requisition_item->adviced_qty += $transfer->advice_qty;
                    $requisition_item->saveOrFail();
                }

                $transfer_advice->requisition->status = Requisition::STATUS_TRANSFER_ADVICED;
                $transfer_advice->requisition->saveOrFail();

                $advices[] = $transfer_advice;
            }


            // Transfer Adviced
            // Procurement Adviced

            // Purchase Advice =============================
            if( !empty( $purchases ) ){

                $purchase_advice = new Advice(['requisition_no' => \request('requisition_no')]);

                $purchase_advice->advice_no = Config::nextNumber( Advice::PURCHASE_NUMBER_PREFIX, 'CENTRAL' );
                $purchase_advice->advice_type = Advice::TYPE_PURCHASE;
                $purchase_advice->user_id = auth()->user()->id;
                $purchase_advice->saveOrFail();

                /** @var AdviceItem $purchase */
                foreach ( $purchases as $purchase ){
                    $purchase->advice_id = $purchase_advice->id;
                    $purchase->saveOrFail();

                    $requisition_item = $purchase->requisition_item;
                    $requisition_item->adviced_qty += $purchase->advice_qty;
                    $requisition_item->saveOrFail();
                }

                $purchase_advice->requisition->status = Requisition::STATUS_TRANSFER_ADVICED;
                $purchase_advice->requisition->saveOrFail();

                $advices[] = $purchase_advice;
            }

            session()->flash('logistics.advice.new', $advices);

        });

        return back();

    }


    public function show( Advice $advice ){

        $advice->load(['items' => function( $query ){
            $query->where('to_lab_id', this_lab()->id);
        }]);

        return view('admin.logistics.advice.show', compact('advice'));
    }

    public function store( Request $request, Advice $advice ){

        try{

            DB::transaction(function() use ($advice, $request){

                $to_transfer_items = Stock::with('item')
                    ->whereIn('item_code', array_keys( $request->shipments ) )
                    ->where('lab_id', this_lab()->id )->get();

                if( empty( $to_transfer_items ) ) throw new \Exception('No item to transfer');

                /** @var array $transfers */
                $transfers = $request->shipments;


                $transfer = new StockTransfer([
                    'stocktransfer_no' => Config::nextNumber('STK', this_lab()->name),
                    'stocktransfer_date' => Carbon::now(),
                    'advice_no' => $advice->advice_no,
                    'user_id' => auth()->user()->id,
                ]);

                $shipment = new Shipment([
                    'po_no' => '-',
                    'requisition_no' => $advice->requisition_no,
                    'lab_id' => '-',
                    'advice_id' => $advice->id,
                    'shipment_no' => $transfer->stocktransfer_no,
                    'shipment_date' => $transfer->stocktransfer_date,
                    'vendor_name' => '-',
                    'courier_name' => Vendor::find($request->vendor_id)->vendor_name,
                    'status' => Shipment::STATUS_PENDING,
                    'user_id' => auth()->user()->id,
                ]);

                $transfer->saveOrFail();
                $shipment->saveOrFail();


                $final_total_transferred = 0;
                
                // TODO: Reduce Stock of items & batches during transfer.
                
                /** @var Stock $stock_item */
                foreach ( $to_transfer_items as $stock_item ){
                    $item = $stock_item->item;


                    $transfers[ $item->code ]['quantity'] = floatval(
                        $transfers[ $item->code ]['quantity']
                    );

                    if( $transfers[ $item->code ]['quantity'] == 0 ){ continue; }

                    // Check if there is enough stock for the transfer --------------------
                    if( $stock_item->current_stock < $transfers[ $item->code ]['quantity'] ){
                        throw new \Exception("Not Enough Stock in $item->description ($item->code)");
                    }

                    /** @var AdviceItem $advice_item */
                    $advice_item = $advice->items->where('item_code', $item->code)->first();

                    $transfer_item = new StockTransferItem([
                        'id' => Uuid::uuid4()->toString(),
                        'stocktransfer_no' => $transfer->stocktransfer_no,
                        'item_code' => $item->code,
                        'from_lab_id' => this_lab()->id,
                        'to_lab_id' => $advice_item->requisition_item->requisition->lab_id,
                        'advice_qty' => $advice_item->advice_qty,
                        'transfer_qty' => $transfers[ $item->code ]['quantity'],
                        'user_id' => auth()->user()->id,
                    ]);

                    $shipment_item = new ShipmentItem([
                        'shipment_id' => $shipment->id,
                        'item_code' => $item->code,
                        'adviced_qty' => $transfer_item->advice_qty,
                        'shipment_qty' => $transfer_item->transfer_qty,
                        'user_id' => auth()->user()->id,
                        'tr_no' => $request->tr_no,
                        'tr_date' => $request->tr_date,
                    ]);

                    if( $shipment->lab_id == '-' ){
                        $shipment->lab_id = $transfer_item->to_lab_id;
                        $shipment->saveOrFail();
                    }

                    $transfer_item->saveOrFail();
                    $shipment_item->saveOrFail();

                    if( $item->has_batches ){

                        $total_transferred_quantity = 0;
                        $batches = $stock_item
                            ->batches()
                            ->notEmpty()
                            ->orderBy('expiry_on')
                            ->get();

                        /** @var StockBatch $batch */
                        foreach ( $batches as $batch ){

                            // If Batch Transfer is complete, then stop any more changes.
                            if( $total_transferred_quantity >= $transfers[ $batch->item_code ]['quantity'] ){
                                break;
                            }


                            $transfer_qty = $transfers[ $batch->item_code ]['quantity'] - $total_transferred_quantity;
                            $transferred_qty = min( $batch->lot_qty, $transfer_qty );
                            $total_transferred_quantity += $transferred_qty;

                            $batch->lot_qty -= $transferred_qty;
                            $batch->saveOrFail();

                            // If there is a transfer, we need to store in transfer =======
                            if( $transferred_qty > 0 ){

                                $transfer_batch = new StockTransferBatch([
                                    'transfer_item' => $transfer_item->id,
                                    'stocktransfer_no' => $transfer->stocktransfer_no,
                                    'item_code' => $item->code,
                                    'lot_no' => $batch->lot_no,
                                    'expiry_on' => $batch->expiry_on,
                                    'batch_lot_qty' => $transferred_qty,
                                    'user_id' => auth()->user()->id,
                                ]);

                                $shipment_batch = new ShipmentItemBatch([
                                    'shipment_dtl_id' => $shipment_item->id,
                                    'lot_no' => $batch->lot_no,
                                    'expiry_on' => $batch->expiry_on,
                                    'shipment_qty' => $transferred_qty,
                                    'user_id' => auth()->user()->id,
                                ]);

                                $transfer_batch->saveOrFail();
                                $shipment_batch->saveOrFail();
                            }


                        }

                        $transfer_item->transfer_qty = $total_transferred_quantity;
                        $shipment_item->shipment_qty = $total_transferred_quantity;
                    }else{
                        $transfer_item->transfer_qty = $transfers[ $item->code ]['quantity'];
                        $shipment_item->shipment_qty = $transfers[ $item->code ]['quantity'];
                    }


                    // Subtract from Stock ======
                    $stock_item->current_stock -= $transfer_item->transfer_qty;
                    $stock_item->saveOrFail();

                    $final_total_transferred += $transfer_item->transfer_qty;

                    $transfer_item->saveOrFail();
                    $shipment_item->saveOrFail();

                }


                if( $final_total_transferred <= 0 ){
                    throw new \Exception('Nothing to be transferred');
                }

                session()->flash(
                    'logistics.advice.transfer.success',
                    "The transfer #$transfer->stocktransfer_no for advice #$advice->advice_no is generated."
                );

            });


        }catch (\Exception $e){
            session()->flash('logistics.advice.transfer.error', "Failed: " . $e->getMessage());
            return back();
        }


        return redirect()->route('logistics.advice.transfer.index');


    }


    public function download( Advice $advice ){

        if( !$advice->is_purchase ) abort(404);


        Excel::create($advice->advice_no, function( $excel ) use ( $advice ) {

            $advice->load(['items.detail', 'items.detail.item_type', 'items.lab']);

            $excel


                ->setTitle( $advice->advice_no )
                ->setCreator('Lims :: Logistics')
                ->setCompany('UFLIX DESIGN')

                ->sheet('P.O. Adv. Summary', function( LaravelExcelWorksheet $sheet ) use( $advice ) {

                    $sheet->setAllBorders();

                    // Headings ==================
                    $sheet->appendRow([
                        'PO Number', 'Advice Number', 'Item Type', 'Item Category', 'Item Code',
                        'Description', 'Procurement Advice Quantity',
                    ]);

                    // Rows ==================

                    $total_row_count = 1;

                    foreach ( $advice->items as $item ){

                        $row = [
                            '', // PO Number
                            $advice->advice_no, // Advice Number
                            $item->detail->item_type->name, // Item Type
                            $item->detail->category->name, // Item Category
                            $item->item_code, // Item Code
                            trim( $item->detail->description ), // Nomenclature
                            $item->advice_qty, // Advice Quantity
                        ];

                        $sheet->appendRow($row);
                        $total_row_count++;

                    }

                    // Styling ===================
                    $sheet->row(1, function( $cells ){
                        $cells->setFontWeight('bold');
                        $cells->setBackground('cccccc');
                    });

                    $sheet->cells("A1", function( $cells ){
                        $cells->setBackground('7c9ac4');
                    });

                    $sheet->cells("A2:A$total_row_count", function( $cells ){
                        $cells->setBackground('adc5e7');
                    });

                    $sheet->cells("B2:G$total_row_count", function( $cells ){
                        $cells->setBackground('eaeaea');
                    });

                })


                ->sheet('P.O. Adv. Details', function( LaravelExcelWorksheet $sheet ) use( $advice ) {


                    $sheet->setAllBorders();

                    // Headings ==================
                    $sheet->appendRow([
                        'PO Number', 'Advice Number', 'Item Type', 'Item Category', 'Item Code',
                        'Description', 'Procurement Advice Quantity', 'Delivery Quantity', 'Lab Code', 'Lab Name',
                        'Vendor Name', 'Batch No.', 'Expiry On', 'Batch Quantity', 'Courier Name',
                        'TR/Docket No.', 'TR/Docket Date',
                    ]);



                    // Rows ==================

                    $all_labs = Lab::all();

                    $total_row_count = 1;

                    foreach ( $advice->items as $item ){

                        if( $item->lab ){
                            $labs = [ $item->lab ];
                        }else{
                            $labs = $all_labs;
                        }

                        foreach ( $labs as $lab ){

                            $row = [
                                '', // PO Number
                                $advice->advice_no, // Advice Number
                                $item->detail->item_type->name, // Item Type
                                $item->detail->category->name, // Item Type
                                $item->item_code, // Item Code
                                trim( $item->detail->description ), // Nomenclature
                                $item->advice_qty, // Advice Quantity
                                '', // Delivery Quantity
                                $lab->id ?? '', // Lab Code
                                $lab->name ?? '', // Lab Name
                                '', // Vendor Name
                                '', // Batch No.
                                '', // Expiry On
                                '', // Batch Quantity
                                '', // Courier Name
                                '', // TR/Docket No.
                                '', // TR/Docket Date
                            ];

                            $sheet->appendRow($row);
                            $total_row_count++;
                        }

                    }

                    // Styling ===================
                    $sheet->row(1, function( $cells ){
                        $cells->setFontWeight('bold');
                        $cells->setBackground('cccccc');
                    });

                    $sheet->cells("A1", function( $cells ){
                        $cells->setBackground('7c9ac4');
                    });

                    $sheet->cells("A2:A$total_row_count", function( $cells ){
                        $cells->setBackground('adc5e7');
                    });

                    $sheet->cells("B2:G$total_row_count", function( $cells ){
                        $cells->setBackground('eaeaea');
                    });

                    $sheet->cells("I2:J$total_row_count", function( $cells ){
                        $cells->setBackground('eaeaea');
                    });

                    $sheet->cells("L1:N1", function( $cells ){
                        $cells->setBackground('add58a');
                    });

                    $sheet->cells("L2:N$total_row_count", function( $cells ){
                        $cells->setBackground('e1f7cd');
                    });



                });


        })->download('xlsx');

    }

    public function upload( Request $request, Advice $advice ){

        if( !$advice->is_purchase ) abort(404);

        $this->validate($request, [
            'file.*' => 'file|mimes:xlsx'
        ],[], [
            'file.*' => 'file'
        ]);


        /** @var UploadedFile $file */
        $file = $request->file('file');
        $file = array_pop( $file );
        $file->storeAs('/', "$advice->id.xlsx", 'shipments');


        session()->flash("logistics.shipment.uploaded.$advice->id", 'Shipment detail file has been uploaded.');

        return back();

//        dd( $advice );
    }


    public function shipment( Advice $advice ){

        if( !$advice->shipment_is_uploaded ) abort(404);

        DB::transaction(function() use ($advice){

            $file = storage_path("app/shipments/$advice->id.xlsx");

            Excel::load($file, function(LaravelExcelReader $reader) use ( $advice ) {

                $shipments = [];
                $shipment_items = [];
                $labs = Lab::all();

                $sheets = $reader->all();
                $details_sheet = $sheets->filter(function( $sheet ){
                    return $sheet->getTitle() === 'P.O. Adv. Details';
                })->first();

                if( !$details_sheet ){
                    abort(503, 'Cannot find "P.O. Adv. Details" in uploaded file. Please re-upload file & re-submit.');
                }

                foreach ( $details_sheet->all() as $row ){


                    // Transform Row Data ====================

                    $row['item_code']   = intval( $row['item_code'] );
                    $row['lab_code']    = intval( $row['lab_code'] );
                    $row['batch_no']    = $row['batch_no.'] ?? $row['batch_no'] ?? '';
                    $row['trdocket_no'] = $row['trdocket_no.'] ?? $row['trdocket_no'] ?? '';

                    // Transform Row Data :: ENDS ===============


                    $item_type = strtolower( $row['item_type'] );
                    $has_batches = ($item_type === 'consumable' OR $item_type === 'others');



                    // Skip for Invalid Data =================

                    if( empty( $row['po_number'] ) OR
                        empty( $row['trdocket_no'] ) OR
                        empty( $row['trdocket_date'] ) ){
                        continue;
                    }

                    if( $has_batches ){
                        if( empty( $row['batch_no'] ) OR
                            empty( $row['batch_quantity'] ) OR
                            empty( $row['batch_quantity'] ) ){
                            continue;
                        }
                    } else {
                        if( empty( $row['delivery_quantity'] ) ){
                            continue;
                        }
                    }
                    // Skip for Invalid Data :: ENDS =================


                    // Create the shipment if not exists ============

                    $shipment_key = $row['po_number'] . '-' . $row['advice_number'] . '-' . $row['lab_code'];

                    if( isset( $shipments[ $shipment_key ] ) ) {
                        $shipment = $shipments[ $shipment_key ];

                    } else {

                        $shipment = new Shipment([
                            'lab_id' => $row['lab_code'],
                            'po_no' => $row['po_number'],
                            'advice_id' => $advice->id,
                            'shipment_no' => Config::nextNumber( Shipment::NUMBER_PREFIX, $labs->find( $row['lab_code'] )->name ),
                            'shipment_date' => Carbon::now(),
                            'vendor_name' => $row['vendor_name'],
                            'status' => Shipment::STATUS_PENDING,
                            'user_id' => auth()->user()->id,

                        ]);

                        $shipment->saveOrFail();

                        $shipments[ $shipment_key ] = $shipment;
                    }


                    // Create the shipment item if not exists ============

                    $shipment_item_key = $shipment->id . '-' . $row['item_code'];

                    if( isset( $shipment_items[ $shipment_item_key ] ) ){
                        $shipment_item = $shipment_items[ $shipment_item_key ];

                    }else{

                        $shipment_item = new ShipmentItem([
                            'shipment_id' => $shipment->id,
                            'item_code' => $row['item_code'],
                            'adviced_qty' => $row['procurement_advice_quantity'],
                            'shipment_qty' => $has_batches ? 0 : $row['delivery_quantity'],
                            'tr_no' => $row['trdocket_no'],
                            'tr_date' => $row['trdocket_date'],
                            'user_id' => auth()->user()->id

                        ]);

                        $shipment_item->saveOrFail();

                        $shipment_items[ $shipment_item_key ] = $shipment_item;
                    }

                    // If item batches, then we need to put it into batch.
                    if( $has_batches ){
                        /** @var ShipmentItemBatch $shipment_item_batch */
                        $shipment_item_batch = new ShipmentItemBatch([
                            'shipment_dtl_id' => $shipment_item->id,
                            'lot_no' => $row['batch_no'], // May also use 'batch_no.'
                            'expiry_on' => $row['expiry_on'],
                            'shipment_qty' => $row['batch_quantity'],
                            'user_id' => auth()->user()->id

                        ]);

                        $shipment_item_batch->saveOrFail();

                        $shipment_item->shipment_qty += $shipment_item_batch->shipment_qty;
                        $shipment_item->saveOrFail();

                    }

                }


                session()->flash('logistics.shipment.new', $shipments);

            });

            try { unlink( $file ); }
            catch ( \Exception $exception) { dd( $exception->getMessage() ); }

        });


        return back();

    }


}
