(function($){

    $.fn.is_loading = function(){
        return this.hasClass('is-loading');
    };

    $.fn.enable_loading = function(){
        return this.addClass('is-loading');
    };

    $.fn.disable_loading = function(){

        if( this.is_loading() ){
            this.removeClass('is-loading')
        }

        return this;
    };

})(jQuery);