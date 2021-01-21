@extends('admin.logistics.base')

@section('logistics-title', $new_requisition ? 'Generate Requisition' : 'Current Stock')

@section('secondary-nav')
    @if( $new_requisition )
        {{--<a href="{{ route('logistics.item.index', ['new_requisition' => 'yes']) }}"--}}
           {{--class="btn-sm btn-info"><i class="fas fa-plus"></i> New Requisition</a>--}}
        <a href="{{ route('logistics.requisition.cart.index') }}"
           class="btn-sm btn-info">Requisition Cart (<span id="requisition-cart-count">0</span>)</a>
    @endif
    {{--<a href="{{ route('logistics.item.opening-balance') }}" class="btn-sm btn-primary"><i class="fas fa-box-open"></i> Opening Stock</a>--}}
    {{--&mdash;--}}
@endsection

@section('logistics')

    <div class="card">
        <div class="card-block p-2">

            <form action="" class="form-horizontal">
                @if( $new_requisition )
                    <input type="hidden" name="new_requisition" value="yes">
                @endif
                <div class="table-responsive">
                    <table class="table table-striped table-sm" >
                        <thead>
                        <tr>
                            <th width="130">
                                @include('common.inputs.select', [
                                    'name' => 'item_type_code',
                                    'placeholder' => '-- All Types --',
                                    'options' => logistics_item_types()->toArray(),
                                ])
                            </th>

                             <th width="130">
                                @include('common.inputs.select', [
                                    'name' => 'category',
                                    'placeholder' => '-- All Categories --',
                                    'options' => $item_categories->pluck('name', 'code')->toArray(),
                                ])
                            </th>

                            <th width="130">
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
                            <th width="130">
                                @include('common.inputs.input', [
                                    'name' => 'pack_size',
                                    'placeholder' => 'Pack Size',
                                ])
                            </th>
                            <th width="60">UOM</th>
                            <th width="80" class="text-center">
                                <div class="shorting">
                                    Reorder Level
                                    <a href="#" class="up"><i class="fas fa-sort-up"></i></a>
                                    <a href="#" class="down"><i class="fas fa-sort-down"></i></a>
                                </div>
                            </th>
                            <th width="80" class="text-center">Current Stock</th>
                          
                            <!--th width="80" class="text-center">Stock to be Transferred</th-->
                            <!--th width="80" class="text-center">Effective Current Stock</th-->
                            <th width="80" class="text-center">Last 3 Months Consumption (Average)</th>
                            <th width="80" class="text-center">No. of Month Stock Availability(Apprx.)</th>
                            @if( $new_requisition )
                                <th width="80" class="text-center">Required Quantity</th>
                            @endif
                            <th><button class="btn btn-info btn-sm">Filter</button></th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach( $stock as $stock_item )
                            @php( $item = $stock_item->item )
                            <tr data-item='{!! json_encode( $stock_item ) !!}'
                                class="{{ $stock_item->is_in_requisition_cart ? 'bg-exists' : ($stock_item->below_reorder_level ? 'bg-alert' : '') }}">
                                <td>{{ $item->item_type->name }}</td>
                                 <td>{{ $item->category->name ?? '-' }}</td>
                                <td>{{ $item->code }}</td>
                                <td>
                                    <span title="{{ $item->description }}"
                                          class="nomenclature">
                                        {{ $item->description }}
                                    </span>
                                </td>
                                <td>{{ $item->pack_size }}</td>
                                <td>{{ $item->uom->name }}</td>
                                <td class="text-center">{{ $stock_item->re_order }}</td>
                                <td class="text-center">{{ $stock_item->current_stock }}</td>
                                <td class="text-center">0</td>
                                <!--td class="text-center">0</td-->
                                <!--td class="text-center">{{ $stock_item->effective_stock }}</td-->
                                <td class="text-center">0</td>
                                @if( $new_requisition )
                                    <td><input type="number" value="1" min="0.01" step="0.01" class="form-control item-quantity"/></td>
                                    <td><a href="#" class="btn btn-info btn-sm requisition-add-to-cart"><i class="fas fa-plus"></i></a></td>
                                @else <td></td> @endif
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

@endsection