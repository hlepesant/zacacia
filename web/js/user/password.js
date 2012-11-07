var _displayName = 'fl';

$(document).ready(function() {

    $.fx.off = true;
    
    $('#button-cancel').click(function() {
        $('#form_cancel').submit();
    });
/*
    $('input#zdata_userPassword').password_strength();
*/
    $('input#zdata_userPassword').observe_field(1, function() {
        checkPasswordEquality($('input#zdata_userPassword'), $('input#zdata_confirmPassword'));
    });

    $('input#zdata_confirmPassword').observe_field(1, function() {
        checkPasswordEquality($('input#zdata_userPassword'), $('input#zdata_confirmPassword'));
    });

    $("#form_password").submit(function(e) {
        var _md5 = $('input#zdata_userPassword').crypt({method:"md5",source:""});
        $('input#zdata_userPassword').val(_md5);
        $('input#zdata_confirmPassword').val(_md5);
    });

});

function checkPasswordEquality(pass, conf)
{
    if ( ( pass.val() == conf.val() ) && ( strlen(pass.val()) > 0 ) ) {
        $('#userPassword').removeClass('ym-error');
        $('#confirmPassword').removeClass('ym-error');
        $('#userPassword-message').hide();
        $('.button-submit').removeAttr('disabled');
    } else {
        $('.button-submit').attr('disabled', true);
        $('#userPassword').addClass('ym-error');
        $('#confirmPassword').addClass('ym-error');
        $('#userPassword-message').show();
    }
}
