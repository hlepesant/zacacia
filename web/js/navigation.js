$(document).ready(function() {

    $("#selectedPlatform").change(function() {
        if ( $(this).val() == 'add' ) {
            $('#navForm').attr('action', create_url);
        }
        $("#navForm").submit();
    });
});
