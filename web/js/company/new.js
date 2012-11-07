/*
 * Minivisp New Company step 1 JavaScript
 * version 0.1
 * Author: Hugues Lepesant <hugues@lepesant.com>
 */


var cn_ok = 0;
/* var ip_ok = 0;
*/

$(document).ready(function() {

    $('.button-cancel').click(function() {
        $("#form_cancel").submit();
    });

    $('input#zdata_cn').blur(function() {

        if ( $('input#zdata_cn').length ) {
            $.get( json_check_url, {
                name: $(this).val()
            },
            function(data){

                if ( data.disabled == true ) {
                    $('#cn').addClass('ym-error');
                    $('#cn-message').show();
                    cn_ok = 0;
                } else {
                    $('#cn').removeClass('ym-error');
                    $('#cn-message').hide();
                    cn_ok = 1;
                }

            }, 'json');
        }

        check_form();
    });

    $('select#zdata_zarafaAccount').change(function() {
        if ($(this).val() == 1) {
          $('#zarafa-settings').slideDown('slow');
        } else {
          $('#zarafa-settings').slideUp();
        }
    });

    $('select#zdata_zarafaQuotaOverride').change(function() {
        if ($(this).val() == 1) {
          $('#zarafa-settings-zarafaquotawarn').slideDown('slow');
        } else {
          $('#zarafa-settings-zarafaquotawarn').slideUp();
        }
    });

    $('select#zdata_zarafaUserDefaultQuotaOverride').change(function() {
        if ($(this).val() == 1) {
          $('#zarafa-settings-userdefaultquota').slideDown('slow');
        } else {
          $('#zarafa-settings-userdefaultquota').slideUp();
        }
    });

});

function check_form() {

    if ( cn_ok == 1 ) {
        $('.button-submit').removeAttr("disabled");
    } else {
        $('.button-submit').attr('disabled', true);
    }
}
