$(document).ready(function() {

    $("#button_cancel").click(function() {
        $("#form_cancel").submit();
    });

    var val_sn = $("input#zdata_sn").validator();
    var val_givenName = $("input#zdata_givenName").validator();
    var val_cn = $("input#zdata_cn").validator();

    $("input#zdata_sn").observe_field(0.5, function() {
        if( $("input#zdata_givenName").val().length ) {
            $("input#zdata_cn").val( sprintf("%s %s", $("input#zdata_sn").val(), $("input#zdata_givenName").val() ) ) ;
        }
    });

    $("input#zdata_givenName").observe_field(0.5, function() {
        if( $("input#zdata_sn").val().length ) {
            $("input#zdata_cn").val( sprintf("%s %s", $("input#zdata_sn").val(), $("input#zdata_givenName").val() ) ) ;
        }
    });

    $("input#zdata_cn").observe_field(0.5, function() {

        $("#checkName_msg").html("");
        $("#button_submit").attr("disabled", true);

        if ( val_cn.data("validator").checkValidity() ) {
            $.get( json_checkcn_url, {
                companyDn: $("input#zdata_companyDn").val(),
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

