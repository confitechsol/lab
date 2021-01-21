@extends('admin.logistics.base')

@section('logistics-title', 'Generate Requisition')

@section('secondary-nav')

@endsection

@section('logistics')

    <div class="card">
        <div class="card-block p-2">

            <form action="" class="form-horizontal">

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
                            <th width="80">
                                @include('common.inputs.input', [
                                    'name' => 'code',
                                    'placeholder' => 'Item Code',
                                ])
                            </th>
                            <th>
                                @include('common.inputs.input', [
                                    'name' => 'description',
                                    'placeholder' => 'Nomenclature',
                                ])
                            </th>
                            <th width="80">
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
                            <th width="80" class="text-center">Stock to be Transferred</th>
                            <th width="80" class="text-center">Effective Current Stock</th>
                            <th width="80" class="text-center">Last 3 Months Consumption</th>
                            <th width="80" class="text-center">Required Quantity</th>
                            <th><button class="btn btn-info btn-sm">Filter</button></th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach( $items as $item )
                        <tr data-item='{!! json_encode( $item ) !!}'
                            class="{{ $item->is_in_cart ? 'bg-exists' : ($item->below_reorder_level ? 'bg-alert' : '') }}">
                            <td>{{ $item->item_type->name }}</td>
                            <td>{{ $item->code }}</td>
                            <td>
                                <span title="{{ $item->description }}"
                                      class="nomenclature">{{ $item->description }}</span>
                            </td>
                            <td>{{ $item->pack_size }}</td>
                            <td>{{ $item->uom->name }}</td>
                            <td class="text-center">{{ $item->re_order }}</td>
                            <td class="text-center">{{ $item->current_stock }}</td>
                            <td class="text-center">0</td>
                            <td class="text-center">{{ $item->effective_stock }}</td>
                            <td class="text-center">0</td>
                            <td><input type="number" value="1" min="0.01" step="0.01" class="form-control item-quantity"/></td>
                            <td>
                                <a href="#" class="btn btn-info btn-sm requisition-add-to-cart"><i class="fas fa-plus"></i></a>
                            </td>
                        </tr>
                        @endforeach


                        </tbody>

                    </table>
                </div>

            </form>

        </div>
    </div>


    @if( !$items->count() )
        @alertinfo("We couldn't find any results.")
    @else
        <div class="pagination-wrap">
            <div class="items-count">
                Found {{ $items->total() }} items.
            </div>
            {{ $items->links() }}
        </div>
    @endif

@endsection