// ValidIpAddressRegex = "^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$";
// ValidHostnameRegex = "^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$";
$(document).ready(function() {

//    $('#form_save').hide();
    $('#form_cn').focus();
    $('#form_zarafahttpport').addClass('has-success');

//    $('#form_cn').change(function(){
//        var cn = ($('#form_cn').val());
//        if ( cn.length > 3 ) {
//            event.preventDefault();
//            $.getJSON('/api/check/platform/' + cn, function(data) {
//                var platform_exist = data['data'];
//                if ( platform_exist == "0" ) {
//                    console.log( "show #form_save" );
//                    $('#form_save').show();
//                }
//            })
//            .fail(function() {
//                console.log( "fail to get data" );
//            });
//        }
//    });

    $('#form_zarafahttpport').change(function(){
        if ( $.isNumeric($('#form_zarafahttpport').val())) {
            console.log( "#form_zarafahttpport is numeric" );
            $('#form_zarafahttpport').removeClass('.has-error');
        } else {
            console.log( "#form_zarafahttpport is not numeric" );
            $('#form_zarafahttpport').addClass('has-error');
        }
    });

    $('#form_cancel').on('click', function(){
        if(confirm('Change have not been saved. Do you want to leave ?')) {
            $(location).attr('href', cancel_redirect);
        }
    });
});
