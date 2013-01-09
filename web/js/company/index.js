$(document).ready(function() {

    $('#back-link').click(function() {
        $('#back_form').submit();
    });

    $('#logout-link').click(function() {
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

        case 'domain':
        case 'user':
        case 'group':
        case 'contact':
        case 'forward':
        case 'addresslist':
            m = target;
            d = null;
        break;

        default:
            return false;
        break;
    }

    if ( is_null(d) ) {
        f.attr('action', sprintf('%s%s/', _js_url, m));
    }
    else {
        f.attr('action', sprintf('%s%s/%s/', _js_url, m, d));
    }

    f.submit();
    return true;
}
