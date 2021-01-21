@extends('admin.logistics.base')

@section('logistics-title', 'Procurement Advice of C & DST Labs')

@section('secondary-nav')
    <div class="btn-group btn-group-sm">

        <a href="{{ route('logistics.stock.index', [ 'mode' => 'grouped' ]) }}"
           class="btn px-2 btn-{{ $cart_mode === 'grouped' ? 'warning' : 'secondary' }}">GROUPED</a>

        <a href="{{ route('logistics.stock.index', [ 'mode' => 'all' ]) }}"
           class="btn px-2 btn-{{ $cart_mode === 'all' ? 'warning' : 'secondary' }}">LAB WISE</a>

    </div> &mdash;

    <a href="{{ route('logistics.stock.cart.index', [ 'mode' => $cart_mode ]) }}"
       class="btn-sm btn-info">P.O. Cart (<span id="po-requisition-cart-count">0</span>)</a>
@endsection

@section('logistics')

    <meta name="cart-mode" content="{{ $cart_mode }}">

    <style>
        .table tbody td, .table thead th, .table tbody th{font-size: 0.72rem}
        .stock-list .btn{font-size: 0.7rem; padding: 0.4rem 0.5rem}
        .table .form-control{font-size: 0.7rem; padding: 0.4rem 0.5rem !important; height: 1rem !important}
    </style>

    <div class="card">
        <div class="card-block p-2">

            <form action="{{ route('logistics.stock.index') }}"
                  autocomplete="off"
                  class="form-horizontal">

                @include('common.inputs.input', [
                    'type' => 'hidden',
                    'name' => 'mode',
                    'value' => $cart_mode
                ])

                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>
                                @include('common.inputs.select', [
                                    'name' => 'type',
                                    'placeholder' => '-- All Types --',
                                    'options' => logistics_item_types()->toArray(),
                                ])
                            </th>
                            <th>
                                @include('common.inputs.select', [
                                    'name' => 'category',
                                    'placeholder' => '-- All Category --',
                                    'options' => $item_categories->pluck('name', 'code')->toArray(),
                                ])
                            </th>
                            @if( !$is_grouped )
                            <th>
                                @include('common.inputs.select', [
                                    'name' => 'lab',
                                    'placeholder' => '-- All Labs --',
                                    'options' => $labs->pluck('name', 'id')->toArray(),
                                ])
                            </th>
                            @endif
                            <th width="80">
                                @include('common.inputs.input', [
                                    'name' => 'code',
                                    'placeholder' => 'Item Code',
                                ])
                            </th>
                            <th>
                                @include('common.inputs.input', [
                                    'name' => 'description',
                                    'placeholder' => 'Item / Product Name',
                                ])
                            </th>
                            <th>Pack Size</th>
                            <th>Current Stock</th>
                            <th>Last 3 Months Consumption</th>
                            <th>No. of Months Stock(Approx.)</th>
                            <th>Requested Qty</th>
                            <th width="100">Procurement Advice Quantity</th>
                            <th colspan="2">
                                <button type="submit" class="btn btn-info btn-sm btn-block">Filter</button>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="stock-list">

                        @foreach( $stock as $stock_item )
                            @php( $item = $stock_item->item )
                            @php( $item_group = $is_grouped ? '--grouped--' : $stock_item->lab_id )
                            <tr data-stock-item="{{ $stock_item }}"
                                class="{{ $stock_item->is_in_cart ? 'bg-exists' : '' /*($stock_item->below_reorder_level ? 'bg-alert' : '')*/ }}">
                                <td class="text-left">{{ $item->item_type->name }}</td>
                                <td class="text-left">{{ $item->category->name ?? '' }}</td>
                                @if( !$is_grouped )
                                    <td class="text-left">{{ $is_grouped ? 'All labs' : $stock_item->lab->name }}</td>
                                @endif
                                <td>{{ $item->code }}</td>
                                <td class="text-left">{{ $item->description }}</td>
                                <td>{{ $item->pack_size }}</td>
                                <td class="font-weight-bold">{{ $stock_item->current_stock }}</td>
                                <td>{{--Last 3 Months Consumption--}} 0</td>
								<td>{{--No. of Months Stock(Approx.)--}} 0</td>
                                <td>{{--Requested Qty--}} {{ $stock_item->required_quantity }}</td>
                                <td>
                                    @include('common.inputs.input', [
                                        'placeholder' => 'Quantity',
                                        'class' => 'form-control item-quantity',
                                        'type' => 'number',
                                        'value' => 1,
                                        'attrs' => [ 'min' => '0', 'step' => '0.01'],
                                    ])
                                </td>
                                <td width="30">
                                    <button type="button"
                                            title="Add to P.O. Requisition Cart"
                                            class="btn btn-info btn-sm po-add-to-cart"><i class="fas fa-plus"></i></button>
                                </td>
                                <td width="80">
                                    <button type="button"
                                            data-toggle="modal"
                                            data-target="#modal-show-requisitions"
                                            title="Show Requisitions of this Item"
                                            class="btn btn-block btn-primary btn-sm">Requisitions</button>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>

                    </table>
                </div>

            </form>

        </div>
    </div>


    @if( !$stock->count() )
        @alertinfo("We couldn't find any results.")
    @else
        <div class="pagination-wrap">
            <div class="items-count">
                Found {{ $stock->total() }} items.
            </div>
            {{ $stock->links() }}
        </div>
    @endif



    <div id="modal-show-requisitions"
         class="modal fade"
         data-url='{{ route('logistics.stock.requisition.index') }}'>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pending Requisitions</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Requisition #</th>
                            <th>Date</th>
                            <th>Lab</th>
                            <th class="text-right">Quantity Requested</th>
                        </tr>
                        </thead>
                        <tbody class="item-list"></tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection