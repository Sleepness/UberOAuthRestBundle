<?php

namespace Sleepness\UberOAuthRestBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Sleepness\UberOAuthRestBundle\DependencyInjection\SleepnessUberOAuthRestExtension;

class SleepnessUberOAuthRestBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new SleepnessUberOAuthRestExtension();
    }
}
