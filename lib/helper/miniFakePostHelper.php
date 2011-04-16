<?php

  /*
   *
   *
   *
   */

  function fake_post($action, $target, $fields = array())
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers('Url');

    $action->setLayout(false);
    $action->setTemplate(false);

    $output  = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
    $output .= "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n";
    $output .= "<head>\n";
    $output .= "<title></title>\n";
    $output .= "</head>\n";
    $output .= "<body onLoad=\"JavaScript: timePost();\">\n";
    $output .= "<script type=\"text/javascript\">\n";
    $output .= "//<![CDATA[\n";
    $output .= "function timePost()\n";
    $output .= "{\n";
    $output .= "var t = setTimeout(\"fakePost()\",3000);\n";
    $output .= "}\n";
    $output .= "function fakePost()\n";
    $output .= "{\n";
    $output .= "var f = document.getElementById('fakeForm');\n";
    $output .= "f.submit();\n";
    $output .= "}\n";
    $output .= "//]]>\n";
    $output .= "</script>\n";
    $output .= "<form name=\"fakeForm\" id=\"fakeForm\" action=\"". url_for($target) ."\" method=\"POST\">\n";
    foreach ($fields as $field => $value) {
      $output .= "<input type=\"hidden\" name=\"".$field."\" value=\"".$value."\" />\n";
    }
    $output .= "</form>\n";
    $output .= "</body>\n";    
    $output .= "</html>\n";  



    return $output;
  }
