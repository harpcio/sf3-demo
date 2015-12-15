<?php

namespace Ace\Vendor\FOSUserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AceVendorFOSUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
