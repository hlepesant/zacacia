/*
 * Minivisp New Server JavaScript
 * version 0.1
 * Author: Hugues Lepesant <hugues@lepesant.com>
 */

var cn_ok = 0;
var ip_ok = 0;

$(document).ready(function() {

/*
    $('._link img[title]').tooltip({
        position: "bottom left",
        opacity: 0.9
    });
*/

    $('#logount-link').click(function() {
        if ( confirm(_js_msg_logout) == false ) {
            return false;
        }
    });

    $('.button-cancel').click(function() {
        $('#form-cancel').submit();
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

            $.get( json_resolvhost_url, { name: $(this).val() },
                function(data){
                    $('input#zdata_ip').val(data.ip);
                    if ( data.disabled ) {
                        ip_ok = 0;
                    }
                    /* no network */
                    ip_ok = 1;
                    /* end no network */
                },
                'json');

            check_form();
        }
    });

    $('select#zdata_zarafaAccount').change(function() {
        if ($(this).val() == 1) {
          $('#zarafa-settings').slideDown('slow');
        } else {
          $('#zarafa-settings').slideUp();
        }
    });
});

function check_form() {
    $('.button-submit').attr('disabled', true);

    if ( (cn_ok == 1 ) && (ip_ok == 1) ) {
        $('.button-submit').removeAttr("disabled");
    }
}
