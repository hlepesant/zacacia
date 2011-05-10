/*
 * Minivisp New Company step 1 JavaScript
 * version 0.1
 * Author: Hugues Lepesant <hugues@lepesant.com>
 */


$(document).ready(function() {

    $("#button_cancel").click(function() {
        $("#form_cancel").submit();
    });

    $("input[type='checkbox']#zdata_zarafaUserDefaultQuotaOverride").change(function() {
        if ($("input[type='checkbox']#zdata_zarafaUserDefaultQuotaOverride").is(':checked')) {
            $("#zarafaUserDefaultQuota").show();
        } else {
            $("#zarafaUserDefaultQuota").hide();
        }
        check_form();
    });

});

function check_form() {
    $("#button_submit").attr("disabled", true);
    $("#button_submit").removeAttr("disabled");
}

