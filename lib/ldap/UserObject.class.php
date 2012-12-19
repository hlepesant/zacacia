<?php

class UserObject extends BaseUserObject
{

    public function getZarafaAliasesAsOptions()
    {
        $aliases = $this->getZarafaAliases();
        foreach ( $aliases as $index => $alias ) {
            $aliases[ $alias ] = $alias;
            unset( $aliases[ $index ] );
        }
        return $aliases;
    }
}
