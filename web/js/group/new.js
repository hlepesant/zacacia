$(document).ready(function(){

    function validateForm() {
        form_is_valid = false;

        if ( $('#form_cn').parent("fieldset.form-group").hasClass('has-success') ) { form_is_valid = true; } else { form_is_valid = false; console.log( "ko = cn"); }
        if ( $('#form_hasSendAs_0').prop('checked') ) {
            if ( $('#form_zarafaSendAsPrivilege').parent("fieldset.form-group").hasClass('has-success') ) {
                form_is_valid = true;
            } else {
                form_is_valid = false;
                console.log( "ko = sendas");
            }
        } else {
            console.log('checkd = ' + $('#form_hasSendAs_0').prop('checked') );
            form_is_valid = true;
        }
        if ( $('#form_member').parent("fieldset.form-group").hasClass('has-success') ) { form_is_valid = true; } else { form_is_valid = false; console.log( "ko = member"); }

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
    
        if ( groupemail.length > 6 ) {
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

    function validateSendAs() {
        if ( $('#form_hasSendAs_0').prop('checked')) {
            $('#form_zarafaSendAsPrivilege').parent().show();
            if ( $('#form_zarafaSendAsPrivilege').val().length > 0 ) {
                $('#form_zarafaSendAsPrivilege').parent("fieldset.form-group").removeClass('has-error');
                $('#form_zarafaSendAsPrivilege').parent("fieldset.form-group").addClass('has-success');
            } else {
                $('#form_zarafaSendAsPrivilege').parent("fieldset.form-group").removeClass('has-success');
                $('#form_zarafaSendAsPrivilege').parent("fieldset.form-group").addClass('has-error');
            }
        } else {
            $('#form_zarafaSendAsPrivilege option').prop('selected', false);
            $('#form_zarafaSendAsPrivilege').parent().hide();
        }
        validateForm();
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


    $('#form_zarafaSendAsPrivilege').parent().hide();

    validateForm();

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

                    $('#form_email').val( displayname_exist );
                } else {
                    console.log( "group name is used");
                    $('#form_sn').parent("fieldset.form-group").removeClass('has-success');
                    $('#form_cn').parent("fieldset.form-group").addClass('has-error');
                    $('#form_email').val('');
                }
            })
            .fail(function() {
                console.log( "fail to get data for group name" );
            })
            .always(function() {
                validateForm();
                $('#form_email').val(cn.toLowerCase());
            });
        }
    });
  
    $('#form_email').on('change blur click focus', function() {
        validateEmail();
    });

    $('#form_domain').on('change', function() {
        validateEmail();
    });

    $('#form_member').on('change blur click', function() {
        console.log('member = '+$('#form_member').val().length);
        if ( $('#form_member').val().length > 0 ) {
            $('#form_member').parent("fieldset.form-group").removeClass('has-error');
            $('#form_member').parent("fieldset.form-group").addClass('has-success');
        } else {
            $('#form_member').parent("fieldset.form-group").removeClass('has-success');
            $('#form_member').parent("fieldset.form-group").addClass('has-error');
        }
        validateForm();
    });

    $('#form_hasSendAs').on('click change', function() {
        console.log('hasSendAs = '+$('#form_hasSendAs_0').prop('checked'));
        validateSendAs();
    });


    $('#form_zarafaSendAsPrivilege').on('focus change blur', function() {
        console.log('sendas = '+$('#form_zarafaSendAsPrivilege').val().length);
        validateSendAs();
    });

});
