$(document).ready(function() {
/*
    $("#goback").hover(function() {
        alert('go back');
    });
    $("#goback").click(function() {
        $("#platform_back").submit();
    });

    $("#gotonew").click(function() {
        $("#server_new").submit();
    });

    $("img[title].tt").tooltip({
        position: "bottom left",
        opacity: 0.9
    });

    $("img[title].act").tooltip({
        position: "top left",
        opacity: 0.9
    });
*/

    $('#logount-link').click(function() {
        if ( confirm(_js_msg_logout) == false ) {
            return false;
        }
    });
});

function jumpTo(id, name, target, status) {

    var m = _js_module;
    var d = target;
    var f = 'f = $(sprintf("#navigation_form_%03d", id))';
    eval(f);

    switch ( target ) {
        case 'edit':
        break;

        case 'status':
            if ( 'enable' == status ) {
                var alert_msg = _js_msg_disable;
            } else {
                var alert_msg = _js_msg_enable;
            }
            
            if ( ! confirm( alert_msg + ' ' + name + ' ?') ) {
                return false;
            }
        break;

        case 'delete':
            if ( ! confirm( _js_msg_delete + ' ' + name + ' ?') ) {
              return false;
            }
        break;

        default:
            return false;
        break;
    }

    f.attr('action', sprintf('%s%s/%s/', _js_url, m, d));

    f.submit();
    return true;
}
