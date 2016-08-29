$(document).ready(function(){

//  function ShowHide(check_values){
//    console.log( "check_values = " + check_values );
//    if ( check_values ) {
//      console.log( "show #form_save" );
//      $('#form_save').show();
//    } else {
//      console.log( "hide #form_save" );
//      $('#form_save').hide();
//    }
//  }

    function validateForm() {
        form_is_valid = false;
    
        if ( $('#form_sn').val().length ) { form_is_valid = true; } else { form_is_valid = false; }
        if ( $('#form_givenname').val().length ) { form_is_valid = true; } else { form_is_valid = false; }
        if ( $('#form_displayname').val().length ) { form_is_valid = true; } else { form_is_valid = false; }
        if ( $('#form_username').val().length ) { form_is_valid = true; } else { form_is_valid = false; }
        if ( $('#form_password').val().length ) { form_is_valid = true; } else { form_is_valid = false; }
    
        if ( form_is_valid ) {
            $('#form_save').show();
        } else {
            $('#form_save').hide();
        }
    }
  
    $('#form_cancel').on('click', function(){
        if(confirm('Change have not been saved. Do you want to leave ?')) {
            $(location).attr('href', cancel_redirect);
        }
    });


    validateForm()

    $('#form_sn').focus();
  
    // $('#form_displayname').prop('readonly', 'readonly')
  
    $('#block_zarafaquotasoft').hide();
    $('#block_zarafaquotawarn').hide();
    $('#block_zarafaquotahard').hide();

    var platform = ($('#form_platform').val());
    var organization = ($('#form_organization').val());

    $('#form_sn, #form_givenname').on('change blur click', function(){

        var sn = ($('#form_sn').val());
        var givenname = ($('#form_givenname').val());
    
        if ( sn.length && givenname.length ) {
            var displayname = (sn + ' ' + givenname);
            event.preventDefault();
            $.getJSON('/api/check/displayname/' + platform + '/' + organization + '/' + displayname , function(data){
                var displayname_exist = data['data'];
                if ( displayname_exist == '0' ) {
                    console.log( "displayname is free");
                    $('#form_displayname').val(displayname);
                    //$('#form_displayname').addClass('has‐success');
                    $('#form_group_displayname').addClass('has‐success');
                } else {
                    console.log( "displayname is used");
                    //$('#form_displayname').addClass('has‐danger');
                    $('#form_group_displayname').addClass('has‐danger');
                }
            })
            .fail(function() {
                console.log( "fail to get data for displayname" );
            })
            .always(function() {
                validateForm()
                // $('#form_username').val(sn.slice(0,1).toLowerCase() + givenname.toLowerCase());
                $('#form_email').val(sn.toLowerCase() + '.' + givenname.toLowerCase());
            });
        }
    });
  
    $('#form_username').on('blur change click focus', function(){
    
        var username = ($('#form_username').val());
        if ( username.length ) {
            event.preventDefault();
            $.getJSON('/api/check/username/' + platform + '/' + organization + '/' + username, function(data){
                var username_exist = data['data'];
                console.log( "username_exist = " + username_exist );
                if ( username_exist == "0" ) {
                    console.log( "username is free");
                    // $('#form_username').parent("div.form-group").removeClass('has‐danger');
                    // $('#form_username').parent("div.form-group").addClass('has‐success');
                    $('#form_username').removeClass('has‐danger');
                    $('#form_username').addClass('has‐success');
                } else {
                    console.log( "username is used");
                    // $('#form_username').parent("div.form-group").removeClass('has‐success');
                    // $('#form_username').parent("div.form-group").addClass('has‐danger');
                    $('#form_username').removeClass('has‐success');
                    $('#form_username').addClass('has‐danger');
                }
            })
            .fail(function() {
                console.log( "fail to get data for username" );
            })
            .always(function() {
                validateForm()
            });
        }
    });

    $('#form_password').on('change blur', function(){
        console.log( "password length = " + $('#form_password').val().length );
        if ( $('#form_password').val().length == 0 ) {
            $('#form_password').parent("div.form-group").addClass('has-danger')
        } else {
            $('#form_password').parent("div.form-group").addClass('has-success')
            validateForm()
        }
    });

    $('#form_zarafaquotaoverride').change(function(){
        var quota_override = ($('#form_zarafaquotaoverride').val());
        if ( quota_override == "1" ) {
            $('#block_zarafaquotasoft').show();
            $('#block_zarafaquotawarn').show();
            $('#block_zarafaquotahard').show();
        } else {
            $('#block_zarafaquotasoft').hide();
            $('#block_zarafaquotawarn').hide();
            $('#block_zarafaquotahard').hide();
        }
    });

});
