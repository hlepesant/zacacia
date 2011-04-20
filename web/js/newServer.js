/*
 * Minivisp New Server JavaScript
 * version 0.1
 * Author: Hugues Lepesant <hugues@lepesant.com>
 */

var cn_ok = 0;
var ip_ok = 0;

$(document).ready(function() {

    $('._link img[title]').tooltip({
        position: "bottom left",
        opacity: 0.9
    });

    $('#button_cancel').click(function() {
        $('#form_cancel').submit();
    });


    var val_cn = $('input#minidata_cn').validator();

    $('input#minidata_cn').blur(function() {

        if ( val_cn.data('validator').checkValidity() ) {

            $('#checkName_msg').html('');

            $.get( json_check_url, { name: $(this).val() },
                function(data){
                    cn_ok = 0;
                    $('#checkName_msg').html('<img src=\''+data.img+'\' />');
                    if ( ! data.disabled ) {
                        cn_ok = 1;
                    }
                    check_form();
                },
                'json');

            $.get( json_resolvhost_url, { name: $(this).val() },
                function(data){
                    $('input#minidata_ip').val(data.ip);
                    if ( ! data.disabled ) {
                        ip_ok = 1;
                    }
                    check_form();
                },
                'json');
        }
    });

    $("input[type='checkbox']#minidata_zarafaAccount").change(function() {

        if ($(this).is(':checked')) {
            $("input[type='text']#minidata_zarafaHttpPort").removeAttr("disabled");
            $("input[type='text']#minidata_zarafaSslPort").removeAttr("disabled");
            $("input[type='checkbox']#minidata_multitenant").removeAttr("disabled");
            $("input[type='checkbox']#minidata_zarafaContainsPublic").removeAttr("disabled");
        } else {
            $("input[type='text']#minidata_zarafaHttpPort").attr("disabled", true);
            $("input[type='text']#minidata_zarafaSslPort").attr("disabled", true);
            $("input[type='checkbox']#minidata_multitenant").attr("disabled", true);
            $("input[type='checkbox']#minidata_zarafaContainsPublic").attr("disabled", true);
        }
    });

/*
    var val_ip = $("input#minidata_ip").validator();

    $("input#minidata_cn").change(function() {
        $("#checkIpAddress_msg_msg").html('');
        if ( val_ip.data("validator").checkValidity() ) {
            $("#checkIpAddress_msg_msg").html('<img src=\'/images/famfam/tick.png\' />');
           ip_ok = 1;
        }
        check_form();
    });
*/
});

function check_form() {
    $("#button_submit").attr("disabled", true);
    if ( (cn_ok == 1 ) && (ip_ok == 1) ) {
        $("#button_submit").removeAttr("disabled");
    }
}
