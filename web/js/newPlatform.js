$(document).ready(function() {

    $("._link img[title]").tooltip({
        position: "bottom left",
        opacity: 0.9
    });

    $('#button_cancel').click(function() {
        $('#form_cancel').submit();
    });
/*
    $('#minidata_cn').change(function() {
        $.get( json_check_url,
            { name: $(this).val() },
            function(data){
                $("#checkName_msg").html('');
                $("#button_submit").attr("disabled", true);

                $("#checkName_msg").html('<img src=\''+data.img+'\' />');
                if ( ! data.disabled ) {
                    $("#button_submit").removeAttr("disabled");
                }
            },
            "json");
    });
*/

    $("#minidata_cn").observe_field(0.5, function() {
        $.get( json_check_url,
            { name: $(this).val() },
            function(data){
                $("#checkName_msg").html('');
                $("#button_submit").attr("disabled", true);

                $("#checkName_msg").html('<img src=\''+data.img+'\' />');
                if ( ! data.disabled ) {
                    $("#button_submit").removeAttr("disabled");
                }
            },
            "json");
    });
});

