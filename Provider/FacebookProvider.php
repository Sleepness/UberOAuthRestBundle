<?php

namespace Sleepness\UberOAuthRestBundle\Provider;

use Sleepness\UberOAuthRestBundle\Provider\BaseOAuthProvider as BaseProvider;
use Sleepness\UberOAuthRestBundle\Model\User;

class FacebookProvider extends BaseProvider
{
    const ACCESS_TOKEN_URL = 'https://graph.facebook.com/v2.5/oauth/access_token';
    const INFOS_URL = 'https://graph.facebook.com/v2.5/me';
    const PROVIDER_NAME = 'fb';
    const FIELDS = 'email,id,first_name,last_name';

    /**
     * @param $accessToken
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function getUserInformation($accessToken)
    {
        $parameters = array(
            'access_token' => $accessToken->access_token,
            'fields' => self::FIELDS
        );

        $url = $this->normalizeUrl(self::INFOS_URL, $parameters);

        $response = $this->doRequest($url, self::GET);

        return $response;
    }

    /**
     * @param $code
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function getAccessToken($code)
    {
        $parameters = [
            'code' => $code,
            'grant_type' => 'authorization_code',
            'client_id' => $this->credentials['client_id'],
            'client_secret' => $this->credentials['client_secret'],
            'redirect_uri' => $this->credentials['redirect_uri'],
        ];

        $response = $this->doRequest($this->normalizeUrl(self::ACCESS_TOKEN_URL, $parameters), self::GET, $parameters);

        return $response;
    }

    /**
     * @param $code
     *
     * @return User
     */
    public function getUser($code)
    {
        $accessToken = $this->getAccessToken($code);
        $userInformation = $this->getUserInformation($accessToken);

        $user = new User();
        $user->socialId = $userInformation->id;
        $user->email = $userInformation->email;
        $user->firstName = $userInformation->first_name;
        $user->lastName = $userInformation->last_name;

        return $user;
    }
}
