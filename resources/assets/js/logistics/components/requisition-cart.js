$(document).ready(() => {

    const $requisition_cart_count = $('#requisition-cart-count');
    if( $requisition_cart_count.length === 0 ) return;


    $.get('/logistics/requisition/cart', ( res ) => {
        let total = 0;
        for( const i in res ) total += ( res.hasOwnProperty( i ) ? 1 : 0 );
        $requisition_cart_count.html( total );
    });


    $('.requisition-add-to-cart').click(function( e ){

        e.preventDefault();

        const $item_row = $(this).parents('tr');
        const item = $item_row.data('item');

        let quantity = $item_row.find('.item-quantity').val();
        quantity = parseFloat( quantity );
        quantity = quantity <= 0 ? 1 : quantity;

        const data = {
            code: item.item_code,
            quantity: quantity,
        };

        $.post('/logistics/requisition/cart', data, ( res ) => {
            $item_row.removeClass('bg-alert').addClass('bg-exists');
            $item_row.find('.item-quantity').val(1);
            let total = 0;
            for( const i in res ) total += ( res.hasOwnProperty( i ) ? 1 : 0 );
            $requisition_cart_count.html( total );
        });

    });


    $('.requisition-delete-from-cart').click(function( e ){

        e.preventDefault();

        const $item_row = $(this).parents('tr');
        const item = $item_row.data('item');

        $.ajax({
            url: '/logistics/requisition/cart/' + item.item_code,
            type: 'DELETE',
            success: () => {
                $item_row.remove();
                $requisition_cart_count.html( parseInt( $requisition_cart_count.text() ) - 1 );
            }
        });

    });


    $('.sent-tos').click(function( e ){
        e.preventDefault();
        const $button = $(this);
        const $form = $button.parents('form');
        const $input_sent_to = $form.find('input[name=sent_to]');
        $input_sent_to.val( $button.data('sent-to') );
        $form.submit();
    });


});