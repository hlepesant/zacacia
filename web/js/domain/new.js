$(document).ready(function() {

    $(".button-cancel").click(function() {
        $("#form_cancel").submit();
    });

    $("input#zdata_cn").observe_field(0.5, function() {

        if ( $("input#zdata_cn").length ) {
            $.get( json_check_url, {
                name: $(this).val()
            },
            function(data){

                if ( data.disabled == true ) {
                    $('#cn').addClass('ym-error');
                    $('#cn-message').show();
                    $("#button-submit").attr("disabled", true);
                } else {
                    $('#cn').removeClass('ym-error');
                    $('#cn-message').hide();
                    $("#button-submit").removeAttr("disabled");
                }
            }, "json");
        }
    });

});

