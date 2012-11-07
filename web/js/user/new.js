var _displayName = 'fl';

var _sum_userinfo = 6;
var _sum_zarafa = 1;

var _check_sn = 'no';
var _check_givenName = 'no';
var _check_cn = 'no';
var _check_uid = 'no';
var _check_displayName = 'no';
var _check_userPassword = 'no';
var _check_confirmPassword = 'no';
var _check_emailAddress = 'no';

var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;


$(document).ready(function() {

    $('.button_cancel').click(function() {
        $('#form_cancel').submit();
    });

    $('input#zdata_sn').observe_field(0.7, function() {
        /* ?? do not work onn mozilla firefox 16.0.2
        if ( (strlen($('input#zdata_sn').val() > 0)) && (strlen($('input#zdata_givenName').val() > 0)) ) {
        */
        if ( strlen($('input#zdata_sn').val()) > 0 ) {
            if ( strlen($('input#zdata_givenName').val()) > 0 ) {
                $('#zdata_cn').val( sprintf("%s %s", $('input#zdata_sn').val(), $('input#zdata_givenName').val() ) ) ;
            }
        }
    });

    $('input#zdata_givenName').observe_field(0.7, function() {
        /* ?? do not work onn mozilla firefox 16.0.2
        if ( (strlen($('input#zdata_sn').val() > 0)) && (strlen($('input#zdata_givenName').val() > 0)) ) {
        */
        if ( strlen($('input#zdata_sn').val()) > 0 ) {
            if ( strlen($('input#zdata_givenName').val()) > 0 ) {
                $('#zdata_cn').val( sprintf("%s %s", $('input#zdata_sn').val(), $('input#zdata_givenName').val() ) ) ;
            }
        }
    });

    $('input#zdata_cn').observe_field(0.7, function() {

        if ( $('input#zdata_cn').length ) {
            $.get( json_checkcn_url, {
                companyDn: $('input#zdata_companyDn').val(),
                name: $(this).val()
            },
            function(data){

                if ( data.disabled == true ) {
                    $('#sn').addClass('ym-error');
                    $('#givenName').addClass('ym-error');

                    $('input#zdata_displayName').val(null); 
                    $('input#zdata_uid').val(null); 

                    _check_sn = 'no';
                    _check_givenName = 'no';
                    _check_cn = 'no';
                } else {
                    $('#sn').removeClass('ym-error');
                    $('#givenName').removeClass('ym-error');

                    $('input#zdata_displayName').val( buildDiplayName($('input#zdata_givenName'), $('input#zdata_sn')) ); 
                    $('input#zdata_uid').val( buildUserName($('input#zdata_givenName'), $('input#zdata_sn')) ); 

                    _check_sn = 'yes';
                    _check_givenName = 'yes';
                    _check_cn = 'yes';
                }
            }, 'json');
        }
//        checkSumUserInfo()
    });

    $('input#zdata_userPassword').observe_field(0.7, function() {
        if ( strlen($('input#zdata_userPassword').val()) == 0 ) {
            $('#userPassword').addClass('ym-error');
            _check_userPassword = 'no';
        } else {
            $('#userPassword').removeClass('ym-error');
            _check_userPassword = 'yes';
        }
//        checkSumUserInfo()
    });


    $('input#zdata_confirmPassword').observe_field(0.7, function() {
        if ( _check_userPassword == 'yes' ) {
            if ( $('input#zdata_userPassword').val() == $('input#zdata_confirmPassword').val() ) {
                $('#userPassword').removeClass('ym-error');
                $('#confirmPassword').removeClass('ym-error');
                _check_confirmPassword = 'yes';
            } else {
                $('#userPassword').addClass('ym-error');
                $('#confirmPassword').addClass('ym-error');
                _check_confirmPassword = 'no';
            }
//            checkSumUserInfo()
        }
    });

    $('select#zdata_zarafaAccount').change(function() {
        if ($(this).val() == 1) {
          $('#zarafa-settings').slideDown('slow');
          $('input#zdata_mail').val( buildLhsEmailAddress($('input#zdata_givenName'), $('input#zdata_sn')) );
          $('input#zdata_emailAddress').val(buildEmailAddress($('input#zdata_mail'), $('#zdata_domain'))) ;
        } else {
          $('input#zdata_mail').val(null);
          $('#zarafa-settings').slideUp();
        }
    });

    $('input#zdata_mail').observe_field(0.5, function() {
        $('input#zdata_emailAddress').val(buildEmailAddress($(this), $('#zdata_domain'))) ;
    });

    $('#zdata_domain').change(function() {
        $('input#zdata_emailAddress').val(buildEmailAddress($('#zdata_mail'), $(this))) ;
    });

    $('input#zdata_emailAddress').observe_field(0.2, function() {
        if ( ! emailReg.test($(this).val()) ) {
            $('#mail').addClass('ym-error');
            $('#domain').addClass('ym-error');
        } else {
            $('.button_submit').attr('disabled', true);
            $.getJSON( json_checkemail_url, { email: $(this).val() }, function(data) {
                if ( ! data.disabled ) {
                    $('#mail').removeClass('ym-error');
                    $('#domain').removeClass('ym-error');
                    _check_emailAddress = 'yes';
                } else {
                    $('#mail').addClass('ym-error');
                    $('#domain').addClass('ym-error');
                    _check_emailAddress = 'no';
                }
            });
        }
    });





    $('select#zdata_zarafaQuotaOverride').click(function() {
        if ($(this).val() == 1) {
            $('#zarafa-settings-zarafaquotawarn').slideDown('slow');
        } else {
            $('#zarafa-settings-zarafaquotawarn').slideUp();
        }
    });








/*
    $('#switch').click( function() {
        if ( _displayName == 'fl' ) {
            $('input#zdata_displayName').val( sprintf("%s %s", $('input#zdata_givenName').val(), $('input#zdata_sn').val() ) ) ;
            _displayName = 'lf';
        } else {
            $('input#zdata_displayName').val( sprintf("%s %s", $('input#zdata_sn').val(), $('input#zdata_givenName').val() ) ) ;
            _displayName = 'fl';
        }
    });

    $('#zdata_userPassword').pwdMeter({
        minLength: 6,
        displayGeneratePassword: false,
        generatePassText: 'Password Generator',
        generatePassClass: 'GeneratePasswordLink',
        randomPassLength: 13           
    });

    $("#userform").submit(function(e) {
        var _md5 = $('input#zdata_userPassword').crypt({method:"md5",source:""});
        $('input#zdata_userPassword').val(_md5);
        $('input#zdata_confirmPassword').val(_md5);
    });

    $('#zdata_zarafaQuotaOverride').click(function() {
        if ( $(this).is(':checked')) {
            $('#quota_setting').show();
        } else {
            $('#quota_setting').hide();
        }
    });
*/
});


function checkSumUserInfo() {

    $('#goto_section_zarafa').attr('disabled', true);
    
    if ( ( _check_sn == 'yes' ) && 
         ( _check_givenName == 'yes' ) &&
         ( _check_cn == 'yes' ) && 
         ( _check_displayName == 'yes' ) && 
         ( _check_userPassword == 'yes' ) && 
         ( _check_confirmPassword == 'yes' ) 
       ) {
        $("#goto_section_zarafa").removeAttr("disabled");
    } else {
        $('#goto_section_zarafa').attr('disabled', true);
    }
}
