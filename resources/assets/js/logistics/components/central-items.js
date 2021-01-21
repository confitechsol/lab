$(document).ready(() => {

    const $modal = $('#modal-advice');


    $('.btn-cancel-advice').click(function(e){
        e.preventDefault();
        const $btn = $(this);
        const $row = $btn.parents('tr');
        $row.find('.advice-lab').val('');
        $row.find('.advice-details').html('');
        $row.removeClass('adviced');
    });


    $('.btn-purchase-advice').click(function(e){
        e.preventDefault();
        const $btn = $(this);
        const $row = $btn.parents('tr');
        $row.find('.advice-lab').val('');
        $row.find('.advice-details').html('Purchase Advice');
        $row.addClass('adviced');
    });


    $modal.on('show.bs.modal', function(e){

        const $title = $modal.find('.advice-item-title');
        const $modal_items = $modal.find('.item-list').empty();
        const $button = $(e.relatedTarget);
        const $row = $button.parents('tr');

        const item = $row.data('item');
        const lab = $modal.data('lab');

        $title.text( $row.find('td').eq(1).text() + ' - ' + $row.find('td').eq(2).text() );
        $modal.find('.advice-item-quantity').text( item.required_qty );

        $modal.data('item-row', $row);
        $modal.addClass('loading');

        const data = {
            code: item.item_code,
            lab_id: lab.id,
        };

        $.get( $modal.data('url'), data, function( res ){

            for( const index in res ){

                if( !res.hasOwnProperty( index ) ) continue;

                const item = res[ index ];

                const $item = $('' +
                    '<tr>' +
                    '   <td class="l-id text-left"></td>' +
                    '   <td class="l-name text-left"></td>' +
                    '   <td class="l-location text-left"></td>' +
                    '   <td class="l-state text-left"></td>' +
                    '   <td class="l-reorder"></td>' +
                    '   <td class="l-stock"></td>' +
                    '   <td class="l-effective"></td>' +
                    '   <td><button class="btn-select-lab btn btn-info btn-sm" type="button">Select</button></td>' +
                    '</tr>'
                );

                $item.find('.l-id').html( item.lab.id );
                $item.find('.l-name').html( item.lab.name );
                $item.find('.l-location').html( item.lab.location );
                $item.find('.l-state').html( item.lab.state );
                $item.find('.l-reorder').html( item.re_order );
                $item.find('.l-stock').html( item.current_stock );
                $item.find('.l-effective').html( item.effective_stock );
                $item.data('item', item);

                $modal_items.append( $item );
            }

        }).always(() => $modal.removeClass('loading') );

    });


    $modal.on('click', '.btn-select-lab', function(e){

        e.preventDefault();

        const $btn      = $(this);
        const $lab_row  = $btn.parents('tr');
        const $item_row = $modal.data('item-row');

        const lab = $lab_row.data('item').lab;

        $item_row.find('.advice-lab').val( lab.id );
        $item_row.find('.advice-details').html( 'Transfer from ' + lab.name );
        $item_row.addClass('adviced');

        $modal.modal('hide');

    });

});