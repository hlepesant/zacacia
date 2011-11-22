/*
 * Minivisp New Company step 1 JavaScript
 * version 0.1
 * Author: Hugues Lepesant <hugues@lepesant.com>
 */


$(document).ready(function() {

    $('.button_cancel').click(function() {
        $("#form_cancel").submit();
    });

    $('input#zdata_cn').blur(function() {

        $('#checkName_msg').html('');
        $('.button_submit').attr('disabled', true);

        if ( $('input#zdata_cn').length ) {
            $.get( json_check_url, {
                name: $(this).val()
            },
            function(data){
                $('#checkName_msg').html('<img src=\"'+data.img+'\" />');
                if ( ! data.disabled ) {
                    $('.button_submit').removeAttr('disabled');
                }
            }, 'json');
        }
    });

    $("input[type='checkbox']#zdata_zarafaAccount").change(function() {
        if ($(this).is(':checked')) {
          $('#zarafa_settings').slideDown('slow');
        } else {
          $('#zarafa_settings').slideUp();
        }
    });

    $("input[type='checkbox']#zdata_zarafaQuotaOverride").change(function() {
        if ($("input[type='checkbox']#zdata_zarafaQuotaOverride").is(':checked')) {
            $('#zarafaQuota').show();
        } else {
            $('#zarafaQuota').hide();
        }
    });

    $("input[type='checkbox']#zdata_zarafaUserDefaultQuotaOverride").change(function() {
        if ($("input[type='checkbox']#zdata_zarafaUserDefaultQuotaOverride").is(':checked')) {
            $('#zarafaUserDefaultQuota').show();
        } else {
            $('#zarafaUserDefaultQuota').hide();
        }
    });

});

