$(document).ready(function(){

    function validateForm(){
        form_is_valid = false;
    
        if ( $('#form_cn').parent("fieldset.form-group").hasClass('has-success') ) { form_is_valid = true; } else { form_is_valid = false; console.log( "ko = cn"); }

        console.log( "form is valid = " + form_is_valid);
        if ( form_is_valid ) {
            $('#form_save').removeClass('hidden').show();
        } else {
            $('#form_save').addClass('hidden').hide();
        }
    }

    $('#form_cn').focus();

    $('#form_cn').on('change blur', function(){
        var cn = ($('#form_cn').val());
        if ( cn.length > 3 ) {
            // event.preventDefault();
            $.getJSON('/api/check/domain/' + cn, function(data) {
                var domain_exist = data['data'];
                if ( domain_exist == "0" ) {
                    $('#form_cn').parent("fieldset.form-group").removeClass('has-error').addClass('has-success');
                    $('#glyphicon_form_cn').removeClass('glyphicon-remove').addClass('glyphicon-ok');
                } else {
                    $('#form_cn').parent("fieldset.form-group").removeClass('has-success').addClass('has-error');
                    $('#glyphicon_form_cn').removeClass('glyphicon-ok').addClass('glyphicon-remove');
                }
            })
            .fail(function(){
                console.log( "fail to get data for username" );
            })
            .always(function(){
                validateForm();
            });
        }
    });

    $('#form_cancel').click( function(){
        BootstrapDialog.confirm({
            title: 'INFO',
            message: 'All changes will be lost !!',
            type: BootstrapDialog.TYPE_INFO,
            closable: false,
            draggable: false,
            btnCancelLabel: 'Cancel',
            btnOKLabel: 'It\'s OK !',
            btnOKClass: 'btn-info',
            callback: function(result) {
                if (result) {
                    $(location).attr('href', cancel_redirect);
                }
            }
        });
    });

});
