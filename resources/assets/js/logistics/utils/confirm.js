(function ($) {

    $(document).ready(function(){
        let $confirm_items = $('[data-confirm]');
        $confirm_items.on('click', function( e ) {
            if( !confirm( $(this).data('confirm') ) ){
                e.preventDefault();
                e.stopImmediatePropagation();
            }
        });
    });

})(jQuery);