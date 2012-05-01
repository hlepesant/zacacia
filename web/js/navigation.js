$(document).ready(function() {

    $("#selectedPlatform").change(function() {
        $("#navForm").attr('action', show_url); 
        $("#navForm").submit();
    });

    $("#logout").click(function() {
        if ( ! confirm('Do you want to quit Zacacia ?')) {
            return false;
        };
        $("#navForm").attr('action', logout_url); 
        $("#navForm").submit();
    });

    $("#gotonew").click(function() {
        $("#navForm").attr('action', new_url); 
        $("#navForm").submit();
    });
});
