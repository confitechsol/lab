@extends('admin.logistics.base')

@section('logistics-title', 'Procurement Advice Cart - Item Details (' . ( $cart_mode === 'all' ? 'Lab Wise' : ucwords( $cart_mode ) ) . ')')

@section('secondary-nav')

    <a href="{{ route('logistics.stock.index', [ 'mode' => $cart_mode ]) }}"
       class="btn btn-sm btn-info"><i class="fas fa-arrow-left mr-1"></i> Stock</a> &mdash;

    <div class="btn-group btn-group-sm">

        <a href="{{ route('logistics.stock.cart.index', [ 'mode' => 'grouped' ]) }}"
           class="btn px-2 btn-{{ $cart_mode === 'grouped' ? 'warning' : 'secondary' }}">GROUPED</a>

        <a href="{{ route('logistics.stock.cart.index', [ 'mode' => 'all' ]) }}"
           class="btn px-2 btn-{{ $cart_mode === 'all' ? 'warning' : 'secondary' }}">LAB WISE</a>

    </div> &mdash;

    <a class="btn btn-sm btn-danger requisition-clear-cart"
       href="{{ route('logistics.stock.cart.clear', [ 'mode' => $cart_mode ]) }}"
       data-confirm="Are you sure to clear all items in cart?"
       data-action="delete">Clear Cart</a>
@endsection

@section('logistics')



    @if( session()->has('logistics.advice.new') )
        @php( $advice = session('logistics.advice.new') )
        <div class="alert alert-success">
            New Purchase Advice created:
            <a href="{{ route('logistics.advice.show', $advice) }}">
                {{ $advice->advice_no }}
            </a>
        </div>
    @endif


    @if( count( $cart ) )

    <form method="post"
          action="{{ route('logistics.stock.generate-po') }}"
          class="form-horizontal">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="mode" value="{{ $cart_mode }}">

        <div class="card">
            <div class="card-block p-2">

                <div class="table-responsive">
                    <table class="table table-striped table-sm" >
                        <thead>
                        <tr>
                            <th width="130">Item Type</th>
                            @if( !$is_grouped )
                                <th width="80">Lab</th>
                            @endif
                            <th width="80">Item Code</th>
                            <th>Item / Product Name</th>
                            <th>Pack Size</th>
                            <th>Current Stock</th>
                            <th>Last 3 Months Consumption</th>
                            <th>No. of Months Stock(Approx.)</th>
                            <th>Requested Qty</th>
                            <th width="100">Procurement Advice Quantity</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach( $cart as $cart_key => $cart_item )
                            @php( $stock_item = $cart_item['stock_item'] )
                            @php( $item = $stock_item->item )
                            <tr data-item='{!! json_encode( $stock_item ) !!}'
                                class="{{ $stock_item->current_stock <= $stock_item->re_order ? 'bg-alert' : '' }}">
                                <td class="text-left">{{ $item->item_type->name }}</td>
                                @if( !$is_grouped )
                                    <td class="text-left">{{ $stock_item->is_grouped ? 'ALL LABS' : $stock_item->lab->name }}</td>
                                @endif
                                <td class="text-left">{{ $item->code }}</td>
                                <td class="text-left">
                                    <span title="{{ $item->description }}"
                                          class="nomenclature">{{ $item->description }}</span>
                                </td>
                                <td>{{ $item->pack_size }}</td>
                                <td class="text-center">{{ $stock_item->current_stock }}</td>
                                <td>{{--Last 3 Months Consumption--}} 0</td>
                                <td>{{--No. of Months Stock(Approx.)--}} 0</td>
                                <td>{{--Requested Qty--}} {{ $stock_item->required_quantity }}</td>
                                <td>
                                    @include('common.inputs.input', [
                                        'type' => 'number',
                                        'name' => "quantity[$cart_key]",
                                        'value' => $cart[ $cart_key ]['quantity'],
                                        'class' => 'form-control item-quantity',
                                        'attrs' => [ 'min' => '0.01', 'step' => '0.01' ],
                                    ])
                                </td>
                                <td>
                                    <a href="{{ route('logistics.stock.cart.remove', ['item' => $cart_key, 'mode' => $cart_mode]) }}"
                                       data-confirm="Are you sure to delete '{{ $item->description }}' item from cart?"
                                       data-action="delete"
                                       title="Delete from cart."
                                       class="text-danger fa-2x po-delete-from-cart"><i class="fas fa-times-circle"></i></a>
                                </td>
                            </tr>
                        @endforeach


                        </tbody>

                    </table>
                </div>

            </div>
        </div>


        <button class="btn btn-info mr-2" type="submit">Generate Procurement Advice</button>

    </form>

    @else

        <div class="card">
            <div class="card-block text-center py-5">
                <div class="fa-2x text-danger"><i class="fas fa-exclamation-circle fa-2x"></i></div>
                <h3>There are no items in Procurement Advice Cart.</h3>
                <p class="mb-0">Add some items from <a href="{{ route('logistics.stock.index', ['mode' => $cart_mode]) }}">here</a> first.</p>
            </div>
        </div>

    @endif

@endsection