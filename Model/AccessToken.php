<?php

namespace Sleepness\UberOAuthRestBundle\Model;

class AccessToken
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }
}
