var _check_sn = 'no';
var _check_givenName = 'no';
var _check_emailAddress = 'no';
var _check_quotas = 'yes';

var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;


$(document).ready(function() {

    $('.button-cancel').click(function() {
        $('#form_cancel').submit();
    });

    $('input#zdata_sn').observe_field(0.7, function() {
        if ( strlen($('input#zdata_sn').val()) > 0 ) {
            if ( strlen($('input#zdata_givenName').val()) > 0 ) {
                $('input#zdata_displayName').val( buildDiplayName($('input#zdata_givenName'), $('input#zdata_sn')) ); 
            }
        }
    });

    $('input#zdata_givenName').observe_field(0.7, function() {
        if ( strlen($('input#zdata_sn').val()) > 0 ) {
            if ( strlen($('input#zdata_givenName').val()) > 0 ) {
                $('input#zdata_displayName').val( buildDiplayName($('input#zdata_givenName'), $('input#zdata_sn')) ); 
            }
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

    //$('input#zdata_mail').observe_field(0.5, function() {
    $('input#zdata_mail').change(function() {
        alert('plook');
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
            $.get( json_checkemail_url, { 
                    dn: $('input#zdata_userDn').val(),
                    email: $(this).val()
                }, function(data) {
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
//alert("check_emailAddress = " + _check_emailAddress );
//alert("check_quotas = " + _check_quotas );

    if ( ( _check_sn == 'yes' ) && 
         ( _check_givenName == 'yes' ) &&
         ( _check_emailAddress == 'yes' ) &&
         ( _check_quotas == 'yes' )
    ) {
        alert('ok');
        $(".button-submit").attr("disabled", true);
    } else {
        $(".button-submit").removeAttr("disabled");
    }
}
