$(document).ready(function(){

    $('a[data-confirm]').click(function() {
        var href = $(this).attr('data-href');
        var name = $(this).attr('data-confirm');

        BootstrapDialog.confirm({
            title: 'WARNING',
            message: 'Do you really want to delete \"' + name + '\" ?',
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
});
