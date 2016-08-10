$(document).ready(function(){

    $('#form_save').hide();
    $('#form_sn').focus();

    $('#form_cancel').on('click', function(){
        if(confirm('Change have not been saved. Do you want to leave ?')) {
            $(location).attr('href', cancel_redirect);
        }
    });

/*
 *   $('#form_username').change(function(){
 *       var username = ($('#form_username').val());
 *       if ( cn.length > 6 ) {
 *           event.preventDefault();
 *           $.getJSON('/api/check/username/' + username, function(data){
 *               var username_exist = data['data'];
 *               if ( username_exist == "0" ) {
 *                   console.log( "show #form_save" );
 *                   $('#form_save').show();
 *               } else {
 *                   console.log( "hide #form_save" );
 *                   $('#form_save').hide();
 *               }
 *           })
 *           .fail(function() {
 *               console.log( "fail to get data" );
 *           });
 *       }
 *   });
 */

    $('#form_sn').change(function(){
      $('#form_displayname').val($('#form_sn').val() + ' ' + $('#form_givenname').val());
      $('#form_username').val($('#form_sn').val().slice(0,1).toLowerCase() + $('#form_givenname').val().toLowerCase());
      $('#form_email').val($('#form_sn').val().slice(0,1).toLowerCase() + $('#form_givenname').val().toLowerCase());
    });

    $('#form_givenname').change(function(){
      $('#form_displayname').val($('#form_sn').val() + ' ' + $('#form_givenname').val());
      $('#form_username').val($('#form_sn').val().slice(0,1).toLowerCase() + $('#form_givenname').val().toLowerCase());
      $('#form_email').val($('#form_sn').val().slice(0,1).toLowerCase() + $('#form_givenname').val().toLowerCase());
    });

    $('#block_zarafaquotasoft').hide();
    $('#block_zarafaquotawarn').hide();
    $('#block_zarafaquotahard').hide();

    $('#form_zarafaquotaoverride').change(function(){
      var quota_override = ($('#form_zarafaquotaoverride').val());
      if ( quota_override == "1" ) {
        $('#block_zarafaquotasoft').show();
        $('#block_zarafaquotawarn').show();
        $('#block_zarafaquotahard').show();
      } else {
        $('#block_zarafaquotasoft').hide();
        $('#block_zarafaquotawarn').hide();
        $('#block_zarafaquotahard').hide();
      }
    });
});
