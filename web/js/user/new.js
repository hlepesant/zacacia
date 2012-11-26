var _check_sn = 'no';
var _check_givenName = 'no';
var _check_cn = 'no';
var _check_uid = 'no';
var _check_userPassword = 'no';
var _check_confirmPassword = 'no';
var _check_emailAddress = 'no';
var _check_quotas = 'yes';

var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;


$(document).ready(function() {

    $('.button_cancel').click(function() {
        $('#form_cancel').submit();
    });

    $('input#zdata_sn').observe_field(0.7, function() {
        if ( strlen($('input#zdata_sn').val()) > 0 ) {
            if ( strlen($('input#zdata_givenName').val()) > 0 ) {
                $('#zdata_cn').val( sprintf("%s %s", $('input#zdata_sn').val(), $('input#zdata_givenName').val() ) ) ;
            }
        }
    });

    $('input#zdata_givenName').observe_field(0.7, function() {
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
        checkSumUserInfo()
    });

    $('input#zdata_uid').observe_field(0.5, function() {
        if ( $('input#zdata_uid').length ) {
            $.get( json_checkuid_url, { name: $(this).val() },
            function(data) {
                if ( data.disabled == true ) {
                    $('#uid').addClass('ym-error');
                    _check_uid = 'no';
                } else {
                    $('#uid').removeClass('ym-error');
                    _check_uid = 'yes';
                }
            }, 'json');
        }
        checkSumUserInfo()
    });


    $('input#zdata_userPassword').observe_field(0.7, function() {
        if ( strlen($('input#zdata_userPassword').val()) == 0 ) {
            $('#userPassword').addClass('ym-error');
            _check_userPassword = 'no';
        } else {
            $('#userPassword').removeClass('ym-error');
            _check_userPassword = 'yes';
        }
        checkSumUserInfo()
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
            checkSumUserInfo()
        }
    });

    $('select#zdata_zarafaAccount').change(function() {
        if ($(this).val() == 1) {
            $('#zarafa-settings').slideDown('slow');
            $('input#zdata_mail').val( buildLhsEmailAddress($('input#zdata_givenName'), $('input#zdata_sn')) );
            $('input#zdata_emailAddress').val(buildEmailAddress($('input#zdata_mail'), $('#zdata_domain'))) ;

            $('input#zdata_mail').focus();

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
            $('#maillabel').addClass('ym-error');
            $('#mail').addClass('ym-error');
            $('#domain').addClass('ym-error');
        } else {
            $.get( json_checkemail_url, { email: $(this).val() }, function(data) {
                if ( data.disabled == true ) {
                    $('#maillabel').addClass('ym-error');
                    $('#mail').addClass('ym-error');
                    $('#domain').addClass('ym-error');
                    _check_emailAddress = 'no';
                } else {
                    $('#maillabel').removeClass('ym-error');
                    $('#mail').removeClass('ym-error');
                    $('#domain').removeClass('ym-error');
                    _check_emailAddress = 'yes';
                }
            }, 'json');
            checkSumUserInfo()
        }
    });

    $('select#zdata_zarafaQuotaOverride').change(function() {
        if ($(this).val() == 1) {
            $('#zarafa-settings-zarafaquotawarn').slideDown('slow');

            $('input#zdata_zarafaQuotaHard').val(quota_hard);

            if ( full_user_quota_check == 1 ) {
            
                $('input#zdata_zarafaQuotaWarn').val(quota_warn);
                $('input#zdata_zarafaQuotaSoft').val(quota_soft);

                $('input#zdata_zarafaQuotaHard').change(function() {
                    quota_check = checkQuotas($('input#zdata_zarafaQuotaHard'), $('input#zdata_zarafaQuotaSoft'), $('input#zdata_zarafaQuotaWarn'));
                    _check_quotas = checkQuotasErrorReport( quota_check );
                });

                $('input#zdata_zarafaQuotaSoft').change(function() {
                    quota_check = checkQuotas($('input#zdata_zarafaQuotaHard'), $('input#zdata_zarafaQuotaSoft'), $('input#zdata_zarafaQuotaWarn'));
                    _check_quotas = checkQuotasErrorReport( quota_check );
                });

                $('input#zdata_zarafaQuotaWarn').change(function() {
                    quota_check = checkQuotas($('input#zdata_zarafaQuotaHard'), $('input#zdata_zarafaQuotaSoft'), $('input#zdata_zarafaQuotaWarn'));
                    _check_quotas = checkQuotasErrorReport( quota_check );
                });
                checkSumUserInfo()
            }

        } else {
            quotaResetValues();
            $('#zarafa-settings-zarafaquotawarn').slideUp();
            _check_quotas = 'yes';
        }
    });
});


function checkSumUserInfo() {

//alert("check_sn = " + _check_sn );
//alert("check_givenName = " + _check_givenName ); 
//alert("check_cn = " + _check_cn );
//alert("check_userPassword = " + _check_userPassword );
//alert("check_confirmPassword = " + _check_confirmPassword );
//alert("check_emailAddress = " + _check_emailAddress );
//alert("check_quotas = " + _check_quotas );

    if ( ( _check_sn == 'yes' ) && 
         ( _check_givenName == 'yes' ) &&
         ( _check_cn == 'yes' ) && 
         ( _check_userPassword == 'yes' ) && 
         ( _check_confirmPassword == 'yes' ) &&
         ( _check_emailAddress == 'yes' ) &&
         ( _check_quotas == 'yes' )
    ) {
        $(".button-submit").attr("disabled", true);
    } else {
        $(".button-submit").removeAttr("disabled");
    }
}
