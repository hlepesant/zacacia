$(document).ready(function() {

    $('.button-cancel').click(function() {
        $('#form_cancel').submit();
    });

    $('input#zdata_cn').observe_field(0.5, function() {

        $('#checkName_msg').html('');
        $('.button-submit').attr('disabled', true);

        if ( $('input#zdata_cn').length ) {
            $.get( json_check_url, {
                name: $(this).val()
            },
            function(data){
                $('input#zdata_cn').css('border', '1px solid #C0C0C0');
                $('input#zdata_cn').css('background-color', '#FFFFFF');

                if ( data.disabled ) {
                    $('input#zdata_cn').css('border', '1px solid #FF0000');
                    $('input#zdata_cn').css('background-color', '#F58D82');
                }

                if ( ! data.disabled ) {
                    $('.button-submit').removeAttr('disabled');
                }
            }, 'json');
        }
    });
});

