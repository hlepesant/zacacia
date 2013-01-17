$(document).ready(function() {

    $('.button-cancel').click(function() {
        $('#form_cancel').submit();
    });

    $('fieldset .selectAll').click(function(event) {
        event.preventDefault();
        $(this).siblings('input:checkbox').attr('checked', 'checked');
    });

});
