$(document).ready(function() {

    $("#button_cancel").click(function() {
        $("#form_cancel").submit();
    });

    var val_sn = $("input#zdata_sn").validator();
    var val_givenName = $("input#zdata_givenName").validator();

    $("input#zdata_sn").observe_field(0.5, function() {
    /* $("input#zdata_sn").blur(function() { */

        $("#checkName_msg").html("");
        $("#button_submit").attr("disabled", true);

        if ( val_cn.data("validator").checkValidity() ) {
            $.get( json_checkcn_url, {
                name: $(this).val()
            },
            function(data){
                $("#checkName_msg").html("<img src=\""+data.img+"\" />");
                if ( ! data.disabled ) {
                    $("#button_submit").removeAttr("disabled");
                }
            }, "json");
        }
    });

});

