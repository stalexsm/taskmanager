$(function(){
    // Подтверждение новых задач
    $( '.confirm-js' ).approve();

    // активируем подсказки на bootstrap.
    $("[data-toggle='tooltip']").tooltip();

    // Динамический фильтр.
    $( '#filter-js' ).on( 'click', function(){

        var types = $('input[name^="type"]:checked').map(function() {return this.value;}).get();

        //if( types )
        //{
        //    $.ajax({
        //        url: '/',
        //        type: 'POST',
        //        cache: false,
        //        data: { types: types, cmd: '_getDataFilter' },
        //        success: function( response ){
        //            console.info( response );
        //        }
        //    });
        //}
    } );
});