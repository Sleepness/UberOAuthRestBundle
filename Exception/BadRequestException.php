<?php

namespace Sleepness\UberOAuthRestBundle\Exception;

class BadRequestException extends \RuntimeException
{
    /**
     * @var string
     */
    private $provider;

    public function __construct($message, $provider, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->provider = $provider;
    }

    /**
     * @return string
     */
    public function getProvider()
    {
        return $this->provider;
    }
}
