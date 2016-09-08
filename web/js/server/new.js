// ValidIpAddressRegex = "^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$";
// ValidHostnameRegex = "^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$";
$(document).ready(function() {

    function validateForm() {
        form_is_valid = false;
    
        if ( $('#form_cn').val().length ) { form_is_valid = true; } else { form_is_valid = false; console.log( "ko = cn"); }
        if ( $('#form_iphostnumber').val().length ) { form_is_valid = true; } else { form_is_valid = false; console.log( "ko = iphostnumber"); }

        console.log( "form is valid = " + form_is_valid);
    
        if ( form_is_valid ) {
            $('#form_save').show();
        } else {
            $('#form_save').hide();
        }
    }

    $('#form_save').hide();
    $('#form_cn').focus();

    $('#form_cn').on('change blur', function(){
        var cn = ($('#form_cn').val());
        if ( cn.length > 3 ) {
            // event.preventDefault();
            $.getJSON('/api/check/server/' + cn, function(data) {
                var server_exist = data['data'];
                if ( server_exist == "0" ) {
                    console.log( "show #form_save" );
                    $('#form_cn').parent("fieldset.form-group").removeClass('has-error');
                    $('#form_cn').parent("fieldset.form-group").addClass('has-success');
                } else {
                    console.log( "hide #form_save" );
                    $('#form_cn').parent("fieldset.form-group").addClass('has-success');
                    $('#form_cn').parent("fieldset.form-group").removeClass('has-error');
                }
            })
            .fail(function() {
                console.log( "fail to get data for cn" );
            })
            .always(function() {
                validateForm()
            });
        }
    });

    $('#form_iphostnumber').on('change blur', function(){
        var ip = ($('#form_iphostnumber').val());
        if ( ip.length > 3 ) {
            // event.preventDefault();
            $.getJSON('/api/check/serverip/' + ip, function(data) {
                var ip_exist = data['data'];
                if ( ip_exist == "0" ) {
                    console.log( "show #form_save" );
                    $('#form_iphostnumber').parent("fieldset.form-group").removeClass('has-error');
                    $('#form_iphostnumber').parent("fieldset.form-group").addClass('has-success');
                } else {
                    console.log( "hide #form_save" );
                    $('#form_iphostnumber').parent("fieldset.form-group").addClass('has-success');
                    $('#form_iphostnumber').parent("fieldset.form-group").removeClass('has-error');
                }
            })
            .fail(function() {
                console.log( "fail to get data for iphostnumber" );
            })
            .always(function() {
                validateForm()
            });
        }
    });

    $('#form_cancel').on('click', function(){
        if(confirm('Change have not been saved. Do you want to leave ?')) {
            $(location).attr('href', cancel_redirect);
        }
    });
});
