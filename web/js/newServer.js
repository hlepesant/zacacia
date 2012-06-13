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
/*
        if ( $('input#zdata_cn').length ) {

            $.get( json_check_url, { name: $(this).val() },
                function(data){
                    cn_ok = 0;
                    if ( ! data.disabled ) {
                        cn_ok = 1;
                    }
                    check_form();
                },
                'json');
*/
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

            $.get( json_resolvhost_url, { name: $(this).val() },
                function(data){
                    $('input#zdata_ip').val(data.ip);
                    if ( ! data.disabled ) {
                        ip_ok = 1;
                    }
                    /* no network */
                    ip_ok = 1;
                    /* end no network */
                    check_form();
                },
                'json');
        }
    });

    $("select#zdata_zarafaAccount").change(function() {

        if ($(this).val() == 1) {
          $("#zarafa-settings").slideDown('slow');
        } else {
          $("#zarafa-settings").slideUp();
        }
    });
});

function check_form() {
    $(".button-submit").attr("disabled", true);
    if ( (cn_ok == 1 ) && (ip_ok == 1) ) {
        $(".button-submit").removeAttr("disabled");
    }
}
