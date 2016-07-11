$(document).ready(function() {

    $('#form_save').hide();
    $('#form_cn').focus();

    $('#form_cn').change(function(){
/*      
        var cn = ($('#form_cn').val());
        if ( cn.length > 3 ) {
            event.preventDefault();
            $.getJSON('/api/check/organization/' + cn, function(data) {
                var server_exist = data['data'];
                if ( server_exist == "0" ) {
                    console.log( "show #form_save" );
                    $('#form_save').show();
                } else {
                    console.log( "hide #form_save" );
                    $('#form_save').hide();
                }
            })
            .fail(function() {
                console.log( "fail to get data for cn" );
            });
        }
*/
    });
    $('#form_save').show();

});
