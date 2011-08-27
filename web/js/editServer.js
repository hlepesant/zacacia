/*
 * Minivisp Edit Server JavaScript
 * version 0.1
 * Author: Hugues Lepesant <hugues@lepesant.com>
 */

$(document).ready(function() {

    $("._link img[title]").tooltip({
        position: "bottom left",
        opacity: 0.9
    });

    $('#button_cancel').click(function() {
        $('#form_cancel').submit();
    });

    $("#button_submit").removeAttr("disabled");
    var val_ip = $("input#zdata_ip").validator();

    $("input#zdata_cn").change(function() {
        $("#checkIpAddress_msg_msg").html('');
        if ( val_ip.data("validator").checkValidity() ) {
            $("#checkIpAddress_msg_msg").html('<img src=\'/images/famfam/tick.png\' />');
            if ( data.disabled ) {
                $("#button_submit").attr("disabled", true);
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
    $("input[type='checkbox']#zdata_zarafaAccount").change(function() {

        if ($(this).is(':checked')) {
          $("#zarafa_settings").slideDown('slow');
        } else {
          $("#zarafa_settings").slideUp();
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
