<?php

namespace FOSUserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class FOSUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}