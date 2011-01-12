<?php
class sfWidgetFormSchemaFormatterMinivISP extends sfWidgetFormSchemaFormatter
{
  protected
#  $rowFormat       = "\n<div id=\"Items\">\n<div class=\"item\">%error%%label%</div>\n<div class=\"field\">%field%%help%%hidden_fields%</div>\n</div>\n",
  $rowFormat       = "\n<div id=\"form_line\">\n<div class=\"item\">%label%%error%</div>\n<div class=\"field\">%field%%help%%hidden_fields%</div>\n</div>\n",
#  $rowFormat       = "%error%%label%\n%field%%help%%hidden_fields%\n",
  $errorRowFormat  = "<div class=\"form-errors\">\n%errors%</div>\n",
  $helpFormat      = '<div class="form-help">%help%</div>',
  $decoratorFormat = "<div>\n  %content%</div>",
  $errorListFormatInARow     = "  <ul class=\"error_list\">\n%errors%</ul>\n",
  $errorRowFormatInARow      = "    <li>%error%</li>\n",
  $namedErrorRowFormatInARow = "    <li>%name%: %error%</li>\n";
}
