$(document).ready(function() {

    $(".button_cancel").click(function() {
        $("#form_cancel").submit();
    });

    var val_cn = $("input#zdata_cn").validator();

    $("input#zdata_cn").observe_field(0.5, function() {

        $("#checkName_msg").html("");
        $(".button_submit").attr("disabled", true);

        if ( val_cn.data("validator").checkValidity() ) {
            $.get( json_check_url, {
                name: $(this).val()
            },
            function(data){
                $("#checkName_msg").html("<img src=\""+data.img+"\" />");

                if ( data.disabled ) {
                    $("input#zdata_cn").css('border', '1px solid red');
                    $("input#zdata_cn").css('background-color', '#F58D82');
                } else {
                    $("input#zdata_cn").css('border', '1px solid #C0C0C0');
                    $("input#zdata_cn").css('background-color', '#FFFFFF');
                }

                if ( ! data.disabled ) {
                    $(".button_submit").removeAttr("disabled");
                }
            }, "json");
        }
    });

});

