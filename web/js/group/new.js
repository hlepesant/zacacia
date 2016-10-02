$(document).ready(function(){

    function validateForm() {
        form_is_valid = false;

        if ( $('#form_cn').parent("fieldset.form-group").hasClass('has-success') ) { form_is_valid = true; } else { form_is_valid = false; console.log( "ko = cn"); }

        console.log( "form is valid = " + form_is_valid);
    
        if ( form_is_valid ) {
            $('#form_save').removeClass('hidden').show();
        } else {
            $('#form_save').addClass('hidden').hide();
        }
    }

    function validateEmail() {

        var email_free = '0';
        var email = ($('#form_email').val());
        var domain = ($('#form_domain').val());
        var groupemail = (email + '@' + domain);
    
        if ( useremail.length > 6 ) {
            event.preventDefault();
            $.getJSON('/api/check/useremail/' + groupemail , function(data){
                var useremail_exist = data['data'];
                if ( useremail_exist == '0' ) {
                    $('#form_email').parent("fieldset.form-group").removeClass('has-error');
                    $('#form_domain').parent("fieldset.form-group").removeClass('has-error');

                    $('#form_email').parent("fieldset.form-group").addClass('has-success');
                    $('#form_domain').parent("fieldset.form-group").addClass('has-success');
        
                } else {
                    $('#form_email').parent("fieldset.form-group").removeClass('has-success');
                    $('#form_domain').parent("fieldset.form-group").removeClass('has-success');

                    $('#form_email').parent("fieldset.form-group").addClass('has-error');
                    $('#form_domain').parent("fieldset.form-group").addClass('has-error');
                    $('#form_mail').val('');
                }
            })
            .fail(function() {
                console.log( "fail to get data for useremail" );
            })
            .always(function() {
                // validateForm()
            });
            
        }
    }
  
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
            callback: function(result){
                if (result) {
                    $(location).attr('href', cancel_redirect);
                }
            }
        });
    });


    validateForm()

    $('#form_cn').focus();
  
    var platform = ($('#form_platformid').val());
    var organization = ($('#form_organizationid').val());

    $('#form_cn').on('change blur click', function(){

        var cn = ($('#form_cn').val());
    
        if ( cn.length ) {

            event.preventDefault();
            $.getJSON('/api/check/groupname/' + platform + '/' + organization + '/' + cn, function(data){
                var displayname_exist = data['data'];
                if ( displayname_exist == '0' ) {
                    console.log( "group name is free");
                    $('#form_cn').parent("fieldset.form-group").removeClass('has-error');
                    $('#form_cn').parent("fieldset.form-group").addClass('has-success');
                } else {
                    console.log( "group name is used");
                    $('#form_sn').parent("fieldset.form-group").removeClass('has-success');
                    $('#form_cn').parent("fieldset.form-group").addClass('has-error');
                }
            })
            .fail(function() {
                console.log( "fail to get data for group name" );
            })
            .always(function() {
                validateForm()
                $('#form_email').val(cn.toLowerCase());
            });
        }
    });
  
    $('#form_email').on('change blur click focus', function() {
        validateEmail();
    //    validateForm()
    });

    $('#form_domain').on('change', function() {
        validateEmail();
    //    validateForm()
    });
});
