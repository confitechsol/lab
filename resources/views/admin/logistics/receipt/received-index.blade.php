@extends('admin.logistics.base')

@section('logistics-title', 'All Received Items')

@section('logistics')

    <div class="card">
        <div class="card-block p-2">

            <table class="table table-striped table-sm">

                <thead>
                <tr>
                    <th>Type</th>
                    <th>Receipt No</th>
                    <th>Receipt Date</th>
                    <th>Shipment No</th>
                    <th>Shipment Date</th>
                </tr>
                </thead>

                <tbody>
                @foreach( $receipts as $receipt )
                <tr>
                    <td>{{ ucwords( $receipt->doc_type ) }}</td>
                    <td>{{ $receipt->receipt_no }}</td>
                    <td>{{ $receipt->receipt_date->format('d/m/Y') }}</td>
                    <td>{{ $receipt->document_no }}</td>
                    <td>{{ $receipt->document_date->format('d/m/Y') }}</td>
                    <td><a class="btn btn-info btn-sm"
                           href="#modal-received-items"
                           data-toggle="modal"
                           data-detail="{{ $receipt->items->map(
                            function( $item ){
                                $item->detail;
                                $item->detail->item_type;
                                $item->detail->category;
                                return $item;
                            }
                           ) }}">Item Details</a></td>
                </tr>
                @endforeach
                </tbody>

            </table>

        </div>
    </div>

    @if( !$receipts->count() )
        @alertinfo("We couldn't find any results.")
    @else
        <div class="pagination-wrap">
            <div class="items-count">
                Found {{ $receipts->total() }} items.
            </div>
            {{ $receipts->links() }}
        </div>
    @endif


    <div id="modal-received-items" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Items</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th class="text-center">Item Type</th>
                            <th class="text-center">Item Category</th>
                            <th class="text-center">Item Code</th>
                            <th class="text-center">Item / Product Name</th>
                            <th class="text-center">Received Qty.</th>
                        </tr>
                        </thead>
                        <tbody class="items"></tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <script>
        var $modal = $('#modal-received-items');
        var $modal_items = $modal.find('.items');
        $modal.on('show.bs.modal', function(e){
            var $btn = $(e.relatedTarget);
            var items = $btn.data('detail');
            $modal_items.empty();
            for( var i in items ){
                if( !items.hasOwnProperty( i ) ) continue;
                var item = items[i];
                var $row = $('' +
                    '<tr>' +
                    '    <td class="text-center item-type">Item Type</td>' +
                    '    <td class="text-center item-category">Item Category</td>' +
                    '    <td class="text-center item-code">Item Code</td>' +
                    '    <td class="text-center item-name">Item / Product Name</td>' +
                    '    <td class="text-center item-received-quantity">Received Qty</td>' +
                    '</tr>');

                $row.find('.item-type').html(item.detail.item_type.name);
                $row.find('.item-category').html(item.detail.category.name);
                $row.find('.item-code').html(item.item_code);
                $row.find('.item-name').html(item.detail.description);
                $row.find('.item-received-quantity').html(item.accepted_qty);

                $modal_items.append($row);

            }
        })
    </script>


@endsection