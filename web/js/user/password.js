$(document).ready(function(){

    function validateForm() {
        form_is_valid = false;
    
        if ( $('#form_userpassword').parent("fieldset.form-group").hasClass('has-success') ) { form_is_valid = true; } else { form_is_valid = false; console.log( "ko = userpassword"); }
        if ( $('#form_confpass').parent("fieldset.form-group").hasClass('has-success') ) { form_is_valid = true; } else { form_is_valid = false; console.log( "ko = confpass"); }

        console.log( "form is valid = " + form_is_valid);
    
        if ( form_is_valid ) {
            $('#form_save').removeClass('hidden').show();
        } else {
            $('#form_save').addClass('hidden').hide();
        }
    }

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

    $('#form_userpassword').focus();
    // validateForm()

    $('#form_userpassword').on('change blur', function(){
        console.log( "userpassword length = " + $('#form_userpassword').val().length );
        if ( $('#form_userpassword').val().length == 0 ) {
            $('#form_confpass').parent("fieldset.form-group").removeClass('has-success')
            $('#form_userpassword').parent("fieldset.form-group").addClass('has-error')
        } else {
            $('#form_confpass').parent("fieldset.form-group").removeClass('has-error')
            $('#form_userpassword').parent("fieldset.form-group").addClass('has-success')
            validateForm()
        }
    });

    $('#form_confpass').on('change blur focus', function(){
        if ( $('#form_userpassword').val() == $('#form_confpass').val() ) {
            console.log( "userpassword match");
            $('#form_confpass').parent("fieldset.form-group").removeClass('has-error')
            $('#form_confpass').parent("fieldset.form-group").addClass('has-success')
            validateForm()
        } else {
            $('#form_confpass').parent("fieldset.form-group").removeClass('has-success')
            $('#form_confpass').parent("fieldset.form-group").addClass('has-error')
        }
    });
});
