$(document).ready(function() {

    $("#navigation_selectedPlatform").change(function() {
        if ( $(this).val() == 'add' ) {
            $('#navForm').attr('action', create_url);
        } else {
            var action_url = sprintf('%s/%s', show_url, $(this).val());
            alert(action_url);
            $('#navForm').attr('action', action_url);
        }
        $("#navForm").submit();
    });
});