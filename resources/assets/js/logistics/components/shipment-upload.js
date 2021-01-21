$(document).ready(() => {

    const $forms = $('.form-shipment-upload');
    if( !$forms.length ) return;

    $forms.find('.input-file').change( function() {
        $(this).parents('form').submit();
    });

    // $forms.each((i, e) => {
    //     const $form = $(e);
    //     $form.find('.input-file')
    //         .change(() => {
    //             console.log( "Changed" );
    //             $form.submit();
    //         });
    // });


});