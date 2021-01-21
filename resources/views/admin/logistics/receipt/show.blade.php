@extends('admin.logistics.base')

@section('logistics-title', 'Item Receipt - Details')

@section('secondary-nav')
    <a href="{{ route('logistics.receipt.received.index') }}"
       class="btn btn-sm btn-info"><i class="fas fa-file-invoice mr-1"></i> All Received Details</a>
@endsection

@section('logistics')

    <style>
        .advice-cancel{ display: none }
        .adviced .advice-actions{ display: none; }
        .adviced .advice-cancel{ display: block; }
    </style>


    <div class="card">
        <div class="card-block">

            <p>LAB: {{ $shipment->lab->name }}</p>

            <hr>

            <div class="row align-items-center small">
                <div class="col-sm-6">
                    <p>Purchase Order Advise No.: {{ $shipment->advice->advice_no }}</p>
                    <p>Shipment No.: {{ $shipment->shipment_no }}</p>
                    <p>Shipment Date.: {{ $shipment->shipment_date->format('d/m/Y') }}</p>
                </div>
                <div class="col-sm-6">
                    <p>Requisition No.: {{ $shipment->requisition ? $shipment->requisition_no : 'DIRECT' }}</p>
                    {{--<p>T.R. Number: {{ $shipment->tr_no }}</p>--}}
                    {{--<p>T.R. Date.: {{ $shipment->tr_date->format('d/m/Y') }}</p>--}}
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('logistics.receipt.received', $shipment) }}" method="post">

        {{ csrf_field() }}

        <div class="card">
            <div class="card-block p-2">

                <table class="table table-striped table-sm">

                    <thead>
                    <tr>
                        <th width="120">
                            {{--<select class="form-control">--}}
                            {{--<option value="#">Item Type</option>--}}
                            {{--<option value="consumable">Consumable</option>--}}
                            {{--<option value="non_consumable">Non Consumable</option>--}}
                            {{--<option value="others">Others</option>--}}
                            {{--</select>--}}
                            Item Type
                        </th>
                        <th width="90" class="text-left">
                            {{--<input type="text" class="form-control" name="item-code" id="item-code" placeholder="Item Code">--}}
                            Item Code
                        </th>
                        <th class="text-left">Nomenclature</th>
                        <th>Pack Size</th>
                        <th class="text-center">UOM</th>
                        <th class="text-center">Required Qty.</th>
                        <th width="80" class="text-center">Advice Qty.</th>
                        <th width="80">Shipment Qty.</th>
                        <th width="80">Received Qty.</th>
                        <th width="80"></th>
                    </tr>
                    </thead>

                    <tbody>

                    <?php /** @var \App\Model\Logistics\ShipmentItem $item */ ?>
                    @foreach( $shipment->items as $item )

                        @php( $requisition_item = $shipment->requisition ? $shipment->requisition->items->where( 'item_code', $item->item_code )->first() : NULL )
                        @php( $advice_item = $shipment->advice ? $shipment->advice->items->where( 'item_code', $item->item_code )->first() : NULL )

                        <tr>
                            <td class="text-left">{{ $item->detail->item_type->name }}</td>
                            <td class="text-left">{{ $item->detail->code }}</td>
                            <td class="text-left">
                            <span class="nomenclature"
                                  title="{{ $item->detail->description }}">
                                {{ $item->detail->description }}
                            </span>
                            </td>
                            <td width="80">{{ $item->detail->pack_size }}</td>
                            <td>{{ $item->detail->uom->name }}</td>
                            <td>{{ $requisition_item ? $requisition_item->required_qty : '-' }}</td>
                            <td>{{ $requisition_item ? $requisition_item->adviced_qty : $item->adviced_qty }}</td>
                            <td>{{ $item->shipment_qty }}</td>
                            <td>
                                @include('common.inputs.input', [
                                    'type'  => 'number',
                                    'name'  => "received[$item->item_code][quantity]",
                                    'class' => "form-control received-quantity",
                                    'tabindex' => "1",
                                    'step' => "0.01",
                                    'min' => "0",
                                    'value' => $item->shipment_qty,
                                    'attrs' => [ 'readonly' => $item->detail->has_batches ],
                                ])
                            </td>
                            <td>
                                @if( $item->detail->has_batches )
                                    @include('common.inputs.input', [
                                        'type' => 'hidden',
                                        'class' => 'batches',
                                        'name'  => "received[$item->item_code][batches]",
                                        'value' => $item->batches->transform(function( $item ){
                                            /** @var \App\Model\Logistics\ShipmentItemBatch $item */
                                            return [
                                                'lot' => $item->lot_no,
                                                'date' => $item->expiry_on->format('Y-m-d'),
                                                'quantity' => $item->shipment_qty,
                                                'received' => 0,
                                                'remarks' => ''
                                            ];
                                        })
                                    ])
                                    <a class="btn btn-info btn-sm"
                                       href="#modal-received-batches"
                                       data-toggle="modal">Batches</a>
                                @endif
                            </td>

                        </tr>
                    @endforeach

                    </tbody>

                </table>

            </div>
        </div>

        <button class="btn btn-primary">Submit</button>

    </form>

    <form id="modal-received-batches" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Batches</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th class="text-center" width="180">Batch/Lot</th>
                            <th class="text-center" width="120">Expiry On</th>
                            <th class="text-center" width="80">Batch/Lot Quantity</th>
                            <th class="text-center" width="80">Received Quantity</th>
                            <th class="text-center">Remarks</th>
                        </tr>
                        </thead>
                        <tbody class="batch-list"></tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                </div>

            </div>
        </div>
    </form>

@endsection