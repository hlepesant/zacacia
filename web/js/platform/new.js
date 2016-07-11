$(document).ready(function(){

    $('#form_save').hide();
    $('#form_cn').focus();

    $('#form_cancel').on('click', function(){
        if(confirm('Change have not been saved. Do you want to leave ?')) {
            $(location).attr('href', cancel_redirect);
        }
    });

    $('#form_cn').change(function(){
        var cn = ($('#form_cn').val());
        if ( cn.length > 3 ) {
            event.preventDefault();
            $.getJSON('/api/check/platform/' + cn, function(data){
//                $.each( data, function( key, val ) {
//                    alert('key = ' + key + '| val = ' + val);
//                });
                var platform_exist = data['data'];
                if ( platform_exist == "0" ) {
                    console.log( "show #form_save" );
                    $('#form_save').show();
                } else {
                    console.log( "hide #form_save" );
                    $('#form_save').hide();
                }
            })
//            .done(function() {
//                console.log( "done" );
//            })
            .fail(function() {
                console.log( "fail to get data" );
            });
        }
    });
});
