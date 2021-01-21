$(document).ready(() => {

    const $cart_count = $('#po-requisition-cart-count');
    if( !$cart_count.length ) return;


    const cart_mode = $('meta[name="cart-mode"]').attr('content');


    $.get('/logistics/stock/cart?mode=' + cart_mode, ( res ) => {
        let total = 0;
        for( const i in res ) total += ( res.hasOwnProperty( i ) ? 1 : 0 );
        $cart_count.html( total );
    });


    $('.po-add-to-cart').click(function( e ){

        e.preventDefault();

        const $item_row = $(this).parents('tr');
        const stock_item = $item_row.data('stock-item');

        let quantity = $item_row.find('.item-quantity').val();
        quantity = parseFloat( quantity );
        quantity = quantity <= 0 ? 1 : quantity;

        const data = {
            code: stock_item.item_code,
            lab: stock_item.is_grouped ? null : stock_item.lab_id,
            quantity: quantity,
        };

        $.post('/logistics/stock/cart?mode=' + cart_mode, data, ( res ) => {
            $item_row.removeClass('bg-alert').addClass('bg-exists');
            $item_row.find('.item-quantity').val(1);
            let total = 0;
            for( const i in res ) total += ( res.hasOwnProperty( i ) ? 1 : 0 );
            $cart_count.html( total );
        });

    });


    $('#modal-show-requisitions').on('show.bs.modal', function(e){

        const $modal = $(this);
        const $item_list = $modal.find('.item-list');

        const $button = $( e.relatedTarget );
        const $row = $button.parents('tr');
        const item = $row.data('stock-item');

        console.log( item );

        $item_list.empty();

        $.post( $modal.data('url'), {
            code: item.item_code,
            lab: item.is_grouped ? null : item.lab_id,
        }, function( data ){

            let quantity_total = 0;

            for(const i in data ){
                const req_item = data[ i ];
                const $tr = $(
                    '<tr>' +
                    '    <td class="text-left"><a target="_blank" class="req-number"></a></td>' +
                    '    <td class="req-date text-left"></td>' +
                    '    <td class="req-lab text-left"></td>' +
                    '    <td class="req-quantity text-right"></td>' +
                    '</tr>'
                );

                $tr.find('.req-number')
                    .attr('href', '/logistics/requisition/' + req_item.requisition.id)
                    .html(req_item.requisition.requisition_no);

                const date = new Date( req_item.requisition.created_at );

                let month = date.getMonth() + 1; month = month <= 9 ? '0' + month : month;
                let day = date.getDate() + 1; day = day <= 9 ? '0' + day : day;
                let year = date.getFullYear();

                $tr.find('.req-date').html( day + '/' + month + '/' + year );
                $tr.find('.req-lab').html(req_item.requisition.lab.name);
                $tr.find('.req-quantity').html(req_item.required_qty);
                $item_list.append( $tr );

                quantity_total += req_item.required_qty;

            }

            const $tr = $(
                '<tr style="background: #777; height: 2px;"><td colspan="4" style="padding: 0"></td></tr>' +
                '<tr>' +
                '    <th colspan="3" class="req-lab text-right">TOTAL</th>' +
                '    <td class="req-quantity-total text-right"></td>' +
                '</tr>'
            );

            $tr.find('.req-quantity-total').html( quantity_total );
            $item_list.append( $tr );

        });


    });


});