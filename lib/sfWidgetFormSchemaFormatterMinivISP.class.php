<?php
class sfWidgetFormSchemaFormatterMinivISP extends sfWidgetFormSchemaFormatter
{
  protected
  $rowFormat                 = "\n<div id=\"form-line\">\n<div id=\"form-line\" class=\"item\">%label%%error%</div>\n<div id=\"form-line\" class=\"field\">%field%%help%%hidden_fields%</div>\n</div>\n",
  $errorRowFormat            = "<div class=\"form-errors\">\n%errors%</div>\n",
  $helpFormat                = '<div class="form-help">%help%</div>',
  $decoratorFormat           = "<div>\n  %content%</div>",
  $errorListFormatInARow     = "  <ul class=\"error-list\">\n%errors%</ul>\n",
  $errorRowFormatInARow      = "    <li>%error%</li>\n",
  $namedErrorRowFormatInARow = "    <li>%name%: %error%</li>\n";
}
