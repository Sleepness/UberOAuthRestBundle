<?php

namespace Uber\OAuthRestBundle\Provider;

use Uber\OAuthRestBundle\Provider\OAuthProviderInterface;

abstract class BaseOAuthProvider implements OAuthProviderInterface
{
    protected $client;
    protected $credentials;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function setCredentials(array $credentials)
    {
        $this->credentials = $credentials;
    }
}
