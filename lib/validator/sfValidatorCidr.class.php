<?php 
/*
 http://oss.timico.net/
*/

class sfValidatorCidr extends sfValidatorBase
{

    protected function doClean($value)
    {
        $matches = array();
        if (preg_match('#^(.*)/([0-9]+)$#', $value, $matches)) {
            if (long2ip(ip2long($matches[1])) != $matches[1]) {
              throw new sfValidatorError($this, 'Invalid IP', array('value' => $value));
            }

            try {
                $net = IpToolkit::ipcalc($matches[1], $matches[2]);
            }
            catch (Exception $e) {
                throw new sfValidatorError($this, 'IpToolkit says no', array('value' => $value));
            }
            
            if ($net['network'] != $matches[1]) {
                throw new sfValidatorError($this, 'Invalid network address for subnet mask', array('value' => $value));
            }
            return $value;
        }
        throw new sfValidatorError($this, 'Invalid Format', array('value' => $value));
    }
}
