<?php

namespace Uber\OAuthRestBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Uber\OAuthRestBundle\DependencyInjection\OAuthRestExtension;

class OAuthRestBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new OAuthRestExtension();
    }
}
