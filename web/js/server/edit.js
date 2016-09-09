$(document).ready(function() {

    $('#form_cn').focus();

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
            callback: function(result) {
                if (result) {
                    $(location).attr('href', cancel_redirect);
                }
            }
        });
    });
});
