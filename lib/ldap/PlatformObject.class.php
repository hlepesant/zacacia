<?php

class PlatformObject extends BasePlatformObject
{
    public function setDn64()
    {
        return base64_encode($this->getDn());
    }

    public function getDn64($v)
    {
        return base64_decode($v);
    }
}
