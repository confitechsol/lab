@extends('admin.logistics.base')

@section('logistics-title', ( $advice->is_transfer ? 'Stock Transfer' : 'Purchase' )  . ' Advice - Item Details')

@section('logistics')


    <style>
        .advice-cancel{ display: none }
        .adviced .advice-actions{ display: none; }
        .adviced .advice-cancel{ display: block; }
    </style>

    <form action="{{ $advice->is_transfer ? '' : route('logistics.shipment.generate', $advice ) }}" method="post">

        {{ csrf_field() }}


        {{--@if( $errors->any() )--}}
            {{--@foreach( $errors->all() as $error )--}}
                {{--<div class="alert alert-danger">{{ $error }}</div>--}}
            {{--@endforeach--}}
        {{--@endif--}}

        @if( session()->has('logistics.advice.transfer.error') )
            <div class="alert alert-danger">{{ session('logistics.advice.transfer.error') }}</div>
        @endif

        <div class="card">
            <div class="card-block">
                <div class="row small">
                    <div class="col-sm-6">

                        @if( $advice->requisition )
                        <p>Lab - {{ $advice->requisition->lab->name_and_location }}</p>
                        <p class="mb-0">
                            Requisition No.:
                            <a href="{{ route('logistics.requisition.show', $advice->requisition) }}">{{ $advice->requisition->requisition_no }}</a>
                        </p>
                        @else
                            <h5><strong>DIRECT ADVICE</strong></h5>
                            <p>No Requisition is done for this advice.</p>
                        @endif

                    </div>
                    <div class="col-sm-6">
                        <p>
                            {{ $advice->is_transfer ? 'Stock Transfer Advice No.' : 'Purchase advice No.' }}:
                            {{ $advice->advice_no }}
                        </p>
                        <p class="mb-0">
                            {{ $advice->is_transfer ? 'Stock Transfer Advice Date' : 'Purchase Advice Date' }}::
                            {{ $advice->created_at->format('d/m/y') }}
                        </p>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-sm-6">
                        {{--<div class="form-group row">--}}
                            {{--<label class="col-sm-4">{{ $advice->is_transfer ? 'Stock Transfer' : 'Shipment' }} Number</label>--}}
                            {{--<div class="col-sm-6">--}}
                                {{--@include('common.inputs.input', [--}}
                                    {{--'name' => 'shipment_no'--}}
                                {{--])--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="form-group row">
                            <label class="col-sm-4">{{ $advice->is_transfer ? 'Transfer' : 'Shipment' }} Date</label>
                            <div class="col-sm-6">
                                @include('common.inputs.input', [
                                    'name' => 'shipment_date',
                                    'type' => 'date',
                                ])
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4">{{ $advice->is_transfer ? 'Courier' : 'Vendor' }}</label>
                            <div class="col-sm-6">
                                @include('common.inputs.model-select', [
                                    'model_key' => 'id',
                                    'model_label' => 'vendor_name',
                                    'models' => logistics_vendors( $advice->is_transfer ? 'C' : 'V' ),
                                    'name' => 'vendor_id',
                                    'placeholder' => '-- Select ' . ( $advice->is_transfer ? 'Courier' : 'Vendor' ) . ' --',
                                ])
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label class="col-sm-4">{{ $advice->is_transfer ? 'Docket' : 'T.R.' }} Number</label>
                            <div class="col-sm-6">
                                @include('common.inputs.input', [
                                    'name' => 'tr_no'
                                ])
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4">{{ $advice->is_transfer ? 'Docket' : 'T.R.' }} Date</label>
                            <div class="col-sm-6">
                                @include('common.inputs.input', [
                                    'name' => 'tr_date',
                                    'type' => 'date',
                                ])
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

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
                        <th class="text-left">Item / Product Name</th>
                        <th>Pack Size</th>
                        <th class="text-center">UOM</th>
                        <th class="text-center">Requested Qty.</th>
                        <th width="80" class="text-center">Adviced Qty.</th>
                        <th width="80">{{ $advice->is_transfer ? 'Transfer Qty.' : 'Shipment Qty.' }}</th>
                        <th width="80"></th>
                    </tr>
                    </thead>

                    <tbody>

                    <?php /** @var \App\Model\Logistics\AdviceItem $item */ ?>
                    @foreach( $advice->items as $item )
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
                        <td>{{ $item->required_quantity }}</td>
                        <td>{{ $item->advice_qty }}</td>
                        <td>
                            @include('common.inputs.input', [
                                'type'  => 'number',
                                'name'  => "shipments[$item->item_code][quantity]",
                                'class' => "form-control advice-quantity",
                                'tabindex' => "1",
                                'step' => "0.01",
                                'min' => "0",
                                'value' => "0",
                                'attrs' => [ 'readonly' => !$advice->is_transfer AND $item->detail->has_batches ]
                            ])
                        </td>
                        @if( !$advice->is_transfer )
                        <td>
                            @if( $item->detail->has_batches )
                                @include('common.inputs.input', [
                                    'type' => 'hidden',
                                    'name' => "shipments[$item->item_code][batches]",
                                    'class' => 'batches',
                                ])
                                <a class="btn btn-info btn-sm"
                                   href="#modal-item-batches"
                                   data-toggle="modal">Batches</a>
                            @endif
                        </td>
                        @endif

                    </tr>
                    @endforeach

                    </tbody>

                </table>

            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            {{ $advice->is_transfer ? 'Generate Stock Transfer' : 'Generate Shipment' }}
        </button>

    </form>

    <form id="modal-item-batches" class="modal fade">
        <div class="modal-dialog">
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
                            <th class="text-center">Batch/Lot</th>
                            <th class="text-center">Expiry On</th>
                            <th class="text-center" width="80">Batch/Lot Quantity</th>
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