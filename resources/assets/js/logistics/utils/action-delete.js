(function ($) {

    $(document).ready(function(){
        $('body').on('click', '[data-action="delete"]', function(e){

            e.preventDefault();

            let url = $(this).attr('href');
            if( !url ){
                url = $(this).data('target');
            }

            let $form = $('<form>').attr('action', url).attr('method', 'post');
            let token = $('meta[name="csrf-token"]').attr('content');
            $form.append('<input type="hidden" name="_token" value="' + token + '" />');
            $form.append('<input type="hidden" name="_method" value="delete" />');
            $form.appendTo('body').submit();
        });

    });

})(jQuery);