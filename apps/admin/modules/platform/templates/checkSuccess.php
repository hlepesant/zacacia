<?php
if ( $count ) {
echo image_tag('icons/cross.png');
echo javascript_tag("
Form.Element.disable('form_submit');
");
}
else {
echo image_tag('icons/tick.png');
echo javascript_tag("
Form.Element.enable('form_submit');
");
}
