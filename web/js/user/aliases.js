$(document).ready(function(){

    function validateForm(){
        form_is_valid = false;
    
        if ( $('#form_email').parent("fieldset.form-group").hasClass('has-success') ) { form_is_valid = true; } else { form_is_valid = false; console.log( "ko = email"); }
        if ( $('#form_domain').parent("fieldset.form-group").hasClass('has-success') ) { form_is_valid = true; } else { form_is_valid = false; console.log( "ko = domain"); }

        console.log( "form is valid = " + form_is_valid);
        if ( form_is_valid ) {
            $('#form_save').removeClass('hidden').show();
        } else {
            $('#form_save').addClass('hidden').hide();
        }
    }

    function validateEmail() {

        var email_free = '0';
        var email = ($('#form_email').val());
        var domain = ($('#form_domain').val());
        var useremail = (email + '@' + domain);
    
        if ( email.length > 0 ) {
            event.preventDefault();
            $.getJSON('/api/check/useremail/' + useremail , function(data){
                var useremail_exist = data['data'];
                if ( useremail_exist == '0' ) {
                    $('#form_email').parent("fieldset.form-group").removeClass('has-error');
                    $('#form_domain').parent("fieldset.form-group").removeClass('has-error');

                    $('#form_email').parent("fieldset.form-group").addClass('has-success');
                    $('#form_domain').parent("fieldset.form-group").addClass('has-success');
                    
                    $('#glyphicon_form_email').removeClass('glyphicon-remove').addClass('glyphicon-ok');
                    $('#glyphicon_form_domain').removeClass('glyphicon-remove').addClass('glyphicon-ok');
        
                } else {
                    $('#form_email').parent("fieldset.form-group").removeClass('has-success');
                    $('#form_domain').parent("fieldset.form-group").removeClass('has-success');

                    $('#form_email').parent("fieldset.form-group").addClass('has-error');
                    $('#form_domain').parent("fieldset.form-group").addClass('has-error');
                    
                    $('#glyphicon_form_email').removeClass('glyphicon-ok').addClass('glyphicon-remove');
                    $('#glyphicon_form_domain').removeClass('glyphicon-ok').addClass('glyphicon-remove');
                }
            })
            .fail(function() {
                console.log( "fail to get data for user alias" );
            })
            .always(function() {
                validateForm();
            });
        } else {
            $('#form_email').parent("fieldset.form-group").removeClass('has-success');
            $('#form_domain').parent("fieldset.form-group").removeClass('has-success');

            $('#form_email').parent("fieldset.form-group").addClass('has-error');
            $('#form_domain').parent("fieldset.form-group").addClass('has-error');
            
            $('#glyphicon_form_email').removeClass('glyphicon-ok').addClass('glyphicon-remove');
            $('#glyphicon_form_domain').removeClass('glyphicon-ok').addClass('glyphicon-remove');
        }
    }

    $('#form_email').focus();


    $('#form_email').on('change blur click focus', function() {
        validateEmail();
    });

    $('#form_domain').on('change blur focus', function() {
        validateEmail();
    });


    $('a[data-confirm]').click(function() {
        var href = $(this).attr('data-href');
        var name = $(this).attr('data-confirm');

        BootstrapDialog.confirm({
            title: 'WARNING',
            message: 'Do you really want to delete the alias : \"' + name + '\" ?',
            type: BootstrapDialog.TYPE_WARNING,
            closable: false,
            draggable: false,
            btnCancelLabel: 'Cancel',
            btnOKLabel: 'Yes I\'m sure !',
            btnOKClass: 'btn-warning',
            callback: function(result) {
                if (result) {
                    $(location).attr('href', href);
                }
            }
        });
    });
  
    $('#form_cancel').click( function(){
        BootstrapDialog.confirm({
            title: 'INFO',
            message: 'All changes will be lost !!',
            type: BootstrapDialog.TYPE_INFO,
            closable: false,
            draggable: false,
            btnCancelLabel: 'Cancel',
            btnOKLabel: 'It\'s OK !',
            btnOKClass: 'btn-info',
            callback: function(result){
                if (result) {
                    $(location).attr('href', cancel_redirect);
                }
            }
        });
    });
});
