$(document).ready(function() {
    $('#logout-link').click(function() {
        if ( confirm(_js_msg_logout) == false ) {
            return false;
        }
    });
});
