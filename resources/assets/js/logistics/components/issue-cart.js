$(document).ready(() => {

    const $issue_cart_count = $('#issue-cart-count');
    if( $issue_cart_count.length === 0 ) return;

    $.get('/logistics/issue/cart', ( res ) => {
        let total = 0;
        for( const i in res ) total += ( res.hasOwnProperty( i ) ? 1 : 0 );
        $issue_cart_count.html( total );
    });


    $('.issue-add-to-cart').click(function( e ){

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

        $.post('/logistics/issue/cart', data, ( res ) => {
            $item_row.removeClass('bg-alert').addClass('bg-exists');
            $item_row.find('.item-quantity').val(1);
            let total = 0;
            for( const i in res ) total += ( res.hasOwnProperty( i ) ? 1 : 0 );
            $issue_cart_count.html( total );
        });

    });


    $('.issue-delete-from-cart').click(function( e ){

        e.preventDefault();

        const $item_row = $(this).parents('tr');
        const item = $item_row.data('item');

        $.ajax({
            url: '/logistics/issue/cart/' + item.item_code,
            type: 'DELETE',
            success: () => {
                $item_row.remove();
                $issue_cart_count.html( parseInt( $issue_cart_count.text() ) - 1 );
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