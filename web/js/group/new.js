var _check_cn = 'no';
var _check_emailAddress = 'no';
var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;


$(document).ready(function() {

    $('.button_cancel').click(function() {
        $('#form_cancel').submit();
    });

    $('input#zdata_cn').observe_field(0.7, function() {

        if ( $('input#zdata_cn').length ) {
            $.get( json_checkcn_url, {
                companyDn: $('input#zdata_companyDn').val(),
                name: $(this).val()
            },
            function(data){
                if ( data.disabled == true ) {
                    $('#cn').addClass('ym-error');
                    _check_cn = 'no';
                } else {
                    $('#cn').removeClass('ym-error');
                    _check_cn = 'yes';
                }
            }, 'json');
        }
        checkSumGroupInfo()
    });

    $('select#zdata_zarafaAccount').change(function() {
        if ($(this).val() == 1) {
            $('#zarafa-settings').slideDown('slow');
            $('input#zdata_mail').val( buildLhsEmailAddress($('input#zdata_cn')) );
            $('input#zdata_emailAddress').val(buildEmailAddress($('input#zdata_mail'), $('#zdata_domain'))) ;

            $('input#zdata_mail').focus();

        } else {
            $('input#zdata_mail').val(null);
            $('#zarafa-settings').slideUp();
        }
    });

    $('input#zdata_mail').observe_field(0.5, function() {
        $('input#zdata_emailAddress').val(buildEmailAddress($(this), $('#zdata_domain'))) ;
    });
    
    $('#zdata_domain').change(function() {
        $('input#zdata_emailAddress').val(buildEmailAddress($('#zdata_mail'), $(this))) ;
    });
    
    $('input#zdata_emailAddress').observe_field(0.2, function() {
    
        if ( ! emailReg.test($(this).val()) ) {
            $('#maillabel').addClass('ym-error');
            $('#mail').addClass('ym-error');
            $('#domain').addClass('ym-error');
        } else {
            $.get( json_checkemail_url, { email: $(this).val() }, function(data) {
                if ( data.disabled == true ) {
                    $('#maillabel').addClass('ym-error');
                    $('#mail').addClass('ym-error');
                    $('#domain').addClass('ym-error');
                    _check_emailAddress = 'no';
                } else {
                    $('#maillabel').removeClass('ym-error');
                    $('#mail').removeClass('ym-error');
                    $('#domain').removeClass('ym-error');
                    _check_emailAddress = 'yes';
                }
            }, 'json');
            checkSumGroupInfo()
        }
    });
});


function checkSumGroupInfo() {

alert("check_cn = " + _check_cn );
alert("check_emailAddress = " + _check_emailAddress );

    if ( ( _check_cn == 'yes' ) && 
         ( _check_emailAddress == 'yes' )
    ) {
        $(".button-submit").attr("disabled", true);
    } else {
        $(".button-submit").removeAttr("disabled");
    }
}
