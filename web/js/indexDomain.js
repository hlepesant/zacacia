$(document).ready(function() {

    $("#goback").click(function() {
        $("#company_back").submit();
    });

    $("#gotonew").click(function() {
        $("#domain_new").submit();
    });

    $("._link img[title]").tooltip({
        position: "bottom left",
        opacity: 0.9
    });

    $("._actions img[title]").tooltip({
        position: "top left",
        opacity: 0.9
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
                var alert_msg = _js_msg_01;
            } else {
                var alert_msg = _js_msg_02;
            }
            
            if ( ! confirm( alert_msg + ' ' + name + ' ?') ) {
                return false;
            }
        break;

        case 'delete':
            if ( ! confirm( _js_msg_03 + ' ' + name + ' ?') ) {
                return false;
            }
        break;

        case 'company':
        case 'server':
            m = target;
            d = 'index';
        break;

        default:
            return false;
        break;
    }

    f.attr('action', sprintf('%s%s/%s/', _js_url, m, d));

    f.submit();
    return true;
}
