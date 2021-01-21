(function($){

    $.fn.is_prop_enable = function(){
        return !this.prop('disabled');
    };

    $.fn.prop_enable = function(){
        return this.prop('disabled', false);
    };

    $.fn.prop_disable = function(){
        return this.prop('disabled', true);
    };

})(jQuery);