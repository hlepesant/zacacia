var _displayName = 'fl';

$(document).ready(function() {

  $('#button_cancel').click(function() {
    $('#form_cancel').submit();
  });

  var val_sn = $('input#zdata_sn').validator();
  var val_givenName = $('input#zdata_givenName').validator();
  var val_cn = $('input#zdata_cn').validator();
  var val_uid = $('input#zdata_uid').validator();

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
  $('#button_submit').attr('disabled', true);

    if ( val_cn.data('validator').checkValidity() ) {
      $.get( json_checkcn_url, {
          companyDn: $('input#zdata_companyDn').val(),
          name: $(this).val()
      },
      function(data){
        $('#checkName_msg').html("<img src=\""+data.img+"\" />");
        if ( ! data.disabled ) {
          $('#button_submit').removeAttr('disabled');
          $('input#zdata_displayName').val( sprintf("%s %s", $('input#zdata_sn').val(), $('input#zdata_givenName').val() ) ) ;
          $('#imgSwitch').css('visibility','visible');
          _uid = sprintf("%s%s", substr($('input#zdata_sn').val(), 0, 1), $('input#zdata_givenName').val());
          $('input#zdata_uid').val(_uid.toLowerCase());
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
    $('#button_submit').attr('disabled', true);
  
    if ( val_uid.data('validator').checkValidity() ) {
      $.get( json_checkuid_url, {
        name: $(this).val()
      },
      function(data){
        $('#checkUid_msg').html("<img src=\""+data.img+"\" />");
        if ( ! data.disabled ) {
          $('#button_submit').removeAttr('disabled');
        }
      }, 'json');
    }
  });

  $('input#zdata_userPassword').password_strength({container: $('#pmeter'), minLength: 5, texts: password_i18n});

  if ( null == $('input#zdata_confirmPassword').val() == $('input#zdata_userPassword').val() ) {
    $('#pequality').html("<img src=\"/images/famfam/cross.png\" />");
    $('#button_submit').attr('disabled', true);
  }

  $('input#zdata_confirmPassword').observe_field(0.5, function() {
    if ( $('input#zdata_userPassword').val() == $(this).val() ) {
      $('#pequality').html("<img src=\"/images/famfam/tick.png\" />");
      $('#button_submit').removeAttr('disabled');
    } else {
      $('#pequality').html("<img src=\"/images/famfam/cross.png\" />");
      $('#button_submit').attr('disabled', true);
    }
  });

  $("form").submit(function(e) {
    var _md5 = $('input#zdata_userPassword').crypt({method:"md5",source:""});
    $('input#zdata_userPassword').val(_md5);
    $('input#zdata_confirmPassword').val(_md5);
  });

});


