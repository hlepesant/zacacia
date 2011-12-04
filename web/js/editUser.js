var _displayName = 'fl';

var _check_sn = 'yes';
var _check_givenName = 'yes';
var _check_displayName = 'yes';


$(document).ready(function() {

    $.fx.off = true;
    $('#imgSwitch').css('visibility','visible');
    
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
        _check_sn = 'no';
        if( $('input#zdata_sn').length && $('input#zdata_givenName').length ) {
            $('input#zdata_displayName').val( sprintf("%s %s", $('input#zdata_sn').val(), $('input#zdata_givenName').val() ) ) ;
            _check_sn = 'yes';
        }
        checkSumUserInfo()
    });

    $('input#zdata_givenName').observe_field(0.5, function() {
        _check_givenName = 'no';
        if( $('input#zdata_sn').length && $('input#zdata_givenName').length ) {
            $('input#zdata_displayName').val( sprintf("%s %s", $('input#zdata_sn').val(), $('input#zdata_givenName').val() ) ) ;
            _check_givenName = 'yes';
        }
        checkSumUserInfo()
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

    $('input#zdata_displayName').observe_field(0.5, function() {
        _check_displayName = 'no';
        if( $(this).length ) {
            _check_displayName = 'yes';
        }
        checkSumUserInfo()
    });

    $("input[type='checkbox']#zdata_zarafaAccount").change(function() {

        if ($(this).is(':checked')) {
          $("#zarafa_settings").slideDown('slow');
        } else {
          $("#zarafa_settings").slideUp();
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

    $('#goto_section_zarafa').attr('disabled', true);
/*
    alert('sn = ' + _check_sn + '\ngivenName = ' + _check_givenName + '\ndisplayName = ' + _check_displayName);
*/    
    if ( ( _check_sn == 'yes' ) && 
         ( _check_givenName == 'yes' ) &&
         ( _check_displayName == 'yes' )
       ) {
        $("#goto_section_zarafa").removeAttr("disabled");
    }
}