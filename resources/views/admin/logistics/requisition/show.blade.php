@extends('admin.logistics.base')

@section('logistics-title', 'Stock Transfer advice - Item Details')

@section('logistics')


    <style>
        .advice-cancel{ display: none }
        .adviced .advice-actions{ display: none; }
        .adviced .advice-cancel{ display: block; }
    </style>


    @if( session()->has('logistics.advice.new') )
        @php( $advices = session('logistics.advice.new') )
        <div class="alert alert-success">
            New Advice(s) created.
            @foreach( $advices as $advice )
                <br><strong>{{ ucwords( $advice->advice_type ) }}</strong>:
                <a href="{{ route('logistics.advice.show', $advice) }}">
                    {{ $advice->advice_no }}
                </a>
            @endforeach
        </div>
    @endif


    <div class="card">
        <div class="card-block">
            <div class="row">
                <div class="col-sm-6">
                    <p>Lab - {{ $requisition->lab->name_and_location }}</p>
                    <p class="mb-0">Requisition No.: {{ $requisition->requisition_no }}</p>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('logistics.advice.generate') }}" method="post">

        {{ csrf_field() }}

        <input type="hidden" name="requisition_no" value="{{ $requisition->requisition_no }}">

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
                        <th width="120">
                            {{--<select class="form-control">--}}
                                {{--<option value="#">Item Category</option>--}}
                                {{--<option value="consumable">Critical</option>--}}
                                {{--<option value="non_consumable">Non Critical</option>--}}
                               
                            {{--</select>--}}

                            Item Category
                        </th>

                        <th width="90" class="text-left">
                            {{--<input type="text" class="form-control" name="item-code" id="item-code" placeholder="Item Code">--}}
                            Item Code
                        </th>
                        <th class="text-left">Item / Product Name</th>
                        <th>Pack Size</th>
                        <th>UOM</th>
                        {{--<th>--}}
                            {{--<div class="shorting">--}}
                                {{--Reorder Level--}}
                                {{--<a href="#" class="up"><i class="fas fa-sort-up"></i></a>--}}
                                {{--<a href="#" class="down"><i class="fas fa-sort-down"></i></a>--}}
                            {{--</div>--}}
                        {{--</th>--}}
                        <th>Current Stock</th>
                        <th>Last 3 Months Consumption</th>
                        <th width="80">
                            {{ this_lab() ? 'Required Qty.' : 'Requested Qty.' }}
                        </th>
                        @if( !this_lab() )
                            <th width="100">Transfer Advice Qty.</th>
                            <th width="160"></th>
                        @endif
                    </tr>
                    </thead>

                    <tbody>

                    @foreach( $requisition->items as $item )
                    <tr data-item='{{ json_encode( $item ) }}'>
                        <td class="text-left">{{ $item->item_type->name }}</td>
                         <td class="text-left">{{ $item->item_type->name }}</td>
                        <td class="text-left">{{ $item->detail->code }}</td>
                        <td class="text-left">
                            <span class="nomenclature"
                                  title="{{ $item->detail->description }}">
                                {{ $item->detail->description }}
                            </span>
                        </td>
                        <td width="80">{{ $item->detail->pack_size }}</td>
                        <td>{{ $item->detail->uom->name }}</td>
                        <td>{{ $item->current_stock }}</td>
                        <td>0</td>
                        <td>{{ $item->required_qty }}</td>
                        {{--<td class="text-center">{{ $item->adviced_qty }}</td>--}}
                        @if( !this_lab() )
                        <td>
                            <input type="number"
                                   class="form-control"
                                   tabindex="1"
                                   name="advices[{{ $item->item_code }}][quantity]"
                                   value="0">
                        </td>
                        <td class="text-right">
                            <input type="hidden" class="advice-lab" name="advices[{{ $item->item_code }}][lab]" value="">

                            <div class="advice-details"></div>

                            <div class="advice-actions">

                                <a class="btn btn-info btn-sm"
                                   title="Stock Transfer advice from other labs"
                                   href="#modal-advice"
                                   data-toggle="modal">
                                    <i class="fas fa-dolly mr-1"></i> Transfer
                                </a>

                                {{--<a class="btn btn-info btn-sm btn-purchase-advice"--}}
                                   {{--href="#"--}}
                                   {{--title="Purchase Advice">--}}
                                    {{--<i class="fas fa-file-invoice mr-1"></i> Purchase--}}
                                {{--</a>--}}

                            </div>
                            <div class="advice-cancel">
                                <a class="btn-cancel-advice"
                                   href="#"
                                   title="Stock Transfer from other labs">Cancel</a>
                            </div>
                        </td>
                        @endif

                    </tr>
                    @endforeach

                    </tbody>

                </table>

            </div>
        </div>

        @if( !this_lab() )
            <button type="submit" class="btn btn-primary">Generate Transfer Advice</button>
        @endif

    </form>


    <div id="modal-advice"
         class="modal fade"
         data-lab='{{ json_encode( $requisition->lab ) }}'
         data-url='{{ route('logistics.central-item.index') }}'>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <div class="advice-item-title"></div>
                        <small><strong>Required Quantity:</strong> <span class="advice-item-quantity"></span></small>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th width="50">Lab Id</th>
                            <th>Lab Name</th>
                            <th>Location</th>
                            <th>State</th>
                            <th width="80">Reorder Level</th>
                            <th width="80">Current Stock</th>
                            <th width="80">Effective Stock</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="item-list"></tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

@endsection