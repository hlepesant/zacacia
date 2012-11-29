/*
 * Minivisp New Company step 1 JavaScript
 * version 0.1
 * Author: Hugues Lepesant <hugues@lepesant.com>
 */


$(document).ready(function() {

    $('.button_cancel').click(function() {
        $('#form_cancel').submit();
    });

    $('select#zdata_zarafaAccount').change(function() {
        if ($(this).val() == 1) {
          $('#zarafa-settings').slideDown('slow');
        } else {
          $('#zarafa-settings').slideUp();
        }
    });
/*
    if ($("input[type='checkbox']#zdata_zarafaQuotaOverride").is(':checked')) {
        $('#zarafaQuota').show();
    }
    if ($("input[type='checkbox']#zdata_zarafaUserDefaultQuotaOverride").is(':checked')) {
        $('#zarafaUserDefaultQuota').show();
    }

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
*/
});

