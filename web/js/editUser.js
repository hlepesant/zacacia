var _displayName = 'fl';

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
