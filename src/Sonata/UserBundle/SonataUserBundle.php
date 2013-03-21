<?php

namespace Sonata\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SonataUserBundle extends Bundle {

    public function getParent() {
        return 'FOSUserBundle';
    }
}
