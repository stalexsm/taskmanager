//Самаписная библиотека, по подтверждению проектов версия 1.0.
(function($){

    var data = [];
    var methods = {

        init: function() {
            return this.each(function(){
                $(this).bind('click.approve', function(){

                    data.button =  $(this).attr('rel');
                    data.pId = $('.pId').attr('pid');

                    switch(data.button) {
                        case 'approve':
                            methods.approve();
                            break;
                        default:
                            $(window).unbind('.approve');
                            break;
                    }
                });
            });
        },
        approve: function(){

            $.ajax({
                url: '/',
                type: "POST",
                data: { pId: data.pId, cmd: '_approve', act: 'approve' },
                success: function(response){
                    if(response) document.location.replace('/');
                }
            });
        }
    };

    $.fn.approve = function( method ){
        if(methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if(typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Метод с именем '+ method + ' не существует для jQuery.approveOrReject');
        }
    };
})(jQuery);