/*
 * Minivisp New Company step 2 JavaScript
 * version 0.1
 * Author: Hugues Lepesant <hugues@lepesant.com>
 */

var hs_ok = 1;
var wq_ok = 1;
var check_wq = 0;

$(document).ready(function() {

    $("#button_cancel").click(function() {
        $("#form_cancel").submit();
    });
/*
    $("select#zdata_zarafaCompanyServer").change(function() {
        if ( "_undefined_" == $("select#zdata_zarafaCompanyServer").val() ) {
            hs_ok = 0;
            wq_ok = 1;
        } else {
            hs_ok = 1
        }
        check_form();
    });
*/
    check_form();

    $("input[type='checkbox']#zdata_zarafaQuotaOverride").change(function() {
        if ($("input[type='checkbox']#zdata_zarafaQuotaOverride").is(':checked')) {
            $("input[type='number']#zdata_zarafaQuotaWarn").removeAttr("disabled");
            check_wq = 1;
            wq_ok = 0;
        } else {
            $("input[type='number']#zdata_zarafaQuotaWarn").attr("disabled", true);
            check_wq = 0;
            wq_ok = 1;
        }
        check_form();
    });

    $("input[type='number']#zdata_zarafaQuotaWarn").change(function() {
        if ( check_wq ) {
            var val_qw = $("input[type='number']#zdata_zarafaQuotaWarn").validator();

            if ( val_qw.data("validator").checkValidity() ) {
                wq_ok = 1;
            }
            check_form();
        }
    });
});

function check_form() {
    $("#button_submit").attr("disabled", true);
    if ( (hs_ok == 1 ) && (wq_ok == 1) ) {
        $("#button_submit").removeAttr("disabled");
    }
}
