<?php
class zacaciaForm extends sfFormSymfony
{

    protected static $option_noyes =array('no', 'yes');
    protected static $option_status =array( 'enable' => 'active', 'disable' => 'disabled' );

    protected function __($string, $args = array(), $catalogue = 'messages')
    {
        return sfContext::getInstance()->getI18N()->__($string, $args, $catalogue);
    }

    public function extractValues($pattern)
    {
        $values = $this->getValues();
        $pattern = sprintf('/^%s/', $pattern);
        $match = Array();
        foreach( $values as $key => $value ) {
            if ( preg_match( $pattern, $key ) )
            {
                $match[] = $value;
            }
        }
        return $match;
    }
}
