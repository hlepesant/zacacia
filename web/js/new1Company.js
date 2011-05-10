/*
 * Minivisp New Company step 1 JavaScript
 * version 0.1
 * Author: Hugues Lepesant <hugues@lepesant.com>
 */


$(document).ready(function() {

    $("#button_cancel").click(function() {
        $("#form_cancel").submit();
    });

    var val_cn = $("input#zdata_cn").validator();

/*    $("input#zdata_cn").observe_field(0.5, function() { */
    $("input#zdata_cn").blur(function() {

        $("#checkName_msg").html("");
        $("#button_submit").attr("disabled", true);

        if ( val_cn.data("validator").checkValidity() ) {
            $.get( json_check_url, {
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

