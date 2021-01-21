@extends('admin.logistics.base')

@section('logistics-title', 'Requisition Cart - Item Details')

@section('secondary-nav')
    {{--<a href="{{ route('logistics.requisition.cart.index') }}" class="btn-sm btn-info">Requisition Cart (<span id="requisition-cart-count">0</span>)</a>--}}
    <a href="{{ route('logistics.item.index', ['new_requisition' => 'yes']) }}"
       class="btn-sm btn-info"><i class="fas fa-arrow-left mr-1"></i> Back</a> &mdash;

    <a class="btn btn-sm btn-danger requisition-clear-cart"
       href="{{ route('logistics.requisition.cart.clear') }}" data-action="delete">Clear Cart</a>
@endsection

@section('logistics')



    @if( session()->has('logistics.requisition.new') )
        @php( $requisition = session('logistics.requisition.new') )
        <div class="alert alert-success">
            New Requisition created:
            <a href="{{ route('logistics.requisition.show', $requisition) }}">
                {{ $requisition->requisition_no }}
            </a>
        </div>
    @endif


    @if( count( $cart ) )

    <form method="post"
          action="{{ route('logistics.requisition.generate') }}"
          class="form-horizontal">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="card">
            <div class="card-block p-2">

                <div class="table-responsive">
                    <table class="table table-striped table-sm" >
                        <thead>
                        <tr>
                            <th width="130">Item Type</th>
                            <th width="80">Item Code</th>
                            <th>Item / Product Name</th>
                            <th width="80">Pack Size</th>
                            <th width="60">UOM</th>
                            <th width="80" class="text-center">Reorder Level</th>
                            <th width="80" class="text-center">Current Stock</th>
                            <!--th width="80" class="text-center">Stock to be Transferred</th>
                            <th width="80" class="text-center">Effective Current Stock</th-->
                            <th width="80" class="text-center">Last 3 Months Consumption</th>
                            <th width="80" class="text-center">No. of Months Stock(Apprx.)</th>
                            <th width="80" class="text-center">Required Quantity</th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach( $stock as $stock_item )
                            @php( $item = $stock_item->item )
                            <tr data-item='{!! json_encode( $stock_item ) !!}'
                                class="{{ $stock_item->current_stock <= $stock_item->re_order ? 'bg-alert' : '' }}">
                                <td class="text-left">{{ $item->item_type->name }}</td>
                                <td class="text-left">{{ $item->code }}</td>
                                <td class="text-left">
                            <span title="{{ $item->description }}"
                                  class="nomenclature">{{ $item->description }}</span>
                                </td>
                                <td>{{ $item->pack_size }}</td>
                                <td>{{ $item->uom->name }}</td>
                                <td class="text-center">{{ $stock_item->re_order }}</td>
                                <td class="text-center">{{ $stock_item->current_stock }}</td>
                                <!--td class="text-center">0</td>
                                <td class="text-center">{{ $stock_item->effective_stock }}</td>
                                <td class="text-center">0</td-->
                                <td class="text-center">0</td>   
                                <td class="text-center">0</td>   
                                <td>
                                    @include('common.inputs.input', [
                                        'type' => 'number',
                                        'name' => 'item[' . $item->code . ']',
                                        'value' => $cart[ $item->code ],
                                        'class' => 'form-control item-quantity',
                                        'attrs' => [ 'min' => '0.01', 'step' => '0.01' ],
                                    ])
                                </td>
                                <td>
                                    <a href="#"
                                       data-confirm="Are you sure to delete &quote;{{ $item->description }}&quote; item from cart?"
                                       title="Delete from cart."
                                       class="text-danger fa-2x requisition-delete-from-cart"><i class="fas fa-times-circle"></i></a>
                                </td>
                            </tr>
                        @endforeach


                        </tbody>

                    </table>
                </div>

            </div>
        </div>

        <input type="hidden" name="sent_to" value="">
        <div class="btn-group dropup">
            <button class="btn btn-info mr-2 dropdown-toggle"
                    data-toggle="dropdown"
                    type="button">Send Requisition To</button>
            <div class="dropdown-menu">
                @foreach( $sent_tos as $sent_to )
                <a class="dropdown-item small sent-tos" data-sent-to="{{ $sent_to->id }}" href="#">{{ $sent_to->name }}</a>
                @endforeach
            </div>
        </div>

    </form>

    @else

        <div class="card">
            <div class="card-block text-center py-5">
                <div class="fa-2x text-danger"><i class="fas fa-exclamation-circle fa-2x"></i></div>
                <h3>There are no items in Requisition Cart.</h3>
                <p class="mb-0">Add some items from <a href="{{ route('logistics.item.index') }}">here</a> first.</p>
            </div>
        </div>

    @endif

@endsection