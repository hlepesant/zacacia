<?php
/*
 http://oss.timico.net/
*/

class sfValidatorIpAddress extends sfValidatorBase
{

  protected function doClean($value)
  {
    if (long2ip(ip2long($value)) != $value)
    {
      throw new sfValidatorError($this, 'invalid', array('value' => $value));

    }
    return $value;
  }
}
