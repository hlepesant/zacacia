// ValidHostnameRegex = "^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$";
$(document).ready(function() {

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
            $.getJSON('/api/check/domain/' + cn, function(data) {
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
    });
});
