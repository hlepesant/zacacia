<?php
class sfWidgetFormSchemaFormatterBootstrap extends sfWidgetFormSchemaFormatter
{
  protected
#    $errorRowFormat            = "<div class=\"form-errors\">\n%errors%</div>\n",
#    $helpFormat                = '<div class="form-help">%help%</div>',
#    $decoratorFormat           = "<div>\n  %content%</div>",
#    $errorListFormatInARow     = "  <ul class=\"error-list\">\n%errors%</ul>\n",
#    $errorRowFormatInARow      = "    <li>%error%</li>\n",
#    $namedErrorRowFormatInARow = "    <li>%name%: %error%</li>\n",
#    $rowFormat                 = "<div class=\"form-group\">\n\t%label%\n\t%field%\n</div>\n";

    $rowFormat = "<div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\">%label%</label>
                  <div class=\"col-sm-4\">%field%</div>
                  </div>";
}
