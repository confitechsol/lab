$(document).ready(function(){

    let $hidden_when_items = $('[data-hidden-when]');
    $hidden_when_items.each(( i, e ) => {
        let $item = $( e );
        let conditions = $item.data('hidden-when');
        for( let key in conditions ){
            if( !conditions.hasOwnProperty( key ) ) continue;
            let $target = $( key );

            // Default state ===========
            $item.show();
            if( $target.attr('type') === 'checkbox' || $target.attr('type') === 'radio' ){
                if( $target.prop('checked') && $target.val() === conditions[ key ] ){
                    $item.hide();
                }
            }else{
                if( $target.val() === conditions[ key ] ){
                    $item.hide();
                }
            }

            // On target's change state ===========
            $target.change(() => {
                $item.show();
                if( $target.attr('type') === 'checkbox' || $target.attr('type') === 'radio' ){
                    if( $target.prop('checked') && $target.val() === conditions[ key ] ){
                        $item.hide();
                    }
                }else{
                    if( $target.val() === conditions[ key ] ){
                        $item.hide();
                    }
                }
            });

        }
    });


    let $hidden_visible_items = $('[data-visible-when]');
    $hidden_visible_items.each(( i, e ) => {
        let $item = $( e );
        let conditions = $item.data('visible-when');
        for( let key in conditions ){
            if( !conditions.hasOwnProperty( key ) ) continue;
            let $target = $( key );

            // Default state ===========
            $item.hide();
            if( $target.attr('type') === 'checkbox' || $target.attr('type') === 'radio' ){
                if( $target.prop('checked') && $target.val() === conditions[ key ] ){
                    $item.show();
                }
            }else{
                if( $target.val() === conditions[ key ] ){
                    $item.show();
                }
            }

            // On target's change state ===========
            $target.change(() => {
                $item.hide();
                if( $target.attr('type') === 'checkbox' || $target.attr('type') === 'radio' ){
                    if( $target.prop('checked') && $target.val() === conditions[ key ] ){
                        $item.show();
                    }
                }else{
                    if( $target.val() === conditions[ key ] ){
                        $item.show();
                    }
                }
            });

        }
    });

});