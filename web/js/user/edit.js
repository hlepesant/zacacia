$(document).ready(function(){

    var override_quota = 0;
    var quota_is_ok = 1;

    function validateForm() {
        form_is_valid = false;
    
        console.log( "quota_is_ok = " + quota_is_ok );
        if ( (!override_quota) || (quota_is_ok) )  { form_is_valid = true; } else { form_is_valid = false; console.log( "ko = quota"); }

        // if ( $('#form_sn').parent("fieldset.form-group").hasClass('has-success') ) { form_is_valid = true; } else { form_is_valid = false; console.log( "ko = sn"); }
        // if ( $('#form_givenname').parent("fieldset.form-group").hasClass('has-success') ) { form_is_valid = true; } else { form_is_valid = false; console.log( "ko = givenname"); }
        // if ( $('#form_uid').parent("fieldset.form-group").hasClass('has-success') ) { form_is_valid = true; } else { form_is_valid = false; console.log( "ko = uid"); }
        // if ( $('#form_userpassword').parent("fieldset.form-group").hasClass('has-success') ) { form_is_valid = true; } else { form_is_valid = false; console.log( "ko = userpassword"); }
        // if ( $('#form_confpass').parent("fieldset.form-group").hasClass('has-success') ) { form_is_valid = true; } else { form_is_valid = false; console.log( "ko = confpass"); }

        // if ( $('#form_zarafaquotaoverride').val() == 1 ) {
        //     if ( $('#form_zarafaquotasoft').parent("fieldset.form-group").hasClass('has-success') ) { form_is_valid = true; } else { form_is_valid = false; console.log( "ko = zarafaquotasoft"); }
        //     if ( $('#form_zarafaquotawarn').parent("fieldset.form-group").hasClass('has-success') ) { form_is_valid = true; } else { form_is_valid = false; console.log( "ko = zarafaquotawarn"); }
        //     if ( $('#form_zarafaquotahard').parent("fieldset.form-group").hasClass('has-success') ) { form_is_valid = true; } else { form_is_valid = false; console.log( "ko = zarafaquotahard"); }
        // }

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
        var useremail = (email + '@' + domain);
        var userid = ($('#form_userid').val());
    
        if ( useremail.length > 6 ) {
            event.preventDefault();
            $.getJSON('/api/check/edituseremail/' + userid + '/' + useremail , function(data){
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

    function validateQuota() {

        var soft_quota = parseInt($('#form_zarafaquotasoft').val(), 10);
        var warn_quota = parseInt($('#form_zarafaquotawarn').val(), 10);
        var hard_quota = parseInt($('#form_zarafaquotahard').val(), 10);

        if ( ( soft_quota < warn_quota ) && ( warn_quota < hard_quota ) ) {
            console.log( "soft_quota < warn_quota && warn_quota < hard_quota" );
            $('#form_zarafaquotasoft').parent().parent("fieldset.form-group").removeClass('has-error');
            $('#form_zarafaquotawarn').parent().parent("fieldset.form-group").removeClass('has-error');
            $('#form_zarafaquotahard').parent().parent("fieldset.form-group").removeClass('has-error');

            $('#form_zarafaquotasoft').parent().parent("fieldset.form-group").addClass('has-success');
            $('#form_zarafaquotawarn').parent().parent("fieldset.form-group").addClass('has-success');
            $('#form_zarafaquotahard').parent().parent("fieldset.form-group").addClass('has-success');
            
            return 1;
        } else {
            console.log( "soft_quota > warn_quota ||  warn_quota > hard_quota" );
            $('#form_zarafaquotasoft').parent().parent("fieldset.form-group").removeClass('has-success');
            $('#form_zarafaquotawarn').parent().parent("fieldset.form-group").removeClass('has-success');
            $('#form_zarafaquotahard').parent().parent("fieldset.form-group").removeClass('has-success');

            $('#form_zarafaquotasoft').parent().parent("fieldset.form-group").addClass('has-error');
            $('#form_zarafaquotawarn').parent().parent("fieldset.form-group").addClass('has-error');
            $('#form_zarafaquotahard').parent().parent("fieldset.form-group").addClass('has-error');

            return 0;
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

    $('#form_sn').focus();
  
    $('#zarafa_quota_options').hide();
    // $('#form_sn').parent("fieldset.form-group").addClass('has-success');
    // $('#form_givenname').parent("fieldset.form-group").addClass('has-success');

    var platform = ($('#form_platform').val());
    var organization = ($('#form_organization').val());

    $('#form_sn, #form_givenname').on('change blur click', function(){

        var sn = ($('#form_sn').val());
        var givenname = ($('#form_givenname').val());
    
        if ( sn.length ) {
            $('#form_sn').parent("fieldset.form-group").removeClass('has-error').addClass('has-success');
        } else {
            $('#form_sn').parent("fieldset.form-group").removeClass('has-success').addClass('has-error');
        }

        if ( givenname.length ) {
            $('#form_givenname').parent("fieldset.form-group").removeClass('has-error').addClass('has-success');
        } else {
            $('#form_givenname').parent("fieldset.form-group").removeClass('has-success').addClass('has-error');
        }
    });
  
    $('#form_email').on('change blur click focus', function() {
        validateEmail();
        validateForm()
    });

    $('#form_domain').on('change', function() {
        validateEmail();
        validateForm()
    });

    $('#form_zarafaquotaoverride').change(function(){
        var quota_override = ($('#form_zarafaquotaoverride').val());
        if ( quota_override == "1" ) {
            $('#zarafa_quota_options').show();
            quota_is_ok = 0;
            override_quota = 1;
        } else {
            $('#zarafa_quota_options').hide();
            quota_is_ok = 1;
            override_quota = 0;
        }
    });

    $('#form_zarafaquotasoft').on('change blur click focus', function() {
        quota_is_ok = validateQuota()
        validateForm()
    });

    $('#form_zarafaquotawarn').on('change blur click focus', function() {
        quota_is_ok = validateQuota()
        validateForm()
    });

    $('#form_zarafaquotahard').on('change blur click focus', function() {
        quota_is_ok = validateQuota()
        validateForm()
    });

});
