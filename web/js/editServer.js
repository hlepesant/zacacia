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
    var val_ip = $("input#minidata_ip").validator();

    $("input#minidata_cn").change(function() {
        $("#checkIpAddress_msg_msg").html('');
        if ( val_ip.data("validator").checkValidity() ) {
            $("#checkIpAddress_msg_msg").html('<img src=\'/images/famfam/tick.png\' />');
            if ( data.disabled ) {
                $("#button_submit").attr("disabled", true);
            }
        }
        check_form();
    });
});
