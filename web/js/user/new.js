$(document).ready(function(){

    var override_quota = 0;
    var quota_is_ok = 1;

    function validateForm() {
        form_is_valid = false;
    
        if ( (!override_quota) || (quota_is_ok) )  { form_is_valid = true; } else { form_is_valid = false; console.log( "ko = quota"); }

        if ( $('#form_sn').parent("fieldset.form-group").hasClass('has-success') ) { form_is_valid = true; } else { form_is_valid = false; console.log( "ko = sn"); }
        if ( $('#form_givenname').parent("fieldset.form-group").hasClass('has-success') ) { form_is_valid = true; } else { form_is_valid = false; console.log( "ko = givenname"); }
        if ( $('#form_displayname').parent("fieldset.form-group").hasClass('has-success') ) { form_is_valid = true; } else { form_is_valid = false; console.log( "ko = displayname"); }
        if ( $('#form_uid').parent("fieldset.form-group").hasClass('has-success') ) { form_is_valid = true; } else { form_is_valid = false; console.log( "ko = uid"); }
        if ( $('#form_userpassword').parent("fieldset.form-group").hasClass('has-success') ) { form_is_valid = true; } else { form_is_valid = false; console.log( "ko = userpassword"); }
        if ( $('#form_confpass').parent("fieldset.form-group").hasClass('has-success') ) { form_is_valid = true; } else { form_is_valid = false; console.log( "ko = confpass"); }

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
    
        if ( useremail.length > 6 ) {
            event.preventDefault();
            $.getJSON('/api/check/useremail/' + useremail , function(data){
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

        var soft_quota = $('#form_zarafaquotasoft').val();
        var warn_quota = $('#form_zarafaquotawarn').val();
        var hard_quota = $('#form_zarafaquotahard').val();

        if ( soft_quota < warn_quota && warn_quota < hard_quota ) {
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

  
    $('#form_cancel').on('click', function(){
        if(confirm('Change have not been saved. Do you want to leave ?')) {
            $(location).attr('href', cancel_redirect);
        }
    });


    validateForm()

    $('#form_sn').focus();
  
    $('#form_displayname').prop('readonly', 'readonly')
  
    $('#zarafa_quota_options').hide();

    var platform = ($('#form_platform').val());
    var organization = ($('#form_organization').val());

    $('#form_sn, #form_givenname').on('change blur click', function(){

        var sn = ($('#form_sn').val());
        var givenname = ($('#form_givenname').val());
    
        if ( sn.length && givenname.length ) {
            var displayname = (sn + ' ' + givenname);
            $('#form_displayname').val(displayname);

            event.preventDefault();
            $.getJSON('/api/check/displayname/' + platform + '/' + organization + '/' + displayname , function(data){
                var displayname_exist = data['data'];
                if ( displayname_exist == '0' ) {
                    console.log( "displayname is free");
                    $('#form_sn').parent("fieldset.form-group").removeClass('has-error');
                    $('#form_givenname').parent("fieldset.form-group").removeClass('has-error');
                    $('#form_displayname').parent("fieldset.form-group").removeClass('has-error');

                    $('#form_sn').parent("fieldset.form-group").addClass('has-success');
                    $('#form_givenname').parent("fieldset.form-group").addClass('has-success');
                    $('#form_displayname').parent("fieldset.form-group").addClass('has-success');
                } else {
                    console.log( "displayname is used");
                    $('#form_sn').parent("fieldset.form-group").removeClass('has-success');
                    $('#form_givenname').parent("fieldset.form-group").removeClass('has-success');
                    $('#form_displayname').parent("fieldset.form-group").removeClass('has-success');

                    $('#form_sn').parent("fieldset.form-group").addClass('has-error');
                    $('#form_givenname').parent("fieldset.form-group").addClass('has-error');
                    $('#form_displayname').parent("fieldset.form-group").addClass('has-error');
                }
            })
            .fail(function() {
                console.log( "fail to get data for displayname" );
            })
            .always(function() {
                validateForm()
                $('#form_uiserd').val(sn.slice(0,1).toLowerCase() + givenname.toLowerCase());
                $('#form_email').val(sn.toLowerCase() + '.' + givenname.toLowerCase());
            });
        }
    });
  
    $('#form_uid').on('blur change click focus', function(){
    
        var uid = ($('#form_uid').val());
        if ( uid.length ) {
            event.preventDefault();
            $.getJSON('/api/check/username/' + platform + '/' + organization + '/' + uid, function(data){
                var uid_exist = data['data'];
                console.log( "uid_exist = " + uid_exist );
                if ( uid_exist == "0" ) {
                    console.log( "uid is free");
                    $('#form_uid').parent("fieldset.form-group").removeClass('has-error')
                    $('#form_uid').parent("fieldset.form-group").addClass('has-success');
                } else {
                    console.log( "uid is used");
                    $('#form_uid').parent("fieldset.form-group").removeClass('has-success')
                    $('#form_uid').parent("fieldset.form-group").addClass('has-error');
                }
            })
            .fail(function() {
                console.log( "fail to get data for uid" );
            })
            .always(function() {
                validateForm()
            });
        }
    });

    $('#form_userpassword').on('change blur', function(){
        console.log( "userpassword length = " + $('#form_userpassword').val().length );
        if ( $('#form_userpassword').val().length == 0 ) {
            $('#form_confpass').parent("fieldset.form-group").removeClass('has-success')
            $('#form_userpassword').parent("fieldset.form-group").addClass('has-error')
        } else {
            $('#form_confpass').parent("fieldset.form-group").removeClass('has-error')
            $('#form_userpassword').parent("fieldset.form-group").addClass('has-success')
            validateForm()
        }
    });

    $('#form_confpass').on('change blur focus', function(){
        if ( $('#form_userpassword').val() == $('#form_confpass').val() ) {
            console.log( "userpassword match");
            $('#form_confpass').parent("fieldset.form-group").removeClass('has-error')
            $('#form_confpass').parent("fieldset.form-group").addClass('has-success')
            validateForm()
        } else {
            $('#form_confpass').parent("fieldset.form-group").removeClass('has-success')
            $('#form_confpass').parent("fieldset.form-group").addClass('has-error')
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
