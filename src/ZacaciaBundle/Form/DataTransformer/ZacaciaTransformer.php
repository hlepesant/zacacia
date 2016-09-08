<?php

namespace ZacaciaBundle\Form\DataTransformer;

use ZacaciaBundle\Entity\Platform;

class ZacaciaTransformer extends Platform {

    public function transPlatform($ldapObject)
    {
        $platform = new Platform();
        $platform->setCn($ldapObject->getCn());
        $platform->setZacaciastatus($ldapObject->getZacaciastatus());
        return $platform;
    } 
} 
