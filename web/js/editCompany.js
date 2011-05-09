/*
 * Minivisp New Company step 1 JavaScript
 * version 0.1
 * Author: Hugues Lepesant <hugues@lepesant.com>
 */


$(document).ready(function() {

    $("#button_cancel").click(function() {
        $("#form_cancel").submit();
    });


    if ($("input[type='checkbox']#minidata_zarafaQuotaOverride").is(':checked')) {
        $("#zarafaQuota").show();
    }
    if ($("input[type='checkbox']#minidata_zarafaUserDefaultQuotaOverride").is(':checked')) {
        $("#zarafaUserDefaultQuota").show();
    }

    var val_cn = $("input#minidata_cn").validator();

    $("input[type='checkbox']#minidata_zarafaQuotaOverride").change(function() {
        if ($("input[type='checkbox']#minidata_zarafaQuotaOverride").is(':checked')) {
            $("#zarafaQuota").show();
        } else {
            $("#zarafaQuota").hide();
        }
    });

    $("input[type='checkbox']#minidata_zarafaUserDefaultQuotaOverride").change(function() {
        if ($("input[type='checkbox']#minidata_zarafaUserDefaultQuotaOverride").is(':checked')) {
            $("#zarafaUserDefaultQuota").show();
        } else {
            $("#zarafaUserDefaultQuota").hide();
        }
    });

});

