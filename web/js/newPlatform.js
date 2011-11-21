$(document).ready(function() {

    $('.button_cancel').click(function() {
        $('#form_cancel').submit();
    });

    $('input#zdata_cn').observe_field(0.5, function() {

        $('#checkName_msg').html('');
        $('.button_submit').attr('disabled', true);

        if ( $('input#zdata_cn').length ) {
            $.get( json_check_url, {
                name: $(this).val()
            },
            function(data){
                $('#checkName_msg').html('<img src=\''+data.img+'\' />');

                $('input#zdata_cn').css('border', '1px solid #C0C0C0');
                $('input#zdata_cn').css('background-color', '#FFFFFF');

                if ( data.disabled ) {
                    $('input#zdata_cn').css('border', '1px solid red');
                    $('input#zdata_cn').css('background-color', '#F58D82');
                }

                if ( ! data.disabled ) {
                    $('.button_submit').removeAttr('disabled');
                }
            }, 'json');
        }
    });
});

