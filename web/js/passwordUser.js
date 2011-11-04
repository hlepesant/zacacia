var _displayName = 'fl';

$(document).ready(function() {

    $.fx.off = true;
    
    $('.button_cancel').click(function() {
        $('#form_cancel').submit();
    });

    $('input#zdata_userPassword').password_strength();

    if ( null == $('input#zdata_confirmPassword').val() == $('input#zdata_userPassword').val() ) {
        $('#pequality').html("<img src=\"/images/famfam/cross.png\" />");
        $('#goto_section_zarafa').attr('disabled', true);
    }

    $('input#zdata_confirmPassword').observe_field(0.5, function() {
        if ( $('input#zdata_userPassword').val() == $(this).val() ) {
            $('#pequality').html("<img src=\"/images/famfam/tick.png\" />");
            $('.button_submit').removeAttr('disabled');
        } else {
            $('#pequality').html("<img src=\"/images/famfam/cross.png\" />");
            $('.button_submit').attr('disabled', true);
        }
    });

    $("#passwordform").submit(function(e) {
        var _md5 = $('input#zdata_userPassword').crypt({method:"md5",source:""});
        $('input#zdata_userPassword').val(_md5);
        $('input#zdata_confirmPassword').val(_md5);
    });
});
