$(document).ready(() => {


    function template(){
        return '' +
            '<tr>' +
            '   <td><input type="text" class="form-control batch-lot" placeholder="Batch / Lot No."></td>' +
            '   <td><input type="date" class="form-control batch-date" placeholder="Expiry Date"></td>' +
            '   <td><input type="number" value="0" min="0" step="0.01" class="form-control batch-quantity" placeholder="Quantity"></td>' +
            '</tr>';
    }


    const $modal = $('#modal-item-batches');
    if( !$modal.length ) return;

    const $batches = $modal.find('.batch-list');

    $modal.on('show.bs.modal', (e) => {
        const $btn = $( e.relatedTarget );
        const $target_row = $btn.parents('tr');
        $modal.data('target-row', $target_row);

        $batches.empty();

        let batch_items = null;
        try{ batch_items = JSON.parse( $target_row.find('.batches').val() ); }
        catch (e){ batch_items = null; }

        if( typeof batch_items !== 'undefined' && batch_items ){
            for( const i in batch_items ){
                if( !batch_items.hasOwnProperty( i ) ) continue;

                const $template = $( template() );
                const batch_item = batch_items[ i ];

                $template.find('.batch-lot').val( batch_item.lot );
                $template.find('.batch-date').val( batch_item.date );
                $template.find('.batch-quantity').val( batch_item.quantity );

                $batches.append( $template );
            }
        }

        $batches.append( template() );

    });


    $batches.on('change', '.batch-lot', function(){
        const $input = $(this);

        const $row = $input.parents('tr');

        if( $input.val().length === 0 ){
            $row.remove();
        }

        if( $batches.children().last().find('.batch-lot').val().length > 0 ){
            $batches.append( template() );
        }

    });


    $modal.submit((e) => {
        e.preventDefault();
        const $target_row = $modal.data('target-row');
        const $rows = $batches.children();
        const batch_items = [];
        let total_quantity = 0;
        $rows.each(function(i, e){

            const $row = $( e );
            const item = {
                lot: $row.find('.batch-lot').val(),
                date: $row.find('.batch-date').val(),
                quantity: parseFloat( $row.find('.batch-quantity').val() )
            };


            if( item.lot.length > 0 ){
                batch_items.push( item );
                total_quantity += item.quantity;
            }

            // Last Loop Execution =====
            if( i === $rows.length - 1 ){
                $modal.modal('hide');
                $target_row
                    .find('.batches')
                    .val( JSON.stringify( batch_items ) );

                $target_row.find('.advice-quantity').val( total_quantity );
            }
        });
    });


});