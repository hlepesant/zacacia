<?php
class sfWidgetFormSchemaFormatterGridForm extends sfWidgetFormSchemaFormatter
{
  protected
#    $errorRowFormat            = "<div class=\"form-errors\">\n%errors%</div>\n",
#    $helpFormat                = '<div class="form-help">%help%</div>',
#    $decoratorFormat           = "<div>\n  %content%</div>",
#    $errorListFormatInARow     = "  <ul class=\"error-list\">\n%errors%</ul>\n",
#    $errorRowFormatInARow      = "    <li>%error%</li>\n",
#    $namedErrorRowFormatInARow = "    <li>%name%: %error%</li>\n",
#    $rowFormat       = "<div id=\"form_item\">\n\t\t<div class=\"_name\">%label%%error%</div>\n\t\t<div class=\"_field\">%field%%help%%hidden_fields%</div>\n\t\t<div class=\"_ajaxCheck\"></div>\n\t</div>\n\t<!-- end #form_item -->",
    $rowFormat                 = <<<EOF
<div class='span-15 last form-item'>
<div class='span-6 form-item-label'>%label%</div>
<div class='span-6 form-item-field'>%field%</div>
<div class='span-1 form-item-check last'></div>
</div>
EOF;
#    $rowFormat                 = "<p>%label%<br />%field%</p>";

}
