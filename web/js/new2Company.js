/*
 * Minivisp New Company step 2 JavaScript
 * version 0.1
 * Author: Hugues Lepesant <hugues@lepesant.com>
 */

var hs_ok = 0;
var wq_ok = 0;
var check_wq = 0;

$(document).ready(function() {

    $("#button_cancel").click(function() {
        $("#form_cancel").submit();
    });

    $("select#minidata_zarafaCompanyServer").change(function() {
        if ( "_undefined_" == $("select#minidata_zarafaCompanyServer").val() ) {
            hs_ok = 0;
        } else {
            hs_ok = 1
        }
        check_form();
    });

    $("input[type='checkbox']#minidata_zarafaQuotaOverride").change(function() {
        if ($("input[type='checkbox']#minidata_zarafaQuotaOverride").is(':checked')) {
            $("input[type='text']#minidata_zarafaQuotaWarn").removeAttr("disabled");
            check_wq = 1;
        } else {
            $("input[type='text']#minidata_zarafaQuotaWarn").attr("disabled", true);
            check_wq = 0;
            wq_ok = 1;
        }
    });
/*
    if ( check_wq ) {

        wq_ok = 0;
        var val_qw = $("input[type='text']#minidata_zarafaQuotaWarn").validator();
        if ( val_qw.data("validator").checkValidity() ) {
            wq_ok = 1;
        }
        check_form();
    }
*/
});

function check_form() {
    $("#button_submit").attr("disabled", true);
    if ( (hs_ok == 1 ) && (wq_ok == 1) ) {
        $("#button_submit").removeAttr("disabled");
    }
}