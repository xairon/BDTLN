<?php

namespace Bdtln\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BdtlnUserBundle extends Bundle
{
    /**
     * getParent return the parent's name in case of bundle heritage
     * @return string the parent bundle's name
     */
    public function getParent() {
        return "FOSUserBundle";
    }
}
