
var cn_ok = 0;
var ip_ok = 0;

$(document).ready(function() {

    $("._link img[title]").tooltip({
        position: "bottom left",
        opacity: 0.9
    });

    $('#button_cancel').click(function() {
        $('#form_cancel').submit();
    });

    $('input#minidata_cn').blur(function() {
        $.get( json_check_url, { name: $(this).val() },
            function(data){
                $("#checkName_msg").html('');
                cn_ok = 0;

                $("#checkName_msg").html('<img src=\''+data.img+'\' />');
                if ( ! data.disabled ) {
                    cn_ok = 1;
                }
                check_form();
            },
            "json");

        $.get( json_resolvhost_url, { name: $(this).val() },
            function(data){
                $("input#minidata_ip").val(data.ip);
                if ( ! data.disabled ) {
                    ip_ok = 1;
                }
                check_form();
            },
            "json");
    });
});

function check_form() {
    $("#button_submit").attr("disabled", true);
    if ( (cn_ok == 1 ) && (ip_ok == 1) ) {
        $("#button_submit").removeAttr("disabled");
    }
}
