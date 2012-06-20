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

        case 'domain':
        case 'user':
        case 'group':
        case 'contact':
        case 'forward':
        case 'addresslist':
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
