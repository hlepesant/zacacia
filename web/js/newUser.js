var _displayName = 'fl';

var _sum_userinfo = 6;
var _sum_zarafa = 1;

var _check_sn = 0;
var _check_givenName = 0;
var _check_cn = 0;
var _check_displayName = 0;
var _check_userPassword = 0;
var _check_confirmPassword = 0;
var _check_emailAddress = 0;

var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;


$(document).ready(function() {

    $.fx.off = true;
    
    $("#section_userinfo").show();
    $("#section_zarafa").hide();

    $("#goto_section_zarafa").click(function() {
        $("#section_userinfo").hide();
        $("#section_zarafa").show();
        return false;
    }); 

    $("#back_section_userinfo").click(function() {
        $("#section_userinfo").show();
        $("#section_zarafa").hide();
    });

    $('.button_cancel').click(function() {
        $('#form_cancel').submit();
    });

    $('input#zdata_sn').observe_field(0.5, function() {
        if( $('input#zdata_givenName').val().length ) {
            $('input#zdata_cn').val( sprintf("%s %s", $('input#zdata_sn').val(), $('input#zdata_givenName').val() ) ) ;
        }
    });

    $('input#zdata_givenName').observe_field(0.5, function() {
        if( $('input#zdata_sn').length ) {
            $('input#zdata_cn').val( sprintf("%s %s", $('input#zdata_sn').val(), $('input#zdata_givenName').val() ) ) ;
        }
    });

    $('input#zdata_cn').observe_field(0.5, function() {
        $('#checkName_msg').html("");
        $('.button_submit').attr('disabled', true);

        if ( $(this).length ) {
            $.get( json_checkcn_url, {
                companyDn: $('input#zdata_companyDn').val(),
                name: $(this).val()
            },
            function(data){
                $('#checkName_msg').html("<img src=\""+data.img+"\" />");
                if ( ! data.disabled ) {
                    $('.button_submit').removeAttr('disabled');
                    $('input#zdata_displayName').val( sprintf("%s %s", $('input#zdata_sn').val(), $('input#zdata_givenName').val() ) ) ;
                    $('#imgSwitch').css('visibility','visible');
                    _uid = sprintf("%s%s", substr($('input#zdata_sn').val(), 0, 1), $('input#zdata_givenName').val());
                    $('input#zdata_uid').val(_uid.toLowerCase());

                    _check_sn = 1;
                    _check_givenName = 1;
                    _check_cn = 1;
                } else {
                    _check_sn = 0;
                    _check_givenName = 0;
                    _check_cn = 0;
                }
            }, 'json');
        }
    });

    $('#switch').click( function() {
        if ( _displayName == 'fl' ) {
            $('input#zdata_displayName').val( sprintf("%s %s", $('input#zdata_givenName').val(), $('input#zdata_sn').val() ) ) ;
            _displayName = 'lf';
        } else {
            $('input#zdata_displayName').val( sprintf("%s %s", $('input#zdata_sn').val(), $('input#zdata_givenName').val() ) ) ;
            _displayName = 'fl';
        }
    });

    $('input#zdata_displayName').blur(function() {
        if ( $(this).length ) {
            _check_displayName = 1;
        } else {
            _check_displayName = 0;
        }
    });

    $('input#zdata_uid').observe_field(0.5, function() {
        $('#checkUid_msg').html("");
        $('#goto_section_zarafa').attr('disabled', true);
  
        if ( $('input#zdata_uid').length ) {
        $.get( json_checkuid_url, {
            name: $(this).val()
        },
        function(data){
            $('#checkUid_msg').html("<img src=\""+data.img+"\" />");
            if ( ! data.disabled ) {
                $('#goto_section_zarafa').removeAttr('disabled');
            }
        }, 'json');
        }
    });

    /* $('input#zdata_userPassword').pwdMeter(); */
    $('#zdata_userPassword').pwdMeter({
        minLength: 6,
        displayGeneratePassword: false,
        generatePassText: 'Password Generator',
        generatePassClass: 'GeneratePasswordLink',
        randomPassLength: 13           
    });

    if ( $('input#zdata_confirmPassword').val().length ) {
        if ( null == $('input#zdata_confirmPassword').val() == $('input#zdata_userPassword').val() ) {
            $('#pequality').html("<img src=\"/images/famfam/cross.png\" />");
            $('#goto_section_zarafa').attr('disabled', true);

            _check_userPassword = 1;
            _check_confirmPassword = 1;
        } else {
            _check_userPassword = 0;
            _check_confirmPassword = 0;
        }
    }

    $('input#zdata_confirmPassword').observe_field(0.5, function() {
        if ( $('input#zdata_userPassword').val() == $(this).val() ) {
            $('#pequality').html("<img src=\"/images/famfam/tick.png\" />");
            _check_userPassword = 1;
            _check_confirmPassword = 1;

            /* $('#goto_section_zarafa').removeAttr('disabled'); */
        } else {
            $('#pequality').html("<img src=\"/images/famfam/cross.png\" />");
            _check_userPassword = 0;
            _check_confirmPassword = 0;

            /* $('#goto_section_zarafa').attr('disabled', true); */
        }
        checkSumUserInfo()
    });

    $("#userform").submit(function(e) {
        var _md5 = $('input#zdata_userPassword').crypt({method:"md5",source:""});
        $('input#zdata_userPassword').val(_md5);
        $('input#zdata_confirmPassword').val(_md5);
    });

    $("input[type='checkbox']#zdata_zarafaAccount").change(function() {

        if ($(this).is(':checked')) {
            $("#zarafa_settings").slideDown('slow');
            _check_all = 7;
        } else {
            $("#zarafa_settings").slideUp();
            _check_all = 6;
        }

        if ($(this).is(':checked')) {
            $('input#zdata_mail').val($('input#zdata_uid').val());
        } else {
            $('input#zdata_mail').val(null);
        }
    });

    $('#zdata_mail').observe_field(0.2, function() {
        $('input#zdata_emailAddress').val(sprintf("%s@%s", $(this).val(), $('#zdata_domain').val())) ;
    
    });

    $('#zdata_domain').change(function() {
        $('input#zdata_emailAddress').val(sprintf("%s@%s", $('#zdata_mail').val(), $(this).val())) ;
    });

    $('input#zdata_emailAddress').observe_field(0.2, function() {

        if ( ! emailReg.test($(this).val()) ) {
            $("#checkEmail_msg").html("<img src=\"/images/famfam/cross.png\" />");
            _check_emailAddress = 0;
        } else {
            $.getJSON( json_checkemail_url, { email: $(this).val() }, function(data) {
                $("#checkEmail_msg").html("<img src=\""+data.img+"\" />");
                if ( ! data.disabled ) {
                    _check_emailAddress = 1;
                    $("#goto_section_zarafa").removeAttr("disabled");
                }
            });
        }
    });

    $('#zdata_zarafaQuotaOverride').click(function() {
        if ( $(this).is(':checked')) {
            $('#quota_setting').show();
        } else {
            $('#quota_setting').hide();
        }
    });
});

function checkSumUserInfo() {
    if ( ( _check_sn + _check_givenName + _check_cn + _check_displayName + _check_userPassword + _check_confirmPassword + _check_emailAddress ) == _sum_userinfo ) {
        $("#goto_section_zarafa").removeAttr("disabled");
    } else {
        $('#goto_section_zarafa').attr('disabled', true);
    }
}
