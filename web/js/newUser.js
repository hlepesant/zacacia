var _displayName = 'fl';

$(document).ready(function() {

    $.fx.off = true;
    
    $("#section_userinfo").show();
    $("#section_zarafa").hide();

    $("#goto_section_zarafa").click(function() {
        $("#section_userinfo").hide();
        $("#section_zarafa").show();
        return false;
    }); 

    $("#back_section_userinfo").click(function() {
        $("#section_userinfo").show();
        $("#section_zarafa").hide();
    });

    $('.button_cancel').click(function() {
        $('#form_cancel').submit();
    });

    var val_sn = $('input#zdata_sn').validator();
    var val_givenName = $('input#zdata_givenName').validator();
    var val_cn = $('input#zdata_cn').validator();
    var val_uid = $('input#zdata_uid').validator();
    var val_emailAddress = $('input#zdata_emailAddress').validator();

    $('input#zdata_sn').observe_field(0.5, function() {
        if( $('input#zdata_givenName').val().length ) {
            $('input#zdata_cn').val( sprintf("%s %s", $('input#zdata_sn').val(), $('input#zdata_givenName').val() ) ) ;
        }
    });

    $('input#zdata_givenName').observe_field(0.5, function() {
        if( $('input#zdata_sn').val().length ) {
            $('input#zdata_cn').val( sprintf("%s %s", $('input#zdata_sn').val(), $('input#zdata_givenName').val() ) ) ;
        }
    });

    $('input#zdata_cn').observe_field(0.5, function() {
        $('#checkName_msg').html("");
        $('.button_submit').attr('disabled', true);

        if ( val_cn.data('validator').checkValidity() ) {
            $.get( json_checkcn_url, {
                companyDn: $('input#zdata_companyDn').val(),
                name: $(this).val()
            },
            function(data){
                $('#checkName_msg').html("<img src=\""+data.img+"\" />");
                if ( ! data.disabled ) {
                    $('.button_submit').removeAttr('disabled');
                    $('input#zdata_displayName').val( sprintf("%s %s", $('input#zdata_sn').val(), $('input#zdata_givenName').val() ) ) ;
                    $('#imgSwitch').css('visibility','visible');
                    _uid = sprintf("%s%s", substr($('input#zdata_sn').val(), 0, 1), $('input#zdata_givenName').val());
                    $('input#zdata_uid').val(_uid.toLowerCase());
                    $('input#zdata_mail').val(_uid.toLowerCase());
                }
            }, 'json');
        }
    });

    $('#switch').click( function() {
        if ( _displayName == 'fl' ) {
            $('input#zdata_displayName').val( sprintf("%s %s", $('input#zdata_givenName').val(), $('input#zdata_sn').val() ) ) ;
            _displayName = 'lf';
        } else {
            $('input#zdata_displayName').val( sprintf("%s %s", $('input#zdata_sn').val(), $('input#zdata_givenName').val() ) ) ;
            _displayName = 'fl';
        }
    });

    $('input#zdata_uid').observe_field(0.5, function() {
        $('#checkUid_msg').html("");
        $('#goto_section_zarafa').attr('disabled', true);
  
        if ( val_uid.data('validator').checkValidity() ) {
        $.get( json_checkuid_url, {
            name: $(this).val()
        },
        function(data){
            $('#checkUid_msg').html("<img src=\""+data.img+"\" />");
            if ( ! data.disabled ) {
                $('#goto_section_zarafa').removeAttr('disabled');
            }
        }, 'json');
        }
    });

    $('input#zdata_userPassword').password_strength();

    if ( null == $('input#zdata_confirmPassword').val() == $('input#zdata_userPassword').val() ) {
        $('#pequality').html("<img src=\"/images/famfam/cross.png\" />");
        $('#goto_section_zarafa').attr('disabled', true);
    }

    $('input#zdata_confirmPassword').observe_field(0.5, function() {
        if ( $('input#zdata_userPassword').val() == $(this).val() ) {
            $('#pequality').html("<img src=\"/images/famfam/tick.png\" />");
            $('#goto_section_zarafa').removeAttr('disabled');
        } else {
            $('#pequality').html("<img src=\"/images/famfam/cross.png\" />");
            $('#goto_section_zarafa').attr('disabled', true);
        }
    });

    $("#userform").submit(function(e) {
        var _md5 = $('input#zdata_userPassword').crypt({method:"md5",source:""});
        $('input#zdata_userPassword').val(_md5);
        $('input#zdata_confirmPassword').val(_md5);
    });

    $("input[type='checkbox']#zdata_zarafaAccount").change(function() {

        if ($(this).is(':checked')) {
            $("#zarafa_settings").slideDown('slow');
        } else {
          $("#zarafa_settings").slideUp();
        }
    });

    $('#zdata_mail').observe_field(0.5, function() {
        $('input#zdata_emailAddress').val(sprintf("%s@%s", $(this).val(), $('#zdata_domain').val())) ;
    
    });
    $('#zdata_domain').change(function() {
        $('input#zdata_emailAddress').val(sprintf("%s@%s", $('#zdata_mail').val(), $(this).val())) ;
    });
/*    
    if ( val_emailAddress.data("validator").checkValidity() ) {
        $.get( json_checkemail_url, {
            email: $(this).val()
        },
        function(data){
            $("#checkEmail_msg").html("<img src=\""+data.img+"\" />");
            if ( ! data.disabled ) {
                $(".button_submit").removeAttr("disabled");
            }
        }, "json");
    }
*/
    $('input#zdata_emailAddress').change( function() {
        $.getJSON( json_checkemail_url, { email: $(this).val() }, function(data) {
            $("#checkEmail_msg").html("<img src=\""+data.img+"\" />");
            if ( ! data.disabled ) {
                $(".button_submit").removeAttr("disabled");
            }
        });
    });

    $('#zdata_zarafaQuotaOverride').click(function() {
        if ( $(this).is(':checked')) {
            $('#quota_setting').show();
        } else {
            $('#quota_setting').hide();
        }
    });
});
