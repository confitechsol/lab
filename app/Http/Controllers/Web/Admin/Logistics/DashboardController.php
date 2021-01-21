<?php

namespace App\Http\Controllers\Web\Admin\Logistics;


use App\Http\Controllers\Controller;
use App\Model\Lab;
use App\Model\Logistics\Advice;
use App\Model\Logistics\Receipt;
use App\Model\Logistics\Requisition;
use App\Model\Logistics\SentTo;
use App\Model\Logistics\Shipment;
use App\Model\Logistics\Stock;
use App\Model\Logistics\StockTransfer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{


    public function index(){

        if( this_lab() ) return $this->labIndex();

        return $this->centralIndex();
    }


    public function labIndex(){


        $sentTos = SentTo::all();

        $requisitions_sent_to = Requisition::scopes()->with('sentTo')
            ->lab( this_lab()->id )
            ->groupBy('sent_to')
            ->get([DB::raw('COUNT(*) as count, sent_to')])
            ->pluck('count', 'sent_to');

        $requisitions_sent_to = $sentTos->mapWithKeys(function( SentTo $sentTo ) use ( $requisitions_sent_to ){
            return [ $sentTo->name => $requisitions_sent_to[ $sentTo->id ] ?? 0 ];
        });



        $shipments_from_vendor = Shipment::query()
            ->where('t_central_shipment_hdr.status', 'pending')
            ->where('t_central_shipment_hdr.lab_id', this_lab()->id)
            ->where(function(Builder $query){
                $query->whereNotNull('vendor_name');
                $query->orWhere('vendor_name', '!=', '-');
            })
            // TODO: Currently we are showing all not only to a specific central lab.
            // ->join('t_requisition_hdr', 't_requisition_hdr.requisition_no', 't_central_shipment_hdr.requisition_no')
            // ->groupBy('sent_to')
            // ->get([DB::raw('COUNT(*) as count, sent_to')])
            // ->pluck('count', 'sent_to');
            ->count();

        $shipments_from_vendor = $sentTos->mapWithKeys(function( SentTo $sentTo ) use ( $shipments_from_vendor ){
            // TODO: Currently we are showing all not only to a specific central lab.
            // return [ $sentTo->name => $shipments_from_vendor[ $sentTo->id ] ?? 0 ];
            return [ $sentTo->name => ( $sentTo->id == 2 ? $shipments_from_vendor ?? 0 : 0 ) ];
        });


        $received_from_vendor = Receipt::query()
            ->where('t_itemrcpt_hdr.doc_type', Advice::TYPE_PURCHASE)
            ->where('t_itemrcpt_hdr.lab_id', this_lab()->id)
            // TODO: Currently we are showing all not only to a specific central lab.
            // ->join('t_requisition_hdr', 't_requisition_hdr.requisition_no', 't_itemrcpt_hdr.document_no')
            // ->groupBy('sent_to')
            // ->get([DB::raw('COUNT(*) as count, sent_to')])
            // ->pluck('count', 'sent_to');
            ->count();

        $received_from_vendor = $sentTos->mapWithKeys(function( SentTo $sentTo ) use ( $received_from_vendor ){
            // TODO: Currently we are showing all not only to a specific central lab.
            // return [ $sentTo->name => $received_from_vendor[ $sentTo->id ] ?? 0 ];
            return [ $sentTo->name => ( $sentTo->id == 2 ? $received_from_vendor : 0 ) ];
        });


        $shipment_transit_from_other_lab = Shipment::query()
            ->join('t_central_advice_hdr', 't_central_advice_hdr.requisition_no', 't_central_shipment_hdr.requisition_no')
            ->join('t_requisition_hdr', 't_requisition_hdr.requisition_no', 't_central_advice_hdr.requisition_no')
            ->leftJoin('t_itemrcpt_hdr', 't_itemrcpt_hdr.document_no', 't_central_shipment_hdr.shipment_no')
            ->where('t_central_advice_hdr.advice_type', Advice::TYPE_TRANSFER)
            ->where('t_central_shipment_hdr.lab_id', this_lab()->id)
            ->whereNull('t_itemrcpt_hdr.id')
            ->groupBy('sent_to')
            ->get([DB::raw('COUNT(*) as count, sent_to')])
            ->pluck('count', 'sent_to');

        $shipment_transit_from_other_lab = $sentTos->mapWithKeys(function( SentTo $sentTo ) use ( $shipment_transit_from_other_lab ){
            return [ $sentTo->name => $shipment_transit_from_other_lab[ $sentTo->id ] ?? 0 ];
        });


        $shipment_received_from_other_lab = Shipment::query()
            ->join('t_central_advice_hdr', 't_central_advice_hdr.requisition_no', 't_central_shipment_hdr.requisition_no')
            ->join('t_requisition_hdr', 't_requisition_hdr.requisition_no', 't_central_advice_hdr.requisition_no')
            ->join('t_itemrcpt_hdr', 't_itemrcpt_hdr.document_no', 't_central_shipment_hdr.shipment_no')
            ->where('t_central_advice_hdr.advice_type', Advice::TYPE_TRANSFER)
            ->where('t_central_shipment_hdr.lab_id', this_lab()->id)
            ->groupBy('sent_to')
            ->get([DB::raw('COUNT(*) as count, sent_to')])
            ->pluck('count', 'sent_to');

        $shipment_received_from_other_lab = $sentTos->mapWithKeys(function( SentTo $sentTo ) use ( $shipment_received_from_other_lab ){
            return [ $sentTo->name => $shipment_received_from_other_lab[ $sentTo->id ] ?? 0 ];
        });


        $shipment_transferred_to_other_lab = Shipment::query()
            ->join('t_central_advice_hdr', 't_central_advice_hdr.requisition_no', 't_central_shipment_hdr.requisition_no')
            ->join('t_requisition_hdr', 't_requisition_hdr.requisition_no', 't_central_advice_hdr.requisition_no')
            ->join('t_central_advice_item', 't_central_advice_item.advice_id', 't_central_advice_hdr.id')
            ->where('t_central_advice_hdr.advice_type', Advice::TYPE_TRANSFER)
            ->where('t_central_advice_item.to_lab_id', this_lab()->id)
            ->groupBy('sent_to')
            ->get([DB::raw('COUNT( DISTINCT t_central_shipment_hdr.shipment_no ) as count, sent_to')])
            ->pluck('count', 'sent_to');

        $shipment_transferred_to_other_lab = $sentTos->mapWithKeys(function( SentTo $sentTo ) use ( $shipment_transferred_to_other_lab ){
            return [ $sentTo->name => $shipment_transferred_to_other_lab[ $sentTo->id ] ?? 0 ];
        });

        return view('admin.logistics.dashboard.lab-index', compact(
            'sentTos', 'requisitions_sent_to', 'shipments_from_vendor', 'received_from_vendor',
            'shipment_transit_from_other_lab', 'shipment_received_from_other_lab', 'shipment_transferred_to_other_lab'
        ));

    }



    public function centralIndex(){

        $labs = Lab::all();

        $requisitions_received = Requisition::query()
            ->where('sent_to', central_lab()->id)
            ->groupBy('lab_id')
            ->get([DB::raw('COUNT(*) as count, lab_id')])
            ->pluck('count', 'lab_id');

        $requisitions_received = $labs->mapWithKeys(function( Lab $lab ) use ($requisitions_received){
            return [ $lab->name => $requisitions_received[ $lab->id ] ?? 0 ];
        });



        $shipment_sent_procurement = Shipment::query()
            // TODO: Currently we are showing all not only to a specific central lab.
//            ->whereHas('requisition', function(Builder $query){
//                $query->where('sent_to', central_lab()->id);
//            })
            ->whereNotNull( 'po_no' )
            ->where( 'po_no', '!=', '-' )
            ->groupBy('lab_id')
            ->get([DB::raw('COUNT(*) as count, lab_id')])
            ->pluck('count', 'lab_id');

        $shipment_sent_procurement = $labs->mapWithKeys(function( Lab $lab ) use ($shipment_sent_procurement){
            return [ $lab->name => $shipment_sent_procurement[ $lab->id ] ?? 0 ];
        });


        $transfer_advice_sent = Advice::query()
            ->join('t_requisition_hdr', 't_requisition_hdr.requisition_no', 't_central_advice_hdr.requisition_no')
            ->join('t_central_advice_item', 't_central_advice_item.advice_id', 't_central_advice_hdr.id')
            ->where( 't_central_advice_hdr.advice_type', Advice::TYPE_TRANSFER )
            ->groupBy('to_lab_id')
            ->get([DB::raw('COUNT(DISTINCT t_central_advice_hdr.id) as count, to_lab_id as lab_id')])
            ->pluck('count', 'lab_id');

        $transfer_advice_sent = $labs->mapWithKeys(function( Lab $lab ) use ($transfer_advice_sent){
            return [ $lab->name => $transfer_advice_sent[ $lab->id ] ?? 0 ];
        });


        $action_to_be_taken = Stock::scopes()
            ->belowReorderLevel()
            ->groupBy('lab_id')
            ->get([DB::raw('COUNT(*) as count, lab_id')])
            ->pluck('count', 'lab_id');

        $action_to_be_taken = $labs->mapWithKeys(function( Lab $lab ) use ($action_to_be_taken){
            return [ $lab->name => $action_to_be_taken[ $lab->id ] ?? 0 ];
        });

        return view('admin.logistics.dashboard.central-index', compact(
            'labs',
            'requisitions_received', 'shipment_sent_procurement',
            'transfer_advice_sent', 'action_to_be_taken'
        ));


    }

}