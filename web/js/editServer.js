/*
 * Minivisp Edit Server JavaScript
 * version 0.1
 * Author: Hugues Lepesant <hugues@lepesant.com>
 */

$(document).ready(function() {
/*
    $('._link img[title]').tooltip({
        position: 'bottom left',
        opacity: 0.9
    });
*/
    $('.button-cancel').click(function() {
        $('#form-cancel').submit();
    });

    $(".button-submit").removeAttr("disabled");

    $("input#zdata_cn").change(function() {
        $("#checkIpAddress_msg_msg").html('');
        if ( $("input#zdata_ip").length ) {
            if ( data.disabled ) {
                $(".button-submit").attr("disabled", true);
            }
        }
        check_form();
    });

/*
    if ($("input[type='checkbox']#zdata_zarafaAccount").is(':checked')) {
        $("input[type='text']#zdata_zarafaHttpPort").attr("disabled", true);
        $("input[type='text']#zdata_zarafaSslPort").attr("disabled", true);
        $("input[type='checkbox']#zdata_multitenant").attr("disabled", true);
        $("input[type='checkbox']#zdata_zarafaContainsPublic").attr("disabled", true);
    }
*/

    $("select#zdata_zarafaAccount").change(function() {

        if ($(this).val() == 1) {
          $("#zarafa-settings").slideDown('slow');
        } else {
          $("#zarafa-settings").slideUp();
        }
    });
/*
    $("input[type='checkbox']#zdata_zarafaAccount").change(function() {

        if ($(this).is(':checked')) {
            $("input[type='text']#zdata_zarafaHttpPort").removeAttr("disabled");
            $("input[type='text']#zdata_zarafaSslPort").removeAttr("disabled");
            $("input[type='checkbox']#zdata_multitenant").removeAttr("disabled");
            $("input[type='checkbox']#zdata_zarafaContainsPublic").removeAttr("disabled");
            $("input[type='text']#zdata_zarafaHttpPort").val(_zarafaHttpPort);
            $("input[type='text']#zdata_zarafaSslPort").val(_zarafaSslPort);
        } else {
            $("input[type='text']#zdata_zarafaHttpPort").attr("disabled", true);
            $("input[type='text']#zdata_zarafaSslPort").attr("disabled", true);
            $("input[type='checkbox']#zdata_multitenant").attr("disabled", true);
            $("input[type='checkbox']#zdata_zarafaContainsPublic").attr("disabled", true);
            $("input[type='text']#zdata_zarafaHttpPort").val(null);
            $("input[type='text']#zdata_zarafaSslPort").val(null);
        }
    });
*/
});
