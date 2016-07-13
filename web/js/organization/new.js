$(document).ready(function() {

    $('#form_save').hide();
    $('#form_cn').focus();

    $('#form_cancel').on('click', function(){
        if(confirm('Change have not been saved. Do you want to leave ?')) {
            $(location).attr('href', cancel_redirect);
        }
    });

    $('#form_cn').change(function(){
        var platform = ($('#form_platform').val());
        var cn = ($('#form_cn').val());
        if ( cn.length > 3 ) {
            event.preventDefault();
            $.getJSON('/api/check/organization/' + platform + '/' + cn, function(data) {
                var organization_exist = data['data'];
                if ( organization_exist == "0" ) {
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
    });

});
